<div class="container-fluid">
    <div class="row">
        <div class="col">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto ml-auto">

                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login">login</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                      </li>

                      <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" href="/reminder">Reminder </a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" href="/appointments">Appointments </a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" href="/admin/counselors">admin counselors </a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" href="/admin/counselor">Create counselor</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" href="/advisor/reminder">advisor reminder</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" href="/advisor">advisor</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/student">student</a>
                      </li>

                      @else
                      <div class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link btn btn-navbar text-white dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="/home" class="dropdown-item">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @endguest
                  </ul>

                </div>
              </nav>

        </div>
    </div>
</div>
