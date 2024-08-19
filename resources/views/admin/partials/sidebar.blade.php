<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small">{{ Auth::user()->type }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        @if (Auth::user()->isAbleTo('view dashboard'))
            <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <span class="menu-title">{{ __('Dashboard') }}</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
        @endif

        @if (Auth::user()->isAbleTo('create company'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('show.all.company') }}">
                    <span class="menu-title">{{ __('Company') }}</span>
                    <i class="menu-icon fa fa-user-circle-o"></i>
                </a>
            </li>
        @endif

        @if (Auth::user()->isAbleTo('manage role'))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <span class="menu-title">{{ __('Role & Permissions') }}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('get.roles') }}">{{ __('Roles') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if (Auth::user()->isAbleTo('manage user'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('show.all.users') }}">
                    <span class="menu-title">{{ __('Users') }}</span>
                    <i class="menu-icon fa fa-user-circle-o"></i>
                </a>
            </li>
        @endif

    </ul>
</nav>
