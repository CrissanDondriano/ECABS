@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
            <h3 class=" fw-bold mb-4">View Maintenance Task List</h3>
            <div class="table-responsive">
                <table id="view-maintenance" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Schedule ID</th>
                            <th>Task Name</th>
                            <th>Location</th>
                            <th>Schedule Date</th>
                            <th>Assigned Staff</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addScheduleTask as $scheduleTask)
                            <tr>
                                <td>{{ $scheduleTask->id }}</td>
                                <td>{{ $scheduleTask->name }}</td>
                                <td>{{ $scheduleTask->location }}</td>
                                <td>{{ $scheduleTask->date }}</td>
                                @php
                                    $staffList = json_decode($scheduleTask->staff_list, true);
                                    $length = 0;

                                    if ($staffList) {
                                        $length = count($staffList);
                                    }
                                @endphp

                                @if ($length > 0)
                                    <td>{{ $length }}</td>
                                @else
                                    <td>No Staff Assigned</td>
                                @endif
                                <td><span
                                        class="badge rounded-pill d-inline-block
                                @if ($scheduleTask->status === 'In Progress') bg-warning
                                @else
                                    bg-success @endif">
                                        {{ $scheduleTask->status }}
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#view-maintenance').dataTable({
                responsive: true,
                fixedheader: true
            });

        });
    </script>
@endsection
