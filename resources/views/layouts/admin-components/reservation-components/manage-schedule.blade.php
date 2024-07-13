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
    {{-- <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
            <h3 class=" fw-bold mb-4">Manage Event Reservation</h3>

            <div class="col text-end pb-3">
                <button type="submit" class="btn btn-outline-success text-capitalize ms-1" data-bs-toggle="modal"
                    data-bs-target="#addEventModal"><i class="fa-regular fa-calendar-plus text-outline-success"
                        style="padding-right: 8px;"></i>Add
                    Event</button>
            </div>

            <div class="table-responsive">
                <table id="event-reservation" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Event Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addEventItems as $addEventItem)
                            <tr>
                                <td>{{ $addEventItem->id }}</td>
                                <td>{{ $addEventItem->title }}</td>
                                <td>{{ $addEventItem->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($addEventItem->start_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($addEventItem->end_date)->format('Y-m-d') }}</td>
                                <td>
                                    <button type="submit" class="btn btn-warning eventUpdate" data-bs-toggle="modal"
                                        data-id="{{ $addEventItem->id }}" data-title="{{ $addEventItem->title }}"
                                        data-description="{{ $addEventItem->description }}"
                                        data-start="{{ $addEventItem->start_date }}"
                                        data-end="{{ $addEventItem->end_date }}" data-bs-target="#updateEventModal"><i
                                            class="fas fa-pencil"></i></button>
                                    <button type="submit" class="btn btn-danger eventDelete" data-bs-toggle="modal"
                                        data-id="{{ $addEventItem->id }}" data-bs-target="#deleteEventModal"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
            <h3 class=" fw-bold mb-4">Manage Event Reservation</h3>

            <div class="col text-end pb-3">
                <button type="submit" class="btn btn-outline-success text-capitalize ms-1" data-bs-toggle="modal"
                    data-bs-target="#addEventModal"><i class="fa-regular fa-calendar-plus text-outline-success"
                        style="padding-right: 8px;"></i>Add
                    Event</button>
            </div>
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

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="addModalLabel">Add Event Reservation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating my-3">
                        <input type="text" name="eventName" id="eventName" class="form-control" placeholder=" " />
                        <label for="eventName">Event Name</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="text" name="eventDescription" id="eventDescription" class="form-control"
                            placeholder=" " />
                        <label for="eventName">Event Description</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="file" name="eventImage" id="eventImage" class="form-control" placeholder=" " />
                        <label for="eventName">Image Attachment</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="date" name="startDate" id="startDate" class="form-control" placeholder=" " />
                        <label for="startDate">Start Date</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="date" name="endDate" id="endDate" class="form-control" placeholder=" " />
                        <label for="endDate">End Date</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="addEventBtn" class="btn btn-success">Add Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Event Modal -->
    <div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateModalLabel">Update Event Information Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="updateEventId" style="display: none"></p>
                    <div class="form-floating my-3">
                        <input type="text" name="updateEventName" id="updateEventName" class="form-control"
                            placeholder=" " />
                        <label for="updateEventName">Event Name</label>
                    </div>
                    <div class="form-floating my-3">
                        <select class="form-select" id="facilitySelect" name="facilitySelect"
                            aria-label="Default select example">
                            <option value="">Select Facility</option>
                            <option value="Multi-Sports Hall">
                                Multi-Sports Hall</option>
                            <option value="Aquatic Center">Aquatic Center</option>
                            <option value="Multi-Sports Hall, Aquatic Center">Both Facilities</option>
                        </select>
                    </div>
                    <div class="form-floating my-3">
                        <input type="text" name="updateEventDescription" id="updateEventDescription"
                            class="form-control" placeholder=" " />
                        <label for="updateEventDescription">Event Description</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="file" name="updateEventImage" id="updateEventImage" class="form-control"
                            placeholder=" " />
                        <label for="updateEventImage">Image Attachment</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="date" name="updateStartDate" id="updateStartDate" class="form-control"
                            placeholder=" " />
                        <label for="updateStartDate">Start Date</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="date" name="updateEndDate" id="updateEndDate" class="form-control"
                            placeholder=" " />
                        <label for="updateEndDate">End Date</label>
                    </div>
                    <p>Status: <span id="eventStatusForm" class="badge rounded-pill d-inline-block"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="eventUpdateBtn" class="btn btn-warning ">Update Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Event Modal -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete Event</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Event ID. <span id="eventIdDel" class="eventIdDel"></span>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="eventDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
    <script>
        $('#addEventBtn').click(function() {
            var eventName = $('#eventName').val();
            var eventDescription = $('#eventDescription').val();
            var eventImage = $('#eventImage')[0].files[0]; // Get the selected file
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            var formData = new FormData();
            formData.append('name', eventName);
            formData.append('description', eventDescription);
            formData.append('image', eventImage);
            formData.append('startDate', startDate);
            formData.append('endDate', endDate);

            $.ajax({
                url: '/admin/reservation/addEvent',
                method: 'POST',
                processData: false, // Important for handling FormData
                contentType: false, // Important for handling FormData
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formData,
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Event has been added successfully!!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/reservation/manage';
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 200) {
                        var message = xhr.responseJSON.message;

                        // Display SweetAlert error notification
                        swal({
                            icon: 'error',
                            title: "Cannot apply this Event!!",
                            text: message
                        });
                    } else {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Event:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                }
            });
        });


        $('.eventUpdate').click(function() {
            var eventId = $(this).data('id');
            var eventTitle = $(this).data('title');
            var eventDescription = $(this).data('description');
            var eventStart = $(this).data('start');
            var eventEnd = $(this).data('end');

            $('#updateEventId').text(eventId);
            $('#updateEventName').val(eventTitle);
            $('#updateEventDescription').val(eventDescription);
        });

        $('#eventUpdateBtn').click(function() {
            var eventId = $('#updateEventId').text();
            var eventName = $('#updateEventName').val();
            var eventDescription = $('#updateEventDescription').val();
            var eventImage = $('#updateEventImage')[0].files[0]; // Get the selected file
            var startDate = $('#updateStartDate').val();
            var endDate = $('#updateEndDate').val();

            var formData = new FormData();
            formData.append('id', eventId);
            formData.append('name', eventName);
            formData.append('description', eventDescription);
            formData.append('image', eventImage);
            formData.append('startDate', startDate);
            formData.append('endDate', endDate);

            $.ajax({
                url: '/admin/reservation/updateEvent',
                method: 'POST',
                processData: false, // Important for handling FormData
                contentType: false, // Important for handling FormData
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formData, // Use the FormData object for data
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Event has been Updated Successfully!!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/reservation/manage';
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 200) {
                        var message = xhr.responseJSON.message;

                        // Display SweetAlert error notification
                        swal({
                            icon: 'error',
                            title: 'Cannot apply this Event!!',
                            text: message
                        });
                    } else {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Event:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                }
            });
        });


        $('.eventDelete').click(function() {
            var eventId = $(this).data('id');
            $('#eventIdDel').text(eventId);
        });

        $('#eventDeleteBtn').click(function() {
            var eventId = $('#eventIdDel').text();

            $.ajax({
                url: '/admin/reservation/deleteEvent',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: eventId,
                },
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Event has been Deleted Successfully!!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/reservation/manage';
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 200) {
                        var message = xhr.responseJSON.message;

                        // Display SweetAlert error notification
                        swal({
                            icon: 'error',
                            title: "Cannot apply this Event!!",
                            text: message
                        });
                    } else {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Event:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                }
            });
        });


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

            $('#event-reservation').DataTable({
                responsive: true,
                fixedheader: true,
                "order": [
                    [0, "desc"]
                ]
            });
        });
    </script>
@endsection
