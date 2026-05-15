<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <!-- TOGGLE DARK MODE -->
            @if (Request::is('dashboard*'))
            <!-- TOGGLE DARK MODE -->
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="themeDropdown" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="sun"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
                    <a class="dropdown-item theme-toggle" href="#" data-theme="light">
                        <i class="align-middle me-2" data-feather="sun"></i> Light Mode
                    </a>

                    <a class="dropdown-item theme-toggle" href="#" data-theme="dark">
                        <i class="align-middle me-2" data-feather="moon"></i> Dark Mode
                    </a>

                    <a class="dropdown-item theme-toggle" href="#" data-theme="auto">
                        <i class="align-middle me-2" data-feather="monitor"></i> Auto (System)
                    </a>
                </div>
            </li>
            @endif

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="message-square"></i>
                    </div>
                </a>
                <div class="py-0 dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="messagesDropdown">
                    <div class="dropdown-menu-header">
                        <div class="position-relative">
                            4 New Messages
                        </div>
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle"
                                        alt="Vanessa Tucker">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">Vanessa Tucker</div>
                                    <div class="mt-1 text-muted small">Nam pretium turpis et arcu. Duis arcu tortor.
                                    </div>
                                    <div class="mt-1 text-muted small">15m ago</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle"
                                        alt="William Harris">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">William Harris</div>
                                    <div class="mt-1 text-muted small">Curabitur ligula sapien euismod vitae.</div>
                                    <div class="mt-1 text-muted small">2h ago</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle"
                                        alt="Christina Mason">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">Christina Mason</div>
                                    <div class="mt-1 text-muted small">Pellentesque auctor neque nec urna.</div>
                                    <div class="mt-1 text-muted small">4h ago</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle"
                                        alt="Sharon Lessman">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">Sharon Lessman</div>
                                    <div class="mt-1 text-muted small">Aenean tellus metus, bibendum sed, posuere ac,
                                        mattis non.</div>
                                    <div class="mt-1 text-muted small">5h ago</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all messages</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <span class="text-dark">
                        {{ auth()->user()->nama_lengkap ?? 'Guest' }}
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">

                    <a class="dropdown-item" href="#">
                        <i class="align-middle me-1" data-feather="user"></i>
                        Profile
                    </a>

                    <div class="dropdown-divider"></div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="align-middle me-1" data-feather="log-out"></i>
                        Logout
                    </a>

                </div>
            </li>
        </ul>
    </div>
</nav>
