<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tblPayment;
use App\Models\tblReservation;
use App\Models\User;
use App\Models\tblAuditLogs;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{
    public function addPayment(Request $request)
    {
        $request->validate([
            'reservedId' => 'required|string',
            'amount' => 'required|string',
            'date' => 'required|date',
        ]);

        $reservationId = $request->input('reservedId');
        $reserveeName = $request->input('reserveeName');
        $paymentAmount = $request->input('amount');
        $paymentDate = $request->input('date');

        $payment = new tblPayment();
        $payment->control_no = "";
        $payment->name = $reserveeName;
        $payment->amount = $paymentAmount;
        $payment->status = "Unpaid";
        $payment->date = $paymentDate;
        $reservation = tblReservation::find($reservationId);

        if(!$reservation){
            return response()->json(['message' => 'Reservation Does not exist!!'], 404);
        }

        $formattedDate = str_replace('-', '', $reservation->date);
        $payment->reservationId = $reservationId;
        $payment->save();

        $payment->control_no = 'CN'. $formattedDate .'-'. str_pad($payment->id, 4, '0', STR_PAD_LEFT);
        $payment->save();
    }

    public function approvePayment(Request $request)
    {
        $paymentId = $request->input('id');
        $request = tblPayment::find($paymentId);
        $reservationId = $request->reservationId;
        $requestRe = tblReservation::find($reservationId);
        $reservationRenterId = $requestRe->recipientId;

        if(!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        
        $request->status = "Paid";
        $request->save();

        $message = " has approved Paid the Payment No. ". $paymentId;
        $this->createFacilityAudit($message);

        return response()->json(['message' => 'Payment Approved Successfully!', 'reservationId' => $reservationId, 'renterId' => $reservationRenterId]);
    }
    
    public function updatePayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|string',
            'date' => 'required|date',
        ]);

        $paymentId = $request->input('id');
        $reservationId = $request->input('reservedId');
        $reserveeName = $request->input('reserveeName');
        $paymentAmount = $request->input('amount');
        $paymentDate = $request->input('date');

        $request = tblPayment::find($paymentId);

        if(!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $request->name = $reserveeName;
        $request->amount = $paymentAmount;
        $request->date = $paymentDate;
        $request->reservationId = $reservationId;
        $request->save();
    }

    public function deletePayment($paymentId)
    {
        $request = tblPayment::find($paymentId);

        if(!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $request->delete();
    }

    public function viewPayment(Request $request)
    {
        $paymentId = $request->input('id');
        $reservationId = $request->input('reservationId');
        $payment = tblPayment::find($paymentId);

        if(!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $reservation = tblReservation::find($reservationId);

        if(!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $paymentData = [
            'reservationFacility' => $reservation->facility,// Replace with the actual attribute name
            'amount' => $payment->amount, // Replace with the actual attribute name
            // Add other payment attributes here
        ];

        $recipientId = $reservation->recipientId;
        $user = User::find($recipientId);

        if(!$user) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        return response()->json([
            'success' => true,
            'recipientName' => $reservation->name,
            'recipientEmail' => $user->email,
            'recipientOrganization' => $reservation->organization,
            'recipientAddress' => $reservation->address,
            'recipientContact' => $user->contact,
            'reservationEventType' => $reservation->event_type,
            'reservationActivity' => $reservation->activity,
            'reservationFacility' => $reservation->facility,
            'reservationDate' => $reservation->date,
            'reservationTime' => $reservation->time,
            'reservationEquipment' => $reservation->equipment_needed,
            'payment' => $paymentData
        ]);
    }

    private function createFacilityAudit($message){
        $userId = Auth()->id();
        $user = User::find($userId);

        if(!$user){
            return response()->json(['message' => 'User does not exist!!'], 404);
        }

        tblAuditLogs::create([
            'userId' => $userId,
            'type' => "Payment",
            'description' => strtok($user->name, ' ') . $message,
        ]);
    }
}
