@extends('layouts.staff-app')

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 inventory-container m-2 p-3">
            <h3 class=" fw-bold mb-4">View Maintenance Task List</h3>
            <div class="table-responsive">
                <table id="view-maintenance" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task Description</th>
                            <th>Designation</th>
                            <th>Due Date</th>
                            <th>Assigned Staff</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffTasks as $staffTask)
                            <tr>
                                <td>{{ $staffTask->id }}</td>
                                <td>{{ $staffTask->name }}</td>
                                <td>{{ $staffTask->location }}</td>
                                <td>{{ \Carbon\Carbon::parse($staffTask->date)->format('M j, Y') }}</td>
                                @php
                                    $staffList = json_decode($staffTask->staff_list, true);
                                @endphp

                                @if (!empty($staffList))
                                    <td>
                                        @foreach ($staffList as $staff)
                                            {{ $staff[1] }} <br>
                                        @endforeach
                                    </td>
                                @else
                                    <td>No Staff Assigned</td>
                                @endif

                                <td class="status">
                                    <span class="badge @if ($staffTask->status === 'Unfinished') decline
                                      @elseif ($staffTask->status === 'Not Done') pending
                                                @else approved @endif">{{ $staffTask->status }}</span>
                                </td>
                                <td>
                                    @if ($staffTask->status === 'Not Done')
                                        <button type="button" class="btn btn-success taskDoneBtn"
                                        data-id = "{{ $staffTask->id }}"><i class="fa-regular fa-circle-check"
                                                style="color: #fff;"></i>
                                    @endif
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
