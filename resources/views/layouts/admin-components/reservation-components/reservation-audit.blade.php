@extends('layouts.admin-app')

@section('content')
<div class="container-fluid content-wrapper">
    <div class="row mt-4 m-1">
        <h3 class=" fw-bold mb-4">Reservation Audit Log</h3>
        <div class="table-responsive">
            <table id="view-reservation" class="table table-striped table-hover nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Action taken by</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($auditLogs as $auditLog)
                        <tr>
                            <td>{{ $auditLog->created_at }}</td>
                            <td>{{ $auditLog->user->email }}</td>
                            <td>{{ $auditLog->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
