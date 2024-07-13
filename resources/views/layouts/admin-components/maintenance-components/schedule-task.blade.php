@extends('layouts.admin-app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css">
@endsection

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row m-1">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                <li class="nav-item text-start">
                    <a class="nav-link " style="color: rgb(255, 81, 0);">
                        <i class="fa-regular fa-calendar fa-fw fa-lg me-2"></i>Schedule Task
                    </a>
                </li>
                <ul class="nav nav-tabs justify-content-end" style="flex-grow: 1;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                            href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                            aria-selected="true">Schedule</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">Task</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-3" data-bs-toggle="tab" href="#ex-with-icons-tabs-3"
                            role="tab" aria-controls="ex-with-icons-tabs-3" aria-selected="false">Location</a>
                    </li>
                </ul>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="col mt-3">
                        <h3 class=" fw-bold mb-3">Schedule Maintenance Task</h3>
                        <div class="col text-end pb-3">
                            <button type="submit" id="createScheduleBtn"
                                class="btn btn-outline-success text-capitalize ms-1" data-bs-toggle="modal"
                                data-bs-target="#scheduleModal"><i class="fa-regular fa-calendar-plus text-outline-primary"
                                    style="padding-right: 8px;"></i>Schedule
                                Task</button>
                            <button type="submit"class="btn btn-outline-primary text-capitalize ms-1 overallScheduleBtn"
                                data-bs-toggle="modal" data-bs-target="#viewScheduleModal"><i
                                    class="fa-regular fa-calendar-plus text-outline-primary"
                                    style="padding-right: 8px;"></i>View Overall Staff Schedule</button>
                        </div>
                        <div class="table-responsive">
                            <table id="schedule-task" class="table table-striped table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Task Description</th>
                                        <th>Designation</th>
                                        <th>Due Date</th>
                                        <th>Assigned Staff</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($addScheduleTask as $scheduleTask)
                                        <tr>
                                            <td>{{ $scheduleTask->name }}</td>
                                            <td>{{ $scheduleTask->location }}</td>
                                            <td>{{ \Carbon\Carbon::parse($scheduleTask->date)->format('M j, Y') }}</td>
                                            @php
                                                $staffList = json_decode($scheduleTask->staff_list, true);
                                            @endphp

                                            @if (!empty($staffList))
                                                <td>
                                                    @foreach ($staffList as $staff)
                                                        {{ $staff[1] }}
                                                        <span
                                                            class="badge rounded-pill d-inline-block
                                                        {{ $staff[2] == 'Not Done' ? 'bg-warning' : ($staff[2] == 'Unfinished' ? 'bg-danger' : 'bg-success') }}">
                                                            {{ $staff[2] }}
                                                        </span>
                                                        <br>
                                                    @endforeach
                                                </td>
                                            @else
                                                <td>No Staff Assigned</td>
                                            @endif
                                            <td>
                                                <span
                                                    class="badge rounded-pill d-inline-block
                                                    @if ($scheduleTask->status === 'In Progress') bg-warning
                                                        @elseif($scheduleTask->status === 'Done') bg-success 
                                                            @else bg-danger @endif">{{ $scheduleTask->status }}</span>
                                            </td>
                                            <td>
                                                @if ($scheduleTask->status === 'In Progress')
                                                    <button type="submit" class="btn btn-success btnTaskApprove"
                                                        data-bs-toggle="modal" data-id="{{ $scheduleTask->id }}"
                                                        data-bs-target="#approveModal">
                                                        <i class="fa-regular fa-circle-check fa-lg"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-warning updateScheduleBtn"
                                                        data-bs-toggle="modal" data-id="{{ $scheduleTask->id }}"
                                                        data-name="{{ $scheduleTask->name }}"
                                                        data-location="{{ $scheduleTask->location }}"
                                                        data-date="{{ $scheduleTask->date }}"
                                                        data-bs-target="#updateScheduleModal">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-danger deleteScheduleBtn"
                                                        data-id="{{ $scheduleTask->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#deleteScheduleModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <h3 class=" fw-bold my-3">Task List</h3>
                    <div class="col text-end pb-3">
                        <button type="submit" class="btn btn-outline-success text-capitalize ms-1" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal"><i class="fa-regular fa-square-plus text-outline-success"
                                style="padding-right: 8px;"></i>Add
                            Task</button>
                    </div>
                    <div class="table-responsive">
                        <table id="taskList" class="table table-striped mb-4 nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Task ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addTask as $task)
                                    <tr>
                                        <td>{{ $task->id }}</td>
                                        <td>{{ $task->name }}</td>
                                        <td><button type="submit" class="btn btn-warning updateTaskBtn"
                                                data-bs-toggle="modal" data-id="{{ $task->id }}"
                                                data-name="{{ $task->name }}"
                                                data-description="{{ $task->description }}"
                                                data-bs-target="#updateTaskModal">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="submit" class="btn btn-danger deleteTaskBtn"
                                                data-id="{{ $task->id }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteTaskModal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-3">
                    <h3 class=" fw-bold my-3">Task Location</h3>
                    <div class="col text-end pb-3">
                        <button type="submit" class="btn btn-outline-success text-capitalize ms-1"
                            data-bs-toggle="modal" data-bs-target="#addLocationModal"><i
                                class="fa-regular fa-square-plus text-outline-success" style="padding-right: 8px;"></i>Add
                            Location</button>
                    </div>
                    <div class="table-responsive">
                        <table id="taskLocation" class="table table-striped mb-4 nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Location ID</th>
                                    <th>Location Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addLocation as $location)
                                    <tr>
                                        <td>{{ $location->id }}</td>
                                        <td>{{ $location->location_name }}</td>
                                        <td><button type="submit" class="btn btn-warning updateLocation"
                                                data-bs-toggle="modal" data-id="{{ $location->id }}"
                                                data-name="{{ $location->location_name }}"
                                                data-bs-target="#updateLocationModal">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="submit" class="btn btn-danger deleteLocationBtn"
                                                data-id="{{ $location->id }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteLocationModal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Tabs content -->
        </div>
    </div>

    <!-- Schedule Task Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-white">
                <form id="formScheduleTask" action="{{ url('/admin/maintenance/addScheduleTask') }}" method="POST">
                    @csrf
                    <input type="hidden" name="assignedStaffData" id="assignedStaffData">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="scheduleModalLabel">Schedule Maintenance Task</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" name="taskName" id="floatingSelectTask"
                                            aria-label="Floating label select example">
                                            @foreach ($addTask as $task)
                                                <option value="{{ $task->name }}">{{ $task->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelectTask">Task Name</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" name="taskLocation" id="floatingSelectLocation"
                                            aria-label="Floating label select example">
                                            @foreach ($addLocation as $location)
                                                <option value="{{ $location->location_name }}">
                                                    {{ $location->location_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelectLocation">Task Location</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="taskDate" id="floatingInputDate">
                                    <label for="floatingInputDate">Date</label>
                                </div>
                                <hr class="my-3">
                                <div class="table-responsive">
                                    <table id="assign-task" class="table table-striped mb-4 nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Staff</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="availableSchedStaffList">
                                            {{-- @foreach ($addStaff as $staff)
                                                <tr>
                                                    <td>
                                                        {{ $staff->name }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary assignStaffBtn"
                                                            data-id="{{ $staff->id }}"
                                                            data-name="{{ $staff->name }}">Assign</button>
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="scheduleButton" class="btn btn-primary">Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Schedule Task Modal -->
    <div class="modal fade" id="updateScheduleModal" tabindex="-1" aria-labelledby="updateScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="height: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateScheduleModalLabel">Update Schedule Maintenance Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" name="updateScheduleName" id="updateScheduleName"
                                aria-label="Floating label select example">
                                <option selected id="updateScheduleName"></option>
                                @foreach ($addTask as $task)
                                    <option value="{{ $task->name }}">{{ $task->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Task Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" name="updateScheduleLocation" id="updateScheduleLocation"
                                aria-label="Floating label select example">
                                <option selected id="updateScheduleLocation"></option>
                                @foreach ($addLocation as $location)
                                    <option value="{{ $location->location_name }}">{{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Task Location</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="updateScheduleDate" id="updateScheduleDate">
                        <label for="floatingInput">Date</label>
                    </div>
                    <hr class="my-3">
                    <div class="table-responsive">
                        <table id="update-assign" class="table table-striped mb-4 nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="availableSchedUpdateStaffList">
                                {{-- @foreach ($addStaff as $staff)
                                    <tr>
                                        <td>
                                            {{ $staff->name }}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary assignStaffSBtn"
                                                data-id="{{ $staff->id }}"
                                                data-name="{{ $staff->name }}">Assign</button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updateSchedule">Update Schedule</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Schedule  Modal -->
    <div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteScheduleModalLabel">Delete Schedule</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want Schedule ID : <span class="scheduleIdDel"></span> mark as Unfinished?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="scheduleDelete" class="btn btn-danger">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal fade" id="viewScheduleModal" tabindex="-1" aria-labelledby="viewScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewScheduleModalLabel">Overall Schedule</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="overall-calendar"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="height: 50%;">
            <div class="modal-content">
                <form id="formAddtask" action="{{ url('/admin/maintenance/addTask') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="addTaskModalLabel">Add Task Information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="my-3">
                            <label for="taskName" class="form-label">Name of Task</label>
                            <input type="text" class="form-control" id="taskName" name="taskName" required>
                        </div>
                        <div class="my-3">
                            <label for="taskDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Task Modal -->
    <div class="modal fade" id="updateTaskModal" tabindex="-1" aria-labelledby="updateTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="height: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateTaskModallLabel">Update Task Information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3">
                        <label for="updateTaskName" class="form-label">Name of Task</label>
                        <input type="text" class="form-control" id="updateTaskName" name="updateTaskName" required>
                    </div>
                    <div class="my-3">
                        <label for="updateTaskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="updateTaskDescription" name="updateTaskDescription" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updateTask">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Task List Modal -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteTaskModalLabel">Delete Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete Task ID : <span class="taskIdDel"></span> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="taskDelete" class="btn btn-danger">Delete Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Location Modal -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="height: 50%;">
            <div class="modal-content">
                <form id="formLocation" action="{{ url('/admin/maintenance/addLocation') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="addLocationModalLabel">Add Location</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="my-3">
                            <label for="locationName" class="form-label">Name of Location</label>
                            <input type="text" class="form-control" id="locationName" name="locationName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Location Modal -->
    <div class="modal fade" id="updateLocationModal" tabindex="-1" aria-labelledby="updateLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="height: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateLocationModalLabel">Update Location</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3">
                        <label for="updateLocationName" class="form-label">Name of Location</label>
                        <input type="text" class="form-control" id="updateLocationName" name="updateLocationName"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updateLocation">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Location Modal -->
    <div class="modal fade" id="deleteLocationModal" tabindex="-1" aria-labelledby="deleteLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteLocationModalLabel">Delete Location</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete Location ID : <span class="locationIdDel"></span> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="locationDelete" class="btn btn-danger">Delete Location</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Task Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="approveScheduleTaskModalLabel">Approve Request List</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure that the scheduled Task has been done?</p>
                    <p id="approveScheduleTaskId" style="display: block"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="approveScheduleTaskBtn" class="btn btn-success">Approve</button>
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

            $(".overallScheduleBtn").click(function() {
                $.ajax({
                    url: '/admin/maintenance/staffOverallList',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        var events = response.events;

                        console.log(events);

                        var calendarEl = document.getElementById('overall-calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'timeGridWeek',
                            slotMinTime: '7:00:00',
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
            });
        });
    </script>
@endsection
