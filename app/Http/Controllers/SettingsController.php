<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\tblSettings;
use App\Models\tblPrices;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function toggleMaintenanceMode()
    {
        try {
            // Get the current maintenance mode status
            $maintenanceSettings = tblSettings::where('name', 'maintenanceMode')->firstOrFail();

            // Toggle the maintenance mode status
            $maintenanceSettings->value = ($maintenanceSettings->value == 1) ? 0 : 1;
            $maintenanceSettings->save();

            // Update user type to reflect maintenance mode status
            $userType = Auth::user()->type;
            if ($maintenanceSettings->value == 1) {
                // Enable maintenance mode for renters and staff
                if (in_array($userType, [0, 2])) {
                    User::where('id', Auth::id())->update(['maintenance_mode' => 1]);
                }
            } else {
                // Disable maintenance mode for renters and staff
                if (in_array($userType, [0, 2])) {
                    User::where('id', Auth::id())->update(['maintenance_mode' => 0]);
                }
            }

            return response()->json(['message' => 'Maintenance Mode toggled successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error toggling Maintenance Mode: ' . $e->getMessage()], 500);
        }
    }

    public function updatingGuidelines(Request $request){
        $updatedGuidelines = $request->input('guidelines');

        // $updatedGuidelines is now an array of guideline objects
        // You can loop through them and update your database records
    
        foreach ($updatedGuidelines as $updatedGuideline) {
            $guidelineId = $updatedGuideline['id'];
            $guidelineContent = $updatedGuideline['content'];

            // Perform the database update for each guideline using $guidelineId and $guidelineContent
            $guideLine = tblSettings::findorfail($guidelineId);
            $guideLine->description = $guidelineContent;
            $guideLine->save();
        }    
    }

    public function updatingBusinessContact(Request $request){
        // Validate the form data
        $request->validate([
            'businessNumber' => 'required|string|min:10|regex:/^9\d{9}$/|numeric',
            'businessEmail' => 'required|string',
        ]);
        $updatedContact = $request->input('businessNumber');
        $updatedEmail = $request->input('businessEmail');

        // Get the current maintenance mode status
        $maintenanceNum = tblSettings::where('name', 'businessNumber')->firstOrFail();
        $maintenanceEmail = tblSettings::where('name', 'businessEmail')->firstOrFail();

        $maintenanceNum->value = $updatedContact;
        $maintenanceEmail->value = $updatedEmail;

        $maintenanceNum->save();
        $maintenanceEmail->save();
    }

    public function addPrice(Request $request){
        $request->validate([
            'facility' => 'required|string|filled',
            'activity' => 'required|string|filled',
            'organization' => 'required|string|filled',
            'price' => 'required|string|filled',
        ]);

        $price = new tblPrices();
        $price->facility = $request->input('facility');
        $price->activity = $request->input('activity');
        $price->organization = $request->input('organization');
        $price->prices = $request->input('price');
        $price->save();
    }

    public function deletePrice(Request $request){
        $id = $request->input('priceId');
        $price = tblPrices::findOrFail($id);
        $price->delete();
    }
}
