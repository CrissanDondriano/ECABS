<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Events\AdminAssign;
use App\Events\AdminUnassign;
use App\Models\tblScheduleTask;
use App\Models\tblReservation;
use App\Models\tblNotification;
use App\Models\tblStaffSchedule;
use App\Models\User;

class StaffController extends Controller
{
    //viewRequest for Assign Staff
    public function assignView(Request $request)
    {
        $requestId = $request->input('requestId');
        
        //Retrieve the request with the specified ID
        $newSchedule = tblScheduleTask::findOrFail($requestId);
        
        //Retrieve the items for the request
        $items = $newSchedule->staff_list;
        
        //Convert the items string back to an array
        $itemsArray = json_decode($items, true);
        
        //Return the items as a JSON response
        return response()->json([
            'items' => $itemsArray
        ]);
    }

    public function assignResView(Request $request)
    {
        $requestId = $request->input('requestId');
        
        // Retrieve the request with the specified ID
        $newSchedule = tblReservation::findOrFail($requestId);
        
        // Retrieve the items for the request
        $items = $newSchedule->staff;
        
        // Convert the items string back to an array
        $itemsArray = json_decode($items, true);
        
        // Return the items as a JSON response
        return response()->json([
            'items' => $itemsArray
        ]);
    }

    public function assignResStaff(Request $request)
    {
        $staff = $request->input('staffData');
        $staffId = $request->input('staffDataId');
        $reservationId = $request->input('requestId');

        // Retrieve the record for which you want to update the column
        $requestItem = tblReservation::findOrFail($reservationId);

        // Retrieve the existing staff list from the column
        $existingStaffList = $requestItem->staff;

        // Decode the existing staff list from JSON to an array
        $existingStaffListArray = $existingStaffList ? json_decode($existingStaffList, true) : [];

        // Check if the new staff already exists in the staff list
        $newStaff = $staff;
        $isStaffAlreadyExists = false;
        foreach ($existingStaffListArray as $existingStaff) {
            if ($existingStaff === $newStaff) {
                $isStaffAlreadyExists = true;
                break;
            }
        }

        if ($isStaffAlreadyExists) {
            return response()->json(['message' => 'Staff already exists'], 400);
        }

        $dateReservation = $requestItem->date;

        if($requestItem->event_type === "Big Event"){
            $startDateTime = $dateReservation. " 07:00:00";
            $endDateTime = $dateReservation. " 22:00:00";
        }else{
            $timeRange = $requestItem->time;
            list($startTime, $endTime) = explode('-', $timeRange);

            $startTimeCarbon = Carbon::parse($startTime);
            $endTimeCarbon = Carbon::parse($endTime);

            // Replace the date portion with $dateReservation
            $startTimeCarbon->setDateFrom($dateReservation);
            $endTimeCarbon->setDateFrom($dateReservation);

            $startDateTime = $startTimeCarbon->format('Y-m-d H:i:s');
            $endDateTime = $endTimeCarbon->format('Y-m-d H:i:s');
        }

        // $newStaff array with additional date and time information
        $newStaff = array_merge($newStaff, [$startDateTime, $endDateTime]);

        // Merge the new staff into the existing staff list
        $updatedStaffList = array_merge($existingStaffListArray, [$newStaff]);

        // Encode the updated staff list back to JSON
        $updatedStaffListJson = json_encode($updatedStaffList);

        // Update the column with the new value
        $requestItem->staff = $updatedStaffListJson;

        // Save the changes
        $requestItem->save();

        // Sending Notification to the User
        $newNotif = new tblNotification;
        $newNotif->userId = $staffId;
        $newNotif->description = "Admin assigned you to " . $requestItem->facility . " for " . $requestItem->activity ." Reservation on ". $requestItem->date ." between ". $requestItem->time;
        $newNotif->readed = 0;
        $newNotif->save();

        event(new AdminAssign($staffId, "Admin has assign you on reservation for ". $requestItem->activity ." in ". $requestItem->facility));
    }

    public function removeResStaff(Request $request)
    {   
        $staff = $request->input('staffData');
        $staffId = $request->input('staffDataId');
        $reservationId = $request->input('requestId');

        $requestItem = tblReservation::findOrFail($reservationId);

        $existingStaffList = $requestItem->staff;
        $existingStaffListArray = $existingStaffList ? json_decode($existingStaffList, true) : [];

        foreach ($existingStaffListArray as $key => $existingStaff) {
            if ($existingStaff === $staff) {
                unset($existingStaffListArray[$key]);
                break;
            }
        }

        // Reindex the array after removing the staff member
        $existingStaffListArray = array_values($existingStaffListArray);

        // Encode the updated staff list back to JSON
        $updatedStaffListJson = json_encode($existingStaffListArray);

        // Update the column with the new value
        $requestItem->staff = $updatedStaffListJson;

        // Save the changes
        $requestItem->save();

        // Sending Notification to the User
        $newNotif = new tblNotification;
        $newNotif->userId = $staffId;
        $newNotif->description = "Admin unassigned you from ". $requestItem->facility ." for ". $requestItem->activity ." Reservation on ". $requestItem->date ." between ". $requestItem->time;
        $newNotif->readed = 0;
        $newNotif->save();

        event(new AdminUnassign($staffId, "Admin has unassign you on reservation for ". $requestItem->activity ." in ". $requestItem->facility));

        return response()->json(['message' => 'Staff updated successfully'], 200);
    }

    public function staffAvailability(Request $request)
    {
        $request->validate([
            'staffId' => 'required|string',
            'staffReason' => 'required|string',
            'startStaffDate' => 'required|date',
            'endStaffDate' => 'required|date',
            'staffAvailType' => 'required',
        ]);

        $staffId = $request->input('staffId');
        $staffReason = $request->input('staffReason');
        $startStaffDate = $request->input('startStaffDate');
        $endStaffDate = $request->input('endStaffDate');
        $staffAvailType = $request->input('staffAvailType');

        $newSchedule = new tblStaffSchedule();
        $newSchedule->staffId = $staffId;
        $newSchedule->staffReason = $staffReason;
        $newSchedule->startDate = $startStaffDate;
        $newSchedule->endDate = $endStaffDate;
        $newSchedule->availability = $staffAvailType;
        $newSchedule->save();
    }

    public function availableResStaff(Request $request)
    {
        $reservationId = $request->input('reservationId');
        $staff = User::where('type', 2)->get();
        
        $reservation = tblReservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['message' => "Reservation Doesn't Exist!!"], 404);
        }

        $reservationDate = $reservation->date;
        $reservationTime = $reservation->time;
        $availableStaff = [];

        foreach ($staff as $s) {
            $staffId = $s->id;
            $alreadyAssigned = false;

            //Check if the staff is not Available
            $staffSchedule = tblStaffSchedule::where('staffId', $staffId)
                ->where('startDate', '<=', $reservationDate)
                ->where('endDate', '>=', $reservationDate)
                ->where('availability', 'notAvail')
                ->first();

            //Check if the staff is already Assigned
            $existReservations = tblReservation::where("date", $reservationDate)->where("time", $reservationTime)->get();
            if($existReservations){
                foreach($existReservations as $existReservation){
                    $staffList = json_decode($existReservation->staff, true);
                    if($staffList){
                        foreach ($staffList as $staffInfo) {
                            if (in_array($staffId, $staffInfo)) {
                                $alreadyAssigned = true;
                                break;
                            }
                        }
                    }
                }
            }

            if (!$staffSchedule && !$alreadyAssigned) {
                // Staff is available for the given reservation date
                $availableStaff[] = $s;
            }
        }

        // $availableStaff now contains a list of staff members available for the reservation
        return response()->json(['availableStaff' => $availableStaff]);
    }

    public function availableStaff(Request $request)
    {
        $scheduleDate = $request->input('selectedDate');
        $staff = User::where('type', 2)->get();

        $availableStaff = [];

        foreach ($staff as $s) {
            $staffId = $s->id;
            $alreadyAssigned = false;
            
            // Assuming you have a model for tblStaffSchedule named StaffSchedule
            $staffSchedule = tblStaffSchedule::where('staffId', $staffId)
                ->where('startDate', '<=', $scheduleDate)
                ->where('endDate', '>=', $scheduleDate)
                ->where('availability', 'notAvail')
                ->first();

            //Check if the staff is already Assigned
            $existTasks = tblScheduleTask::where("date", $scheduleDate)->where('status', "In Progress")->get();
            if($existTasks){
                foreach($existTasks as $existTask){
                    $staffList = json_decode($existTask->staff_list, true);
                    if($staffList){
                        foreach ($staffList as $staffInfo) {
                            if (in_array($staffId, $staffInfo)) {
                                $alreadyAssigned = true;
                                break;
                            }
                        }
                    }
                }
            }

            if (!$staffSchedule && !$alreadyAssigned) {
                // Staff is available for the given reservation date
                $availableStaff[] = $s;
            }
        }

        // $availableStaff now contains a list of staff members available for the reservation
        return response()->json(['availableStaff' => $availableStaff]);
    }

    public function staffLeaveList(Request $request)
    {
        $staffId = $request->input('staffId');
        $staff = tblStaffSchedule::where('staffId', $staffId)->first();
        $staffSched = tblScheduleTask::all();
        $staffReservation = tblReservation::all();

        $events = [];

        if ($staff) {
            $events[] = [
                "title" => "Not Available",
                "start" => $staff->startDate,
                "end" => $staff->endDate,
                "color" => "red",
                "allDay" => true
            ];
        }

        foreach ($staffSched as $task) {
            // Assuming staff_list is an array of arrays
            $staffList = json_decode($task->staff_list, true);

            if ($staffList) {
                // Check if $staffId exists in any subarray
                foreach ($staffList as $staffInfo) {
                    if (in_array($staffId, $staffInfo)) {
                        $events[] = [
                            'title' => "Task: " . $task->name . " on " . $task->location,
                            'start' => $task->date,
                            "color" => "#ef8354",
                            'eventType' => 'Staff Task',
                        ];
                        break;
        
                        // // Check if an event with the same date already exists
                        // $existingEventIndex = null;
                        // foreach ($events as $index => $existingEvent) {
                        //     if ($existingEvent['start'] == $eventToAdd['start']) {
                        //         $existingEventIndex = $index;
                        //         break;
                        //     }
                        // }
        
                        // if ($existingEventIndex !== null) {
                        //     // If an event with the same date exists, concatenate titles with a <br> tag
                        //     $events[$existingEventIndex]['title'] .= " " . $eventToAdd['title'];
                        // } else {
                        //     // If no existing event found, add the new event
                        //     $events[] = $eventToAdd;
                        // }
        
                        // break;
                    }
                }
            }
        }

        foreach ($staffReservation as $reservations) {
            // Assuming staff_list is an array of arrays
            $staffList = json_decode($reservations->staff, true);

            if ($staffList) {
                // Check if $staffId exists in any subarray
                foreach ($staffList as $staffInfo) {
                    if (in_array($staffId, $staffInfo)) {
                        if ($reservations->event_type === "Big Event") {
                            $events[] = [
                                'title' => "Big Event: " . $reservations->activity . " on " . $reservations->facility,
                                'start' => $reservations->date . " 07:00:00",
                                'end' => $reservations->date . " 22:00:00",
                                "color" => "#1f7a8c",
                                'eventType' => 'Big Event',
                            ];
                        }
                        if ($reservations->event_type === "Small Event") {
                            $startTimeCarbon = $staffInfo[2];
                            $endTimeCarbon = $staffInfo[3];

                            $events[] = [
                                'title' => $reservations->activity . " on " . $reservations->facility,
                                'start' => $startTimeCarbon,
                                'end' => $endTimeCarbon,
                                "color" => "blue",
                                'eventType' => 'Small Event',
                            ];
                        }
                        break;

                        // // Check if an event with the same date already exists
                        // $existingEventIndex = null;
                        // foreach ($events as $index => $existingEvent) {
                        //     if ($existingEvent['start'] == $eventToAdd['start']) {
                        //         $existingEventIndex = $index;
                        //         break;
                        //     }
                        // }
        
                        // if ($existingEventIndex !== null) {
                        //     // If an event with the same date exists, concatenate titles with a <br> tag
                        //     $events[$existingEventIndex]['title'] .= " " . $eventToAdd['title'];
                        // } else {
                        //     // If no existing event found, add the new event
                        //     $events[] = $eventToAdd;
                        // }
                    }
                }
            }
        }

        return response()->json([
            'events' => $events
        ]);
    }

    // public function staffOverallList() {
    //     $staffs = User::where('type', 2)->get() ?? [];
    //     $staffTasks = tblScheduleTask::all();
    //     $staffReservations = tblReservation::where('status', 'Approved')->get();

    //     $events = [];

    //     foreach ($staffs as $staff) {
    //         $staffId = $staff->id;
    //         foreach ($staffTasks as $task) {
    //             $staffList = json_decode($task->staff_list, true);

    //             if($staffList){
    //                 // Check if $staffId exists in any subarray
    //                 foreach ($staffList as $staffInfo) {
    //                     if (in_array($staffId, $staffInfo)) {
    //                         // If match is found, add the $schedule to the $staffTaskList
    //                         $events[] = [
    //                             'title' => "Task: " .$task->name. " on " .$task->location. " (" .$staff->name. ")",
    //                             'start' => $task->date,
    //                             'eventType' => 'Staff Task',
    //                         ];
    //                     }
    //                 }
    //             }
    //         }

    //         foreach ($staffReservations as $reservations) {
    //             $staffList = json_decode($reservations->staff, true);

    //             if($staffList){
    //                 // Check if $staffId exists in any subarray
    //                 foreach ($staffList as $staffInfo) {
    //                     if (in_array($staffId, $staffInfo)) {
    //                         if($reservations->event_type === "Big Event"){
    //                             $events[] = [
    //                                 'title' => "Big Event: " .$reservations->activity. " on " .$reservations->facility. " (" .$staff->name. ")",
    //                                 'start' => $reservations->date. " 07:00:00",
    //                                 'end' => $reservations->date. " 22:00:00",
    //                                 'eventType' => 'Big Event',
    //                             ];

    //                         }
    //                         if($reservations->event_type === "Small Event"){
    //                             $startTimeCarbon = $staffInfo[2];
    //                             $endTimeCarbon = $staffInfo[3];

    //                             $events[] = [
    //                                 'title' => $reservations->activity. " on " .$reservations->facility. " (" .$staff->name. ")",
    //                                 'start' => $startTimeCarbon,
    //                                 'end' => $endTimeCarbon,   
    //                                 'eventType' => 'Small Event',  
    //                             ];

    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return response()->json( [
    //         'events' => $events
    //     ]);
    // }
    
    public function staffOverallList() {
        $staffs = User::where('type', 2)->get() ?? [];
        $staffTasks = tblScheduleTask::all();
        $staffReservations = tblReservation::where('status', 'Approved')->get();
    
        $events = [];
    
        foreach ($staffTasks as $task) {
            $taskEvents = [];
    
            foreach ($staffs as $staff) {
                $staffId = $staff->id;
                $staffList = json_decode($task->staff_list, true);
    
                if($staffList){
                    foreach ($staffList as $staffInfo) {
                        if (in_array($staffId, $staffInfo)) {
                            $taskEvents[$task->id][] = $staff->name;
                            break; // No need to continue checking other staffInfo
                        }
                    }
                }
            }
    
            // Combine events for tasks
            foreach ($taskEvents as $taskId => $staffNames) {
                $events[] = [
                    'title' => "Task: " . $task->name . " on " . $task->location . " (" . implode(', ', $staffNames) . ")",
                    'start' => $task->date,
                    'eventType' => 'Task',
                ];
            }
        }
    
        foreach ($staffReservations as $reservations) {
            $reservationEvents = [];
    
            foreach ($staffs as $staff) {
                $staffId = $staff->id;
                $staffList = json_decode($reservations->staff, true);
    
                if($staffList){
                    foreach ($staffList as $staffInfo) {
                        if (in_array($staffId, $staffInfo)) {
                            $reservationEvents[$reservations->id][] = $staff->name;
                            break; // No need to continue checking other staffInfo
                        }
                    }
                }
            }
    
            // Combine events for reservations
            foreach ($reservationEvents as $reservationId => $staffNames) {
                if ($reservations->event_type === "Big Event") {
                    $events[] = [
                        'title' => "Big Event: " . $reservations->activity . " on " . $reservations->facility . " (" . implode(', ', $staffNames) . ")",
                        'start' => $reservations->date. " 07:00:00",
                        'end' => $reservations->date. " 22:00:00",
                        'eventType' => 'Big Event',
                    ];
                } elseif ($reservations->event_type === "Small Event") {
                    $startTimeCarbon = $staffInfo[2];
                    $endTimeCarbon = $staffInfo[3];
            
                    // Check if an event with the same date and time already exists
                    $existingEventIndex = null;
                    foreach ($events as $index => $existingEvent) {
                        if ($existingEvent['start'] == $startTimeCarbon && $existingEvent['end'] == $endTimeCarbon) {
                            $existingEventIndex = $index;
                            break;
                        }
                    }
            
                    if ($existingEventIndex !== null) {
                        // If an event with the same date and time exists, concatenate titles with a newline character
                        $events[$existingEventIndex]['title'] .= "\n" . $reservations->activity . " on " . $reservations->facility . " (" . implode(', ', $staffNames) . ")";
                    } else {
                        // If no existing event found, add the new event
                        $events[] = [
                            'title' => $reservations->activity . " on " . $reservations->facility . " (" . implode(', ', $staffNames) . ")",
                            'start' => $startTimeCarbon,
                            'end' => $endTimeCarbon,
                            'eventType' => 'Small Event',
                        ];
                    }
                }
            }
        }

        // Check if an event with the same date already exists
        // $existingEventIndex = null;
        // foreach ($events as $index => $existingEvent) {
        //     if ($existingEvent['start'] == $eventToAdd['start']) {
        //         $existingEventIndex = $index;
        //         break;
        //     }
        // }

        // if ($existingEventIndex !== null) {
        //     // If an event with the same date exists, concatenate titles with a <br> tag
        //     $events[$existingEventIndex]['title'] .= " " . $eventToAdd['title'];
        // } else {
        //     // If no existing event found, add the new event
        //     $events[] = $eventToAdd;
        // }
    
        return response()->json([
            'events' => $events
        ]);
    }
}