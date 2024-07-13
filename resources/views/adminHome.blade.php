@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">

        <div class="row mt-3">
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Total Booking</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    @php
                                        $length = 0;
                                        $length = count($reservations);
                                    @endphp

                                    {{ $length }}
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span>
                                    @php
                                        $total = 5000;
                                        $length = 0;
                                        $length = count($reservations);
                                        $percentage = ($length / $total) * 100;
                                    @endphp

                                    {{ $percentage }}%
                                    <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1" data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="{{ $percentage }}%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-box"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Stock Item</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    @php
                                        $length = 0;
                                        $length = $inventoryCounts;
                                    @endphp

                                    {{ $length }}
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span>
                                    @php
                                        $total = 50000;
                                        $length = 0;
                                        $length = $inventoryCounts;
                                        $percentage = ($length / $total) * 100;
                                    @endphp

                                    {{ $percentage }}%
                                    <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1" data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-green" role="progressbar" data-width="{{ $percentage }}%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-gear"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Task List</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    @php
                                        $length = 0;
                                        $length = count($tasks);
                                    @endphp

                                    {{ $length }}
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span>
                                    @php
                                        $total = 5000;
                                        $length = 0;
                                        $length = count($tasks);
                                        $percentage = ($length / $total) * 100;
                                    @endphp

                                    {{ $percentage }}%
                                    <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1" data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="{{ $percentage }}%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Total Payment</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    @php
                                        $length = 0;
                                        $length = $payments->sum('amount');
                                    @endphp

                                    ₱ {{ $length }}
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span>
                                    @php
                                        $total = 50000;
                                        $length = 0;
                                        $length = $payments->sum('amount');
                                        $percentage = ($length / $total) * 100;
                                    @endphp

                                    {{ $percentage }}%
                                    <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1" data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="{{ $percentage }}%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart on Reservation --}}
        <div class="row mt-1">
            <div class="col-md-12">

            </div>
        </div>

        <div class="row mt-1">
            <div class="col-md-12">
                <div class="row px-3">
                    <div class="col-sm-2 text-center rounded pt-3 agenda-text">
                        <h1 class="display-1 text-white fw-bold">{{ date('d') }}</h1>
                        <h2 class="text-white">{{ date('M') }}</h2>
                    </div>

                    @if ($currentReservation)
                        <div class="col-sm-10 inventory-container py-3">
                            <h3 class="text-uppercase"><strong> {{ $currentReservation->activity }}</strong></h3>
                            <ul class="list-unstyled">
                                <li class="list-inline-item"><i class="far fa-calendar"></i>
                                    {{ Carbon\Carbon::now()->format('l') }}</li>
                                <li class="list-inline-item"><i class="far fa-clock"></i> {{ $currentReservation->time }}
                                </li>
                                <li class="list-inline-item"><i class="fas fa-map-marker-alt"></i>
                                    {{ $currentReservation->facility }}</li>
                            </ul>
                            <div class="alert alert-primary">
                                <strong>Reminder!</strong> This is your current schedule right now.
                            </div>
                        </div>
                    @else
                        <div class="col-sm-10 inventory-container py-3">
                            <div class="d-flex align-items-center justify-content-center h-100 ">
                                <div class="alert alert-warning w-100">
                                    <strong>Reminder!</strong> There's no schedule in the current date right now.
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-sm-3">
                <div class="inventory-container p-4 bg-light">
                    <h4 class="mb-3 fw-bold">Inventory Overview</h4>
                    <div class="table-responsive">
                        <table class="table nowrap ">
                            <thead>
                                <tr>
                                    <th>Item No.</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $latestInventories = $inventories->sortByDesc('itemId')->take(5);
                                @endphp
                                @foreach ($latestInventories as $inventory)
                                    <tr>
                                        <td class="fw-bold">{{ $inventory->itemId }}</td>
                                        <td>{{ $inventory->quantity }}</td>
                                        <td>
                                            @if ($inventory->status === 'Pending')
                                                <span class="badge bg-warning rounded-pill d-inline-block">Pending</span>
                                            @elseif($inventory->status === 'Damaged')
                                                <span class="badge bg-danger rounded-pill d-inline-block">Damaged</span>
                                        </td>
                                    @else
                                        <span class="badge bg-info rounded-pill d-inline-block">Reserved</span>
                                @endif
                                </td>
                                </tr>
                                @endforeach
                                <!-- Add more table rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="payment-container p-4 bg-light">
                    <h4 class="mb-3 fw-bold">Payment Overview</h4>
                    <div class="table-responsive">
                        <table class="table nowrap">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $latestPayments = $payments->sortByDesc('id')->take(5);
                                @endphp
                                @foreach ($latestPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->date }}</td>
                                        <td>₱{{ $payment->amount }}</td>
                                    </tr>
                                @endforeach
                                <!-- Add more table rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
