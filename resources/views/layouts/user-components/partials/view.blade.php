@extends('layouts.user-app')

@section('content')
<div class="container-fluid content-wrapper">
    <div class="row mt-4 reservation-container m-2 p-3">
        <h3 class=" fw-bold mb-4">View Reservation</h3>
        <div class="table-responsive">
            <table id="view-reservation" class="table table-striped table-hover nowrap table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Name</th>
                        <th>Recipient Name</th>
                        <th>Facility</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>       
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>{{$reservation->id}}</td>
                        <td>{{$reservation->name}}</td>
                        <td>{{$reservation->recipientName}}</td>
                        <td>{{$reservation->facility}}</td>
                        <td>{{$reservation->date}}</td>
                        <td>{{$reservation->time}}</td>
                        <td><span class="badge rounded-pill d-inline-block
                            @if($reservation->status=== 'Cancelled')
                                bg-danger
                            @elseif ($reservation->status === 'Pending') bg-warning
                            @else
                                bg-success
                            @endif">
                            {{ $reservation->status}}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection