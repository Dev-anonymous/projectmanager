<header class="app-header">
    <div class="main-header-container container-fluid">
        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                            class="desktop-logo">
                        <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                            class="toggle-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                            class="desktop-dark">
                        <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                            class="toggle-dark">
                        <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo"
                            class="desktop-white">
                        <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo"
                            class="toggle-white">
                    </a>
                </div>
            </div>
            <div class="header-element">
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            </div>
        </div>
        <div class="header-content-right">
            <div class="header-element header-theme-mode">
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <i class="bx bx-moon header-link-icon"></i>
                    </span>
                    <span class="dark-layout">
                        <i class="bx bx-sun header-link-icon"></i>
                    </span>
                </a>
            </div>
            <div class="header-element header-fullscreen">
                <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon d-none"></i>
                </a>
            </div>
            @php
                $user = auth()->user();
                $img = $user->image;
                if ($img) {
                    $img = asset('storage/' . $img);
                } else {
                    $img = asset('/assets/images/faces/9.jpg');
                }
                $href = '';
                if ($user->user_role == 'admin') {
                    $href = route('admin.profile');
                }
                if ($user->user_role == 'agent') {
                    $href = route('agent.profile');
                }
                if ($user->user_role == 'driver') {
                    $href = route('driver.profile');
                }
            @endphp
            <div class="header-element">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="{{ $img }}" alt="img" width="32" height="32"
                                class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{ auth()->user()->name }}</p>
                            <span class="op-7 fw-normal d-block fs-11">{{ ucfirst(auth()->user()->user_role) }}</span>
                        </div>
                    </div>
                </a>
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li>
                        <a class="dropdown-item d-flex" href="{{ $href }}">
                            <i class="ti ti-user-circle fs-18 me-2 op-7"></i>Profil</a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex" href="#" logout>
                            <i class="ti ti-logout fs-18 me-2 op-7"></i>Déconnexion</a>
                    </li>
                </ul>
            </div>
            <div class="header-element">
                <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas"
                    data-bs-target="#switcher-canvas">
                    <i class="bx bx-cog header-link-icon"></i>
                </a>
            </div>
        </div>
    </div>
</header>
