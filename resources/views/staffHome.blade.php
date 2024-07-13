@extends('layouts.staff-app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Oswald:300,400,500,700');
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');

        :root {
            --gr-1: linear-gradient(170deg, #01E4F8 0%, #1D3EDE 100%);
            --gr-2: linear-gradient(170deg, #B4EC51 0%, #429321 100%);
        }

        .fc-unthemed .fc-content,
        .fc-unthemed .fc-divider,
        .fc-unthemed .fc-list-heading td,
        .fc-unthemed .fc-list-view,
        .fc-unthemed .fc-popover,
        .fc-unthemed .fc-row,
        .fc-unthemed tbody,
        .fc-unthemed td,
        .fc-unthemed th,
        .fc-unthemed thead {
            border-color: #000;
        }

        .fc-left h2 {
            font-weight: bold;
        }

        .fc-event {
            border: none;
            text-align: center;
            padding: 4px 0;
        }

        td {
            background: transparent !important;
        }

        .legend {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .legend-text {
            margin: 0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #2F4564;
            border-radius: 50%;
            margin-right: 5px;
        }

        .dot1 {
            height: 10px;
            width: 10px;
            background-color: #22CDB6;
            border-radius: 50%;
            margin-right: 5px;
        }

        .gr-1 {
            background: var(--gr-1);
        }

        .gr-2 {
            background: var(--gr-2);
        }

        * {
            transition: 0.5s;
        }

        .column {
            padding-right: 0;
        }

        .card {
            min-height: 170px;
            margin: 0;
            border: none;
            border-radius: 10px;
            color: rgba(0, 0, 0, 1);
            letter-spacing: 0.05rem;
            font-family: 'Oswald', sans-serif;
            box-shadow: 0 0 21px rgba(0, 0, 0, 0.27);
        }

        .more-card {
            padding: 1.7rem 1.2rem;
        }

        .card h2 {
            font-size: 1.5rem;
            font-weight: 300;
            text-transform: uppercase;
        }

        .card p {
            font-size: 0.7rem;
            font-family: 'Open Sans', sans-serif;
            letter-spacing: 0rem;
            margin-top: 33px;
            opacity: 0;
            color: rgba(255, 255, 255, 1);
        }

        .card:hover .txt h2,
        .card:hover .txt p {
            color: rgba(255, 255, 255, 1);
            opacity: 1;
        }

        .card .more-button {
            z-index: 0;
            font-size: 0.7rem;
            color: rgba(0, 0, 0, 1);
            margin-left: 1rem;
            position: relative;
            bottom: -0.5rem;
            text-transform: uppercase;
        }

        .card .more-button:after {
            content: "";
            display: inline-block;
            height: 0.5em;
            width: 0;
            margin-right: -100%;
            margin-left: 10px;
            border-top: 1px solid rgba(255, 255, 255, 1);
            transition: 0.5s;
        }

        .card:hover .more-button:after {
            width: 10%;
        }

        .ico-card {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .card .more-icon {
            position: relative;
            right: -50%;
            top: 60%;
            font-size: 12rem;
            line-height: 0;
            opacity: 0.2;
            color: rgba(255, 255, 255, 1);
            z-index: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-3">
            <div class="col-md-7 mb-3">
                <div class="card inventory-container">
                    <div class="card-body d-flex flex-column">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="px-4">
                                <h1 class="pb-2 text-dark fw-bold">Task List</h1>
                                <a class="btn btn-dark btn-md" href="{{ route('staff.maintenance.viewTask') }}"
                                    style="border-radius: 10px;">
                                    <span class="px-1">View task</span> <i class="fa-solid fa-greater-than px-2"
                                        style="color: #fff;"></i>
                                </a>
                            </div>

                            <img class="card-img" src="{!! url('assets/images/staff-task.png') !!}" style="width: 250px; height: 250px;">
                        </div>
                    </div>

                    <div class="bg-white d-flex justify-content-between mx-3 mb-3 px-4 mt-1">
                        <div class="mt-2">
                            <h7 class="text-dark fw-bold text-capitalize">In Progress</h7>
                            <h1 class="fw-bold">
                                @php
                                    $totalInProgress = $staffTasks->where('status', 'Not Done')->count();
                                @endphp
                                {{ $totalInProgress }}
                            </h1>
                        </div>
                        <div class="mt-2">
                            <h7 class="text-dark fw-bold text-capitalize">Done</h7>
                            <h1 class="fw-bold">
                                @php
                                    $totalDone = $staffTasks->where('status', 'Done')->count();
                                @endphp
                                {{ $totalDone }}
                            </h1>
                        </div>
                        <div class="mt-2">
                            <h7 class="text-dark fw-bold text-capitalize">Unfinished</h7>
                            <h1 class="fw-bold">
                                @php
                                    $totalUnfinished = $staffTasks->where('status', 'Unfinished')->count();
                                @endphp
                                {{ $totalUnfinished }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="column">
                    <div class="card gr-1 mb-3 more-card">
                        <div class="txt">
                            <h2>Reservation</h2>
                            <p>Make sure to check the reservation</p>
                        </div>
                        <a class="more-button" href="{{ route('staff.reservation.view') }}">more</a>
                        <div class="ico-card">
                            <i class="fa fa-calendar more-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div class="card gr-2 more-card">
                        <div class="txt">
                            <h2>Inventory <br>
                                Record</h1>
                                <p>Checking the inventory record.</p>
                        </div>
                        <a class="more-button" href="{{ route('staff.inventory.view') }}">more</a>
                        <div class="ico-card">
                            <i class="fa fa-box more-icon"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-1">
            <div class="col-md-12">
                <div class="row px-3">
                    <div class="col-sm-2 text-center rounded pt-3 inventory-container">
                        <img class="card-img" src="{!! url('assets/images/staff-availability.jpg') !!}" alt="">
                    </div>
                    <div class="col-sm-10 inventory-container py-2">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                            <h2 class="fw-bold text-primary mb-3">Please Update Your Availability for Task Assignments</h2>
                            <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal"
                                data-bs-target="#availabilityModal" id="modifyAvailabilityButton">
                                <i class="fas fa-arrow-left px-1"></i> Modify Availability
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="inventory-container mt-sm-3 p-3">
                    <h4 class="fw-bold text-capitalize p-3">{{ Auth::user()->name }}'s Current Task</h4>
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staffTasks->take(5)->sortByDesc('id') as $key => $staffTask)
                                        <tr>
                                            <td data-name="Task Name">{{ $staffTask->name }}</td>
                                            <td data-name="Location">{{ $staffTask->location }}</td>
                                            <td data-name="Date">{{ $staffTask->date }}</td>
                                            <td class="status">
                                                <span
                                                    class="badge @if ($staffTask->status === 'Unfinished') decline
                                    @elseif ($staffTask->status === 'Not Done') pending
                                    @else approved @endif">{{ $staffTask->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="inventory-container mt-sm-3 p-3">
                    <h4 class="fw-bold text-capitalize p-3">Upcoming Reservation Assistance</h4>
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staffReserveTasks->take(5)->sortByDesc('id') as $staffReserveTask)
                                        <tr>
                                            <td data-name="Task Name">Assist for {{ $staffReserveTask->activity }}</td>
                                            <td data-name="Location">{{ $staffReserveTask->facility }}</td>
                                            <td data-name="Date">
                                                {{ $staffReserveTask->date }}<br>{{ $staffReserveTask->time }}</td>
                                            <td class="status">
                                                <span
                                                    class="badge
                                                @if ($staffReserveTask->status === 'Decline') decline
                                                @elseif ($staffReserveTask->status === 'Pending') pending
                                                @else approved @endif">
                                                    {{ $staffReserveTask->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Availability Modal -->
        <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="availabilityModalLabel">Update Availability</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="m-2">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#availabilityModal').on('shown.bs.modal', function() {
                $('#calendar').fullCalendar({
                    defaultView: 'agendaWeek',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'agendaWeek,agendaDay'
                    },
                    allDaySlot: true, 
                });
            });
        });
    </script>
@endsection
