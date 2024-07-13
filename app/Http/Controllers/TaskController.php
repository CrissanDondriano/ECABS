<?php

namespace App\Http\Controllers;
use App\Events\AdminAssign;
use App\Events\AdminUnassign;
use App\Events\AdminUpdateAssign;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\tblTask;
use App\Models\tblTaskLocation;
use App\Models\tblScheduleTask;
use App\Models\tblNotification;
use App\Models\tblAuditLogs;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        // Validate the request data
        $request->validate([
            'taskName' => 'required',
            'taskDescription' => 'required',
        ]);

        // Create a new task record
        $task = new tblTask();
        $task->name = $request->input('taskName');
        $task->description = $request->input('taskDescription');

        // Save the task record
        $task->save();

        return redirect('/admin/maintenance/scheduleTask');
    }

    public function updateTask(Request $request, $taskId)
    {

        $taskName = $request->input('name');
        $taskDescription = $request->input('description');
    
        // Find the Task record by its ID
        $task = tblTask::find($taskId);
    
        // Update the Task data
        $task->name = $taskName;
        $task->description = $taskDescription;

        // Save the updated Task record
        $task->save();
        
    }

    public function deleteTask($taskId)
    {
        $task = tblTask::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->delete();
    }


    public function addLocation(Request $request)
    {
        // Validate the request data
        $request->validate([
            'locationName' => 'required',
        ]);

        // Create a new location record
        $location = new tblTaskLocation();
        $location->location_name = $request->input('locationName');

        // Save the location record
        $location->save();

        return redirect('/admin/maintenance/scheduleTask');
    }

    public function updateLocation(Request $request, $locationId)
    {

        $locationName = $request->input('name');
    
        // Find the Location record by its ID
        $location = tblTaskLocation::find($locationId);
    
        // Update the Location data
        $location->location_name = $locationName;

        // Save the updated Location record
        $location->save();
        
    }

    public function deleteLocation($locationId)
    {
        $location = tblTaskLocation::find($locationId);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        $location->delete();
    }

    public function addScheduleTask(Request $request)
    {
        try {
            $request->validate([
                'taskName' => 'required',
                'taskLocation' => 'required',
                'taskDate' => 'required|date',
            ]);
    
            $maintenance = new tblScheduleTask();
            $maintenance->name = $request->input('taskName');
            $maintenance->location = $request->input('taskLocation');
            $maintenance->date = $request->input('taskDate');
            $maintenance->status = 'In Progress';
    
            // Retrieve the assigned staff data from the request
            $assignedStaffData = json_decode($request->input('assignedStaffData'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON decoding error: ' . json_last_error_msg());
            }

            // Ensure assigned staff data is not empty
            if (empty($assignedStaffData)) {
                throw new \Exception('No staff assigned to the task');
            }

            // Sending Notification to the User
            foreach ($assignedStaffData as $staff) {
                $staffId = $staff[0];

                $newNotif = new tblNotification;
                $newNotif->userId = $staffId;
                $newNotif->description = "Admin assigned you to " . $maintenance->name . " Task into " . $maintenance->location;
                $newNotif->readed = 0;
                $newNotif->save();

                event(new AdminAssign($staffId, "Admin has assign you for ". $maintenance->name ." in ". $maintenance->location));
            }

            $message = " has created a ScheduleTask '". $maintenance->name ."' for ". $maintenance->location;
            $this->createFacilityAudit($message);

            $maintenance->staff_list = json_encode($assignedStaffData);
            $maintenance->save();

            return redirect('/admin/maintenance/scheduleTask');

        } catch (\Exception $e) {
            // Handle the error, e.g., log the error message or return a response to the client.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function approveScheduleTask(Request $request)
    {
        $scheduleTaskId = $request->input('id');
        $request = tblScheduleTask::find($scheduleTaskId);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $currentStaff = json_decode($request->staff_list, true);
        // For Decode Error
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decoding error: ' . json_last_error_msg());
        }

        foreach ($currentStaff as &$staff) {
            $staffStatus = $staff[2];
            if ($staffStatus === "Not Done") {
                $staff[2] = "Unfinished";
            }
        }    

        $message = " has approved the ScheduleTask '". $request->name ."' id: ". $request->id ." to be done.";
        $this->createFacilityAudit($message);

        $request->staff_list = json_encode($currentStaff);
        $request->status = "Done";
        $request->save();

        return redirect('/admin/maintenance/scheduleTask');
    }

    public function updateScheduleTask(Request $request, $scheduleId)
    {

        $scheduleName = $request->input('name');
        $scheduleLocation = $request->input('location');
        $scheduleDate = $request->input('date');
    
        // Find the Location record by its ID
        $schedule = tblScheduleTask::find($scheduleId);

        $message = " has updated the ScheduleTask '". $schedule->name ."' id: ". $schedule->id;
        $this->createFacilityAudit($message);

        // Retrieve the assigned staff data from the request
        $assignedStaffData = json_decode($request->input('assignedStaffData'), true);
        $currentStaff = json_decode($schedule->staff_list, true);

        // For Decode Error
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decoding error: ' . json_last_error_msg());
        }

        // Ensure assigned staff data is not empty
        if (empty($assignedStaffData)) {
            throw new \Exception('No staff assigned to the task');
        }

        foreach ($currentStaff as $staff) {
            $staffId = $staff[0];
            // Check if the current staff is in the assigned staff data
            if (!in_array($staffId, $assignedStaffData)) {
                $newNotif = new tblNotification;
                $newNotif->userId = $staffId;
                $newNotif->description = "Admin has unassigned you from ". $schedule->name .' Task for '. $schedule->location;
                $newNotif->readed = 0;
                $newNotif->save();

                event(new AdminUnassign($staffId, "Admin has unassigned you from the ". $schedule->name ." Task for ". $schedule->location));
            }
        }

        // Sending Notification to the User
        foreach ($assignedStaffData as $staff) {
            $staffId = $staff[0];

            $newNotif = new tblNotification;
            $newNotif->userId = $staffId;
            $newNotif->description = "Admin has update your task from". $schedule->name .' on '. $schedule->location .' into '. $scheduleName .' on '. $scheduleLocation;
            $newNotif->readed = 0;
            $newNotif->save();

            event(new AdminUpdateAssign($staffId, "Admin has updated you task! Go Check it out!!"));
        }
    
        // Update the Location data
        $schedule->name = $scheduleName;
        $schedule->location = $scheduleLocation;
        $schedule->date = $scheduleDate;

        $schedule->staff_list = json_encode($assignedStaffData);
        $schedule->save();
        
    }

    public function deleteScheduleTask($scheduleId)
    {
        $schedule = tblScheduleTask::find($scheduleId);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $currentStaff = json_decode($schedule->staff_list, true);
        // For Decode Error
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decoding error: ' . json_last_error_msg());
        }

        foreach ($currentStaff as $staff) {
            $staff[2] = "Unfinished";
        }   

        $message = " has Mark the ScheduleTask '". $schedule->name ."' id: (". $schedule->id .") as unfinished";
        $this->createFacilityAudit($message);

        $schedule->staff_list = json_encode($currentStaff);
        $schedule->status = "Unfinished";
        $schedule->save();
    }


    public function updateTaskProcedure(Request $request, $taskId)
    {

        $taskDescription = $request->input('description');
    
        // Find the Task record by its ID
        $task = tblTask::find($taskId);

        $message = " has updated the Task Procedure '". $task->name ."' id: ". $task->id;
        $this->createFacilityAudit($message);
    
        $task->description = $taskDescription;

        // Save the updated Task record
        $task->save();
    }

    public function doneScheduleTask(Request $request)
    {
        $scheduleId = $request->input('requestId');
        $userId = auth()->id();
        $schedule = tblScheduleTask::findorfail($scheduleId); // Retrieve the schedule task

        // Check if the staff field is null or empty
        if ($schedule->staff_list !== null) {
            $staff = json_decode($schedule->staff_list, true);

            $allDone = true;

            // Iterate through the staff array
            foreach ($staff as $key => $staffMember) {
                if ($staffMember[0] == $userId) {
                    // Update the status to "Done"
                    $staff[$key][2] = "Done";

                    $message = " has been 'mark as Done' on ScheduleTask '". $schedule->name ."' for ". $schedule->location;
                    $this->createFacilityAudit($message);
                }
                
                if ($staff[$key][2] !== "Done") {
                    $allDone = false;
                }
            }

            // If all staff members have their status set to "Done," update the schedule status as well
            if ($allDone) {
                $schedule->status = "Done";
            }

            // Update the staff column in the database
            $schedule->staff_list = json_encode($staff);
            $schedule->save();
        } else {
            // Handle the case where the staff field is null or empty, e.g., return an error response
            return response()->json(['error' => 'Staff data is missing'], 404);
        }
    }

    private function createFacilityAudit($message){
        $userId = Auth()->id();
        $user = User::find($userId);

        if(!$user){
            return response()->json(['message' => 'User does not exist!!'], 404);
        }

        tblAuditLogs::create([
            'userId' => $userId,
            'type' => "Maintenance",
            'description' => strtok($user->name, ' ') . $message,
        ]);
    }

}
