<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

use Illuminate\Http\Request;

use App\Events\UserReserve;
use App\Events\UserCancel;
use App\Events\AdminApprove;
use App\Events\AdminDecline;
use App\Events\AdminUnassign;

use App\Models\tblReservation;
use App\Models\tblEvent;
use App\Models\tblNotification;
use App\Models\tblItems;
use App\Models\tblFurniture;
use App\Models\tblUserNotification;
use App\Models\tblAuditLogs;
use App\Models\tblPayment;
use App\Models\tblPrices;
use App\Models\tblSettings;
use App\Models\User;


class ReservationController extends Controller
{
    public function createReservation(Request $request)
    {
        // Validate the form data
        $request->validate([
            //Add validation rules for the form fields
            'facilitySelect' => 'required|string',
            'rentersName' => 'required|string',
            'categorySelect'=> 'required|string|not_in:',
            'organization'=> 'required|string',
            'contactNumber' => 'required|string|min:11|regex:/^09\d{9}$/|numeric',
            'address' => 'required|string',
            'activitySelect' => 'required|string',
            'eventSelect' => 'required|string',
            // 'equipmentSelect' => 'required|string',
            // 'quantityNum' => 'required|integer'
        ]);

        // Replace the following lines with your reservation creation logic
        $rentersName = $request->input('rentersName');
        $event_selected = $request->input('eventSelect');
        $time_selected = $request->input('timeSelect');

        // $equipmentList = $request->input('equipmentList');
        $equipmentSelect = $request->input('equipmentSelect'); 

        $facility = $request->input('facilitySelect');
        $activity = $request->input('activitySelect');
        $organizationType = $request->input('categorySelect');

        $reservation = new tblReservation();
        $reservation->name = $rentersName;
        $reservation->recipientId = $request->input('rentersId');
        $reservation->recipientName = $request->input('rentersName');
        $reservation->orgType = $organizationType;
        $reservation->organization = $request->input('organization');
        $reservation->contact_number = $request->input('contactNumber');
        $reservation->address = $request->input('address');
        $reservation->facility = $facility;

        $sDate = $request->input('reservationDate');
        $carbonDate = Carbon::createFromFormat('F d, Y', $sDate);
        $date = $carbonDate->format('Y-m-d');
        $reservation->date = $date;

        if($event_selected === "Big Event"){
            $reservation->time = "Whole Day";

            if ($request->hasFile('attachmentSelect')) {

                $attachment = $request->file('attachmentSelect');

                // Check if the uploaded file is valid
                if (!$attachment->isValid()) {
                    return response()->json(['message' => 'Invalid file upload.'], 400);
                }

                $allowedExtensions = ['pdf', 'doc', 'docx', 'PDF', 'DOC', 'DOCX'];
                
                $fileExtension = $attachment->getClientOriginalExtension();
                if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                    return response()->json(['message' => 'Invalid file format. Only PDF and document files are allowed.'], 404);
                }

                $storagePath = public_path('attachments');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }

                $filename = uniqid() . '.' . $fileExtension;

                $attachment->move($storagePath, $filename);

                $tempAttachments = 'attachments/' . $filename;

                $reservation->attachment = $tempAttachments;

            }else {
                return response()->json(['message' => 'There are no attachments attached!!'], 404);
            }

        }else {
            $reservation->time = $time_selected;
            // if($time_selected == "7:00AM-"){
            //     $reservation->startTime = "00:00:00";
            //     $reservation->startTime = "23:00:00";
            // }
            $reservation->attachment = "";
        }

        $reservation->status = "Pending";
        $reservation->reason = "None";
        $reservation->activity = $activity;

        $reservation->equipment_needed =  $equipmentSelect;

        // if(!$equipmentList){
        //     $reservation->equipment_needed = "none";
        // }else{
        //     $equipment_needed_list = []; // Initialize an empty array for the equipment
        //     foreach ($equipmentList as $key) {
        //         // Access individual equipment properties using $equipment['name'] and $equipment['value']
        //         $name = $key['name'];
        //         $value = $key['value'];

        //         $equipment_needed_list[] = $key;
        //     }
            
        //     $reservation->equipment_needed = json_encode($equipment_needed_list);
        // }
        
        $reservation->quantity = 0;

        $reservation->event_type = $event_selected;
        $reservation->staff = "";
        $reservation->qrcode = "";

        //Inventory System
        // $item = tblItems::where($equipment_selected);
        // $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Available")->get();
        // $count = $tblFurniture->count();
        // if($count <= $item_quantity){
        //     return response()->json(['message' => 'The no. of equipment available in Inventory is not enough to the no. of Equipments Required!! Available Equipment: '. $count], 410);
        // }else{
        //     //Create payment
        //     $formattedDate = str_replace('-', '', $date);
        //     $payment = new tblPayment;
        //     $payment->control_no = "";
        //     $payment->name = $rentersName;
        //     $itemPrice = tblPrices::where('facility', $facility)->where('organization', $organizationType)->where('activity', $activity)->first();
            
        //     if(!$itemPrice){
        //         return response()->json(['message' => 'There are no Price Listed for the said Request'], 404);
        //     }

        //     //Save Reservation
        //     $reservation->save();

        //     //Create Payment 2
        //     $payment->amount = $itemPrice->prices;
        //     $payment->status = "Unpaid";
        //     $payment->date = $date;
        //     $payment->reservationId = $reservation->id;
        //     $payment->save();
        //     $payment->control_no = 'CN'. $formattedDate .'-'. str_pad($payment->id, 4, '0', STR_PAD_LEFT);
        //     $payment->save();

        //     // Use the min of $count and $item_quantity to determine how many items to reserve
        //     $itemsToReserve = min($count, $item_quantity);

        //     foreach ($tblFurniture->take($itemsToReserve) as $furniture) {
        //         $furniture->status = 'Reserved';
        //         $furniture->reservationId = $reservation->id;
        //         $furniture->save();
        //     }
        // }

        //Inventory System
        // Check if $equipmentList is not empty
        if (!empty($equipmentList)) {
            foreach ($equipmentList as $equipmentItem) {
                $itemName = $equipmentItem['name'];
                $itemValue = (int) $equipmentItem['value'];

                $item = tblItems::where('name', $itemName)->first();
                if(!$item){
                    return response()->json(['message' => $itemName .' item is out of stock. Please call the contact for the concern'], 404);
                }
                $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Available")->get();
                if(!$tblFurniture){
                    return response()->json(['message' => $itemName .' equipment is out of stock. Please call the contact for the concern'], 404);
                }
                $count = $tblFurniture->count();
                if($count <= $itemValue){
                    return response()->json(['message' => 'The no. of '. $itemName .' available in Inventory is not enough to the no. of '. $itemName .' Required!! Available '. $itemName .': '. $count], 410);
                }else{
                    // Use the min of $count and $item_quantity to determine how many items to reserve
                    $itemsToReserve = min($count, $itemValue);

                    //save the reserrvation details
                    $reservation->save();

                    foreach ($tblFurniture->take($itemsToReserve) as $furniture) {
                        $furniture->status = 'Reserved';
                        $furniture->reservationId = $reservation->id;
                        $furniture->save();
                    }
                }
            }
        } else {
            $reservation->save();
        }

        //Create payment
        $formattedDate = str_replace('-', '', $date);
        $payment = new tblPayment;
        $payment->control_no = "";
        $payment->name = $rentersName;
        $itemPrice = tblPrices::where('facility', $facility)->where('organization', $organizationType)->where('activity', $activity)->first();
        
        if(!$itemPrice){
            return response()->json(['message' => 'There are no Price Listed for the said Request'], 404);
        }

        $payment->amount = $itemPrice->prices;
        $payment->status = "Unpaid";
        $payment->date = $date;
        $payment->reservationId = $reservation->id;
        $payment->save();

        $payment->control_no = 'CN'. $formattedDate .'-'. str_pad($payment->id, 4, '0', STR_PAD_LEFT);
        $payment->save();

        //Number
        $currentNumber = tblSettings::where('name','businessNumber')->firstOrFail();

        // Nexmo Function
        // $basic  = new Basic("0b084dc3", "8IiqVm2JHUOUBwLx");
        // $client = new Client($basic);

        // $client->sms()->send(
        //     new SMS("63".$currentNumber->value , "ECABS", '[ECABS] A user has made a reservation. Please review our system for details.')
        // );

        //Reserved Facility
        $message = " has Reserved on ". $facility ." for ". $activity;
        $this->createFacilityAudit($message);

        event(new UserReserve('A user has reserve!! Check the reservation for more info'));

        return response()->json(['message' => 'Reservation created successfully']);
    }

    public function validateReservation(Request $request)
    {   
        $userId = Auth()->id();
        $user = User::find($userId);

        $class = $request->input('class');
        
        $request->validate([
            'event' => 'required|string',
        ]);

        $event = $request->input('event');

        if($class === "step-1"){
            if($event === "Big Event"){
                $request->validate([
                    'date' => 'required',
                    'facility' => 'required|string',
                    'category' => 'required|string',
                    // 'equipment' => 'required|string',
                ]);
            }else{
                $request->validate([
                    'date' => 'required',
                    'facility' => 'required|string',
                    'time' => 'required|string',
                    'category' => 'required|string',
                    // 'equipment' => 'required|string',
                ]);
            }
        }else{

            $request->validate([
                'renter' => 'required|string',
                'contact' => 'required|digits_between:11,11|starts_with:09',
                'address' => 'required|string',
                'organization' => 'required|string',
            ],[
                'contact.digits_between' => 'The contact field must be 11 digits only.',
            ]);
        }

        return response()->json(['userContact' => $user->contact]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'reservationDate' => 'required|string',
        ]);

        $rentersId = $request->input('rentersId');

        //Formatted Date
        $sDate = $request->input('reservationDate');
        $carbonDate = Carbon::createFromFormat('F d, Y', $sDate);
        $date = $carbonDate->format('Y-m-d');

        $event = $request->input('eventSelect');
        $facility = $request->input('facilitySelect');
        
        if($event === "Big Event") {
            if ($date) {
                // Check if the selected date is 7 days or more from now
                $selectedDate = Carbon::parse($date);
                $sevenDaysFromNow = Carbon::now()->addDays(6);
        
                if ($selectedDate->lte($sevenDaysFromNow)) {
                    return response()->json(['message' => 'The selected date must be at least 7 days from now.'], 404);
                }
            }
            $time = "";
        }else {
            $request->validate([
                'timeSelect' => 'required|string',
            ]);

            $timeRange = $request->input('timeSelect');
            // Split the time range into start and end times
            list($startTime, $endTime) = explode('-', $timeRange);

            $endTimeCarbon = Carbon::parse($endTime, 'Asia/Manila');
            $currentTime = Carbon::now('Asia/Manila');
            $currentDate = $currentTime->toDateString();

            if ($endTimeCarbon->lt($currentTime) && $currentDate == $date) {
                return response()->json(['message' => 'the selected time has already passed on!!'], 404);
            }

            $time = $request->input('timeSelect');
        }

        $user = User::findorfail($rentersId);
        if ($user->endCooldownDate && Carbon::now()->lt($user->endCooldownDate)) {
            return response()->json(['message' => 'You had a cooldown due to an approved reservation!! End Cooldown in: '. substr($user->endCooldownDate, 0, 10)], 404);
        }

        $exist = tblReservation::where('date', $date)->where('event_type','Big-Event')->where('status', 'Approved')
            ->exists();

        $partOfEvent = tblEvent::where('start_date', '<=', $date)->where('end_date', '>=', $date)
            ->get();

        if(!$exist && $partOfEvent->isEmpty()){
            $isAvailable = tblReservation::where('date', $date)
            ->where('time', $time)
            ->where('facility', $facility)
            ->where(function ($query) {
                $query->where('status', 'Approved')
                ->orWhere('status', 'Pending');
            })
            ->doesntExist();

            $message = $isAvailable ? '' : 'Selected time is not available. Please choose another time.';

            return response()->json(['is_available' => $isAvailable, 'message' => $message]);
        }else {
            return response()->json(['is_available' => $exist, 'message' => 'There is an Event from the date you chose, try the other Available dates.']);
        }
    }

    public function timeMenuChanger(Request $request)
    {
        // Formatted Date
        $sDate = $request->input('reserveDate');
        $carbonDate = Carbon::createFromFormat('F d, Y', $sDate);
        $date = $carbonDate->format('Y-m-d');

        $requestFacility = $request->input('requestFacility');
        $eventReservations = tblReservation::where('date', $date)
            ->where('facility', $requestFacility)
            ->where(function ($query) {
                $query->where('status', 'Pending')
                    ->orWhere('status', 'Approved');
            })
            ->get();

        // Extract reserved time slots from existing reservations
        $reservedTimeSlots = $eventReservations->pluck('time')->toArray();

        // Your original menu options
        $timeToShow = [
            "",
            "7:00AM-12:00PM",
            "1:00PM-5:00PM",
            "6:00PM-10:00PM"
        ];

        // Remove reserved time slots from the menu options
        $updatedTimeOptions = array_values(array_diff($timeToShow, $reservedTimeSlots));

        return response()->json(['updatedTimeOptions' => $updatedTimeOptions, 'reservedTimeSlots' => $reservedTimeSlots]);
    }


    public function getReservationCount(Request $request)
    {
        $isoDate = $request->input('date');
        $date = Carbon::parse($isoDate);

        $facility = ["Aquatic Center", "Multi-purpose Hall"];

        // $exist = tblReservation::where('date', $date)
        //     ->where('event_type', 'Big-Event')
        //     ->where('status', 'Approved')
        //     ->whereHas('facilities', function ($query) {
        //         $query->where('name', 'Aquatic Center');
        //     })
        //     ->whereHas('facilities', function ($query) {
        //         $query->where('name', 'Multi-purpose Hall');
        //     })
        //     ->exists();

        $exist = tblReservation::where('date', $date)
            ->where('event_type', 'Big-Event')
            ->where('status', 'Approved')
            ->whereIn('facility', $facility)
            ->exists();

        $partOfEvent = tblEvent::where('start_date', '<=', $date)->where('end_date', '>=', $date)->get();

        if(!$exist && $partOfEvent->isEmpty()){
            $facility = ["Aquatic Center", "Multi-purpose Hall"];
            $count = tblReservation::where('date', $date)
                ->whereIn('facility', $facility)
                ->whereIn('status', ['Approved', 'Pending'])
                ->where('event_type', 'Small-Event')
                ->count();
        }else {
            $count = 6;
            $allTime = "";
        }

        return response()->json(['count' => $count]);
    }

    public function view_reservation(Request $request)
    {
        $reviewId = $request->input('reviewId');
        $reviewEquipment = $request->input('reviewEquipment');

        $reservation = tblReservation::find($reviewId);

        $existPayment = tblPayment::where('reservationId', $reviewId)->first();

        if (!$existPayment) {
            $reservationPrice = "0 (Approval to Calculate)";
        }else{
            $reservationPrice = $existPayment->amount;
        }

        // Inventory System
        // $exist = tblItems::find($reviewEquipment);
        // $existPayment = tblPayment::where('reservationId', $reviewId)->first();

        // if(!$exist){
        //     return response()->json(['message' => 'Item not found'], 404);
        // }
        
        // $tblFurniture = tblFurniture::where('name', $exist->name)->where("reservationId", $reviewId)->get();

        // // Build an array to hold the furniture items
        // $furnitureItems = [];

        // foreach ($tblFurniture as $furniture) {
        //     // Append each furniture item to the array
        //     $furnitureItems[] = [
        //         'itemId' => $furniture->itemId,
        //         'name' => $furniture->name // Add more properties as needed
        //     ];
        // }
        
        // $itemName = $exist->name

        $furniture = [];

        // Check if $reviewEquipment is a string and contains "none"
        if (is_string($reviewEquipment) && stripos($reviewEquipment, 'none') !== false) {
            $furniture = ["none"];
        } else {
            // Decode the JSON string to an associative array
            $equipment = is_string($reviewEquipment) ? json_decode($reviewEquipment, true) : $reviewEquipment;

            // Check if $equipment is not empty
            if (!empty($equipment)) {
                $furniture = []; // Initialize $furniture array

                foreach ($equipment as $equipmentItem) {
                    $itemName = $equipmentItem['name'];
                    $itemValue = $equipmentItem['value'];

                    // Add each equipment item to the $furniture array
                    $furniture[] = ['name' => $itemName, 'value' => $itemValue];
                }
            } else {
                return response()->json(['message' => 'The Equipment List is Blank (must be need to be "none")'], 404);
            }
        }
        
        return response()->json([
            'reviewRecipientId' => $reservation->recipientId,
            'reviewRecipient' => $reservation->recipientName,
            'organization' => $reservation->organization,
            'contactNumber' => $reservation->contact_number,
            'address' => $reservation->address,
            'activity' => $reservation->activity,
            'eventType' => $reservation->event_type,
            'reviewDate' => $reservation->date,
            'reviewTime' => $reservation->time,
            'reviewLocation' => $reservation->facility,
            'reviewStatus' => $reservation->status,
            
            // 'itemName' => $itemName,
            // 'reviewQuantity' => $reservation->quantity,
            'furnitureItems' => $furniture, // Include the furniture items in the response\

            'reviewAttachments' => $reservation->attachment,
            'reservationPrice' => $reservationPrice,
        ]);
    }

    public function approveReservation(Request $request)
    {
        $reservationId = $request->input('reservationId');
        $recipientId = $request->input('recipientId');

        //Check Approved Payment
        $paidCheck = tblPayment::where('reservationId', $reservationId)->where('status', 'Paid')->first();
        if(!$paidCheck){
            return response()->json(['message' => 'The payment for this reservation has not paid yet!!'], 404);
        }

        $payment = new tblPayment;
        $reservation = tblReservation::find($reservationId);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        
        $recipientId = $reservation->recipientId;
        $recipientName = $reservation->recipientName;
        $date = $reservation->date;
        $time = $reservation->time;
        $facility = $reservation->facility;
        $organizationType = $reservation->orgType;
        $activity = $reservation->activity;
        $status = $reservation->status;

        if($status === "Cancelled"){
            return response()->json(['message' => 'The Reservation had been already Declined by the User'], 404);
        }

        $exist = tblReservation::where('date', $date)->where('event_type','Big-Event')->where('status', 'Approved')->where('facility', $facility)
            ->exists();

        $partOfEvent = tblEvent::where('start_date', '<=', $date)->where('end_date', '>=', $date)
            ->get();

        $alreadyApproved = tblReservation::where('date', $date)->where('time', $time)->where('event_type','Small-Event')->where('status', 'Approved')->where('facility', $facility)
            ->exists();

        if($reservation->event_type === "Big-Event"){
            if(!$alreadyApproved && !$exist && $partOfEvent->isEmpty()){
                $listOfEvents = tblReservation::where('date', $reservation->date)
                    ->where('facility', $reservation->facility)
                    ->where(function ($query) {
                    $query->where('status', 'Approved')
                        ->orWhere('status', 'Pending');
                    })
                    ->where('event_type', 'Small-Event')->get() ?? [];

                foreach($listOfEvents as $listOfEvent){
                    $listOfEvent->status = "Cancelled";
                    $listOfEvent->save();

                    $newNotif = new tblUserNotification;
                    $newNotif->userId = $listOfEvent->recipientId;
                    $newNotif->description = "Your Reservation in ". $reservation->facility ." for ". $reservation->activity ." has suddenly cancelled because of an Event";
                    $newNotif->readed = 0;
                    $newNotif->save();
                }
                
                // Generate QR code for the reservation
                $qrCode = QrCode::size(100)->generate(json_encode($reservationId));
                $qrCodeData = base64_encode($qrCode);
                // Save the QR code data to the database
                $reservation->qrcode = $qrCodeData;

                if ($reservation->attachment) {
                    // Remove the attachment from storage
                    Storage::delete($reservation->attachment);
                }

                $reservation->status = "Approved";
            }else {
                return response()->json(['message' => 'An another reservation or Event has already been approved!!'], 404);
            }
        }else {
            if(!$alreadyApproved && !$exist && $partOfEvent->isEmpty()){
                // Generate QR code for the reservation
                $qrCode = QrCode::size(100)->generate(json_encode($reservationId));
                $qrCodeData = base64_encode($qrCode);

                // Save the QR code data to the database
                $reservation->qrcode = $qrCodeData;
                $reservation->status = "Approved";
            }else {
                return response()->json(['message' => 'An another reservation or Event has already been approved!!'], 404);
            }
        }

        $newNotif = new tblUserNotification;
        $newNotif->userId = $recipientId;
        $newNotif->description = "Admin approved your reservation on ". $reservation->facility ." for ". $reservation->activity;
        $newNotif->readed = 0;

        //Create Payment
        $formattedDate = str_replace('-', '', $date);
        $payment->control_no = "";
        $payment->name = $recipientName;
        $itemPrice = tblPrices::where('facility', $facility)->where('organization', $organizationType)->where('activity', $activity)->firstorfail();
        
        if(!$itemPrice){
            return response()->json(['message' => 'There are no Price Listed for the said Request'], 404);
        }

        $payment->amount = $itemPrice->prices;
        $payment->status = "Unpaid";
        $payment->date = $date;
        $payment->reservationId = $reservationId;
        $payment->save();
        $payment->control_no = 'CN'. $formattedDate .'-'. str_pad($payment->id, 4, '0', STR_PAD_LEFT);

        //User one week cooldown
        $user = User::findorfail($recipientId);
        // Calculate the end of the cooldown period (1 week from now)
        $cooldownEndDate = Carbon::now()->addWeek();
        // Update the 'endCooldownDate' for the user
        $user->endCooldownDate = $cooldownEndDate;

        $user->save();
        $reservation->save();
        // $payment->save();
        $newNotif->save();

        // Nexmo Function
        // $originalNumber = $reservation->contact_number;
        // $originalNumber = ltrim($originalNumber, '0');

        // $newNumber = "63".$originalNumber;

        // $basic  = new Basic("0b084dc3", "8IiqVm2JHUOUBwLx");
        // $client = new Client($basic);
        // $client->sms()->send(
        //     new SMS($newNumber, "ECABS", '[ECABS] Your reservation has been approved by the admin. Have a great day!')
        // );

        $message = " has Approved the Reservation of ". $reservation->recipientName ." on ". $facility ." for ". $activity;
        $this->createFacilityAudit($message);

        event(new AdminApprove($recipientId, "Admin has approved your reservation for ". $activity ." in ". $facility));
    }

    public function declineReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reasonDetails' => 'required|string|filled',
        ]);

        $reservationId = $request->input('reservationId');
        $recipientId = $request->input('recipientId');
        $reasonDetails = $request->input('reasonDetails');
        $type = $request->input('type');

        $reservation = tblReservation::find($reservationId);
        $equipment = $equipment = json_decode($reservation->equipment_needed, true);
        $recipientId = $reservation->recipientId;

        if (!$reservation) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $reservation->status = "Cancelled";

        if ($reservation->attachment) {
            // Remove the attachment from storage
            Storage::delete($reservation->attachment);
        }

        $newNotif = new tblUserNotification;
        $newNotif->userId = $recipientId;
        if($type == 1 || $validator->fails()){
            $reservation->reason = "Admin Comment: Sorry for the inconvenience! We're facing some difficulties but are actively working to fix them. Thanks for your patience.";
            $newNotif->description = "Admin declined your reservation on ". $reservation->facility ." for ". $reservation->activity;
        }else{
            $reservation->reason = "Admin Comment: ". $reasonDetails;
            $newNotif->description = "Admin cancelled your reservation on ". $reservation->facility ." for ". $reservation->activity ."! Check the Details for more informations";
        }
        
        $newNotif->readed = 0;
        $newNotif->save();

        //Inventory System
        // $item = tblItems::findorfail($equipment);
        // $tblFurniture = tblFurniture::where('name', $item->name)->where("reservationId", $reservationId)->get();

        // foreach ($tblFurniture as $furniture) {
        //     if($furniture->reservationId == $reservationId){
        //         $furniture->status = 'Available';
        //         $furniture->reservationId = "0";
        //         $furniture->save();
        //     }
        // }

        //New Inventory System
        // Check if $equipment is not empty
        if (!empty($equipment) && !is_string($equipment)) {
            foreach ($equipment as $equipmentItem) {
                $itemName = $equipmentItem['name'];

                $item = tblItems::where('name', $itemName)->first();
                if(!$item){
                    return response()->json(['message' => $itemName .' item is not exist in the List'], 404);
                }
                $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Reserved")->get();
                if(!$tblFurniture){
                    return response()->json(['message' => $itemName .' equipment is not exist in the List'], 404);
                }

                foreach ($tblFurniture as $furniture) {
                    if($furniture->reservationId == $reservationId){
                        $furniture->status = 'Available';
                        $furniture->reservationId = "0";
                        $furniture->save();
                    }
                }
            }
        } else {
            //nothing what else?
        }

        // Retrieve the assigned staff data from the request
        $assignedStaffData = json_decode($reservation->staff, true);

        if (!empty($assignedStaffData)) {
            // Sending Notification to the User
            foreach ($assignedStaffData as $staff) {
                $staffId = $staff[0];

                $newNotif = new tblNotification;
                $newNotif->userId = $staffId;
                $newNotif->description = "Your assigned reservation for ". $reservation->activity ." in ". $reservation->facility ." has been Declined by the Admin";
                $newNotif->readed = 0;
                $newNotif->save();

                event(new AdminUnassign($staffId, "One of your assigned reservation has been declined by the Admin"));
            }
        }

        //User one week cooldown
        $user = User::findorfail($recipientId);
        // Calculate the end of the cooldown period (1 week from now)
        $cooldownEndDate = "";
        // Update the 'endCooldownDate' for the user
        $user->endCooldownDate = $cooldownEndDate;
        $user->save();

        $reservation->save();

        $message = " has Decline the Reservation of ". $reservation->recipientName ." on ". $reservation->facility ." for ". $reservation->activity;
        $this->createFacilityAudit($message);
        
        event(new AdminDecline($recipientId, "Admin has decline your reservation for ". $reservation->activity ." in ". $reservation->facility));
    }

    public function showAttachment($filename)
    {
        $filePath = public_path('attachments') . '/' . $filename;

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'Attachment file not found.'], 404);
        }

        Log::info('File Path: ' . $filePath);

        return response()->file($filePath);
    }


    public function updateReservation(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string'
        ]);

        $reservationId = $request->input('id');
        $reserveeName = $request->input('name');
        $reservationDate = $request->input('date');
        $reservationTime = $request->input('time');

        $reservation = tblReservation::find($reservationId);

        if(!$reservation){
            return response()->json(['error' => 'Reservation does not exist!!']);
        }

        $message = " has Updated their Reservation on ". $reservation->facility ." for ". $reservation->activity;
        $this->createFacilityAudit($message);

        $facility = $reservation->facility;

        $isExist = tblReservation::where('date', $reservationDate)
            ->where('time', $reservationTime)
            ->where('facility', $facility)
            ->exists();

        if($isExist){
            return response()->json(['message' => 'Someone already book on the specific time'], 404);
        }

        $reservation->name = $reserveeName;
        $reservation->recipientName = $reserveeName;
        $reservation->date = $reservationDate;
        $reservation->time = $reservationTime;
        $reservation->save();

        event(new UserReserve('A user has updated their Reservation!! Check the reservation tab for more info'));
    }

    public function cancelReservation(Request $request)
    {
        $reservationId = $request->input('id');
        $reservationName = $request->input('name');
        $reasonDetails = $request->input('reason');

        $reservation = tblReservation::find($reservationId);
        if(!$reservation){
            return response()->json(['message' => 'Reservation do not exist!!'], 404);
        }

        $status = $reservation->status;
        $recipientId = $reservation->recipientId;

        if ($reservation->attachment) {
            // Remove the attachment from storage
            Storage::delete($reservation->attachment);
        }

        $equipment = json_decode($reservation->equipment_needed, true);
        
        //Inventory System
        // $item = tblItems::findorfail($equipment);
        // $tblFurniture = tblFurniture::where('name', $item->name)->where("reservationId", $reservationId)->get();

        // foreach ($tblFurniture as $furniture) {
        //     if($furniture->reservationId == $reservationId){
        //         $furniture->status = 'Available';
        //         $furniture->reservationId = "0";
        //         $furniture->save();
        //     }
        // }

        //New Inventory System
        // Check if $equipment is not empty
        if (!empty($equipment) && !is_string($equipment)) {
            foreach ($equipment as $equipmentItem) {
                $itemName = $equipmentItem['name'];

                $item = tblItems::where('name', $itemName)->first();
                if(!$item){
                    return response()->json(['message' => $itemName .' item is not exist in the List. Call the contact for this technical Concern'], 404);
                }
                $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Reserved")->get();
                if(!$tblFurniture){
                    return response()->json(['message' => $itemName .' equipment is not exist in the List. Call the contact for this technical Concern'], 404);
                }

                foreach ($tblFurniture as $furniture) {
                    if($furniture->reservationId == $reservationId){
                        $furniture->status = 'Available';
                        $furniture->reservationId = "0";
                        $furniture->save();
                    }
                }
            }
        } else {
            //nothing what else?
            // return response()->json(['message' => 'item is not exist in the List.'], 404);
        }

        if($status === "Approve"){
            // Retrieve the assigned staff data from the request
            $assignedStaffData = json_decode($reservation->staff, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON decoding error: ' . json_last_error_msg());
            }

            // Sending Notification to the User
            foreach ($assignedStaffData as $staff) {
                $staffId = $staff[0];

                $newNotif = new tblNotification;
                $newNotif->userId = $staffId;
                $newNotif->description = "Your assigned reservation for ". $reservation->activity ." in ". $reservation->facility ." has been Cancelled by the User";
                $newNotif->readed = 0;
                $newNotif->save();

                event(new AdminUnassign($staffId, "One of your assigend reservation has been Cancelled by the User"));
            }
        }

        $reservation->status = 'Cancelled';
        $reservation->reason = 'Client comment: '. $reasonDetails;

        //User one week cooldown
        $user = User::findorfail($recipientId);
        // Calculate the end of the cooldown period (1 week from now)
        $cooldownEndDate = "";
        // Update the 'endCooldownDate' for the user
        $user->endCooldownDate = $cooldownEndDate;
        $user->save();

        $reservation->save();

        // Send notification to users with type 1
        $usersToNotify = User::where('type', 1)->get();

        foreach ($usersToNotify as $user) {
            $newNotif = new tblNotification;
            $newNotif->userId = $user->id;
            $newNotif->description = $reservationName ." cancelled his/her reservation for ". $reservation->activity ." in ". $reservation->facility ." for reason: ". $reasonDetails;
            $newNotif->readed = 0;
            $newNotif->save();   
        }

        $message = " has cancelled his/her Reserved on ". $reservation->activity ." for ". $reservation->facility;
        $this->createFacilityAudit($message);

        event(new UserCancel($reservationName .' has cancel its Reservation for'. $reservation->date));
    }

    public function specificPriceUpdate(Request $request)
    {
        $request->validate([
            'priceValue' => 'required|integer'
        ]);

        $id = $request->input('priceId');
        $value = $request->input('priceValue');

        $priceItem = tblPrices::find($id);

        if(!$priceItem){
            return response()->json(['message' => 'The Price Item doesnt exist!!'], 404);
        }

        $priceItem->prices = $value;
        $priceItem->save();
    }

    public function labelPriceUpdate(Request $request)
    {
        // Define the validation rules
        $rules = [
            'categorySelect' => 'required|string|filled',
            'activitySelect' => 'required|string|filled',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){
            $organization = $request->input('categorySelect');
            $activity = $request->input('activitySelect');
            $facility = $request->input('facilitySelect');

            $priceItem = tblPrices::where('facility', $facility)->where('activity', $activity)->where('organization', $organization)->first();

            if(!$priceItem){
                $priceLabel = "Prize still not Implemented Yet";
            }else{
                $priceLabel = $priceItem->prices;
            }
            
            return response()->json(['priceLabel' => $priceLabel]);
        }else{
            return;
        }
    }

    public function addEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation rules here
        ]);

        $eventName = $request->input('name');
        $eventDescription = $request->input('description');
        $startDate = $request->input('startDate');
        $startEnd = $request->input('endDate');

        $newEvent = new tblevent;
        $newEvent->title = $eventName;

        // $this->reservationCleansing($startDate, $startEnd);

        $isBigEvent= false;

        $reservationLists = tblReservation::all();
        foreach($reservationLists as $reservationList){
            $reservationDate = Carbon::parse($reservationList->date);
            $startRange = Carbon::parse($startDate);
            $endRange = Carbon::parse($startEnd);

            // Check if the reservation date is within the range
            if ($reservationDate->between($startRange, $endRange)) {
                // Check if reservation status is "Big-Event"
                if ($reservationList->event_type === "Big Event" || $reservationList->event_type === "Small Event") {
                    $isBigEvent = true;
                }
            }
        }

        if($isBigEvent){
            return response()->json(['message' => "There's an Event(s) already approved within the range of Date!!"], 404);
        }

        $newEvent->description = $eventDescription;

        if ($request->hasFile('image')) {
             $eventImage = $request->file('image');
             $fileContent = file_get_contents($eventImage->path());
             $filename = $eventImage->getClientOriginalName();
        
             Storage::disk('uploads')->put($filename, $fileContent);
        
             $newEvent->image = $filename;
        }

        $message = " has announced the ". $eventName ." Event that will be ongoing on ". $startDate ." to ". $startEnd;
        $this->createFacilityAudit($message);

        $newEvent->start_date = $startDate;
        $newEvent->end_date = $startEnd;
        $newEvent->save();
    }

    public function updateEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        $eventId = $request->input('id');
        $event = tblevent::find($eventId);

        if (!$event) {
            return response()->json(['message' => "The Event Doesn't Exist!!"], 404);
        }

        $message = " has updated the ". $event->title ." Event";
        $this->createFacilityAudit($message);

        $eventName = $request->input('name');
        $eventDescription = $request->input('description');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $event->title = $eventName;

        $this->reservationCleansing($startDate, $endDate);

        $event->description = $eventDescription;

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($event->image) {
                Storage::disk('uploads')->delete($event->image);
            }

            $eventImage = $request->file('image');
            $fileContent = file_get_contents($eventImage->path());
            $filename = $eventImage->getClientOriginalName();
        
            Storage::disk('uploads')->put($filename, $fileContent);
        
            $event->image = $filename;
        }

        $event->start_date = $startDate;
        $event->end_date = $endDate;

        $event->save();

        return response()->json(['message' => 'Event updated successfully']);
    }

    public function reservationCleansing($startDate, $startEnd){
        $isBigEvent= false;

        $reservationLists = tblReservation::all();
        foreach($reservationLists as $reservationList){
            $reservationDate = Carbon::parse($reservationList->date);
            $startRange = Carbon::parse($startDate);
            $endRange = Carbon::parse($startEnd);

            // Check if the reservation date is within the range
            if ($reservationDate->between($startRange, $endRange)) {
                // Check if reservation status is "Big-Event"
                if ($reservationList->event_type === "Big Event" || $reservationList->event_type === "Small Event") {
                    $isBigEvent = true;
                }
            }
        }

        if($isBigEvent){
            return response()->json(['message' => "There's an Event(s) already approved within the range of Date!!"], 404);
        }else{
            // $smallEventLists = tblReservation::all();
            // foreach($smallEventLists as $smallEventList){
            //     $smallEventDate = Carbon::parse($smallEventList->date);
            //     $smallEventStatus = $smallEventList->status;
            //     $startRange = Carbon::parse($startDate);
            //     $endRange = Carbon::parse($startEnd);

            //     // Check if the reservation date is within the range
            //     if ($smallEventDate->between($startRange, $endRange) && ($smallEventStatus === "Approved")) {
                    // $smallEventList->status = "Cancelled";

                    // // Retrieve the assigned staff data from the request
                    // $assignedStaffData = json_decode($smallEventList->staff, true);

                    // if (json_last_error() !== JSON_ERROR_NONE) {
                    //     // throw new \Exception('JSON decoding error: ' . json_last_error_msg());
                    // }

                    // if (!empty($assignedStaffData)) {
                    //     // Sending Notification to the User
                    //     foreach ($assignedStaffData as $staff) {
                    //         $staffId = $staff[0];

                    //         $newNotif = new tblNotification;
                    //         $newNotif->userId = $staffId;
                    //         $newNotif->description = "Your assigned reservation for ". $smallEventList->activity ." in ". $smallEventList->facility ." has been Cancelled due to an event";
                    //         $newNotif->readed = 0;
                    //         $newNotif->save();

                    //         event(new AdminUnassign($staffId, "One of your assigned reservation has been Cancelled due to an event"));
                    //     }
                    // }

                    // $reservationId = $smallEventList->id;
                    // $equipment = $smallEventList->equipment_needed;
        
                    // //Inventory System
                    // // $item = tblItems::findorfail($equipment);
                    // // $tblFurniture = tblFurniture::where('name', $item->name)->where("reservationId", $reservationId)->get();

                    // // foreach ($tblFurniture as $furniture) {
                    // //     if($furniture->reservationId == $reservationId){
                    // //         $furniture->status = 'Available';
                    // //         $furniture->reservationId = "0";
                    // //         $furniture->save();
                    // //     }
                    // // }

                    // //New Inventory System
                    // // Check if $equipment is not empty
                    // if (!empty($equipment)) {
                    //     foreach ($equipment as $equipmentItem) {
                    //         $itemName = $equipmentItem['name'];

                    //         $item = tblItems::where('name', $itemName)->first();
                    //         if(!$item){
                    //             return response()->json(['message' => $itemName .' item is not exist in the List'], 404);
                    //         }
                    //         $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Available")->get();
                    //         if(!$tblFurniture){
                    //             return response()->json(['message' => $itemName .' equipment is not exist in the List'], 404);
                    //         }

                    //         foreach ($tblFurniture as $furniture) {
                    //             if($furniture->reservationId == $reservationId){
                    //                 $furniture->status = 'Available';
                    //                 $furniture->reservationId = "0";
                    //                 $furniture->save();
                    //             }
                    //         }
                    //     }
                    // } else {
                    //     //nothing what else?
                    // }

                    // $smallEventList->save();
                    // $userId = $smallEventList->recipientId;
                    // // Update the 'endCooldownDate' for the user
                    // $user = User::findorfail($userId);
                    // $user->endCooldownDate = "";

                    // $newNotif = new tblUserNotification;
                    // $newNotif->userId = $userId;
                    // $newNotif->description = "Your Reservation in ". $smallEventList->facility ." for ". $smallEventList->activity ." has suddenly cancelled because of an Event";
                    // $newNotif->readed = 0;

                    // $user->save();
                    // $newNotif->save();

                    // event(new AdminDecline($userId, "One of your reservation has suddenly Cancelled due to an event"));
                // }
            // }
        }
    }

    public function deleteEvent(Request $request)
    {
        $eventId = $request->input('id');
        $event = tblevent::find($eventId);

        if (!$event) {
            return response()->json(['message' => "The Event Doesn't Exist!!"], 404);
        }

        $message = " has removed the ". $event->title ." Event from the event list";
        $this->createFacilityAudit($message);

        if ($event->image) {
            Storage::disk('uploads')->delete($event->image);
        }

        $event->delete();
        
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function getQrCode(Request $request)
    {
        $qrcodeEncoded = $request->input('qr');
        return response()->json(['qrCodeData' => $qrcodeEncoded]);
    }

    public function itemStatusUpdate()
    {
        $currentDateTime = Carbon::now();
        $allReservations = tblReservation::where("status", "Approved")->get();

        foreach ($allReservations as $reservation) {
            $reservationEndDateTime = null;
            if($reservation->type === 'Big-Event'){
                $reservationEndDateTime = Carbon::createFromFormat('Y-m-d g:iA', $reservation->date);
                $reservationEndDateTime->setTimezone('Asia/Manila');
            }else{
                $timeRange = explode('-', $reservation->time);
                if (count($timeRange) === 2) {
                    $endTime = trim($timeRange[1]);

                    // Combine start and end times with the reservation date
                    $reservationEndDateTime = Carbon::createFromFormat('Y-m-d g:iA', $reservation->date . ' ' . $endTime);
                    $reservationEndDateTime->setTimezone('Asia/Manila');
                }
            }

            // Check if the current date and time are beyond the reservation end time
            if ($currentDateTime > $reservationEndDateTime) {
                // // Reservation has passed
                $reservationId = $reservation->id;
                $equipment = $reservation->equipment_needed;

                // // Inventory System
                // $item = tblItems::findorfail($equipmentId);
                // $tblFurniture = tblFurniture::where('name', $item->name)->where("reservationId", $reservation->id)->get();

                // foreach ($tblFurniture as $furniture) {
                //     if ($furniture->reservationId == $reservationId) {
                //         $furniture->status = 'Available';
                //         $furniture->reservationId = "0";
                //         $furniture->save();
                //     }
                // }

                //new Inventory System
                // Check if $equipment is not empty
                if (!empty($equipment) && !is_string($equipment)) {
                    foreach ($equipment as $equipmentItem) {
                        $itemName = $equipmentItem['name'];

                        $item = tblItems::where('name', $itemName)->first();
                        if(!$item){
                            return response()->json(['message' => $itemName .' item is not exist in the List.'], 404);
                        }
                        $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Reserved")->get();
                        if(!$tblFurniture){
                            return response()->json(['message' => $itemName .' equipment is not exist in the List.'], 404);
                        }

                        foreach ($tblFurniture as $furniture) {
                            if($furniture->reservationId ==  $reservationId){
                                $furniture->status = 'Available';
                                $furniture->reservationId = "0";
                                $furniture->save();
                            }
                        }
                    }
                } else {
                    //nothing what else?
                }
            }
        }

        return response()->json(["status" => "Updated furniture status for passed reservations."]);
    }

    public function reservationPaymentStatusUpdate()
    {
        $allReservations = tblReservation::where("status", "Pending")->get();

        if(!$allReservations){
            return;
        }

        foreach ($allReservations as $reservation) {
            $reservationId = $reservation->id;
            $reservationDate = $reservation->date;
            $reservationType = $reservation->event_type;
            
            $payment = tblPayment::where('reservationId')->first();

            if(!$payment){
                return response()->json(['message' => 'The Reservation Id:' .$reservationId. ' has a missing Payment Data!!'], 200);
            }

            $status = $payment->status;

            // Check if today is 5 days or fewer from the reservationDate
            $today = Carbon::now();
            $daysUntilReservation = $today->diffInDays($reservationDate);

            if ($reservationType === "Big Event") {
                if ($daysUntilReservation <= 5) {
                    if($status === "Unpaid"){
                        if ($reservation->attachment) {
                            // Remove the attachment from storage
                            Storage::delete($reservation->attachment);
                        }
                
                        $equipment = json_decode($reservation->equipment_needed, true);
                
                        //New Inventory System
                        // Check if $equipment is not empty
                        if (!empty($equipment) && !is_string($equipment)) {
                            foreach ($equipment as $equipmentItem) {
                                $itemName = $equipmentItem['name'];
                
                                $item = tblItems::where('name', $itemName)->first();
                                if(!$item){
                                    return response()->json(['message' => $itemName .' item is not exist in the List. Call the contact for this technical Concern'], 404);
                                }
                                $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Reserved")->get();
                                if(!$tblFurniture){
                                    return response()->json(['message' => $itemName .' equipment is not exist in the List. Call the contact for this technical Concern'], 404);
                                }
                
                                foreach ($tblFurniture as $furniture) {
                                    if($furniture->reservationId == $reservationId){
                                        $furniture->status = 'Available';
                                        $furniture->reservationId = "0";
                                        $furniture->save();
                                    }
                                }
                            }
                        } else {
                            //nothing what else?
                            // return response()->json(['message' => 'item is not exist in the List.'], 404);
                        }

                        $reservation->status = "Cancelled";
                        $reservation->reason = "Admin Comment: You didn't comply to the reservation payment due";

                        $newNotif = new tblNotification;
                        $newNotif->userId = $reservation->recipientId;
                        $newNotif->description = "Your reservation for ". $reservation->activity ." in ". $reservation->facility ." has been Declined due to could not comply on payment due";
                        $newNotif->readed = 0;
                        $newNotif->save();

                        $reservation->save();
                    }
                    // Do something if today is 5 days or fewer from the reservationDate
                    return response()->json(['message' => 'The Payment is due within 5 days.'], 200);
                }
            } else {
                if ($daysUntilReservation <= -1) {
                    if($status === "Unpaid"){
                        $equipment = json_decode($reservation->equipment_needed, true);
                
                        //New Inventory System
                        // Check if $equipment is not empty
                        if (!empty($equipment) && !is_string($equipment)) {
                            foreach ($equipment as $equipmentItem) {
                                $itemName = $equipmentItem['name'];
                
                                $item = tblItems::where('name', $itemName)->first();
                                if(!$item){
                                    return response()->json(['message' => $itemName .' item is not exist in the List. Call the contact for this technical Concern'], 404);
                                }
                                $tblFurniture = tblFurniture::where('name', $item->name)->where("status", "Reserved")->get();
                                if(!$tblFurniture){
                                    return response()->json(['message' => $itemName .' equipment is not exist in the List. Call the contact for this technical Concern'], 404);
                                }
                
                                foreach ($tblFurniture as $furniture) {
                                    if($furniture->reservationId == $reservationId){
                                        $furniture->status = 'Available';
                                        $furniture->reservationId = "0";
                                        $furniture->save();
                                    }
                                }
                            }
                        } else {
                            //nothing what else?
                            // return response()->json(['message' => 'item is not exist in the List.'], 404);
                        }

                        $reservation->status = "Cancelled";
                        $reservation->reason = "Admin Comment: You didn't comply to the reservation payment due";

                        $newNotif = new tblNotification;
                        $newNotif->userId = $reservation->recipientId;
                        $newNotif->description = "Your reservation for ". $reservation->activity ." in ". $reservation->facility ." has been Declined due to could not comply on payment due";
                        $newNotif->readed = 0;
                        $newNotif->save();
                        
                        $reservation->save();
                    }
                }
            }
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
            'type' => "Reservation",
            'description' => strtok($user->name, ' ') . $message,
        ]);
    }
}
