<?php
 
use App\Http\Controllers\ScanQRCodeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\OtpController;

use App\Models\tblFacility;
use App\Models\tblReservation;
use App\Models\tblEvent;
use App\Models\tblSettings;
use App\Models\User;

Route::get('/', function () {
    Artisan::call('storage:link');
    $currentDate = now()->toDateString();

    $currentEvents = tblEvent::whereDate('end_date', '>=', $currentDate)
        ->get();

    $currentNumber = tblSettings::where('name','businessNumber')->firstOrFail();
    $currentEmail = tblSettings::where('name', 'businessEmail')->firstOrFail();

    return view('welcome', [
        'renters' => User::where('type', 0)->get(),
        'staffs' => User::where('type', 2)->get(),
        'facilities' => tblFacility::all(),
        'reservations' => tblReservation::all(),
        'currentEvents' => $currentEvents, 
        'currentNumber' => $currentNumber->value,
        'currentEmail' => $currentEmail->value,
    ]);
});


Route::get('/schedule-page', function () {
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

    return view('auth.schedule', [
        'events_show' => $combinedData,
        'events' => $events
        
    ]);
})->name('schedule');

// 404 Error
Route::get('/error404', function () {
    return view('partials.error404');
})->name('error404');

Route::get('/maintenanceServer', function () {
    return view('partials.maintenance');
})->name('maintenanceServer');

//reservationItemsStatus
Route::get('/itemStatusUpdate', [ReservationController::class, 'itemStatusUpdate']);

//reservationPaymetStatus
Route::get('/reservationPaymentStatusUpdate', [ReservationController::class, 'reservationPaymentStatusUpdate']);

//Get the UserId
Route::get('/getUserId', [HomeController::class, 'getUserId']);

//Get the UserId
Route::get('/sentEmail', [HomeController::class, 'sentEmail']);

//New OTP Routes
Route::any('/confirmation', [OtpController::class, 'showConfirmationForm'])->name('confirmation.show');
Route::any('/finalConfirmation', [OtpController::class, 'finalConfirmation'])->name('confirmation.final');

//Auth Routes
Auth::routes();
   
//Normal Users Routes List
Route::middleware(['user-access:user'])->group(function () {

    //Profile
    Route::get('/userProfile', [HomeController::class, 'userProfile'])->name('userProfile');
    
    Route::get('/user/profile/get', [HomeController::class, 'getUserProfile']);
    Route::get('/user/profile/update', [HomeController::class, 'updateUserProfile']);

    //Settings
    Route::get('/user/settingsView', [HomeController::class, 'userSettingsView'])->name('user.settingsView');

    //Notification
    Route::get('/userNotification', [HomeController::class, 'userNotification'])->name('userNotification');
    Route::get('/userNotifRead/{notifId}', [HomeController::class, 'userNotifRead'])->name('userNotifRead');
    Route::get('/user/delete_notification', [HomeController::class, 'userNotificationDelete'])->name('user.delete.notification');
    Route::get('/user/delete_activity_log', [HomeController::class, 'clearActLog'])->name('user.delectActivity.log');

    //Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Calendar Route
    Route::get('/modify-reservation', [HomeController::class, 'userModify'])->name('modifyReservation');
    Route::post('/modify-reservation/update', [ReservationController::class, 'updateReservation']);
    Route::post('/modify-reservation/cancel', [ReservationController::class, 'cancelReservation']);
    Route::post('/modify-reservation/view', [ReservationController::class, 'getQrCode']);

    //Make Reservation Route
    Route::get('/make-reservation', [HomeController::class, 'userReserve'])->name('makeReservation');
    //Functions
    Route::post('/make-reservation/createReservation', [ReservationController::class, 'createReservation']);
    Route::post('/make-reservation/validateReservation', [ReservationController::class, 'validateReservation']);
    Route::post('/make-reservation/checkAvailability', [ReservationController::class, 'checkAvailability']);
    Route::get('/get-reservation-count', [ReservationController::class, 'getReservationCount'])->name('get-reservation-count');
    Route::post('/make-reservation/labelPriceUpdate', [ReservationController::class, 'labelPriceUpdate']);
    Route::post('/user/reservation/view_reservation', [ReservationController::class, 'view_reservation']);

    //View Reservation Route
    Route::get('/view-reservation', [HomeController::class, 'userView'])->name('viewReservation');

    //Help Desk Route
    Route::get('/helpDesk', [HomeController::class, 'helpDesk'])->name('helpDesk');

    //Change Time Menu
    Route::get('/timeMenuChanger', [ReservationController::class, 'timeMenuChanger']);

});
   
//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    // Profile
    Route::get('/admin/profileView', [HomeController::class, 'profileView'])->name('admin.profileView');
    Route::get('/admin/profile/get', [HomeController::class, 'getUserProfile']);
    Route::get('/admin/profile/update', [HomeController::class, 'updateUserProfile']);

    // Settings
    Route::get('/admin/settingsView', [HomeController::class, 'settingsView'])->name('admin.settingsView');

    // Permission
    Route::get('/admin/permissionView', [HomeController::class, 'permissionView'])->name('admin.permissionView');

    // Notification
    Route::get('/admin/notificationView', [HomeController::class, 'notificationView'])->name('admin.notificationView');
    Route::get('/admin/delete_notification', [HomeController::class, 'notificationDelete'])->name('admin.delete.notification');
    Route::get('/admin/delete_activity_log', [HomeController::class, 'clearActLog'])->name('admin.delete.activity.log');
    Route::get('/adminNotifRead/{notifId}', [HomeController::class, 'adminNotifRead'])->name('adminNotifRead');

    //Home
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::get('/admin/manageUser', [HomeController::class, 'manageUsersView'])->name('admin.manageUsersView');
    Route::get('/admin/manageTeamScheduler', [HomeController::class, 'manageTeamScheduler'])->name('admin.manageTeamScheduler');
    
    //Reservation Routes
    Route::get('/admin/reservation/review', [HomeController::class, 'reservationReviewRoute'])->name('admin.reservation.review');
    Route::get('/admin/reservation/manage', [HomeController::class, 'reservationManageRoute'])->name('admin.reservation.manage');
    Route::get('/admin/reservation/scanQR', [HomeController::class, 'reservationScannerRoute'])->name('admin.reservation.scanQR');
    Route::get('/admin/reservation/view', [HomeController::class, 'adminReservationViewRoute'])->name('admin.reservation.view');
    Route::get('/admin/reservation/view-calendar', [HomeController::class, 'adminReservationViewCalendarRoute'])->name('admin.reservation.view-calendar');
   
    //Inventory Routes
    Route::get('/admin/inventory/mail-content', [HomeController::class, 'mailContentRoute']);
    Route::get('/admin/inventory/purchase', [HomeController::class, 'purchaseRoute'])->name('admin.inventory.purchase');
    Route::get('/admin/inventory/manage', [HomeController::class, 'manageInventoryRoute'])->name('admin.inventory.manage');
    Route::get('/admin/inventory/view', [HomeController::class, 'adminViewInventoryRoute'])->name('admin.inventory.view');

    //Maintenance Routes
    Route::get('/admin/maintenance/add', [HomeController::class, 'addFacilityRoute'])->name('admin.maintenance.add');
    Route::get('/admin/maintenance/scheduleTask', [HomeController::class, 'scheduleTaskRoute'])->name('admin.maintenance.scheduleTask');
    // Route::get('/admin/maintenance/assignTask', [HomeController::class, 'assignTaskRoute'])->name('admin.maintenance.assignTask');
    Route::get('/admin/maintenance/updateProcedure', [HomeController::class, 'updateProcedureRoute'])->name('admin.maintenance.updateProcedure');
    Route::get('/admin/maintenance/viewTask', [HomeController::class, 'adminViewTaskRoute'])->name('admin.maintenance.viewTask');

    //Payment Routes
    Route::get('/admin/payment/manage', [HomeController::class, 'managePaymentRoute'])->name('admin.payment.manage');
    Route::get('/admin/payment/view', [HomeController::class, 'viewPaymentRoute'])->name('admin.payment.view');

    //Generate Report Route
    Route::get('/admin/report/generate', [HomeController::class, 'generateReportRoute'])->name('admin.report.generate');

    Route::get('/admin/report/generate/reservationSummary', [ReportController::class, 'reservationSummary'])->name('admin.report.reservation.summary');
    Route::get('/admin/report/generate/reservationCancelled', [ReportController::class, 'reservationCancelled'])->name('admin.report.reservation.cancelled');
    Route::get('/admin/report/generate/reservationOverall', [ReportController::class, 'reservationOverall'])->name('admin.report.reservation.overall');

    Route::post('/admin/report/generate/saveReportData', [ReportController::class, 'saveReportData']);
    Route::post('/admin/report/generate/deleteReportData', [ReportController::class, 'deleteReportData']);
    Route::get('/admin/report/fetchReportContent/{id}', [ReportController::class, 'fetchReportContent']);
    Route::get('/admin/report/fetchCopyReportContent/{id}', [ReportController::class, 'fetchCopyReportContent']);

    Route::get('/admin/report/generate/inventoryStock', [ReportController::class, 'inventoryStock'])->name('admin.report.inventory.stock');
    Route::get('/admin/report/generate/inventoryMovement', [ReportController::class, 'inventoryMovement'])->name('admin.report.inventory.movement');
    Route::get('/admin/report/generate/inventoryOverall', [ReportController::class, 'inventoryOverall'])->name('admin.report.inventory.overall');

    Route::get('/admin/report/generate/maintenanceSummary', [ReportController::class, 'maintenanceSummary'])->name('admin.report.maintenance.summary');
    Route::get('/admin/report/generate/maintenanceRequest', [ReportController::class, 'maintenanceRequest'])->name('admin.report.maintenance.request');
    Route::get('/admin/report/generate/maintenanceOverall', [ReportController::class, 'maintenanceOverall'])->name('admin.report.maintenance.overall');

    Route::get('/admin/report/generate/paymentSummary', [ReportController::class, 'paymentSummary'])->name('admin.report.payment.summary');
    Route::get('/admin/report/generate/paymentHistory', [ReportController::class, 'paymentHistory'])->name('admin.report.payment.history');
    Route::get('/admin/report/generate/paymentOverall', [ReportController::class, 'paymentOverall'])->name('admin.report.payment.overall');

    //Functions

    //Settings
    Route::get('/admin/settings/toggleMaintenanceMode', [SettingsController::class, 'toggleMaintenanceMode']);
    Route::post('/admin/settings/update_guidelines', [SettingsController::class, 'updatingGuidelines']);
    Route::post('/admin/settings/update_contact', [SettingsController::class, 'updatingBusinessContact']);

    //User Management
    Route::post('/admin/userManage/add_user', [PermissionController::class, 'addUser']);
    Route::post('/admin/userManage/update_user', [PermissionController::class, 'updateUser']);
    Route::post('/admin/userManage/delete_user/{userId}', [PermissionController::class, 'deleteUser']);

    //Inventory(manageInventory)
    Route::post('/admin/inventory/addInventory', [InventoryController::class, 'addInventory']);
    Route::post('/admin/inventory/addItem', [InventoryController::class, 'addItem'])->name('admin.inventory.addItem');
    Route::post('/admin/inventory/updateListItem/{itemId}', [InventoryController::class, 'updateListItem'])->name('admin.inventory.updateItem');
    Route::post('/admin/inventory/deleteListItem/{itemId}', [InventoryController::class, 'deleteListItem']);
    Route::post('/admin/inventory/addRequestItem/{itemId}', [InventoryController::class, 'addRequestItem'])->name('admin.inventory.addRequestItem');
    Route::post('/admin/inventory/send_letter', [InventoryController::class, 'sendEmail']);

    Route::post('/admin/inventory/deleteRequestItem/{itemId}', [InventoryController::class, 'deleteRequestItem']);
    Route::post('/admin/inventory/generateRequest', [InventoryController::class, 'generateRequest']);
    Route::post('/admin/inventory/getItems', [InventoryController::class, 'getItems']);
    Route::post('/admin/inventory/deleteRequest/{itemId}', [InventoryController::class, 'deleteRequest']);
    Route::post('/admin/inventory/approveRequest', [InventoryController::class, 'approveRequest']);
    Route::post('/admin/inventory/rejectRequest/{requestId}', [InventoryController::class, 'rejectRequest']);
    Route::post('/admin/inventory/view_inventory_qr', [InventoryController::class, 'getQrCode']);

    Route::post('/admin/inventory/addConsumable', [InventoryController::class, 'addConsumable']);
    Route::post('/admin/inventory/updateConsumable/{id}', [InventoryController::class, 'updateConsumable'])->name('admin.inventory.updateConsumable');
	Route::post('/admin/inventory/markReserved/{id}', [InventoryController::class, 'markReserved'])->name('admin.inventory.markReserved');
    Route::post('/admin/inventory/markAvailable/{id}', [InventoryController::class, 'markAvailable'])->name('admin.inventory.markAvailable');
	Route::post('/admin/inventory/markDamaged/{id}', [InventoryController::class, 'markDamaged'])->name('admin.inventory.markDamaged');

    //Maintenance(manageMaintenance)
    Route::post('/admin/maintenance/addFacility', [FacilityController::class, 'addFacility']);
    Route::post('/admin/maintenance/updateFacility/{facilityId}', [FacilityController::class, 'updateFacility']);
    Route::post('/admin/maintenance/deleteFacility/{facilityId}', [FacilityController::class, 'deleteFacility']);

    Route::post('/admin/maintenance/addTask', [TaskController::class, 'addTask']);
    Route::post('/admin/maintenance/updateTask/{taskId}', [TaskController::class, 'updateTask']);
    Route::post('/admin/maintenance/deleteTask/{taskId}', [TaskController::class, 'deleteTask']);

    Route::post('/admin/maintenance/addLocation', [TaskController::class, 'addLocation']);
    Route::post('/admin/maintenance/updateLocation/{locationId}', [TaskController::class, 'updateLocation']);
    Route::post('/admin/maintenance/deleteLocation/{locationId}', [TaskController::class, 'deleteLocation']);

    Route::post('/admin/maintenance/addScheduleTask', [TaskController::class, 'addScheduleTask']);
    Route::post('/admin/maintenance/approveScheduleTask', [TaskController::class, 'approveScheduleTask']);
    Route::post('/admin/maintenance/updateScheduleTask/{scheduleId}', [TaskController::class, 'updateScheduleTask']);
    Route::post('/admin/maintenance/deleteScheduleTask/{scheduleId}', [TaskController::class, 'deleteScheduleTask']);

    Route::post('/admin/maintenance/assignView', [StaffController::class, 'assignView']);
    Route::post('/admin/maintenance/updateTaskProcedure/{taskId}', [TaskController::class, 'updateTaskProcedure']);

    Route::post('/admin/maintenance/staffAvailability', [StaffController::class, 'staffAvailability']);
    Route::post('/admin/maintenance/availableResStaff', [StaffController::class, 'availableResStaff']);
    Route::post('/admin/maintenance/availableStaff', [StaffController::class, 'availableStaff']);

    Route::post('/admin/maintenance/staffLeaveList', [StaffController::class, 'staffLeaveList']);
    Route::post('/admin/maintenance/staffOverallList', [StaffController::class, 'staffOverallList']);

    //Payment(managePayment)
    Route::post('/admin/payment/addPayment', [PaymentController::class, 'addPayment']);
    Route::post('/admin/payment/approvePayment', [PaymentController::class, 'approvePayment']);
    Route::post('/admin/payment/updatePayment', [PaymentController::class, 'updatePayment']);
    Route::post('/admin/payment/deletePayment/{paymentId}', [PaymentController::class, 'deletePayment']);
    Route::post('/admin/payment/viewPayment', [PaymentController::class, 'viewPayment']);

    //Reservation(manageReservation)
    Route::post('/admin/reservation/approveReservation', [ReservationController::class, 'approveReservation']);
    Route::post('/admin/reservation/declineReservation', [ReservationController::class, 'declineReservation']);
    Route::post('/admin/reservation/addEvent', [ReservationController::class, 'addEvent']);
    Route::post('/admin/reservation/updateEvent', [ReservationController::class, 'updateEvent']);
    Route::post('/admin/reservation/deleteEvent', [ReservationController::class, 'deleteEvent']);
    Route::post('/admin/reservation/view_reservation', [ReservationController::class, 'view_reservation']);
    Route::get('/download/{filename}', [ReservationController::class, 'showAttachment'])->name('showAttachment');
    Route::get('/admin/reservation/assignResStaff', [StaffController::class, 'assignResStaff']);
    Route::post('/admin/reservation/assignResView', [StaffController::class, 'assignResView']);
    Route::get('/admin/reservation/removeResStaff', [StaffController::class, 'removeResStaff']);

    //Reservation Content Update
    Route::get('/admin/reservation/price_add', [SettingsController::class, 'addPrice']);
    Route::get('/admin/reservation/price_update', [ReservationController::class, 'specificPriceUpdate']);
    Route::get('/admin/reservation/price_delete', [SettingsController::class, 'deletePrice']);

    //Reservation(scanningQRCode)
    Route::post('/admin/reservation/scanningQrCode', [ScanQRCodeController::class, 'scanningQrCode']);
    Route::post('/admin/inventory/scanningInventoryQrCode', [ScanQRCodeController::class, 'scanningInventoryQrCode']);

    //Audit Log Routes
    Route::get('/admin/reservation/audit-log', [HomeController::class, 'reservationAuditRoute'])->name('admin.reservation.audit');
    Route::get('/admin/inventory/audit-log', [HomeController::class, 'inventoryAuditRoute'])->name('admin.inventory.audit');
    Route::get('/admin/maintenance/audit-log', [HomeController::class, 'maintenanceAuditRoute'])->name('admin.maintenance.audit');
    Route::get('/admin/payment/audit-log', [HomeController::class, 'paymentAuditRoute'])->name('admin.payment.audit');
});
   
//Staff Routes List
Route::middleware(['user-access:staff'])->group(function () {
    //Profile
    Route::get('/staff/staffProfile', [HomeController::class, 'staffProfile'])->name('staff.staffProfile');
    Route::get('/staff/profile/get', [HomeController::class, 'getUserProfile']);
    Route::get('/staff/profile/update', [HomeController::class, 'updateUserProfile']);

    Route::get('/staff/settingsView', [HomeController::class, 'staffSettingsView'])->name('staff.settingsView');

    //Notification
    Route::get('/staff/staffNotification', [HomeController::class, 'staffNotification'])->name('staff.staffNotification');
    Route::get('/staffNotifRead/{notifId}', [HomeController::class, 'staffNotifRead'])->name('staffNotifRead');
    Route::get('/staff/delete_notification', [HomeController::class, 'notificationDelete'])->name('staff.delete.notification');
    Route::get('/staff/delete_activity_log', [HomeController::class, 'clearActLog'])->name('staff.delectActivity.log');

    //Home
    Route::get('/staff/home', [HomeController::class, 'staffHome'])->name('staff.home');

    Route::get('/staff/reservation/scanQR', [HomeController::class, 'staffReservationScannerRoute'])->name('staff.reservation.scanQR');

    //Reservation Routes
    Route::get('/staff/reservation/view', [HomeController::class, 'staffReservationViewRoute'])->name('staff.reservation.view');

    //Inventory Routes
    Route::get('/staff/inventory/view', [HomeController::class, 'staffViewInventoryRoute'])->name('staff.inventory.view');
    
    //Maintenance Routes
    Route::get('/staff/maintenance/viewTask', [HomeController::class, 'staffViewTaskRoute'])->name('staff.maintenance.viewTask');

    //Payment Record Routes
    Route::get('/staff/payment/view', [HomeController::class, 'staffViewPaymentRoute'])->name('staff.payment.view');
    Route::post('/staff/payment/viewPayment', [PaymentController::class, 'viewPayment']);

    //Reservation(scanningQRCode)
    Route::post('/staff/reservation/scanningQrCode', [ScanQRCodeController::class, 'scanningQrCode']);
    Route::post('/staff/inventory/scanningInventoryQrCode', [ScanQRCodeController::class, 'scanningInventoryQrCode']);

    Route::post('/staff/reservation/view_reservation', [ReservationController::class, 'view_reservation']);

    //Staff Done Task
    Route::post('/staff/maintenance/done_task', [TaskController::class, 'doneScheduleTask']);

});
