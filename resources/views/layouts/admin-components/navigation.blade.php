<style>
    .dropdown-toggle::after {
        display: none;
    }

    .animate-dropdown {
        transition: transform 0.3s;
    }

    .animate-dropdown:hover {
        transform: translateY(-2px);
    }

    .animate-dropdown-menu {
        animation-duration: 0.3s;
        animation-name: slideIn;
        animation-fill-mode: forwards;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .icon {
        animation: notification 2s infinite;
    }

    @keyframes notification {

        5% {
            transform: rotate(10deg);
        }

        10% {
            transform: rotate(-10deg);
        }

        15% {
            transform: rotate(10deg);
        }

        20% {
            transform: rotate(0deg);
        }


    }

    .notify-drop {
        min-width: 330px;
        background-color: #fff;
        min-height: 360px;
        max-height: 360px;
    }

    .notify-drop-title {
        border-bottom: 1px solid #e2e2e2;
        padding: 5px 15px 10px 15px;
    }

    .drop-content {
        min-height: 280px;
        max-height: 280px;
        overflow-y: scroll;
    }

    .drop-content::-webkit-scrollbar-track {
        background-color: #F5F5F5;
    }

    .drop-content::-webkit-scrollbar {
        width: 8px;
        background-color: #F5F5F5;
    }

    .drop-content::-webkit-scrollbar-thumb {
        background-color: #ccc;
    }

    .drop-content>li {
        border-bottom: 1px solid #e2e2e2;
        padding: 10px 0px 5px 0px;
    }


    .notify-drop-footer {
        border-top: 1px solid #e2e2e2;
        padding: 0.3rem 0;
    }

    .notify-drop-footer a {
        color: #777;
        text-decoration: none;
    }

    .notify-drop-footer a:hover {
        color: #333;
    }
</style>
<nav class="navbar navbar-expand-sm navbar-light border-bottom py-3 navbar-fixed" style="background: #C80815;">

    <div class="container-fluid">

        <i class="fa-xl fa-solid fa-bars mx-2" id="sidebarToggle" style="color: #ffff; cursor: pointer;"></i>

        <ul class="navbar-nav ms-auto mt-2 mt-lg-0 flex-row flex-sm-row">
            <li class="nav-item mx-2 dropdown">
                <a class="nav-link position-relative dropdown-toggle animate-dropdown"
                    href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-lg fa-regular fa-bell icon fa-xl" style="color: #ffff;"></i>
                    @php
                        $length = 0;
                        $length = $length = $userNotifications->filter(function ($notification) {
                            return $notification->readed == 0;
                        })->count();;
                    @endphp
                    @if ($length > 0)
                        <span id="notificationCount"
                            class="position-absolute top-5 start-90 translate-middle badge rounded-pill bg-info">
                            {{ $length }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end animate-dropdown-menu bg-white notify-drop"
                    aria-labelledby="navbarDropdownMenuLink">
                    <div class="notify-drop-title">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">Notification</div>
                        </div>
                    </div>
                    <div class="drop-content bg-light">

                        @foreach ($userNotifications->sortByDesc('created_at') as $userNotification)
                            @if ($userNotification->readed == 0)
                                <!-- Only display unread notifications -->
                                <li class="d-flex px-3">
                                    <a class="removeAdminNotifBtn text-decoration-none" data-id="{{ $userNotification->id }}">
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <p class="text-muted">{{ $userNotification->description }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    </div>
                    <div id="clearAllNotif" class="notify-drop-footer text-center">
                        <a href="{{ route('admin.notificationView') }}">See all notifications</a>
                    </div>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle animate-dropdown" style="color: #ffff;"
                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    v-pre>
                    <i class="fa-regular fa-circle-user fa-xl"></i><span class="mx-2">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end animate-dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('admin.profileView') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('admin.settingsView') }}">Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>


    </div>
</nav>
