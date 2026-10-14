<nav class="navbar" style="background: white !important;">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav" style="justify-content: right;">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-50 ht-50 rounded-circle" src="{{ Session::get('foto_profile') }}" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="{{ Session::get('foto_profile') }}" alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ Session::get('fullname') }}</p>
                            <p class="tx-12 text-muted">{{ Session::get('nip') }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2" onclick="showProfile()">
                            <a href="javascript:;;" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2"  onclick="showGantiPassword()">
                            <a href="javascript:;;" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="key"></i>
                                <span>Ganti Password</span>
                            </a>
                        </li>
                        <a href="/auth/logout">
                            <li class="dropdown-item py-2">
                                <div class="text-body ms-0">
                                    <i class="me-2 icon-md" data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </div>
                            </li>
                        </a>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                {{ Session::get('fullname') }}
                <br>
                {{ Session::get('nip') }} : {{ Session::get('role_name') }}
            </li>
            <li class="nav-item" style="margin-left: 20px;margin-right: 20px;">
                <a href="/auth/logout" onclick="return confirm('Are you sure?')" class="text-body ms-0">
                    <i data-feather="log-out"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>