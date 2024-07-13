<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ECABS : Schedule Now</title>

    <link rel="icon" sizes="96x96" href="{!! url('assets/images/Icon.png') !!}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css">

    <style>
        .h-custom-2 {
            height: calc(100% - 7rem);
        }

        .date-input-wrapper {
            position: relative;
        }

        .input-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            padding: 8px;
            color: #aaa;
            pointer-events: none;
            transition: 0.2s ease-out;
        }

        #bday:focus+.input-placeholder,
        #bday:not(:placeholder-shown)+.input-placeholder {
            transform: translateY(-50%);
            font-size: 12px;
            color: #000;
        }


        #calendar-background {
            background-image: url('assets/images/CABSSS.png');
            background-size: cover;
            background-position: left;
        }

        #calendar-background {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow-y: auto;
        }

        .calendar {
            border-radius: 10px;
            background: #F6F6F6;
            box-shadow: rgba(255, 255, 255, 0.1) 0px 1px 1px 0px inset, rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
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

        .fc-unthemed th {
            background: #aaa;
            color: #FFFFFF;
        }

        .fc-button {
            background: #FFFFFF;
        }

        .fc-event {
            border: none;
            text-align: center;
            padding: 4px 0;
        }

        .timeline {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 32px;
        }

        .events {
            position: relative;
            display: grid;
            grid-template-columns: 16px 1fr;
            row-gap: 16px;
            padding-top: 32px;
            width: fit-content;
            max-height: 650px;
            overflow-y: auto;
        }

        .event {
            display: grid;
            grid-template-columns: 16px 1fr;
            column-gap: 16px;
            grid-column: 1 / 3;
        }

        .date>h2,
        .description>p {
            margin: 0;
        }

        .knob {
            grid-column: 1 / 2;
            align-self: center;
            width: 100%;
            aspect-ratio: 1 / 1;
            z-index: 1;
            background: #4c4c4c;
            border-radius: 50%;
        }

        .date,
        .description {
            grid-column: 2 / 3;
            align-self: center;
        }

        .description span {
            opacity: .5;
        }

        .line {
            position: absolute;
            left: 3%;
            height: 85%;
            width: 4px;
            z-index: 0;
            background-color: rgba(0, 0, 0, .1);
        }

        .modal-header {
            border-bottom: none !important;
        }

        .modal-footer {
            border-top: none !important;
            justify-content: center !important;
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

        .pulse {
            --color: #2F4564;
            --hover: #22CDB6;
        }
    
        .button {
            color: var(--color);
            background: none;
            border: 2px solid;
            font: inherit;
            line-height: 1;
            margin: 0.5em;
            padding: 1em 5em;
            transition: 0.25s;
        }

        .button:hover,
        .button:focus {
            border-color: var(--hover);
            color: #000000;
        }

        .pulse:hover,
        .pulse:focus {
            animation: pulse 1s;
            box-shadow: 0 0 0 2em transparent;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 var(--hover);
            }
        }

        .fc-button {
            color: #FFFFFF;
            background: #6c757d;
        }

    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div id="calendar-background" class="w-100 h-100 p-4 d-flex justify-content-center align-items-center">
        <div class="calendar shadow p-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 px-0 d-none d-sm-block" style="position: relative;">


                        <div class="timeline">
                            <div class="events">
                                @php
                                    $currentDate = now()->format('Y-m-d');
                                @endphp

                                @foreach ($events as $event)
                                    @if ($event->start_date >= $currentDate)
                                        <div class="event">
                                            <div class="knob"></div>
                                            <div class="date">
                                                <h2 class="fw-bold">
                                                    {{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}
                                                </h2>
                                            </div>
                                            <div class="description">
                                                <p><strong>{{ $event->title }}</strong></p>
                                                <span>End:
                                                    {{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="line"></div>
                        </div>

                        <div class="text-center position-absolute bottom-0 w-100 p-2">
                            <a href="/" class="btn btn-secondary w-100 p-1 "><i
                                    class="fa fa-arrow-left text-outline-secondary"
                                    style="padding-right: 8px;"></i>Back</a>
                        </div>
                    </div>
                    <div class="col-md-10 ">
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
                        <div class="container-fluid">
                            <div id="calendar"></div>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Schedule Modal -->
    <div class="modal fade" id="viewScheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <a href="/" class="d-flex align-items-center justify-content-center mb-1  text-dark text-decoration-none">
                        <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="50" height="50">
                        <span class="h4 fw-bold mt-2 px-1 logo-name text-danger">Cabuyao Athletes Basic School</span>
                    </a>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container d-flex justify-content-center align-items-center">
                        <a href="{{ route('login') }}" class="button pulse text-decoration-none">
                            Sign In
                        </a>
                    </div>

                </div>
                <div class="modal-footer">

                    <p>Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-danger">Sign Up</a></p>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                eventDisplay: 'block',
                dayClick: function(event) {

                    $('#viewScheduleModal').modal('show');

                }
            });

        });
    </script>
</body>



</html>
