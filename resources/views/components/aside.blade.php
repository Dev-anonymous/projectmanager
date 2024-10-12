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
                    <li class="slide has-sub @if (Route::is('admin.home') or Route::is('admin.transactions') or Route::is('admin.export')) active open @endif">
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
                                <a href="{{ route('admin.transactions') }}"
                                    class="side-menu__item @if (Route::is('admin.transactions')) active @endif">Transactions</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.export') }}"
                                    class="side-menu__item @if (Route::is('admin.export')) active @endif">Envoi
                                    fonds</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Users</span></li>
                    <li class="slide has-sub @if (Route::is('admin.admins') or Route::is('admin.agents') or Route::is('admin.users')) active open @endif">
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
                                <a href="{{ route('admin.agents') }}"
                                    class="side-menu__item @if (Route::is('admin.agents')) active @endif">Agents</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.users') }}"
                                    class="side-menu__item @if (Route::is('admin.users')) active @endif">Clients</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Settings</span></li>
                    <li class="slide has-sub @if (Route::is('admin.settings') or Route::is('admin.profile') or Route::is('admin.category')) active open @endif">
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
                                <a href="{{ route('admin.settings') }}"
                                    class="side-menu__item @if (Route::is('admin.settings')) active @endif">Paramètres</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.category') }}"
                                    class="side-menu__item @if (Route::is('admin.category')) active @endif">Categories</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.profile') }}"
                                    class="side-menu__item @if (Route::is('admin.profile')) active @endif">Profil</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ('user' == $role)
                    <li class="slide has-sub @if (Route::is('user.home') or Route::is('user.transactions')) active open @endif">
                        <a href="javascript:void(0);"
                            class="side-menu__item @if (Route::is('user.home')) active @endif">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">Dashboards </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Dashboards</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('user.home') }}"
                                    class="side-menu__item @if (Route::is('user.home')) active @endif">Dashboard</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('user.transactions') }}"
                                    class="side-menu__item @if (Route::is('user.transactions')) active @endif">Transactions</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Settings</span></li>
                    <li class="slide has-sub @if (Route::is('user.settings') or Route::is('user.profile')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-cog side-menu__icon"></i>
                            <span class="side-menu__label">Paramètres</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('user.profile') }}"
                                    class="side-menu__item @if (Route::is('user.profile')) active @endif">Profil</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ('agent' == $role)
                    <li class="slide has-sub @if (Route::is('agent.home') or Route::is('agent.transactions') or Route::is('agent.transactions-new')) active open @endif">
                        <a href="javascript:void(0);"
                            class="side-menu__item @if (Route::is('agent.home')) active @endif">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">Dashboards </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Dashboards</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('agent.home') }}"
                                    class="side-menu__item @if (Route::is('agent.home')) active @endif">Dashboard</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('agent.transactions') }}"
                                    class="side-menu__item @if (Route::is('agent.transactions')) active @endif">Transactions</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('agent.transactions-new') }}"
                                    class="side-menu__item @if (Route::is('agent.transactions-new')) active @endif">Nouvelle
                                    Transaction</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Users</span></li>
                    <li class="slide has-sub @if (Route::is('admin.users')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-user-detail side-menu__icon"></i>
                            <span class="side-menu__label">Clients </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Clients</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('agent.users') }}"
                                    class="side-menu__item @if (Route::is('agent.users')) active @endif">Clients</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide__category"><span class="category-name">Settings</span></li>
                    <li class="slide has-sub @if (Route::is('agent.profile')) active open @endif">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-cog side-menu__icon"></i>
                            <span class="side-menu__label">Paramètres</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('agent.profile') }}"
                                    class="side-menu__item @if (Route::is('agent.profile')) active @endif">Profil</a>
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
