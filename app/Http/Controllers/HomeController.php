<?php

namespace App\Http\Controllers;

use App\Mail\SendContactRequest;
use App\Models\tblAuditLogs;
use App\Models\tblConsumable;
use App\Models\tblEvent;
use App\Models\tblFacility;
use App\Models\tblFurniture;
use App\Models\tblItemRequest;
use App\Models\tblItems;
use App\Models\tblNotification;
use App\Models\tblPayment;
use App\Models\tblPrices;
use App\Models\tblRecentActivity;
use App\Models\tblReports;
use App\Models\tblRequests;
use App\Models\tblReservation;
use App\Models\tblScheduleTask;
use App\Models\tblSettings;
use App\Models\tblTask;
use App\Models\tblTaskLocation;
use App\Models\tblUserNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'userReservations' => tblReservation::where('recipientId', auth()->id())
                ->where('status', 'approved')
                ->get() ?? [],
            'facilities' => tblFacility::all(),
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function adminHome()
    {
        $currentDateTime = Carbon::now('Asia/Manila');

        $currentDate = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('h:ia');

        $currentReservation = tblReservation::where('date', '=', $currentDate)
            ->where('status', '=', 'Approved')
            ->where(function ($query) use ($currentTime) {
                $query->where(function ($query) use ($currentTime) {
                    $query->whereRaw("STR_TO_DATE(REPLACE(`time`, '-', ' '), '%h:%i%p') <= ?", [$currentTime])
                        ->whereRaw("STR_TO_DATE(REPLACE(`time`, '-', ' '), '%h:%i%p') >= ?", [$currentTime]);
                });
            })
            ->first();

        // Get the total count of rows in tblFurniture
        $totalFurnitureCount = tblFurniture::count();

        // Get the total sum of 'quantity' column in tblConsumables
        $totalConsumablesQuantity = DB::table('tbl_consumables')->sum('quantity');

        $inventoryCount = $totalFurnitureCount + $totalConsumablesQuantity;

        return view('adminHome', [
            'reservations' => tblReservation::all(),
            'inventories' => tblFurniture::where('status', 'Reserved')->orWhere('status', 'Available')->get(),
            'inventoryCounts' => $inventoryCount,
            'tasks' => tblTask::all(),
            'payments' => tblPayment::where('status', 'Paid')->get(),
            'currentReservation' => $currentReservation,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function staffHome()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Query the tblScheduleTask to get tasks where the stafflist matches the user ID
        $staffTasks = tblScheduleTask::where(function ($query) use ($userId) {
            $query->where('staff_list', 'LIKE', '%"' . $userId . '"%');
        })->get();

        foreach ($staffTasks as $staffTask) {
            $staffList = json_decode($staffTask->staff_list, true);
            $status = 'No Status Found'; // Default status if not found
            foreach ($staffList as $staff) {
                if ($staff[0] == $userId) {
                    $status = $staff[2]; // Set the status when a match is found
                    break; // Stop searching once a match is found
                }
            }
            $staffTask->status = $status; // Add the status to the staffTask
        }

        // Query the tblScheduleTask to get tasks where the stafflist matches the user ID
        $staffReserveTasks = tblReservation::where(function ($query) use ($userId) {
            $query->where('staff', 'LIKE', '%"' . $userId . '"%');
        })->get();

        return view('staffHome', [
            'staffTasks' => $staffTasks,
            'staffReserveTasks' => $staffReserveTasks,
            'allTask' => tblScheduleTask::all(),
            'guidelines' => tblSettings::where('name', 'guidelines')->get(),
        ]);
    }

    public function getUserId()
    {
        $userId = auth()->id();
        return response()->json(['userId' => $userId]);
    }

    public function sentEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $name = $request->input("name");
        $email = $request->input("email");
        $subject = $request->input("subject");
        $message = $request->input("message");

        $mailData = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ];

        $emailSettings = tblSettings::where('name', 'businessEmail')->firstOrFail();
        $emailSent = $emailSettings->value;
        $tempEmail = "corpuzbaronrances92@gmail.com";

        Mail::to($tempEmail)->send(new SendContactRequest($mailData));
    }

    //Admin Renders View
    public function profileView()
    {
        return view('layouts.admin-components.profile', ['userDetails' => User::where('id', auth()->id())->first()]);
    }

    public function settingsView()
    {
        try {
            $maintenanceSettings = tblSettings::where('name', 'maintenanceMode')->firstOrFail();
            $userId = Auth::user()->id;

            return view('layouts.admin-components.settings', [
                'recentActivities' => tblRecentActivity::where('userId', $userId)->get() ?? [],
                'maintenanceSettings' => $maintenanceSettings, // Pass $maintenanceSettings to the view
            ]);
        } catch (\Exception $e) {
            // Handle the exception, or log it for debugging purposes.
            // For now, let's just dump the error message:
            dump($e->getMessage());
        }
    }

    public function manageUsersView()
    {
        return view('layouts.admin-components.manage-user-components.manage-users', [
            'userLists' => User::where('type', 1)->orWhere('type', 2)->get(),
        ]);
    }

    //Reservation Components View
    public function reservationReviewRoute()
    {
        $currentNumber = tblSettings::where('name', 'businessNumber')->firstOrFail();
        $currentEmail = tblSettings::where('name', 'businessEmail')->firstOrFail();
        $guidelines = tblSettings::where('name', 'guidelines')->get();

        return view('layouts.admin-components.reservation-components.review', ['approvedReviewItems' => tblReservation::where('status', 'Approved')->get(), 'declinedReviewItems' => tblReservation::where('status', 'Cancelled')->get(), 'addReviewItems' => tblReservation::where('status', 'pending')->get(), 
        // 'addStaffs' => User::where('type', 2)->get(), 
        'priceLists' => tblPrices::all(), 'guidelines' => $guidelines, 'businessNum' => $currentNumber, 'businessEmail' => $currentEmail]);
    }

    public function reservationManageRoute()
    {
        $events = tblEvent::all();
        $reservations = tblReservation::where('status', 'approved')->get();

        $combinedData = [];

        $currentDate = date('Y-m-d');

        foreach ($events as $event) {
            $start_date = date('Y-m-d', strtotime($event->start_date));
            $end_date_view = date('Y-m-d', strtotime($event->end_date . ' +1 day'));

            $combinedData[] = [
                'title' => $event->title,
                'start' => $start_date,
                'end' => $end_date_view,
                'backgroundColor' => '#22CDB6',
            ];

        }

        foreach ($reservations as $reservation) {
            $reservation_date = date('Y-m-d', strtotime($reservation->date));

            if ($currentDate <= $reservation_date) {

                $combinedData[] = [
                    'title' => $reservation->activity,
                    'start' => $reservation_date,
                    'end' => $reservation_date,
                    'backgroundColor' => '#2F4564',
                ];

            }
        }

        return view('layouts.admin-components.reservation-components.manage-schedule', ['addEventItems' => tblEvent::all(), 'events_show' => $combinedData,
            'events' => $events]);
    }
    public function reservationScannerRoute()
    {
        return view('layouts.admin-components.reservation-components.scanning-qrcode');
    }
    public function adminReservationViewRoute()
    {
        return view('layouts.admin-components.reservation-components.view', ['addReviewItems' => tblReservation::where('status', 'Approved')->orWhere('status', 'Cancelled')->get()]);
    }
    public function adminReservationViewCalendarRoute()
    {
        $events = tblEvent::all();
        $reservations = tblReservation::where('status', 'approved')->get();

        $combinedData = [];

        $currentDate = date('Y-m-d');

        foreach ($events as $event) {
            $start_date = date('Y-m-d', strtotime($event->start_date));
            $end_date_view = date('Y-m-d', strtotime($event->end_date . ' +1 day'));

            $combinedData[] = [
                'title' => $event->title,
                'start' => $start_date,
                'end' => $end_date_view,
                'backgroundColor' => '#22CDB6',
            ];
        }

        foreach ($reservations as $reservation) {
            $reservation_date = date('Y-m-d', strtotime($reservation->date));

            if ($currentDate <= $reservation_date) {

                $combinedData[] = [
                    'title' => $reservation->activity,
                    'start' => $reservation_date,
                    'end' => $reservation_date,
                    'backgroundColor' => '#2F4564',
                ];

            }
        }
        return view('layouts.admin-components.reservation-components.view-calendar', [
            'events_show' => $combinedData,
            'events' => $events,

        ]);
    }
    //Inventory Components View
    public function purchaseRoute()
    {
        $addRequestItems = tblItemRequest::all();
        return view('layouts.admin-components.inventory-components.purchase', ['addItems' => tblItems::all(), 'addRequestLists' => tblRequests::all(), 'addRequestItems' => $addRequestItems]);
    }
    public function manageInventoryRoute()
    {
        return view('layouts.admin-components.inventory-components.manage', ['addtblInventoriesC' => tblConsumable::all(), 'addtblInventoriesI' => tblFurniture::all()]);
    }
    public function adminViewInventoryRoute()
    {
        return view('layouts.admin-components.inventory-components.view', ['addtblInventoriesC' => tblConsumable::all(), 'addtblInventoriesI' => tblFurniture::all()]);
    }
    //Maintenance Components View
    public function addFacilityRoute()
    {
        return view('layouts.admin-components.maintenance-components.add-facilities', ['addFacilities' => tblFacility::all()]);
    }
    public function updateFacilityRoute()
    {
        return view('layouts.admin-components.maintenance-components.update-facilities', ['addFacilities' => tblFacility::all()]);
    }
    public function scheduleTaskRoute()
    {
        return view('layouts.admin-components.maintenance-components.schedule-task', [
            // 'addStaff' => User::where('type', 2)->get(), 
            'addScheduleTask' => tblScheduleTask::all(), 'addTask' => tblTask::all(), 'addLocation' => tblTaskLocation::all()]);
    }

    public function manageTeamScheduler()
    {
        // $staffs = User::where('type', 2)->get() ?? [];
        // $staffTasks = tblScheduleTask::all();
        // $staffReservations = tblReservation::where('status', 'Approved')->get();

        // $events = [];

        // foreach ($staffs as $staff) {
        //     $staffId = $staff->id;
        //     foreach ($staffTasks as $task) {
        //         $staffList = json_decode($task->staff_list, true);

        //         if($staffList){
        //             // Check if $staffId exists in any subarray
        //             foreach ($staffList as $staffInfo) {
        //                 if (in_array($staffId, $staffInfo)) {
        //                     // If match is found, add the $schedule to the $staffTaskList
        //                     $events[] = [
        //                         'title' => $task->name. " on " .$task->location. " (" .$staff->name. ")",
        //                         'start' => $task->date,
        //                     ];
        //                     break;
        //                 }
        //             }
        //         }
        //     }

        //     foreach ($staffReservations as $reservations) {
        //         $staffList = json_decode($task->staff, true);

        //         if($staffList){
        //             // Check if $staffId exists in any subarray
        //             foreach ($staffList as $staffInfo) {
        //                 if (in_array($staffId, $staffInfo)) {
        //                     if($reservations->event_type === "Big Event"){
        //                         $events[] = [
        //                             'title' => $reservations->acvtivity. " on " .$reservations->facility. " (" .$staff->name. ")",
        //                             'start' => $reservations->date,
        //                         ];
        //                         break;
        //                     }else{
        //                         $timeRange = $reservations->time;
        //                         list($startTime, $endTime) = explode('-', $timeRange);

        //                         $startTimeCarbon = Carbon::parse($endTime, 'Asia/Manila');
        //                         $endTimeCarbon = Carbon::parse($endTime, 'Asia/Manila');

        //                         $events[] = [
        //                             'title' => $reservations->activity. " on " .$reservations->facility. " (" .$staff->name. ")",
        //                             'start' => $reservations->date." ".$startTimeCarbon,
        //                             'end' => $reservations->date." ".$endTimeCarbon,
        //                         ];
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // $events[] = [
        //     'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
        //     'start' => $appointment->start_time,
        //     'end' => $appointment->finish_time,
        // ];

        return view('layouts.admin-components.maintenance-components.staff-calendar', [
            'userLists' => User::where('type', 2)->get(),
            // 'events' => compact('events')
        ]);
    }

    public function updateProcedureRoute()
    {
        return view('layouts.admin-components.maintenance-components.update-procedure', ['addTask' => tblTask::all()]);
    }
    public function adminViewTaskRoute()
    {
        return view('layouts.admin-components.maintenance-components.view-task', ['addScheduleTask' => tblScheduleTask::all()]);
    }
    //Payment Components View
    public function managePaymentRoute()
    {
        return view('layouts.admin-components.payment-components.manage-payment', ['addPayment' => tblPayment::where('status', 'Unpaid')->get(), 'addPaidPayment' => tblPayment::where('status', 'Paid')->get(), 'approvedReservations' => tblReservation::where('status', 'approved')->get(), 'guidelines' => tblSettings::where('name', 'guidelines')->get()]);
    }
    public function viewPaymentRoute()
    {
        return view('layouts.admin-components.payment-components.view-payment', ['addPayment' => tblPayment::all()]);
    }
    //Report Components View
    public function generateReportRoute()
    {
        return view('layouts.admin-components.report-components.generate-report', ['addReports' => tblReports::all()]);
    }

    //Staff Renders View
    public function staffProfile()
    {
        return view('layouts.staff-components.profile', ['userDetails' => User::where('id', auth()->id())->first()]);
    }

    public function staffSettingsView()
    {
        try {
            $userId = Auth::user()->id;

            return view('layouts.staff-components.settings', [
                'recentActivities' => tblRecentActivity::where('userId', $userId)->get() ?? [],
            ]);
        } catch (\Exception $e) {
            // Handle the exception, or log it for debugging purposes.
            // For now, let's just dump the error message:
            dump($e->getMessage());
        }
    }
    //Notification
    public function staffNotification()
    {
        $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];

        foreach ($userNotifications as $userNotification) {
            if ($userNotification->readed == 0) {
                $userNotification->readed = 1;
            }

            $userNotification->save();
        }

        return view('layouts.staff-components.notification');
    }

    public function staffNotifRead($notifId)
    {
        $userNotification = tblNotification::find($notifId);

        $exists = tblNotification::where('id', $notifId)->exists();

        if (!$exists) {
            return response()->json(['message' => 'Item Not Found!!'], 404);
        }

        $userNotification->readed = 1;
        $userNotification->save();

        return response()->json(['message' => 'Notification marked as read successfully'], 200);
    }

    //Reservation Components View
    public function staffReservationViewRoute()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Query the tblScheduleTask to get tasks where the stafflist matches the user ID
        $staffReserveTasks = tblReservation::where(function ($query) use ($userId) {
            $query->where('staff', 'LIKE', '%"' . $userId . '"%');
        })->get();

        return view('layouts.staff-components.reservation-components.view',
            [
                'staffReserveTasks' => $staffReserveTasks,
                'guidelines' => tblSettings::where('name', 'guidelines')->get(),
            ]);
    }
    public function staffReservationScannerRoute()
    {
        return view('layouts.staff-components.reservation-components.scanning-qrcode');
    }
    //Inventory Components View
    public function staffViewInventoryRoute()
    {
        return view('layouts.staff-components.inventory-components.view', ['addtblInventoriesC' => tblConsumable::all(), 'addtblInventoriesI' => tblFurniture::all()]);
    }
    //Maintenance Components View
    public function staffViewTaskRoute()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Query the tblScheduleTask to get tasks where the stafflist matches the user ID
        $staffTasks = tblScheduleTask::where(function ($query) use ($userId) {
            $query->where('staff_list', 'LIKE', '%"' . $userId . '"%');
        })->get();

        foreach ($staffTasks as $staffTask) {
            $staffList = json_decode($staffTask->staff_list, true);
            $status = 'No Status Found'; // Default status if not found
            foreach ($staffList as $staff) {
                if ($staff[0] == $userId) {
                    $status = $staff[2]; // Set the status when a match is found
                    break; // Stop searching once a match is found
                }
            }
            $staffTask->status = $status; // Add the status to the staffTask
        }

        return view('layouts.staff-components.maintenance-components.view',
            [
                'staffTasks' => $staffTasks,

            ]);
    }

    public function staffViewPaymentRoute()
    {
        return view('layouts.staff-components.payment-components.view', ['addPayment' => tblPayment::all()]);
    }

    //User Render View
    //Profile
    public function userProfile()
    {
        return view('layouts.user-components.profile', ['userDetails' => User::where('id', auth()->id())->first()]);
    }

    public function userSettingsView()
    {
        try {
            $userId = Auth::user()->id;

            return view('layouts.user-components.settings', [
                'recentActivities' => tblRecentActivity::where('userId', $userId)->get() ?? [],
            ]);
        } catch (\Exception $e) {
            // Handle the exception, or log it for debugging purposes.
            // For now, let's just dump the error message:
            dump($e->getMessage());
        }
    }

    //Calendar Components View
    public function userModify()
    {
        return view('layouts.user-components.partials.modify', ['reservations' => tblReservation::where('recipientId', auth()->id())->get() ?? [], 'guidelines' => tblSettings::where('name', 'guidelines')->get()]);
    }
    //Reservation Components View
    public function userReserve()
    {
        return view('layouts.user-components.partials.reservation', ['currentUsers' => User::where('id', auth()->id())->get() ?? [], 'reservations' => tblReservation::all(), 'availFurnitures' => tblItems::where('type', 'furniture')->get() ?? [], 'facilities' => tblFacility::all(), 'guidelines' => tblSettings::where('name', 'guidelines')->get()]);
    }
    public function userView()
    {
        return view('layouts.user-components.partials.view', ['reservations' => tblReservation::where('recipientId', auth()->id())->get() ?? []]);
    }
    //HelpDesk Components View
    public function helpDesk()
    {
        return view('layouts.user-components.partials.help-desk');
    }

    //Universal Function
    public function getUserProfile()
    {
        $userProfile = User::where('id', auth()->id())->first();

        if (!$userProfile) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        return response()->json([
            'name' => $userProfile->name,
            'email' => $userProfile->email,
            'contact' => $userProfile->contact,
            'birthdate' => $userProfile->birthdate,
            'address' => $userProfile->address,
        ]);
    }

    public function updateUserProfile(Request $request)
    {
        $request->validate([
            'tabActive' => 'required',
        ]);
        $tabActive = $request->input('tabActive');

        $user = User::where('id', auth()->id())->first();

        if (!$user) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        if ($tabActive === "ex-with-icons-tabs-1") {
            $request->validate([
                'name' => 'required',
                'contact' => 'required|size:11',
                'birthdate' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                'address' => 'required',
            ]);

            $newName = $request->input('name');
            $newContact = $request->input('contact');
            $newBDay = $request->input('birthdate');
            $newAddress = $request->input('address');

            $user->name = $newName;
            $user->contact = $newContact;
            $user->birthdate = $newBDay;
            $user->address = $newAddress;
            $user->save();

            return response()->json(['message' => 'Basic infos has been Updated!!']);
        }

        if ($tabActive === "ex-with-icons-tabs-2") {
            $request->validate([
                'email' => 'required|email',
                'userPass' => 'required|match_passwords:confirmPass',
                'confirmPass' => 'required',
            ], [
                'userPass.match_passwords' => 'The passwords do not match.',
            ]);

            $newEmail = $request->input('email');
            $confirmPass = $request->input('confirmPass');

            $validatePass = $user->password;
            if (Hash::check($confirmPass, $validatePass)) {
                $exist = User::where('email', $newEmail)->count(); // Use count() instead of get()
                if ($exist === 0) {
                    $user->email = $newEmail;
                    $user->save();

                    return response()->json(['message' => 'Email has been Updated!!']);
                } else {
                    return response()->json(['error' => 'Email already Exist!!'], 422); //New Error
                }
            } else {
                return response()->json(['error' => 'Confirm Password does not match on actual Password!!'], 422); //New Error
            }
        }

        if ($tabActive === "ex-with-icons-tabs-3") {
            $request->validate([
                'oldPass' => 'required',
                'pass' => 'required|match_passwords:confirm',
                'confirm' => 'required',
            ], [
                'pass.match_passwords' => 'The passwords do not match.',
            ]);

            $oldPass = $request->input('oldPass');
            $newConfirm = $request->input('confirm');

            $validatePass = $user->password;
            if (Hash::check($oldPass, $validatePass)) {
                $user->password = Hash::make($newConfirm);
                $user->save();

                return response()->json(['message' => 'Password has been Updated!!']);
            } else {
                return response()->json(['error' => 'Old Password does not match on actual Password!!'], 422); //New Error
            }
        }
    }

    //Notification
    public function notificationView()
    {
        $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];

        foreach ($userNotifications as $userNotification) {
            if ($userNotification->readed == 0) {
                $userNotification->readed = 1;
            }
            $userNotification->save();
        }

        return view('layouts.admin-components.notification');
    }

    public function notificationDelete()
    {
        $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];

        foreach ($userNotifications as $userNotification) {
            $userNotification->delete();
        }
    }

    public function adminNotifRead($notifId)
    {
        $userNotification = tblNotification::find($notifId);
        $exists = tblNotification::where('id', $notifId)->exists();

        if (!$exists) {
            return response()->json(['message' => 'Item Not Found!!'], 404);
        }

        $userNotification->readed = 1;
        $userNotification->save();

        return response()->json(['message' => 'Notification marked as read successfully'], 200);
    }

    //Notification
    public function userNotification()
    {
        $userNotifications = tblUserNotification::where('userId', auth()->id())->get() ?? [];

        foreach ($userNotifications as $userNotification) {
            if ($userNotification->readed == 0) {
                $userNotification->readed = 1;
            }

            $userNotification->save();
        }

        return view('layouts.user-components.notification');
    }

    public function userNotificationDelete()
    {
        $userNotifications = tblUserNotification::where('userId', auth()->id())->get() ?? [];

        foreach ($userNotifications as $userNotification) {
            if ($userNotification->readed == 0) {
                $userNotification->delete();
            }
        }
    }

    public function userNotifRead($notifId)
    {
        $userNotification = tblUserNotification::find($notifId);

        $exists = tblUserNotification::where('id', $notifId)->exists();

        if (!$exists) {
            return response()->json(['message' => 'Item Not Found!!'], 404);
        }

        $userNotification->readed = 1;
        $userNotification->save();

        return response()->json(['message' => 'Notification marked as read successfully'], 200);
    }

    public function clearActLog()
    {
        $userActivityLogs = tblRecentActivity::where('userId', auth()->id())->get() ?? [];

        foreach ($userActivityLogs as $userActivityLog) {
            $userActivityLog->delete();
        }
    }

    //Audit Log:
    public function reservationAuditRoute()
    {
        $reservationLogs = tblAuditLogs::with('user')
            ->where('type', 'Reservation')
            ->get();

        return view('layouts.admin-components.reservation-components.reservation-audit', ["auditLogs" => $reservationLogs]);
    }

    public function inventoryAuditRoute()
    {
        $inventoryLogs = tblAuditLogs::with('user')
            ->where('type', 'Inventory')->get();
        return view('layouts.admin-components.inventory-components.inventory-audit', ["auditLogs" => $inventoryLogs]);
    }

    public function maintenanceAuditRoute()
    {
        $maintenanceLogs = tblAuditLogs::with('user')
            ->where('type', 'Maintenance')->get();
        return view('layouts.admin-components.maintenance-components.maintenance-audit', ["auditLogs" => $maintenanceLogs]);
    }

    public function paymentAuditRoute()
    {
        $paymentLogs = tblAuditLogs::with('user')
            ->where('type', 'Payment')->get();
        return view('layouts.admin-components.payment-components.payment-audit', ["auditLogs" => $paymentLogs]);
    }
}
