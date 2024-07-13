<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\tblConsumable;
use App\Models\tblFurniture;
use App\Models\tblPayment;
use App\Models\tblReports;
use App\Models\tblRequests;
use App\Models\tblScheduleTask;
use Illuminate\Http\Request;
use App\Models\tblReservation;
use App\Models\tblEvent;

class ReportController extends Controller
{
    //Reservation Summary Report
    public function reservationSummary(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $totalHallApproved = tblReservation::where('status', 'Approved')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('facility', 'Aquatic Center')
        ->count();
    
        $totalHallCancelled = tblReservation::where('status', 'Cancelled')->whereBetween('date', [$startDate, $endDate])->where('facility', 'Aquatic Center')->count();
        $totalAquaticApproved = tblReservation::where('status', 'Approved')->whereBetween('date', [$startDate, $endDate])->where('facility', 'Multi-Sports Hall')->count();
        $totalAquaticCancelled = tblReservation::where('status', 'Cancelled')->whereBetween('date', [$startDate, $endDate])->where('facility', 'Multi-Sports Hall')->count();

        if ($totalHallApproved === null) {
            $totalHallApproved = 0;
        }
        if ($totalHallCancelled === null) {
            $totalHallCancelled = 0;
        }
        if ($totalAquaticApproved === null) {
            $totalAquaticApproved = 0;
        }
        if ($totalAquaticCancelled === null) {
            $totalAquaticCancelled = 0;
        }

        $totalHallOverall = $totalHallApproved + $totalHallCancelled;
        $totalAquaticOverall = $totalAquaticApproved +  $totalAquaticCancelled;

        
        return view('layouts.admin-components.report-components.reservation-report.summary-report', [
            'totalHallApproved' => $totalHallApproved,
            'totalHallCancelled' => $totalHallCancelled,
            'totalHallOverall' => $totalHallOverall,
            'totalAquaticApproved' => $totalAquaticApproved,
            'totalAquaticCancelled' => $totalAquaticCancelled,
            'totalAquaticOverall' => $totalAquaticOverall,
        ]);
    }

    //Reservation Cancelled Report
    public function reservationCancelled(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Retrieve canceled reservations between the specified date range
        $cancelledReservations = tblReservation::where('status', 'Cancelled')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        return view('layouts.admin-components.report-components.reservation-report.cancelled-report', [
            'declinedReviewItems' => $cancelledReservations,
        ]);
    }

    //Reservation Overall Report
    public function reservationOverall(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        
        $overallReservations = tblReservation::whereBetween('date', [$startDate, $endDate])
            ->get();

        return view('layouts.admin-components.report-components.reservation-report.overall-report', ['viewReservations'=>$overallReservations]);
    }

    //Inventory Stock Report
    public function inventoryStock(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        
        $furnitureItems = tblFurniture::whereBetween('created_at', [$startDate, $endDate])->get();

        $furnitureGroups = $furnitureItems->groupBy('name')->map(function ($group) {
            return [
                'name' => $group->first()->name,
                'total_quantity' => $group->sum('quantity'),
            ];
        })->values();

        $consumables = tblConsumable::whereBetween('created_at', [$startDate, $endDate])->get();

        return view('layouts.admin-components.report-components.inventory-report.stock-inventory', [
            'addtblInventoriesConsumable' => $consumables,
            'addtblInventoriesF' => $furnitureGroups,
        ]);
    }

    //Inventory Movement Report
    public function inventoryMovement(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $requests = tblRequests::whereBetween('created_at', [$startDate, $endDate])->get();

        foreach ($requests as $request) {
            $request->items = json_decode($request->items, true);
        }

        return view('layouts.admin-components.report-components.inventory-report.stock-movement', ['viewTblRequest' => $requests]);
    }

    //Inventory Overall Report
    public function inventoryOverall(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $furnitureItems = tblFurniture::whereBetween('created_at', [$startDate, $endDate])->get();
        $consumables = tblConsumable::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('layouts.admin-components.report-components.inventory-report.overall-report', ['addtblInventoriesC'=>$consumables, 'addtblInventoriesF'=>$furnitureItems]);
    }

    //Maintenance Summary Report
    public function maintenanceSummary(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $totalTasks = tblScheduleTask::whereBetween('date', [$startDate, $endDate])->count();
        $totalLocations = tblScheduleTask::whereBetween('date', [$startDate, $endDate])->distinct('location')->count();
    
        // Count total number of staff across all tasks
        $totalAssignedStaff = tblScheduleTask::select(DB::raw('SUM(JSON_LENGTH(staff_list)) as totalStaff'))
        ->value('totalStaff');
    
        $totalCompletedTasks = tblScheduleTask::where('status', 'Done')->whereBetween('date', [$startDate, $endDate])->count();
        $totalPendingTasks = tblScheduleTask::where('status', 'In Progress')->whereBetween('date', [$startDate, $endDate])->count();

        if ($totalTasks === null) {
            $totalTasks = 0;
        }
        if ($totalLocations === null) {
            $totalLocations = 0;
        }
        if ($totalAssignedStaff === null) {
            $totalAssignedStaff = 0;
        }
        if ($totalCompletedTasks === null) {
            $totalCompletedTasks = 0;
        }
        if ($totalPendingTasks === null) {
            $totalPendingTasks = 0;
        }
    
        return view('layouts.admin-components.report-components.maintenance-report.summary-report', [
            'totalTasks' => $totalTasks,
            'totalLocations' => $totalLocations,
            'totalAssignedStaff' => $totalAssignedStaff,
            'totalCompletedTasks' => $totalCompletedTasks,
            'totalPendingTasks' => $totalPendingTasks,
        ]);
    }

    //Maintenance Request Report
    public function maintenanceRequest(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $totalPendingTasks = tblScheduleTask::where('status', 'In Progress')->whereBetween('date', [$startDate, $endDate])->get();

        return view('layouts.admin-components.report-components.maintenance-report.request-maintenance', ['addScheduleTask'=>$totalPendingTasks]);
    }

    //Maintenance Overall Report
    public function maintenanceOverall(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $totalTasks = tblScheduleTask::whereBetween('date', [$startDate, $endDate])->get();

        return view('layouts.admin-components.report-components.maintenance-report.overall-report', ['addScheduleTask'=>$totalTasks]);
    }

    //Payment Summary Report
    public function paymentSummary(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Retrieve the necessary data from your model or database
        $totalPayments = tblPayment::whereBetween('date', [$startDate, $endDate])->count();
        $totalPaymentAmount = tblPayment::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $averagePaymentAmount = tblPayment::whereBetween('date', [$startDate, $endDate])->avg('amount');
        $paidPayments = tblPayment::whereBetween('date', [$startDate, $endDate])->where('status', 'Paid')->count();
        $unpaidPayments = tblPayment::whereBetween('date', [$startDate, $endDate])->where('status', 'Unpaid')->count();
        $earliestPaymentDate = tblPayment::whereBetween('date', [$startDate, $endDate])->min('date');
        $latestPaymentDate = tblPayment::whereBetween('date', [$startDate, $endDate])->max('date');

        
        if ($totalPayments === null) {
            $totalPayments = 0;
        }
        if ($totalPaymentAmount === null) {
            $totalPaymentAmount = 0;
        }
        if ($averagePaymentAmount === null) {
            $averagePaymentAmount = 0;
        }
        if ($paidPayments === null) {
            $paidPayments = 0;
        }
        if ($unpaidPayments === null) {
            $unpaidPayments = 0;
        }
        if ($earliestPaymentDate === null) {
            $earliestPaymentDate = 0;
        }
        if ($latestPaymentDate === null) {
            $latestPaymentDate = 0;
        }

        return view('layouts.admin-components.report-components.payment-report.summary-report', [
            'totalPayments' => $totalPayments,
            'totalPaymentAmount' => $totalPaymentAmount,
            'averagePaymentAmount' => $averagePaymentAmount,
            'paidPayments' => $paidPayments,
            'unpaidPayments' => $unpaidPayments,
            'earliestPaymentDate' => $earliestPaymentDate,
            'latestPaymentDate' => $latestPaymentDate,
        ]);
    }

    //Payment Movement Report
    public function paymentHistory(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $paymentHistory = tblPayment::whereBetween('date', [$startDate, $endDate])->where('status', 'paid')->get();

        return view('layouts.admin-components.report-components.payment-report.history-report', ['addPayment'=> $paymentHistory]);
    }

    //Payment Overall Report
    public function paymentOverall(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $overallPayment = tblPayment::whereBetween('date', [$startDate, $endDate])->get();

        return view('layouts.admin-components.report-components.payment-report.overall-report', ['addPayment'=>$overallPayment]);
    }

    public function saveReportData(Request $request) {
        $category = $request->input('category');
        $type = $request->input('type');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        if($category == "reservation"){
            $newtype = ($type == 1) ? "summary" : (($type == 2) ? "cancelled" : "overall");
        }elseif($category == "inventory"){
            $newtype = ($type == 1) ? "stock" : (($type == 2) ? "movement" : "overall");
        }elseif($category == "maintenance"){
            $newtype = ($type == 1) ? "summary" : (($type == 2) ? "request" : "overall");
        }else{
            $newtype = ($type == 1) ? "summary" : (($type == 2) ? "history" : "overall");
        }
    
        $range = $startDate . " : " . $endDate;
    
        $reportContent = $request->input('reportContent'); // Get the HTML content
    
        $filename = $category . 'report no.' . uniqid() . '.html';
        $storagePath = public_path('reportAttachments');
    
        // Create the directory if it doesn't exist
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }
    
        // Store the report content in the specified directory
        file_put_contents($storagePath . '/' . $filename, $reportContent);
    
        $reports = new tblReports();
        $reports->category = $category;
        $reports->type = $newtype;
        $reports->dateRange = $range;
        $reports->file = $filename;
        $reports->save();
    }

    public function deleteReportData(Request $request) {
        $id = $request->input('reportId');
        $report = tblReports::find($id);

        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        $filenameToDelete = $report->file; // Specify the filename you want to delete
        $storagePath = public_path('reportAttachments');
        $filePathToDelete = $storagePath . '/' . $filenameToDelete;

        if (file_exists($filePathToDelete)) {
            // Attempt to delete the file
            if (unlink($filePathToDelete)) {
                // File deletion was successful
            } else {
                // File deletion failed
                return response()->json(['error' => 'Unable to delete the file!!'], 404);
            }
        } else {
            // File does not exist
            return response()->json(['error' => 'File does not exist!!'], 404);
        }

        $report->delete();
    }
    
    public function fetchReportContent($id) {
        $report = tblReports::find($id);

        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        // Read the blob content
        $filePath = public_path('reportAttachments/' . $report->file);
        $fileContent = file_get_contents($filePath);

        // Return the blob content with appropriate headers for a PDF
        return response($fileContent)
            ->header('Content-Type', 'application/pdf') // Update content type to 'application/pdf'
            ->header('Content-Disposition', 'attachment; filename="' . $report->file . '.pdf"'); // Update Content-Disposition for PDF
    }

    public function fetchCopyReportContent($id) {
        $report = tblReports::find($id);
    
        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }
    
        // Read the blob content
        $filePath = public_path('reportAttachments/' . $report->file);
        $fileContent = file_get_contents($filePath);

        // Return the HTML content with appropriate headers
        return response($fileContent)
            ->header('Content-Type', 'text/html'); // Set content type to HTML
    }

}
