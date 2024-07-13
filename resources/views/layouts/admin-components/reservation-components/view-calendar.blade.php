@extends('layouts.admin-app')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css">
    <style>
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
    </style>
@endsection
@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
            <h3 class=" fw-bold mb-4">View Calendar</h3>
            <div class="col-md-12 ">
                <div class=" pb-3">
                    <div class="legend">
                        <p class="legend-text px-4 fw-bold">Legend :</p>
                        <div class="legend-item">
                            <span class="dot"></span>
                            <p class="legend-text px-2">Reservation</p>
                        </div>
                        <div class="legend-item">
                            <span class="dot1"></span>
                            <p class="legend-text">Event</p>
                        </div>
                    </div>
                </div>
                <div class="m-2">
                    <div id="calendar"></div>
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
            var events = @json($events_show);
            $('#calendar').fullCalendar({
                initialView: 'dayGridMonth',
                events: events,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
            });
        });
    </script>
@endsection
