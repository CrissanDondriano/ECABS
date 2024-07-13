@extends('layouts.user-app')

@section('content')
    <style>
        .text-muted {
            color: #aeb0b4 !important;
        }

        .text-muted {
            font-weight: 300;
        }

        th {
            background: #ffffff;
        }

        .hidden {
            display: none;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 mx-auto p-4">
                <h2 class="h3 fw-bold">Settings</h2>
                <div class="my-3">

                    <h5 class="mb-0 mt-5 fw-bold">Security Settings</h5>
                    <p>These settings are helps you keep your account secure.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-2">Enable Activity Logs</strong>
                                    <p class="text-muted mb-0">Enabling activity logs allows you to monitor and review the
                                        actions taken on your account, enhancing your account's security.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="activityLog" checked="">
                                        <span class="custom-control-label"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-2">Clear Notifications</strong>
                                    <p class="text-muted mb-0">The "Clear All Notifications" button is a convenient and
                                        time-saving feature that allows the user to efficiently manage and declutter their
                                        notification feed.</p>
                                </div>
                                <div class="col-auto">
                                    <button id="clearAllNotif" class="btn btn-danger btn-sm">Clear All Notifications</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-2">Clear Activity Logs</strong>
                                    <p class="text-muted mb-0">The "Clear Logs" button is a user interface element designed to facilitate the removal or deletion of log entries within a system or application.</p>
                                </div>
                                <div class="col-auto">
                                    <button id="clearActLog" class="btn btn-danger btn-sm">Clear Logs</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-0 fw-bold">Recent Activity</h5>
                    <p>Last activities with your account.</p>
                    <table class="table border bg-white" id="recentActivityTable">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>IP</th>
                                <th>Time</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentActivities->sortByDesc('created_at')->take(10) as $recentActivity)
                                <tr>
                                    <th scope="col"><i
                                            class="fe fe-globe fe-12 text-muted mr-2"></i>{{ $recentActivity->device }}</th>
                                    <td>{{ $recentActivity->ip }}</td>
                                    <td>{{ $recentActivity->created_at }}</td>
                                    <td><a hreff="#" class="text-muted"><i class="fe fe-x"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const activityLogSwitch = $('#activityLog');
            const recentActivityTable = $('#recentActivityTable');

            activityLogSwitch.on('change', function() {
                if (activityLogSwitch.prop('checked')) {
                    recentActivityTable.removeClass('hidden');
                } else {
                    recentActivityTable.addClass('hidden');
                }
            });

            $("#clearAllNotif").click(function() {
                $.ajax({
                    url: "/user/delete_notification",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(response) {
                        // Handle the error response
                        swal({
                            title: 'Success',
                            text: 'All Notifications has been Cleared!!',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/user/settingsView';
                        });
                    },
                    error: function(xhr) {
                        // Handle the error response
                        swal({
                            title: 'Error',
                            text: 'Error Clearing Notifications: ' + xhr.responseText,
                            icon: 'error'
                        });
                    }
                });
            });

            $("#clearActLog").click(function() {
                $.ajax({
                    url: "/user/delete_activity_log",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(response) {
                        // Handle the error response
                        swal({
                            title: 'Success',
                            text: 'All Activity Log has been Cleared!!',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/user/settingsView';
                        });
                    },
                    error: function(xhr) {
                        // Handle the error response
                        swal({
                            title: 'Error',
                            text: 'Error Clearing Activity Logs: ' + xhr.responseText,
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
@endsection
