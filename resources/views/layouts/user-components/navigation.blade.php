<nav class="navbar navbar-expand-sm navbar-light border-bottom py-3 navbar-fixed" style="background: #C80815;">
    <div class="container-fluid ">

        <i class="fa-xl fa-solid fa-bars" id="sidebarToggle" style="color: #ffff; cursor: pointer;"></i>

        <ul class="navbar-nav ms-auto mt-2 mt-lg-0 flex-row flex-sm-row">
            <li class="nav-item mx-2 dropdown">
                <a class="nav-link position-relative dropdown-toggle animate-dropdown"
                    href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-lg fa-regular fa-bell icon fa-xl" style="color: #ffff;"></i>
                    @php
                        $length = 0;
                        $length = $userNotifications->filter(function ($notification) {
                            return $notification->readed == 0;
                        })->count();;
                    @endphp
                    @if ($length > 0)
                        <span class="position-absolute top-5 start-90 translate-middle badge rounded-pill bg-info">
                            {{ $length }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end animate-dropdown-menu bg-white notify-drop"
                    aria-labelledby="navbarDropdownMenuLink">
                    <div class="notify-drop-title">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">Notification</div>
                            <div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead"
                                    data-tooltip="tooltip" data-placement="bottom"><i
                                        class="fa fa-dot-circle-o"></i></a></div>
                        </div>
                    </div>
                    <div class="drop-content bg-light" style="cursor: pointer;">

                        @foreach ($userNotifications->sortByDesc('created_at') as $userNotification)
                            @if ($userNotification->readed == 0)
                            <li class="d-flex px-3">
                                <a class="removeUserNotifBtn text-decoration-none" data-id="{{ $userNotification->id }}">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <p class="text-muted" >{{ $userNotification->description }}</p>
                                    </div>
                                </a>
                            </li>
                            @endif
                        @endforeach

                    </div>
                    <div class="notify-drop-footer text-center">
                        <a href="{{ route('userNotification') }}">See all notifications</a>
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
                    <a class="dropdown-item" href="{{ route('userProfile') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('user.settingsView') }}">Settings</a>
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

