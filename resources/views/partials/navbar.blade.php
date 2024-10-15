<nav class="navbar shadow-sm navbar-expand sticky-top" id="navbar">
    <div class="logo_details">
        @if(!Request::is('profile'))
            <i class="bi bi-list" id="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Toggle Menu')"></i>
        @endif
        <div class="logo_name">
            <a href="{{ route('tasks.index', ['previous_url' => url()->current()]) }}" class="text-decoration-none">Dotlist</a>
        </div>
    </div>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            @if(!Request::is('profile'))
            <li class="nav-item">
                <form class="d-flex search-form" action="{{ route('tasks.search') }}" method="GET">
                    <div class="input-group" style="margin-top: 3px; margin-right: 3px;">
                        <input class="form-control border-dark-subtle rounded-start search-input d-none d-md-block" type="search" name="query" placeholder="@lang('navbar.Search tasks')" aria-label="Search" required>
                        <button class="btn border-dark-subtle rounded-end d-none d-md-inline-block search-button" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Search')">
                            <i class="bi bi-search"></i>
                        </button>
                        <div class="d-flex justify-content-end w-100 d-md-none">
                            <button type="button" class="btn border-dark-subtle rounded search-button" onclick="toggleSearchInput()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Search')">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>            
            
            @endif
            @if(Request::is('profile'))
            <li class="nav-item">
                <a class="nav-link rounded py-1" href="{{ route('tasks.index', ['previous_url' => url()->current()]) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Home')">
                    <i class="bi bi-house"></i>
                </a>
            </li>
            @endif
            @if(!Request::is('profile'))
            <li class="nav-item">
                <a class="nav-link rounded py-1" href="{{ route('tasks.create', ['previous_url' => url()->current()]) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Add Task')">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </li>
            @endif
            @guest
            @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle rounded py-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Settings')">
                    <i class="bi bi-gear"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li class="mb-1">
                        <div class="form-check form-switch mx-3">
                            <label class="form-check-label" for="themeSwitch">
                                <i id="themeIcon" class="bi bi-moon"></i>
                            </label>
                            <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch" checked>
                        </div>
                    </li>
                    @if(!Request::is('profile'))
                    <li class="mb-1">
                        <form action="{{ route('profile') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('navbar.Profile')"><i class="bi bi-person"></i> @lang('navbar.Profile')</button>
                        </form>
                    </li>
                    @endif
                    <li>
                        <a class="dropdown-item" href="#" title="@lang('navbar.Language')"><i class="bi bi-translate"></i> @lang('navbar.Language') &raquo; </a>
                        <ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
                            <li>
                                <a class="dropdown-item" href="{{ route('lang', 'en') }}"><i class="flag-icon flag-icon-us"></i> English</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('lang', 'id') }}"><i class="flag-icon flag-icon-id"></i> Bahasa Indonesia</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('lang', 'es') }}"><i class="flag-icon flag-icon-es"></i> Español</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('lang', 'fr') }}"><i class="flag-icon flag-icon-fr"></i> Français</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('lang', 'de') }}"><i class="flag-icon flag-icon-de"></i> Deutsch</a>
                            </li>
                        </ul>
                      </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('navbar.Log Out')"><i class="bi bi-box-arrow-right"></i> @lang('navbar.Log Out')</button>
                        </form>
                    </li>
                </ul>
            </li>
            @endguest
        </ul>
    </div>

    <div id="searchOverlay" class="search-overlay d-none">
        <form class="d-flex align-items-center search-form" action="{{ route('tasks.search') }}" method="GET">
            <div class="input-group">
                <input class="form-control border-dark-subtle rounded-start" type="search" name="query" placeholder="@lang('navbar.Search tasks')" aria-label="Search" required autofocus>
                <button class="btn btn-secondary border-dark-subtle rounded-end" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('navbar.Search')">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <button type="button" class="btn btn-close ms-2" onclick="toggleSearchInput()" aria-label="Close"></button>
        </form>
    </div>
    
</nav>