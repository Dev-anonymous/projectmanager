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
                @if (!Route::is('home'))
                    <a aria-label="Hide Sidebar"
                        class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                        data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                @endif
            </div>
        </div>
        <div class="header-content-right">
            @auth
                @php
                    $user = auth()->user();
                    $img = userimage($user);
                    $href = '';
                    $dah = '';
                    if ($user->user_role == 'admin') {
                        $href = route('admin.profile');
                        $dah = route('admin.home');
                    }
                    if ($user->user_role == 'student') {
                        $href = route('user.profile');
                        $dah = route('user.projects');
                    }
                    if ($user->user_role == 'user') {
                        $href = route('user.profile');
                        $dah = route('user.order');
                    }
                @endphp
            @endauth
            @if (!Route::is('home'))
                <div class="header-element">
                    <a href="{{ route('home') }}" class="header-link">
                        <i class="bx bxs-shopping-bags header-link-icon"></i>
                    </a>
                </div>
            @endif
            @auth
                @if (in_array($user->user_role, ['user', 'student']) && Route::is('home'))
                    <div class="header-element cart-dropdown">
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-cart header-link-icon"></i>
                            <span class="badge bg-primary rounded-pill header-icon-badge" id="cart-icon-badge"
                                npanier></span>
                        </a>
                        <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                            <div class="p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0 fs-17 fw-semibold">Mon Panier</p>
                                    <span class="badge bg-success-transparent" npanier></span>
                                </div>
                            </div>
                            <div>
                                <hr class="dropdown-divider">
                            </div>
                            <ul class="list-unstyled mb-0" id="header-cart-items-scroll"
                                style="max-height: 300px; overflow: auto;">
                            </ul>
                            <div class="p-3 empty-header-item border-top" dvalide style="display: none">
                                <div class="d-grid">
                                    <button class="modal-effect btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                        data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" href="#mpay">Payer
                                    </button>
                                </div>
                            </div>
                            <div class="p-5 empty-item d-none">
                                <div class="text-center">
                                    <span class="avatar avatar-xl avatar-rounded bg-warning-transparent">
                                        <i class="ri-shopping-cart-2-line fs-2"></i>
                                    </span>
                                    <h6 class="fw-bold mb-1 mt-3">Votre panier est vide</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
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

            <div class="header-element">
                @guest
                    <div class="d-flex align-items-center">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary-light" type="button">
                            Connexion
                        </a>
                    </div>
                @endguest
                @auth
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
                            <a class="dropdown-item d-flex" href="{{ $dah }}">
                                <i class="ti ti-home fs-18 me-2 op-7"></i>Dashbord</a>
                        </li>
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
            @endauth

            @if (!Route::is('home'))
                <div class="header-element">
                    <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas"
                        data-bs-target="#switcher-canvas">
                        <i class="bx bx-cog header-link-icon"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>
