<div class="container-fluid" style="background-color: #e3f2fd;">
    <div class="row">
        <div class="col">
            <nav class="navbar navbar-expand-lg navbar-light" >
                <div class="container">
                    <a class="navbar-brand" href="/">SSM</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="/login">login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/register">Register</a>
                                </li>
                            @else
                                @php
                                    $role = auth()->user()->role->title;
                                @endphp

                                @if ($role == 'student')
                                    <li class="nav-item">
                                        <a class="nav-link" href="/student">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/student/reminders">My Appointments</a>
                                    </li>

                                @endif

                                @if ($role == 'advisor')
                                    <li class="nav-item">
                                        <a class="nav-link" href="/advisor">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/advisor/reminder">Appointments</a>
                                    </li>
                                @endif

                                @if ($role == 'admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/appointments">Appointments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/advisors">Advisors</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/advisor">Create Advisor</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/students">Students</a>
                                    </li>

                                @endif
                                <div class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link btn btn-navbar dropdown-toggle " href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a href="/dashboard" class="dropdown-item">Dashboard</a>
                                        <a href="/profile" class="dropdown-item">Profile</a>
                                        <a href="/change-password" class="dropdown-item">Change Password</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </ul>

                    </div>
                </div>
            </nav>

        </div>
    </div>
</div>
