@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">

        <div class="row mt-4 m-2">
            <h4 class="fw-bold pb-3">Notification History</h4>
            <div class="notification-list">
                @foreach ($userNotifications->sortByDesc('created_at') as $userNotification)
                    <div class="notification-item">
                        <div class="notification-item__content text-decoration-none">
                            {{ $userNotification->description }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
