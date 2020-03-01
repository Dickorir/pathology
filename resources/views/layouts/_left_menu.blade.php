

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
{{--                    <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/>--}}
                    PATHOLOGY
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Auth::user()->name ?? 'Not logged in' }}</span>
                        <span class="text-muted text-xs block">{{ Auth::user()->name ?? 'Not logged in' }} <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
{{--                        <li><a class="dropdown-item" href="profile.html">Profile</a></li>--}}
                        <li>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <li {!! (Request::is('pathology') || Request::is('pathology/add') ? 'class="active"' : '') !!}>
                <a href="#"><i class="fa fa-address-card"></i> <span class="nav-label">Pathology </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li {!! (Request::is('pathology')  ? 'class="active"' : '') !!}><a class="nav-link" href="{{ url('/pathology') }}">View Pathology</a></li>
                    <li {!! (Request::is('pathology/add')  ? 'class="active"' : '') !!}><a class="nav-link" href="{{ url('/pathology/add')  }}">Add Pathology</a></li>
                </ul>
            </li>

            <li {!! (Request::is('patients')  ? 'class="active"' : '') !!}>
                <a href="#"><i class="fa fa-address-card"></i> <span class="nav-label">Patients </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="active"><a class="nav-link" href="{{ url('/patients') }}">View Patients</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Admin </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
                    <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Role</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
