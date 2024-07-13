<?php

namespace App\Http\Controllers;
use DateTimeZone;

use App\Models\tblReservation;
use App\Models\tblConsumable;
use App\Models\tblFurniture;

use Illuminate\Http\Request;

class ScanQRCodeController extends Controller
{
    public function scanningQrCode(Request $request)
    {

        date_default_timezone_set('Asia/Manila');
        
        $scannedData = $request->input('reservationId');

        $reservation = tblReservation::find($scannedData);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation does not exist!! provided id: ' . $scannedData], 404);
        }

        $status = $reservation->status;

        $currentDateTime = now();
        $currentDateTime->setTimezone(new DateTimeZone('Asia/Manila'));
        $currentDate = $currentDateTime->format('Y-m-d');
        $validReservation = tblReservation::where('date', $currentDate)->first();

        if ($validReservation && $status == "Approved") {
            return response()->json([
                'id' => $reservation->id,
                'name' => $reservation->name,
                'time' => $reservation->time,
                'status' => $reservation->status,
            ]);
        } else {
            return response()->json(['message' => 'Sorry you have not schedule right now!'], 404);
        }
    }

    public function scanningInventoryQrCode(Request $request)
    {
        $scannedItemId = $request->input('itemId');

        // First, try to find the item in tblFurniture
        $inventory = TblFurniture::where('itemId', $scannedItemId)->first();

        // If not found in tblFurniture, try tblConsumables
        if (!$inventory) {
            $inventory = TblConsumable::where('id', $scannedItemId)->first();
        }

        if (!$inventory) {
            return response()->json(['message' => 'Inventory item not found for itemId or id: ' . $scannedItemId], 404);
        }

        return response()->json([
            'itemId' => $inventory->itemId ?? null, // Use the 'itemId' if found in tblFurniture
            'id' => $inventory->id ?? null, // Use the 'id' if found in tblConsumables
            'itemName' => $inventory->name,
            'status' => $inventory->status,
            'stock' => $inventory->quantity,
        ]);
    }
}
