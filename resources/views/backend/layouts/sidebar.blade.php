<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Magic Pay</li>
                <li>
                    <a href="{{ route('admin.home') }}" class="@yield('home active')">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Admin Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.admin-user.index') }}" class="@yield('home adminuser active')">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Admin Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.user.index') }}" class="@yield('home user active')">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Users
                    </a>
                </li>
            </ul>
        </div>
    </div>
