<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="{{ route('login') }}" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <li class="slide__category"><span class="category-name">Main</span></li>
                @php
                    $role = auth()->user()->user_role;

                @endphp
                @if ('admin' == $role)
                    <li class="slide has-sub @if (Route::is('admin.home') or Route::is('admin.projects')) active open @endif">
                        <a href="javascript:void(0);"
                            class="side-menu__item @if (Route::is('admin.home')) active @endif">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">Dashboards </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Dashboards</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.home') }}"
                                    class="side-menu__item @if (Route::is('admin.home')) active @endif">Dashboard</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.projects') }}"
                                    class="side-menu__item @if (Route::is('admin.projects')) active @endif">Projets</a>
                            </li>

                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Product</span></li>
                    <li class="slide has-sub @if (Route::is('admin.products') or Route::is('admin.category')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-food-menu side-menu__icon"></i>
                            <span class="side-menu__label">Article </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Article</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.products') }}"
                                    class="side-menu__item @if (Route::is('admin.products')) active @endif">Articles</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.category') }}"
                                    class="side-menu__item @if (Route::is('admin.category')) active @endif">Catégories</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Order</span></li>
                    <li class="slide has-sub @if (Route::is('admin.order')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-food-menu side-menu__icon"></i>
                            <span class="side-menu__label">Commande </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Commande</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.order') }}"
                                    class="side-menu__item @if (Route::is('admin.order')) active @endif">Commandes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Users</span></li>
                    <li class="slide has-sub @if (Route::is('admin.admins') or Route::is('admin.students') or Route::is('admin.users')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-user-detail side-menu__icon"></i>
                            <span class="side-menu__label">Utilisateurs </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Utilisateurs</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.admins') }}"
                                    class="side-menu__item @if (Route::is('admin.admins')) active @endif">Administrateurs</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.students') }}"
                                    class="side-menu__item @if (Route::is('admin.students')) active @endif">Etudiants</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.users') }}"
                                    class="side-menu__item @if (Route::is('admin.users')) active @endif">Utilisateurs</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Settings</span></li>
                    <li class="slide has-sub @if (Route::is('admin.settings') or
                            Route::is('admin.profile') or
                            Route::is('admin.category') or
                            Route::is('admin.degree')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-cog side-menu__icon"></i>
                            <span class="side-menu__label">Paramètres</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Paramètres</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.degree') }}"
                                    class="side-menu__item @if (Route::is('admin.degree')) active @endif">Facultés</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.profile') }}"
                                    class="side-menu__item @if (Route::is('admin.profile')) active @endif">Profil</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if ('student' == $role or 'user' == $role)
                    @if ('student' == $role)
                        <li class="slide has-sub @if (Route::is('user.projects')) active open @endif">
                            <a href="javascript:void(0);"
                                class="side-menu__item @if (Route::is('user.projects')) active @endif">
                                <i class="bx bx-home side-menu__icon"></i>
                                <span class="side-menu__label">Dashboards </span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide">
                                    <a href="{{ route('user.projects') }}"
                                        class="side-menu__item @if (Route::is('user.projects')) active @endif">Projets</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="slide__category"><span class="category-name">Order</span></li>
                    <li class="slide has-sub @if (Route::is('user.order')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-food-menu side-menu__icon"></i>
                            <span class="side-menu__label">Commande </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Commande</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('user.order') }}"
                                    class="side-menu__item @if (Route::is('user.order')) active @endif">Commandes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Settings</span></li>
                    <li class="slide has-sub @if (Route::is('admin.settings') or Route::is('user.profile')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-cog side-menu__icon"></i>
                            <span class="side-menu__label">Paramètres</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Paramètres</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('user.profile') }}"
                                    class="side-menu__item @if (Route::is('user.profile')) active @endif">Profil</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
    </div>
</aside>
