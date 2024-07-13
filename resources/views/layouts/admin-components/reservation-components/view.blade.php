@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
            <h3 class=" fw-bold mb-4">View Reservation</h3>
            <div class="table-responsive">
                <table id="view-reservation" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Recipient Name</th>
                            <th>Activity</th>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Time Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addReviewItems as $addReviewItem)
                            <tr>
                                <td>{{ $addReviewItem->id }}</td>
                                <td>{{ $addReviewItem->recipientName }}</td>
                                <td>{{ $addReviewItem->activity }}</td>
                                <td>{{ $addReviewItem->facility }}</td>
                                <td>{{ $addReviewItem->date }}</td>
                                <td>{{ $addReviewItem->time }}</td>
                                <td><span
                                        class="badge rounded-pill d-inline-block @if ($addReviewItem->status === 'Cancelled') bg-danger
                            @else
                                bg-success @endif">{{ $addReviewItem->status }}
                                    </span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
