<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\tblFacility;
use App\Models\tblAuditLogs;

class FacilityController extends Controller
{
    public function addFacility(Request $request)
    {
        $request->validate([
            'facilityName' => 'required',
            'facilityDescription' => 'required',
            'facilityImage' => 'required|image',
        ]);

        $name = $request->input('facilityName');

        if ($request->hasFile('facilityImage')) {
            $facilityImage = $request->file('facilityImage');
            $fileContent = file_get_contents($facilityImage->path());
            $filename = $facilityImage->getClientOriginalName();
    
            Storage::disk('facilities')->put($filename, $fileContent);
        }

        tblFacility::create([
            'name' => $request->input('facilityName'),
            'description' => $request->input('facilityDescription'),
            'image' => $filename,
        ]);

        $message = " has created a new Facility named: ". $name;
        $this->createFacilityAudit($message);

        return redirect('/admin/maintenance/add');
    }

    public function updateFacility(Request $request, $facilityId)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $facility = tblFacility::findOrFail($facilityId);

        $message = "  has update the facility ". $facility->name;
        $this->createFacilityAudit($message);

        $facility->fill([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($facility->image) {
                Storage::disk('facilities')->delete($facility->image);
            }
            
            $facilityImage = $request->file('image');
            $fileContent = file_get_contents($facilityImage->path());
            $filename = $facilityImage->getClientOriginalName();
    
            Storage::disk('facilities')->put($filename, $fileContent);
        
            $facility->image = $filename;
        }

        $facility->save();
    }

    public function deleteFacility($facilityId)
    {
        $facility = tblFacility::findOrFail($facilityId);
        
        if ($facility->image) {
            Storage::disk('facilities')->delete($facility->image);
        }

        $message = " has deleted the facility ". $facility->name;
        $this->createFacilityAudit($message);

        $facility->delete();

        return response()->json(['message' => 'Facility deleted successfully']);
    }

    private function uploadImage($image)
    {
        $imageName = md5($image->getClientOriginalName()) . '.webp';
        $pathOriginal = storage_path('app/public/images/' . $imageName);
        $image->storeAs('public/images', $imageName);

        $imageExtension = $image->getClientOriginalExtension();

        // Convert the image to WebP format
        switch ($imageExtension) {
            case 'jpg':
            case 'jpeg':
            case 'JPEG':
            case 'JPG':
                $imageOriginal = imagecreatefromjpeg($pathOriginal);
                break;
            case 'png':
            case 'PNG':
                $imageOriginal = imagecreatefrompng($pathOriginal);
                break;
            case 'gif':
            case 'GIF':
                $imageOriginal = imagecreatefromgif($pathOriginal);
                break;
            // Add more cases for other image formats as needed
            default:
                $this->deleteImage($imageName);
                throw new \Exception('Unsupported image format: ' . $imageExtension);
        }
        
        imagewebp($imageOriginal, storage_path('app/public/images/' . $imageName), 80); // 80 is the quality, you can adjust as needed
        return $imageName;
    }

    private function deleteImage($imageName)
    {
        $imagePath = 'public/images/' . $imageName;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
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
