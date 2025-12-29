<nav id="sidebarMenu" class="sidebar d-md-block bg-gray-800 text-white collapse" data-simplebar tabindex="1"
    role="navigation">
    <div class="sidebar-inner px-2 pt-3">
        <div
            class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{ auth()->user()->profile_url }}" class="card-img-top rounded-circle border-white"
                        alt="Bonnie Green">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">Hi,
                        {{ auth()->user()->first_name ? ucfirst(auth()->user()->first_name) : 'User Name' }}</h2>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                            <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
        @php
            $segment1 = Request::segment(1);
            $segment2 = Request::segment(2);
            $segment3 = Request::segment(3);
        @endphp
        <ul class="nav flex-column pt-3 pt-md-0">
            <li
                class="nav-item {{ $segment2 == 'dashboard' || $segment1 == 'dashboard' || $segment2 == 'profile' || $segment2 == 'change-password' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg></span></span>
                    <span
                        class="sidebar-text {{ $segment2 === 'dashboard' || $segment1 == 'dashboard' || $segment2 === 'profile' || $segment2 === 'change-password' ? 'nav-active' : '' }}">Dashboard</span>
                </a>
            </li>
            @can('user-view')
                <li class="nav-item {{ $segment2 == 'users' ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                {{-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg> --}}
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'users' ? 'nav-active' : '' }}">Users</span>
                        </span>
                    </a>
                </li>
            @endcan
            {{-- @can('subadmin-view')
                <li class="nav-item {{ $segment2 == 'sub-admin' ? 'active' : '' }}">
                    <a href="{{ route('admin.subadmin.index') }}" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'sub-admin' ? 'nav-active' : '' }}">Subadmin</span>
                        </span>
                    </a>
                </li>
            @endcan --}}
            @can('role-view')
                <li class="nav-item {{ $segment2 == 'roles' ? 'active' : '' }}">
                    <a href="{{ route('admin.role.index') }}" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'roles' ? 'nav-active' : '' }}">Role
                                Management</span>
                        </span>
                    </a>
                </li>
            @endcan
            {{-- @can('category-view')
                <li class="nav-item">
                    <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#submenu-category"
                        aria-expanded="{{ $segment2 === 'category' ? 'true' : 'false' }}">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v2H5V5zm0 3h10v2H5V8zm0 3h10v2H5v-2z">
                                    </path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'category' ? 'nav-active' : '' }}">Manage
                                Category</span>
                        </span>
                        <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></span>
                    </span>
                    <div class="multi-level collapse {{ $segment2 === 'category' ? 'show' : '' }}" role="list"
                        id="submenu-category" aria-expanded="false">
                        <ul class="flex-column nav">
                            @can('user-view')
                                <li
                                    class="nav-item {{ $segment2 === 'category' && ($segment3 === null || $segment3 === '') ? 'active' : '' }}">
                                    <a href="{{ route('admin.category.index') }}" class="nav-link">
                                        <span class="sidebar-text">Category</span>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                            <a href="/users" class="nav-link">
                                <span class="sidebar-text">SubCategory</span>
                            </a>
                        </li>
                        </ul>
                    </div>
                </li>
            @endcan --}}
            @can('commission-view')
                <li class="nav-item {{ $segment2 == 'commissions' ? 'active' : '' }}">
                    <a href="{{ route('admin.commission.index') }}" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span
                                class="sidebar-text {{ $segment2 == 'commissions' ? 'nav-active' : '' }}">Commision</span>
                        </span>
                    </a>
                </li>
            @endcan
            @can('cms-view')
                <li class="nav-item {{ $segment2 == 'cms' ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.index') }}" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'cms' ? 'nav-active' : '' }}">Cms Pages</span>
                        </span>
                    </a>
                </li>
            @endcan
            @can('plan-view')
                <li class="nav-item {{ $segment2 == 'plans' ? 'active' : '' }}">
                    <a href="{{ route('admin.plan.index') }}" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'plans' ? 'nav-active' : '' }}">Plans</span>
                        </span>
                    </a>
                </li>
            @endcan
            @can('payment-setting-view')
                <li class="nav-item {{ $segment2 == 'payment-settings' ? 'active' : '' }}">
                    <a href="{{ route('admin.payment-settings.index') }}"
                        class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'payment-settings' ? 'nav-active' : '' }}">Payment
                                Settings</span>
                        </span>
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#submenu-settings"
                    aria-expanded="{{ $segment2 === 'settings' && ($segment3 === 'website' || $segment3 === 'favicon' || $segment3 === 'website-name' || $segment3 === 'smtp-details' || $segment3 === 'thumbnail-size') ? 'true' : 'false' }}">
                    <span>
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span
                            class="sidebar-text {{ $segment2 == 'settings' && ($segment3 === 'website' || $segment3 === 'favicon' || $segment3 === 'website-name' || $segment3 === 'smtp-details' || $segment3 === 'thumbnail-size' || $segment3 == 'two-factor-create') ? 'nav-active' : '' }}">Settings</span>
                    </span>
                    <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg></span>
                </span>
                <div class="multi-level collapse {{ $segment2 == 'settings' && ($segment3 === 'website' || $segment3 === 'favicon' || $segment3 === 'website-name' || $segment3 === 'smtp-details' || $segment3 === 'thumbnail-size' || $segment3 == 'two-factor-create') ? 'show' : '' }}"
                    role="list" id="submenu-settings" aria-expanded="false">
                    <ul class="flex-column nav">
                        {{-- <li
                            class="nav-item {{ $segment2 === 'settings' && $segment3 === 'website' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.website.index') }}" class="nav-link">
                                <span class="sidebar-text">Website Settings</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item {{ $segment2 === 'settings' && $segment3 === 'favicon' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.favicon.index') }}" class="nav-link">
                                <span class="sidebar-text">Favicon</span>
                            </a>
                        </li>
                        <li class="nav-item {{ $segment2 === 'settings' && $segment3 === 'website-name' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.website_name.index') }}" class="nav-link">
                                <span class="sidebar-text">Website Name</span>
                            </a>
                        </li> --}}
                        <li
                            class="nav-item {{ $segment2 === 'settings' && $segment3 === 'smtp-details' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.smpt_details.index') }}" class="nav-link">
                                <span class="sidebar-text">SMTP Details</span>
                            </a>
                        </li>
                        {{-- <li
                            class="nav-item {{ $segment2 === 'settings' && $segment3 === 'thumbnail-size' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.thumbnail.index') }}" class="nav-link">
                                <span class="sidebar-text">Image Thumbnails</span>
                            </a>
                        </li> --}}
                        {{-- @if(auth()->user()->id == '1')
                            <li
                                class="nav-item {{ $segment2 === 'settings' && $segment3 === 'two-factor-create' ? 'active' : '' }}">
                                <a href="{{ route('admin.settings.two-factor-create') }}" class="nav-link">
                                    <span class="sidebar-text">Two Factor Enabled</span>
                                </a>
                            </li>
                        @endif --}}
                    </ul>
                </div>
            </li>
            {{-- <li class="nav-item">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#submenu-image-settings" aria-expanded="{{ $segment2 === 'settings' && ($segment3 === 'thumbnail-size' || $segment3 === 'image-conversion' || $segment3 === 'webp-quality') ? 'true' : 'false' }}">
                    <span>
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span class="sidebar-text {{ $segment2 == 'settings' && ($segment3 === 'thumbnail-size' || $segment3 === 'image-conversion' || $segment3 === 'webp-quality') ? 'nav-active' : '' }}">Image Settings</span>
                    </span>
                    <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg></span>
                </span>
                <div class="multi-level collapse {{ $segment2 === 'settings' && ($segment3 === 'thumbnail-size' || $segment3 === 'image-conversion' || $segment3 === 'webp-quality') ? 'show' : '' }}" role="list" id="submenu-image-settings" aria-expanded="false">
                    <ul class="flex-column nav">
                        <li class="nav-item {{ $segment2 === 'settings' && $segment3 === 'thumbnail-size' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.thumbnail.index') }}" class="nav-link">
                                <span class="sidebar-text">Thumbnail Sizes</span>
                            </a>
                        </li>
                        <li class="nav-item {{ $segment2 === 'settings' && $segment3 === 'image-conversion' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.image-conversion.index') }}" class="nav-link">
                                <span class="sidebar-text">Convert To WebP</span>
                            </a>
                        </li>
                        <li class="nav-item {{ $segment2 === 'settings' && $segment3 === 'webp-quality' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.webp-quality.index') }}" class="nav-link">
                                <span class="sidebar-text">WebP Quality</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="nav-item">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#submenu-email-template"
                    aria-expanded="{{ $segment2 === 'email-templates' ? 'true' : 'false' }}">
                    <span>
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v2H5V5zm0 3h10v2H5V8zm0 3h10v2H5v-2z">
                                </path>
                            </svg>
                        </span>
                        <span class="sidebar-text {{ $segment2 == 'email-templates' ? 'nav-active' : '' }}">Email
                            Template</span>
                    </span>
                    <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg></span>
                </span>
                <div class="multi-level collapse {{ $segment2 === 'email-templates' ? 'show' : '' }}" role="list"
                    id="submenu-email-template" aria-expanded="false">
                    <ul class="flex-column nav">
                        <li class="nav-item {{ $segment2 === 'email-templates' ? 'active' : '' }}">
                            <a href="{{ route('admin.email-templates.index') }}" class="nav-link">
                                <span class="sidebar-text">Templates</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @can('transaction-view')
                <li class="nav-item {{ Request::segment(1) == 'transactions' ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <span class="sidebar-icon"><svg class="icon icon-xs me-2" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd"
                                    d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                    clip-rule="evenodd"></path>
                            </svg></span>
                        <span class="sidebar-text">Transactions</span>
                    </a>
                </li>
            @endcan
            @can('user-activity-view')
                <li class="nav-item {{ Request::segment(2) == 'users' ? 'active' : '' }}">
                    <a href="{{ route('admin.users.activity') }}" class="nav-link">
                        <span class="sidebar-icon"><svg class="icon icon-xs me-2" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd"
                                    d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                    clip-rule="evenodd"></path>
                            </svg></span>
                        <span class="sidebar-text">User Activity</span>
                    </a>
                </li>
            @endcan

            {{-- @can('store-view')
                <li class="nav-item">
                    <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#submenu-store"
                        aria-expanded="{{ $segment2 === 'store' ? 'true' : 'false' }}">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v2H5V5zm0 3h10v2H5V8zm0 3h10v2H5v-2z">
                                    </path>
                                </svg>
                            </span>
                            <span class="sidebar-text {{ $segment2 == 'store' ? 'nav-active' : '' }}">Manage
                                Stores</span>
                        </span>
                        <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></span>
                    </span>
                    <div class="multi-level collapse {{ $segment2 === 'store' ? 'show' : '' }}" role="list"
                        id="submenu-store" aria-expanded="false">
                        <ul class="flex-column nav">
                            @can('user-view')
                                <li
                                    class="nav-item {{ $segment2 === 'store' && ($segment3 === null || $segment3 === '') ? 'active' : '' }}">
                                    <a href="{{ route('admin.store.index') }}" class="nav-link">
                                        <span class="sidebar-text">Store</span>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                            <a href="/users" class="nav-link">
                                <span class="sidebar-text">SubCategory</span>
                            </a>
                        </li>
                        </ul>
                    </div>
                </li>
            @endcan --}}
            
        </ul>
    </div>
</nav>
