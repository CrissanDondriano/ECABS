<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\tblConsumable;
use App\Models\tblFurniture;
use App\Models\tblItemRequest;
use App\Models\tblItems;
use App\Models\tblTempItems;
use App\Models\tblRequests;
use App\Models\tblAuditLogs;
use \Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use \Illuminate\Support\Facades\Mail;
use App\Mail\SendLetterRequest;

class InventoryController extends Controller
{
    //Purchase Request
    //addItem for Purchase
    public function addItem(Request $request)
    {
        $request->validate([
            'itemName' => 'required',
            'itemType' => 'required',
        ]);

        $newItem = new tblItems;
        $newItem->name = $request->itemName;
        $newItem->type = $request->itemType;

        $newItem->save();
        
        return redirect('/admin/inventory/purchase');
    }

    //addRequestItem for Purchase
    public function addRequestItem($itemId)
    {
        $lisItem = tblItems::find($itemId);
        $exists = tblItemRequest::where('itemId', $itemId)->exists();

        if ($exists) {
            return response()->json(['message' => 'Item already Existed'], 404);
        }

        $newItem = new tblItemRequest;

        $newItem->itemId = $lisItem->id;
        $newItem->name = $lisItem->name;
        $newItem->unit = "";
        $newItem->quantity = 1;
        $newItem->type = $lisItem->type;
        $newItem->save();

        return response()->json(['message' => 'Item added to the request table'], 200);
    }

    //deleteRequestItem for Purchase
    public function deleteRequestItem($itemId)
    {
        $item = tblItemRequest::find($itemId);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $item->delete();
    }
    //updateListItem for Purchase
    public function updateListItem(Request $request, $itemId)
    {
        $listItem = tblItems::find($itemId);

        if (!$listItem) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $listItem->name = $request->itemName;
        $listItem->save();

        return redirect('/admin/inventory/purchase');
    }
    //deleteListItem for Purchase
    public function deleteListItem($itemId)
    {
        $listItem = tblItems::find($itemId);

        if (!$listItem) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $listItem->delete();
    }

    //generateRequest for Purchase
    public function generateRequest(Request $request)
    {
        $request->validate([
            'purpose' => 'required',
            'purpose2' => 'required',
        ]);

        $tableData = $request->input('tableData');
        $tempPurpose = $request->input('purpose');
        $tempPurpose2 = $request->input('purpose2');

        foreach ($tableData as $item) {
            $unit = $item[2];
            if ($unit === "Select Unit") {
                return response()->json(['message' => 'An Item has no Unit'], 404);
            }else{
                
            }
        }

        // Convert the tableData array to a string
        $itemsString = json_encode($tableData);

        // Create a new row in the target table
        $newRequest = new tblRequests();
        $newRequest->purpose = $tempPurpose;
        $newRequest->items = $itemsString;
        $newRequest->purpose2 = $tempPurpose2;
        $newRequest->status = "Pending";

        $message = " has generated an Item Request !!";
        $this->createFacilityAudit($message);

        $newRequest->save();

        foreach ($tableData as $item) {
            //producing Temporary Storage For Items
            $newTempItems = new tblTempItems();
            $newTempItems->purchaseId = $newRequest->id;
            $newTempItems->itemId = $item[0];
            $newTempItems->name = $item[3];
            $newTempItems->unit = $item[2];
            $newTempItems->type = $item[4];
            $newTempItems->quantity = $item[1];
            $newTempItems->save();
        }

        $newRequest2 = new tblItemRequest();
        $newRequest2->truncate();
    }

    //viewRequest for Purchase
    public function getItems(Request $request)
    {
        $requestId = $request->input('requestId');

        //Retrieve the request with the specified ID
        $request = tblRequests::find($requestId);

        if(!$request){
            return response()->json(['message' => 'Purchase Request Id cannot found'], 404);
        }

        //Retrieve the items for the request
        $items = $request->items;

        //Retrieve the purpose and purpose2 values from the request
        $purpose = $request->purpose;
        $purpose2 = $request->purpose2;

        //Convert the items string back to an array
        $itemsArray = json_decode($items, true);
        $itemsArrayTemp = tblTempItems::where("purchaseId", $requestId)->get();

        if(!$itemsArrayTemp){
            return response()->json(['message' => 'Items in this purchase is missing in the list!!'], 404);
        }

        //Return the items as a JSON response along with purpose and purpose2
        return response()->json([
            'items' => $itemsArray,
            'itemTemp' => $itemsArrayTemp,
            'purpose' => $purpose,
            'purpose2' => $purpose2,
        ]);
    }

    public function deleteRequest($itemId)
    {
        $request = tblRequests::find($itemId);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $message = " has deleted the Item Request Form Id: " .$request->id;
        $this->createFacilityAudit($message);

        $request->delete();
    }

    public function approveRequest(Request $request)
    {
        $requestId = $request->input('requestId');
        $requestData = $request->input('cardDataArray');
        $dataRecieved = [];

        if(!$requestData){
            return response()->json(['message' => 'request Data is empty'], 404);
        }

        // Retrieve the request with the specified ID
        $request = tblRequests::find($requestId);

        if(!$request){
            return response()->json(['message' => 'request does not exist!!'], 404);
        }

        if ($request->status === 'Received') {
            return response()->json(['message' => 'Item already Received'], 200);
        }

        $items = $request->items;

        //New Method
        // Ensure $items is an array (Dont delete this yet also Old Method)
        if (is_array($requestData)) {

            // Loop through each item
            foreach ($requestData as $item) {
                // Decode the item array to get the values
                $id = $item['requestItemId'];
                $name = $item['requestItemName'];
                $quantity = $item['requestItemQuantity'];
                $unit = $item['requestItemUnit'];
                $type = $item['requestItemType'];

                //Getting the item Temp Data
                $currentItem = tblTempItems::where('purchaseId', $requestId)->where('name', $name)->first();
                $currentQuantity = $currentItem->quantity;

                if($currentQuantity < $quantity){
                    return response()->json(['message' => 'Your input have exceeded the maximum items of '. $name], 404);
                }

                $currentItem->quantity = $currentQuantity - $quantity;
                $currentItem->save();

                //If temp Data depleted
                if($currentItem->quantity == 0){
                    $message = " has received all of ". $name ." from the Items Requested Form Id: " .$requestId;
                    $this->createFacilityAudit($message);

                    $currentItem->delete();
                }else {
                    $dataRecieved[] = [
                        'name' => $name,
                        'quantity' => $quantity,
                        'currentItemQuantity' => $currentItem->quantity,
                    ];
                }

                //Inventory Process
                if ($type === 'furniture') {

                    $latestInventory = tblFurniture::where('name', $name)->orderBy('itemId', 'desc')->first();
                    $latestValueAsInt = $latestInventory ? intval(substr($latestInventory->itemId, 2)) : 0;

                    for ($i = 0; $i < $quantity; $i++) {
                        $incrementedNumber = str_pad(++$latestValueAsInt, 3, '0', STR_PAD_LEFT);

                        $inventory = new tblFurniture();
                        $inventory->name = $name;

                        // Add the first two letters of the item name in uppercase to itemId
                        $firstTwoLetters = substr(strtoupper(preg_replace('/[^a-zA-Z]/', '', $name)), 0, 2);
                        $inventory->itemId = $firstTwoLetters . $incrementedNumber;

                        $inventory->quantity = 1;
                        $inventory->status = 'Available'; // Set the type to "Approved"

                        // Generate QR code for the reservation
                        $qrCode = QrCode::size(100)->generate(json_encode($inventory->itemId));
                        $qrCodeData = base64_encode($qrCode);

                        $inventory->qrcode = $qrCodeData;
                        $inventory->reservationId = "0";

                        // Save the new inventory record
                        $inventory->save();
                    }

                } else {

                    if (tblConsumable::where('name', $name)->where('unit', $unit)->exists()) {
                        $inventory = tblConsumable::find($id);
                        $inventory->quantity += $quantity;
                        if ($inventory->quantity == 0) {
                            $inventory->status = 'Out of Stock';
                        } else if ($inventory->quantity <= 10) {
                            $inventory->status = 'Low Stock';
                        } else {
                            $inventory->status = 'In stock';
                        }

                        // Save the new inventory record
                        $inventory->save();
                    } else {
                        // Create a new record in tbl_inventories with the decoded values
                        $inventory = new tblConsumable();
                        $inventory->id = $id;
                        $inventory->name = $name;
                        $inventory->quantity = $quantity;
                        $inventory->unit = $unit;
                        if ($inventory->quantity == 0) {
                            $inventory->status = 'Out of Stock';
                        } else if ($inventory->quantity <= 10) {
                            $inventory->status = 'Low Stock';
                        } else {
                            $inventory->status = 'In stock';
                        }

                        // Generate QR code for the reservation
                        $qrCode = QrCode::size(100)->generate(json_encode($inventory->id));
                        $qrCodeData = base64_encode($qrCode);

                        $inventory->qrcode = $qrCodeData;

                        // Save the new inventory record
                        $inventory->save();
                    }
                }
            }

            $availableCount = tblTempItems::where("purchaseId", $requestId)->count();

            if($availableCount == 0){
                $message = " has received All the Items Requested from Id Form: " .$requestId;
                $this->createFacilityAudit($message);

                // Update the request status to "Approved"
                $request->status = 'Received';
                $request->save();
            }else{
                $message = " has received the following items: ";

                foreach ($dataRecieved as $data) {
                    $itemName = $data['name'];
                    $itemQuantity = $data['quantity'];
                    $remainingQuantity = $data['currentItemQuantity'];

                    $message .= "$itemQuantity of $itemName (Remaining: $remainingQuantity), ";
                }
                // Remove the trailing comma and add the rest of the message
                $message = rtrim($message, ', ') . " from the Requested Form Id: $requestId";

                $this->createFacilityAudit($message);
            }

            return response()->json(['success' => true, 'items' => $items]);
        }


        //Old Method (May Delete now)
        // // Retrieve the items for the request
        // $items = $request->items;

        // // Check if $items is a string and convert it to an array if necessary
        // if (!is_array($items) && is_string($items)) {
        //     $items = json_decode($items, true);
        // }

        // // Ensure $items is an array
        // if (is_array($items)) {

        //     // Loop through each item
        //     foreach ($items as $item) {
        //         // Decode the item array to get the values
        //         - = $item[0];
        //         $name = $item[3];
        //         $quantity = $item[1];
        //         $unit = $item[2];
        //         $type = $item[4];

        //         if ($type === 'furniture') {

        //             $latestInventory = tblFurniture::where('name', $name)->orderBy('itemId', 'desc')->first();
        //             $latestValueAsInt = $latestInventory ? intval(substr($latestInventory->itemId, 2)) : 0;

        //             for ($i = 0; $i < $quantity; $i++) {
        //                 $incrementedNumber = str_pad(++$latestValueAsInt, 3, '0', STR_PAD_LEFT);

        //                 $inventory = new tblFurniture();
        //                 $inventory->name = $name;

        //                 // Add the first two letters of the item name in uppercase to itemId
        //                 $firstTwoLetters = substr(strtoupper(preg_replace('/[^a-zA-Z]/', '', $name)), 0, 2);
        //                 $inventory->itemId = $firstTwoLetters . $incrementedNumber;

        //                 $inventory->quantity = 1;
        //                 $inventory->status = 'Available'; // Set the type to "Approved"

        //                 // Generate QR code for the reservation
        //                 $qrCode = QrCode::size(100)->generate(json_encode($inventory->itemId));
        //                 $qrCodeData = base64_encode($qrCode);

        //                 $inventory->qrcode = $qrCodeData;
        //                 $inventory->reservationId = "0";

        //                 // Save the new inventory record
        //                 $inventory->save();
        //             }

        //         } else {

        //             if (tblConsumable::where('id', $id)->exists()) {
        //                 $inventory = tblConsumable::find($id);
        //                 $inventory->quantity += $quantity;
        //                 if ($inventory->quantity == 0) {
        //                     $inventory->status = 'Out of Stock';
        //                 } else if ($inventory->quantity <= 10) {
        //                     $inventory->status = 'Low Stock';
        //                 } else {
        //                     $inventory->status = 'In stock';
        //                 }

        //                 // Save the new inventory record
        //                 $inventory->save();
        //             } else {
        //                 // Create a new record in tbl_inventories with the decoded values
        //                 $inventory = new tblConsumable();
        //                 $inventory->id = $id;
        //                 $inventory->name = $name;
        //                 $inventory->quantity = $quantity;
        //                 $inventory->unit = $unit;
        //                 if ($inventory->quantity == 0) {
        //                     $inventory->status = 'Out of Stock';
        //                 } else if ($inventory->quantity <= 10) {
        //                     $inventory->status = 'Low Stock';
        //                 } else {
        //                     $inventory->status = 'In stock';
        //                 }

        //                 // Generate QR code for the reservation
        //                 $qrCode = QrCode::size(100)->generate(json_encode($inventory->id));
        //                 $qrCodeData = base64_encode($qrCode);

        //                 $inventory->qrcode = $qrCodeData;

        //                 // Save the new inventory record
        //                 $inventory->save();
        //             }
        //         }
        //     }

        //     $message = " has received the Item Request Form Id: " .$requestId;
        //     $this->createFacilityAudit($message);

        //     // Update the request status to "Approved"
        //     $request->status = 'Received';
        //     $request->save();

        //     return response()->json(['success' => true, 'items' => $items]);
        // }

    }

    public function rejectRequest(Request $request)
    {
        $requestId = $request->input('requestId');

        $request = tblRequests::findOrFail($requestId);

        $message = " has reject the Item Request Form Id: " .$requestId;
        $this->createFacilityAudit($message);

        $request->status = 'Rejected';
        $request->save();
     
    }

    public function addInventory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
        ]);

        $newName = $request->input('name');
        $count = $request->input('quantity');

        $latestInventory = tblFurniture::where('name', $newName)->orderBy('itemId', 'desc')->first();
        $latestValueAsInt = $latestInventory ? intval(substr($latestInventory->itemId, 2)) : 0;

        for ($i = 0; $i < $count; $i++) {
            $incrementedNumber = str_pad(++$latestValueAsInt, 3, '0', STR_PAD_LEFT);

            // Add the first two letters of the item name in uppercase to itemId
            $firstTwoLetters = substr(strtoupper(preg_replace('/[^a-zA-Z]/', '', $newName)), 0, 2);

            $newInventoryItem = new tblFurniture();
            $newInventoryItem->name = $newName;
            $newInventoryItem->itemId = $firstTwoLetters . $incrementedNumber;
            $newInventoryItem->quantity = 1;

            $newInventoryItem->status = 'Available'; // Set the type to "Approved"

            // Generate QR code for the reservation
            $qrCode = QrCode::size(100)->generate(json_encode($newInventoryItem->itemId));
            $qrCodeData = base64_encode($qrCode);

            $newInventoryItem->qrcode = $qrCodeData;
            $newInventoryItem->reservationId = "0";

            // Save the new inventory record
            $newInventoryItem->save();
        }
    }

    public function addConsumable(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
        ]);

        $name = $request->input('name');
        $quantity = $request->input('quantity');
        $unit = $request->input('unit');

        if (tblConsumable::whereRaw('LOWER(name) = LOWER(?)', [$name])->where('unit', $unit)->exists()) {
            $inventory = tblConsumable::where('name', $name)->where('unit', $unit)->first();
            $inventory->quantity += $quantity;
            if ($inventory->quantity == 0) {
                $inventory->status = 'Out of Stock';
            } else if ($inventory->quantity <= 10) {
                $inventory->status = 'Low Stock';
            } else {
                $inventory->status = 'In stock';
            }

            // Save the new inventory record
            $inventory->save();
        } else {
            // Create a new record in tbl_inventories with the decoded values
            $inventory = new tblConsumable();
            $inventory->name = $name;
            $inventory->quantity = $quantity;
            $inventory->unit = $unit;
            if ($inventory->quantity == 0) {
                $inventory->status = 'Out of Stock';
            } else if ($inventory->quantity <= 10) {
                $inventory->status = 'Low Stock';
            } else {
                $inventory->status = 'In stock';
            }
            $inventory->qrcode = "";
            $inventory->save();

            // Generate QR code for the reservation
            $qrCode = QrCode::size(100)->generate(json_encode($inventory->id));
            $qrCodeData = base64_encode($qrCode);
            $inventory->qrcode = $qrCodeData;

            // Save the new inventory record
            $inventory->save();
        }
    }

    public function updateConsumable(Request $request, $inventoryId)
    {
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
        ]);

        $inventoryItem = tblConsumable::find($inventoryId);

        $message = " has updated the consumable item named: ". $inventoryItem->name;
        $this->createFacilityAudit($message);

        $inventoryItem->name = $request->input('name');
        $inventoryItem->quantity = $request->input('quantity');
        $inventoryItem->unit = $request->input('unit');

        if ($inventoryItem->quantity == 0) {
            $inventoryItem->status = 'Out of Stock';
        } else if ($inventoryItem->quantity <= 10) {
            $inventoryItem->status = 'Low Stock';
        } else {
            $inventoryItem->status = 'In stock';
        }

        $inventoryItem->save();

        return redirect('/admin/inventory/manage');
    }

    //markReceived the Reservation
    public function markReserved($id)
    {

        $inventoryItem = tblFurniture::find($id);

        if (!$inventoryItem) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $message = " has updated the inventory item ". $inventoryItem->name ."(". $inventoryItem->itemId .") status to 'Reserved'";
        $this->createFacilityAudit($message);

        $inventoryItem->status = "Reserved";
        $inventoryItem->save();
    }

    //markReceived the Reservation
    public function markAvailable($id)
    {

        $inventoryItem = tblFurniture::find($id);

        if (!$inventoryItem) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $message = " has updated the inventory item ". $inventoryItem->name ."(". $inventoryItem->itemId .") status to 'Available'";
        $this->createFacilityAudit($message);

        $inventoryItem->status = "Available";
        $inventoryItem->save();
    }

    //markReceived the Damage
    public function markDamaged($id)
    {
        $inventoryItem = tblFurniture::find($id);

        if (!$inventoryItem) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $message = " has updated the inventory item ". $inventoryItem->name ."(". $inventoryItem->itemId .") status to 'Damaged'";
        $this->createFacilityAudit($message);

        $inventoryItem->status = "Damaged";
        $inventoryItem->save();
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'emailID' => 'required',
        ]);

        $email = $request->input("email");
        $emailID = $request->input("emailID");

        // Retrieve the request with the specified ID
        $emailRequest = tblRequests::findOrFail($emailID);

        // Retrieve the items for the request
        $items = $emailRequest->items;

        // Retrieve the purpose and purpose2 values from the request
        $purpose = $emailRequest->purpose;
        $purpose2 = $emailRequest->purpose2;

        // Convert the items string back to an array
        $itemsArray = json_decode($items, true);

        $tableID = ''; 
        $tableQty = '';
        $tableUnit = '';
        $tableDesc = '';

        $start = 1; 

        foreach ($itemsArray as $item) {
            $tableID .= $start;

            $start++;
            $tableQty .=  $item[1] ;
            $tableUnit .= $item[2] ;
            $tableDesc .= $item[3] ;
        }

        $mailData = [
            'purpose' => $purpose,
            'purpose2' => $purpose2,
            'tableID' => $tableID, 
            'tableQty' => $tableQty, 
            'tableUnit' => $tableUnit, 
            'tableDesc' => $tableDesc, 
        ];

        Mail::to($email)->send(new SendLetterRequest($mailData));
    }


    public function getQrCode(Request $request)
    {
        $qrcodeEncoded = $request->input('qr');
        return response()->json(['qrCodeData' => $qrcodeEncoded]);
    }

    private function createFacilityAudit($message){
        $userId = Auth()->id();
        $user = User::find($userId);

        if(!$user){
            return response()->json(['message' => 'User does not exist!!'], 404);
        }

        tblAuditLogs::create([
            'userId' => $userId,
            'type' => "Inventory",
            'description' => strtok($user->name, ' ') . $message,
        ]);
    }

}
