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
            background-color: #ef8354;
            border-radius: 50%;
            margin-right: 5px;
        }

        .dot1 {
            height: 10px;
            width: 10px;
            background-color: #1f7a8c;
            border-radius: 50%;
            margin-right: 5px;
        }

        .dot2 {
            height: 10px;
            width: 10px;
            background-color: blue;
            border-radius: 50%;
            margin-right: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row m-1">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                <li class="nav-item text-start">
                    <a class="nav-link " style="color: rgb(255, 81, 0);">
                        <i class="fa-regular fa-calendar fa-fw fa-lg me-2"></i>Team Scheduler
                    </a>
                </li>
                <ul class="nav nav-tabs justify-content-end" style="flex-grow: 1;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                            href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                            aria-selected="true">Overall Schedule</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">Staff
                            Schedule</a>
                    </li>
                </ul>
            </ul>
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="col mt-3">
                        <div class="col-md-12">
                            <div class="m-2">
                                <div id="overall-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <!-- Tabs navs -->
                    <div class="row mt-4 m-1">
                        {{-- <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold py-2">Selection Staff</h3>
                            </div>
                            <div class="list-group overflow-auto shadow" style="max-height: 30rem;">
                                @foreach ($userLists as $userList)
                                    <a href="#" class="list-group-item list-group-item-action showStaffOption"
                                        data-bs-toggle="modal" data-id="{{ $userList->id }}" data-bs-target="#staffModal">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1 fw-bold italic"
                                                style="color: {{ sprintf('#%06X', mt_rand(0, 0xffffff)) }}">
                                                {{ $userList->name }}</h5>
                                            <small class="text-muted">Staff</small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="m-2">
                                <div id="calendar"></div>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <h3 class=" fw-bold mb-4">Staff List</h3>
                            <div class="table-responsive">
                                <table id="view-staff" class="table table-striped table-hover nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Schedule</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userLists as $userList)
                                            <tr>
                                                <td>{{ $userList->id }}</td>
                                                <td>{{ $userList->name }}</td>
                                                <td><a class="text-decoration-none showStaffOption" style="cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#viewCalendar"
                                                        data-id="{{ $userList->id }}" data-name="{{ $userList->name }}">View
                                                        Schedule</a> </td>
                                                <td><button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-id="{{ $userList->id }}" data-bs-target="#staffModal">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
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
        </div>


        <!-- Example Staff Modal -->
        <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="staffModalLabel">Edit Staff</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="staffAvailId" style="display: none"></span>
                        <div class="d-grid gap-2 mb-3">
                            <p>Reason</p>
                            <input type="text" id="staffReason" class="form-control" name="staffReason" placeholder=""
                                required />
                            <select id="staffAvailDate" class="form-select">
                                <option value="" selected>Date Avail</option>
                                <option value="single">Single Day</option>
                                <option value="multiple">Multiple Days</option>
                            </select>
                            <p>Start Date</p>
                            <input type="date" id="startStaffDate" class="form-control" name="startStaffDate"
                                placeholder="" required />
                            <p>End Date</p>
                            <input type="date" id="endStaffDate" class="form-control" name="endStaffDate" placeholder=""
                                required />
                            <select id="staffAvailType" class="form-select">
                                <option value="" selected>Select Availability</option>
                                <option value="avail">Available</option>
                                <option value="notAvail">Not Available</option>
                            </select>
                        </div>

                        <div class="d-grid my-2 mt-2">
                            <button type="button" id="staffAvailabilityBtn" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Modal -->
        <div class="modal fade" id="viewCalendar" tabindex="-1" aria-labelledby="viewCalendarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="staffModalLabel"><span id="staffName"></span> Schedule</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="pb-3">
                            <div class="legend">

                                <p class="legend-text px-4 fw-bold">Legend :</p>

                                <div class="legend-item">
                                    <span class="dot"></span>
                                    <p class="legend-text px-2">Maintenance Task</p>
                                </div>
                                <div class="legend-item">
                                    <span class="dot1"></span>
                                    <p class="legend-text">Reservation <span class="text-muted">(Big-Event)</span></p>
                                </div>

                                <div class="legend-item">
                                    <span class="dot2"></span>
                                    <p class="legend-text">Reservation <span class="text-muted">(Small-Event)</span></p>
                                </div>
                            </div>
                        </div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        $(document).ready(function() {

            //Auto generate for New Calendar (Missing StaffId)
            $.ajax({
                url: '/admin/maintenance/staffOverallList',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log(response.events);

                    var calendarEl = document.getElementById('overall-calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'timeGridWeek',
                        slotMinTime: '6:00:00',
                        slotMaxTime: '23:00:00',

                        events: response.events,
                    });
                    calendar.render();
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Creating Staff Schedule:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });

            // New Method
            $(".showStaffOption").click(function() {
                var staffId = $(this).data("id");
                var staffName = $(this).data("name");
                $("#staffAvailId").text(staffId);
                $("#staffName").text(staffName);

                $('#viewCalendar').modal('show');

                $.ajax({
                    url: '/admin/maintenance/staffLeaveList',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        staffId: staffId,
                    },
                    success: function(response) {
                        var events = response.events;

                        console.log(events);

                        $('#viewCalendar').on('shown.bs.modal', function(e) {

                            var calendarEl = document.getElementById('calendar');
                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'timeGridWeek',
                                slotMinTime: '7:00:00',
                                slotMaxTime: '23:00:00',
                                events: response.events,
                            });
                            calendar.render();
                        });

                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Problem for Creating Staff Schedule:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                });
            });
        });

        $("#staffAvailabilityBtn").click(function() {
            var staffId = $("#staffAvailId").text();
            var staffReason = $("#staffReason").val();
            var startStaffDate = $("#startStaffDate").val();
            var endStaffDate = $("#endStaffDate").val();
            var staffAvailType = $("#staffAvailType").val()

            $.ajax({
                url: '/admin/maintenance/staffAvailability',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    staffId: staffId,
                    staffReason: staffReason,
                    startStaffDate: startStaffDate,
                    endStaffDate: endStaffDate,
                    staffAvailType: staffAvailType,
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Staff Schedule has been Added!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/manageTeamScheduler';
                    });
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Creating Staff Schedule:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    </script>
@endsection
