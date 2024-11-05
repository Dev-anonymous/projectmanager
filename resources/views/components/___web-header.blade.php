<header class="app-header">
    <div class="main-header-container container-fluid">
        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="{{ route('home') }}" class="header-logo">
                        <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                        <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                        <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                        <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                        <img src="../assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                        <img src="../assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
                    </a>
                </div>
            </div>
        </div>
        <div class="header-content-right">
            @auth
                <div class="header-element cart-dropdown">
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside"
                        data-bs-toggle="dropdown">
                        <i class="bx bx-cart header-link-icon"></i>
                        <span class="badge bg-primary rounded-pill header-icon-badge" id="cart-icon-badge" npanier></span>
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
                                <button
                                        class="modal-effect btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                        data-bs-effect="effect-flip-vertical" data-bs-toggle="modal"
                                        href="#mpay">Payer
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
            @endauth

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
                                <img src="../assets/images/faces/9.jpg" alt="img" width="32" height="32"
                                    class="rounded-circle">
                            </div>
                            <div class="d-sm-block d-none">
                                <p class="fw-semibold mb-0 lh-1">{{ auth()->user()->name }}</p>
                                <span class="op-7 fw-normal d-block fs-11">{{ auth()->user()->phone }}</span>
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
                            <a class="dropdown-item d-flex" href="#">
                                <i class="ti ti-user-circle fs-18 me-2 op-7"></i>Profil</a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex" href="#" logout>
                                <i class="ti ti-logout fs-18 me-2 op-7"></i>Déconnexion</a>
                        </li>
                    </ul>
                @endauth
            </div>

        </div>

    </div>

</header>
