<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">
    <div
        class="app-menu w-vertical-menu bg-vertical-menu ltr:border-r rtl:border-l border-vertical-menu-border fixed bottom-0 top-0 z-[1003] transition-all duration-75 ease-linear group-data-[sidebar-size=md]:w-vertical-menu-md group-data-[sidebar-size=sm]:w-vertical-menu-sm group-data-[sidebar-size=sm]:pt-header group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar=dark]:border-vertical-menu-dark group-data-[sidebar=brand]:bg-vertical-menu-brand group-data-[sidebar=brand]:border-vertical-menu-brand group-data-[sidebar=modern]:bg-gradient-to-tr group-data-[sidebar=modern]:to-vertical-menu-to-modern group-data-[sidebar=modern]:from-vertical-menu-form-modern group-data-[layout=horizontal]:w-full group-data-[layout=horizontal]:bottom-auto group-data-[layout=horizontal]:top-header hidden md:block print:hidden group-data-[sidebar-size=sm]:absolute group-data-[sidebar=modern]:border-vertical-menu-border-modern group-data-[layout=horizontal]:dark:bg-zink-700 group-data-[layout=horizontal]:border-t group-data-[layout=horizontal]:dark:border-zink-500 group-data-[layout=horizontal]:border-r-0 group-data-[sidebar=dark]:dark:bg-zink-700 group-data-[sidebar=dark]:dark:border-zink-600 group-data-[layout=horizontal]:group-data-[navbar=scroll]:absolute group-data-[layout=horizontal]:group-data-[navbar=bordered]:top-[calc(theme('spacing.header')_+_theme('spacing.4'))] group-data-[layout=horizontal]:group-data-[navbar=bordered]:inset-x-4 group-data-[layout=horizontal]:group-data-[navbar=hidden]:top-0 group-data-[layout=horizontal]:group-data-[navbar=hidden]:h-16 group-data-[layout=horizontal]:group-data-[navbar=bordered]:w-[calc(100%_-_2rem)] group-data-[layout=horizontal]:group-data-[navbar=bordered]:[&.sticky]:top-header group-data-[layout=horizontal]:group-data-[navbar=bordered]:rounded-b-md group-data-[layout=horizontal]:shadow-md group-data-[layout=horizontal]:shadow-slate-500/10 group-data-[layout=horizontal]:dark:shadow-zink-500/10 group-data-[layout=horizontal]:opacity-0">
        <div
            class="flex items-center justify-center px-5 text-center h-header group-data-[layout=horizontal]:hidden group-data-[sidebar-size=sm]:fixed group-data-[sidebar-size=sm]:top-0 group-data-[sidebar-size=sm]:bg-vertical-menu group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar-size=sm]:group-data-[sidebar=brand]:bg-vertical-menu-brand group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:bg-gradient-to-br group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:to-vertical-menu-to-modern group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:from-vertical-menu-form-modern group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:bg-vertical-menu-modern group-data-[sidebar-size=sm]:z-10 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.vertical-menu-sm')_-_1px)] group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:dark:bg-zink-700">
            <a href="{{ route('client.viewHome') }}"
                class="group-data-[sidebar=dark]:hidden group-data-[sidebar=brand]:hidden group-data-[sidebar=modern]:hidden">
                <span class="hidden group-data-[sidebar-size=sm]:block">
                    <img src="../theme/admin/html/assets/images/logo.png" alt="" class="h-6 mx-auto" />
                </span>
                <span class="group-data-[sidebar-size=sm]:hidden">
                    <img src="{{ asset('client/images/icons/logo-03.png') }}" alt="" class="h-6 mx-auto" />
                </span>
            </a>
            <a href="index.html"
                class="hidden group-data-[sidebar=dark]:block group-data-[sidebar=brand]:block group-data-[sidebar=modern]:block">
                <span class="hidden group-data-[sidebar-size=sm]:block">
                    <img src="../theme/admin/html/assets/images/logo.png" alt="" class="h-6 mx-auto" />
                </span>
                <span class="group-data-[sidebar-size=sm]:hidden">
                    <img src="../theme/admin/html/assets/images/logo-light.png" alt="" class="h-6 mx-auto" />
                </span>
            </a>
            <button type="button" class="hidden p-0 float-end" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar"
            class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[layout=horizontal]:h-56 group-data-[layout=horizontal]:md:h-auto group-data-[layout=horizontal]:overflow-auto group-data-[layout=horizontal]:md:overflow-visible group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:mx-auto">
            <div>
                {{-- Sidebar --}}
                <ul class="group-data-[layout=horizontal]:flex group-data-[layout=horizontal]:flex-col group-data-[layout=horizontal]:md:flex-row"
                    id="navbar-nav">

                    @can('view_admin_dashboard')
                        <li
                            class="px-4 py-1 text-vertical-menu-item group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=brand]:text-vertical-menu-item-brand group-data-[sidebar=modern]:text-vertical-menu-item-modern uppercase font-medium text-[11px] cursor-default tracking-wider group-data-[sidebar-size=sm]:hidden group-data-[layout=horizontal]:hidden inline-block group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:underline group-data-[sidebar-size=md]:text-center group-data-[sidebar=dark]:dark:text-zink-200">
                            <span data-key="t-menu">Menu</span>
                        </li>
                        {{-- <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                        <a class="relative flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link text-vertical-menu-item-font-size font-normal transition-all duration-75 ease-linear rounded-md py-2.5 text-vertical-menu-item hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover [&.active]:text-vertical-menu-item-active [&.active]:bg-vertical-menu-item-bg-active group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark group-data-[sidebar=dark]:dark:hover:text-custom-500 group-data-[layout=horizontal]:dark:hover:text-custom-500 group-data-[sidebar=dark]:hover:bg-vertical-menu-item-bg-hover-dark group-data-[sidebar=dark]:dark:hover:bg-zink-600 group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark group-data-[sidebar=dark]:[&.active]:bg-vertical-menu-item-bg-active-dark group-data-[sidebar=brand]:text-vertical-menu-item-brand group-data-[sidebar=brand]:hover:text-vertical-menu-item-hover-brand group-data-[sidebar=brand]:hover:bg-vertical-menu-item-bg-hover-brand group-data-[sidebar=brand]:[&.active]:bg-vertical-menu-item-bg-active-brand group-data-[sidebar=brand]:[&.active]:text-vertical-menu-item-active-brand group-data-[sidebar=modern]:text-vertical-menu-item-modern group-data-[sidebar=modern]:hover:bg-vertical-menu-item-bg-hover-modern group-data-[sidebar=modern]:hover:text-vertical-menu-item-hover-modern group-data-[sidebar=modern]:[&.active]:bg-vertical-menu-item-bg-active-modern group-data-[sidebar=modern]:[&.active]:text-vertical-menu-item-active-modern group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:text-center group-data-[sidebar-size=sm]:group-hover/sm:w-[calc(theme('spacing.vertical-menu-sm')_*_3.63)] group-data-[sidebar-size=sm]:group-hover/sm:bg-vertical-menu group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:group-hover/sm:bg-vertical-menu-dark group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:group-hover/sm:bg-vertical-menu-border-modern group-data-[sidebar-size=sm]:group-data-[sidebar=brand]:group-hover/sm:bg-vertical-menu-brand group-data-[sidebar-size=sm]:my-0 group-data-[sidebar-size=sm]:rounded-b-none group-data-[layout=horizontal]:m-0 group-data-[layout=horizontal]:ltr:pr-8 group-data-[layout=horizontal]:rtl:pl-8 group-data-[layout=horizontal]:hover:bg-transparent group-data-[layout=horizontal]:[&.active]:bg-transparent [&.dropdown-button]:before:absolute [&.dropdown-button]:[&.show]:before:content-['\ea4e'] [&.dropdown-button]:before:content-['\ea6e'] [&.dropdown-button]:before:font-remix ltr:[&.dropdown-button]:before:right-2 rtl:[&.dropdown-button]:before:left-2 [&.dropdown-button]:before:text-16 group-data-[sidebar-size=sm]:[&.dropdown-button]:before:hidden group-data-[sidebar-size=md]:[&.dropdown-button]:before:hidden group-data-[sidebar=dark]:dark:text-zink-200 group-data-[layout=horizontal]:dark:text-zink-200 group-data-[sidebar=dark]:[&.active]:dark:bg-zink-600 group-data-[layout=horizontal]:dark:[&.active]:text-custom-500 rtl:[&.dropdown-button]:before:rotate-180 group-data-[layout=horizontal]:[&.dropdown-button]:before:rotate-90 group-data-[layout=horizontal]:[&.dropdown-button]:[&.show]:before:rotate-0 rtl:[&.dropdown-button]:[&.show]:before:rotate-0"
                            href="{{ route('admin.dashboard.index') }}">
                            <span> --}}
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.dashboard.index');
                            @endphp
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="flex items-center justify-start w-full px-3 py-2.5 my-1 rounded-md transition-all
                                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">

                                <span class="min-w-[1.75rem] text-[16px] inline-block text-start">
                                    <i data-lucide="monitor-dot" class="h-4 w-4"></i>
                                </span>
                                <span class="pl-3">Thống kê</span>
                            </a>
                        </li>
                    @endcan

                    <li
                        class="px-4 py-1 text-vertical-menu-item group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=brand]:text-vertical-menu-item-brand group-data-[sidebar=modern]:text-vertical-menu-item-modern uppercase font-medium text-[11px] cursor-default tracking-wider group-data-[sidebar-size=sm]:hidden group-data-[layout=horizontal]:hidden inline-block group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:underline group-data-[sidebar-size=md]:text-center">
                        <span data-key="t-apps">Apps</span>
                    </li>

                    @can('manage_banners_ql')
                        <li class="relative group">
                            @php
                                $isBannerActive = request()->routeIs('admin.banner.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isBannerActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="image" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Banner</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isBannerActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isBannerActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.banner.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.banner.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.banner.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.banner.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_brands_ql')
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.brands.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="calendar-days" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Thương Hiệu</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isProductActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isProductActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.brands.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.brands.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.brands.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.brands.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_product_catalogues_ql')
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.product_catalogue.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="calendar-days" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Loại Sản Phẩm</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isProductActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isProductActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.product_catalogue.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.product_catalogue.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.product_catalogue.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.product_catalogue.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_products_ql')
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.product.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="calendar-days" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Sản Phẩm</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isProductActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isProductActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.product.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.product.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.product.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.product.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_attribute_catalogues_ql')
                        <li class="relative group">
                            @php
                                $isAttributeActive = request()->routeIs('admin.attribute_catalogue.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all

                            {{ $isAttributeActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="calendar-days" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Loại Thuộc Tính</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isAttributeActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isAttributeActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.attribute_catalogue.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.attribute_catalogue.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.attribute_catalogue.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.attribute_catalogue.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_attributes_ql')
                        <li class="relative group">
                            @php
                                $isAttributeItemActive = request()->routeIs('admin.attribute.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isAttributeItemActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="calendar-days" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Thuộc Tính</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isAttributeItemActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isAttributeItemActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.attribute.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.attribute.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.attribute.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.attribute.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_coupons_ql')
                        <li class="relative group">
                            @php
                                $isCouponActive = request()->routeIs('admin.counpon.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isCouponActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="award" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Khuyến Mãi</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isCouponActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isCouponActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.counpon.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.counpon.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.counpon.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.counpon.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_orders_ql')
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.order.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="shopping-cart" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Dơn Hàng</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isProductActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isProductActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.order.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.order.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_roles_custom_ql')
                        <li class="relative group">
                            @php
                                $isRolesActive = request()->routeIs('admin.roles.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isRolesActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span
                                        class="min-w-[1.75rem] group-data-[sidebar-size=sm]:h-[1.75rem] inline-block text-start text-[16px] group-data-[sidebar-size=md]:block group-data-[sidebar-size=sm]:flex group-data-[sidebar-size=sm]:items-center"><i
                                            data-lucide="user-2"
                                            class="h-4 group-data-[sidebar-size=sm]:h-5 group-data-[sidebar-size=sm]:w-5 transition group-hover/menu-link:animate-icons fill-slate-100 group-hover/menu-link:fill-blue-200 group-data-[sidebar=dark]:fill-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:dark:fill-zink-600 group-data-[layout=horizontal]:dark:fill-zink-600 group-data-[sidebar=brand]:fill-vertical-menu-item-bg-active-brand group-data-[sidebar=modern]:fill-vertical-menu-item-bg-active-modern group-data-[sidebar=dark]:group-hover/menu-link:fill-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:group-hover/menu-link:dark:fill-custom-500/20 group-data-[layout=horizontal]:dark:group-hover/menu-link:fill-custom-500/20 group-data-[sidebar=brand]:group-hover/menu-link:fill-vertical-menu-item-bg-active-brand group-data-[sidebar=modern]:group-hover/menu-link:fill-vertical-menu-item-bg-active-modern group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:mx-auto group-data-[sidebar-size=md]:mb-2"></i></span>
                                    <span class="pl-3">QL Vai Trò</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isRolesActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isRolesActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.roles.create') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.roles.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.roles.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_users_client_ql')
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.users.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span
                                        class="min-w-[1.75rem] group-data-[sidebar-size=sm]:h-[1.75rem] inline-block text-start text-[16px] group-data-[sidebar-size=md]:block group-data-[sidebar-size=sm]:flex group-data-[sidebar-size=sm]:items-center"><i
                                            data-lucide="user-2"
                                            class="h-4 group-data-[sidebar-size=sm]:h-5 group-data-[sidebar-size=sm]:w-5 transition group-hover/menu-link:animate-icons fill-slate-100 group-hover/menu-link:fill-blue-200 group-data-[sidebar=dark]:fill-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:dark:fill-zink-600 group-data-[layout=horizontal]:dark:fill-zink-600 group-data-[sidebar=brand]:fill-vertical-menu-item-bg-active-brand group-data-[sidebar=modern]:fill-vertical-menu-item-bg-active-modern group-data-[sidebar=dark]:group-hover/menu-link:fill-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:group-hover/menu-link:dark:fill-custom-500/20 group-data-[layout=horizontal]:dark:group-hover/menu-link:fill-custom-500/20 group-data-[sidebar=brand]:group-hover/menu-link:fill-vertical-menu-item-bg-active-brand group-data-[sidebar=modern]:group-hover/menu-link:fill-vertical-menu-item-bg-active-modern group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:mx-auto group-data-[sidebar-size=md]:mb-2"></i></span>
                                    <span class="pl-3">QL Người Dùng</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isProductActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isProductActive ? '' : 'hidden' }}">
                                {{-- <li>
                                <a href="{{ route('admin.users.create') }}"
                                    class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.users.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                    Thêm mới
                                </a>
                            </li> --}}
                                <li>
                                    <a href="{{ route('admin.users.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.users.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_staff_ql')
                        <li class="relative group">
                            @php
                                // Sửa ở đây: Kiểm tra active state cho các route của staff management
                                $isStaffActive = request()->routeIs('admin.staff.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
           {{ $isStaffActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
           hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span
                                        class="min-w-[1.75rem] group-data-[sidebar-size=sm]:h-[1.75rem] inline-block text-start text-[16px] group-data-[sidebar-size=md]:block group-data-[sidebar-size=sm]:flex group-data-[sidebar-size=sm]:items-center">
                                        {{-- Icon cho QL Nhân Viên, bạn có thể chọn icon khác nếu muốn --}}
                                        <i data-lucide="user-cog-2"
                                            class="h-4 group-data-[sidebar-size=sm]:h-5 group-data-[sidebar-size=sm]:w-5 ..."></i>
                                    </span>
                                    <span class="pl-3">QL Nhân Viên</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isStaffActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isStaffActive ? '' : 'hidden' }}">
                                <li>
                                    {{-- Sửa ở đây: Route đến trang tạo nhân viên mới --}}
                                    <a href="{{ route('admin.staff.create') }}"
                                        class="block px-3 py-2 rounded-md
                   {{ request()->routeIs('admin.staff.create') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                   hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Thêm mới
                                    </a>
                                </li>
                                <li>
                                    {{-- Sửa ở đây: Route đến trang danh sách nhân viên --}}
                                    <a href="{{ route('admin.staff.index') }}"
                                        class="block px-3 py-2 rounded-md
                   {{ request()->routeIs('admin.staff.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                   hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('manage_reviews_ql')
                        <li class="relative group">
                            @php
                                $isProductActive = request()->routeIs('admin.review.*');
                            @endphp
                            <a href="#"
                                class="relative dropdown-button flex items-center justify-between mx-3 my-1 py-2.5 rounded-md transition-all
                            {{ $isProductActive ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                            hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover"
                                onclick="toggleSubmenu(event)">

                                <div class="flex items-center">
                                    <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                                        <i data-lucide="star" class="h-4"></i>
                                    </span>
                                    <span class="pl-3">QL Đánh Giá</span>
                                </div>

                                <span
                                    class="transition-transform duration-300 arrow {{ $isProductActive ? 'rotate-90' : '' }}">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </span>
                            </a>

                            <ul
                                class="pl-10 mt-1 space-y-1 transition-all duration-300 ease-in-out submenu {{ $isProductActive ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.review.index') }}"
                                        class="block px-3 py-2 rounded-md
                                    {{ request()->routeIs('admin.review.index') ? 'text-vertical-menu-item-hover bg-vertical-menu-item-bg-hover' : 'text-vertical-menu-item' }}
                                    hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover">
                                        Danh sách
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    {{-- <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                        <a class="relative dropdown-button flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link text-vertical-menu-item-font-size font-normal transition-all duration-75 ease-linear rounded-md py-2.5 text-vertical-menu-item hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover [&.active]:text-vertical-menu-item-active [&.active]:bg-vertical-menu-item-bg-active group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark group-data-[sidebar=dark]:dark:hover:text-custom-500 group-data-[layout=horizontal]:dark:hover:text-custom-500 group-data-[sidebar=dark]:hover:bg-vertical-menu-item-bg-hover-dark group-data-[sidebar=dark]:dark:hover:bg-zink-600 group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark group-data-[sidebar=dark]:[&.active]:bg-vertical-menu-item-bg-active-dark group-data-[sidebar=brand]:text-vertical-menu-item-brand group-data-[sidebar=brand]:hover:text-vertical-menu-item-hover-brand group-data-[sidebar=brand]:hover:bg-vertical-menu-item-bg-hover-brand group-data-[sidebar=brand]:[&.active]:bg-vertical-menu-item-bg-active-brand group-data-[sidebar=brand]:[&.active]:text-vertical-menu-item-active-brand group-data-[sidebar=modern]:text-vertical-menu-item-modern group-data-[sidebar=modern]:hover:bg-vertical-menu-item-bg-hover-modern group-data-[sidebar=modern]:hover:text-vertical-menu-item-hover-modern group-data-[sidebar=modern]:[&.active]:bg-vertical-menu-item-bg-active-modern group-data-[sidebar=modern]:[&.active]:text-vertical-menu-item-active-modern group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:text-center group-data-[sidebar-size=sm]:group-hover/sm:w-[calc(theme('spacing.vertical-menu-sm')_*_3.63)] group-data-[sidebar-size=sm]:group-hover/sm:bg-vertical-menu group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:group-hover/sm:bg-vertical-menu-dark group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:group-hover/sm:bg-vertical-menu-border-modern group-data-[sidebar-size=sm]:group-data-[sidebar=brand]:group-hover/sm:bg-vertical-menu-brand group-data-[sidebar-size=sm]:my-0 group-data-[sidebar-size=sm]:rounded-b-none group-data-[layout=horizontal]:m-0 group-data-[layout=horizontal]:ltr:pr-8 group-data-[layout=horizontal]:rtl:pl-8 group-data-[layout=horizontal]:hover:bg-transparent group-data-[layout=horizontal]:[&.active]:bg-transparent [&.dropdown-button]:before:absolute [&.dropdown-button]:[&.show]:before:content-['\ea4e'] [&.dropdown-button]:before:content-['\ea6e'] [&.dropdown-button]:before:font-remix ltr:[&.dropdown-button]:before:right-2 rtl:[&.dropdown-button]:before:left-2 [&.dropdown-button]:before:text-16 group-data-[sidebar-size=sm]:[&.dropdown-button]:before:hidden group-data-[sidebar-size=md]:[&.dropdown-button]:before:hidden group-data-[sidebar=dark]:dark:text-zink-200 group-data-[layout=horizontal]:dark:text-zink-200 group-data-[sidebar=dark]:[&.active]:dark:bg-zink-600 group-data-[layout=horizontal]:dark:[&.active]:text-custom-500 rtl:[&.dropdown-button]:before:rotate-180 group-data-[layout=horizontal]:[&.dropdown-button]:before:rotate-90 group-data-[layout=horizontal]:[&.dropdown-button]:[&.show]:before:rotate-0 rtl:[&.dropdown-button]:[&.show]:before:rotate-0"
                            href="{{ route('admin.review.index') }}">
                            <span
                                class="min-w-[1.75rem] group-data-[sidebar-size=sm]:h-[1.75rem] inline-block text-start text-[16px] group-data-[sidebar-size=md]:block group-data-[sidebar-size=sm]:flex group-data-[sidebar-size=sm]:items-center"><i
                                    data-lucide="user-2"
                                    class="h-4 group-data-[sidebar-size=sm]:h-5 group-data-[sidebar-size=sm]:w-5 transition group-hover/menu-link:animate-icons fill-slate-100 group-hover/menu-link:fill-blue-200 group-data-[sidebar=dark]:fill-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:dark:fill-zink-600 group-data-[layout=horizontal]:dark:fill-zink-600 group-data-[sidebar=brand]:fill-vertical-menu-item-bg-active-brand group-data-[sidebar=modern]:fill-vertical-menu-item-bg-active-modern group-data-[sidebar=dark]:group-hover/menu-link:fill-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:group-hover/menu-link:dark:fill-custom-500/20 group-data-[layout=horizontal]:dark:group-hover/menu-link:fill-custom-500/20 group-data-[sidebar=brand]:group-hover/menu-link:fill-vertical-menu-item-bg-active-brand group-data-[sidebar=modern]:group-hover/menu-link:fill-vertical-menu-item-bg-active-modern group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:mx-auto group-data-[sidebar-size=md]:mb-2"></i></span>
                            <span
                                class="group-data-[sidebar-size=sm]:ltr:pl-10 group-data-[sidebar-size=sm]:rtl:pr-10 align-middle group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:hidden"
                                data-key="t-calendar">QL Đánh Giá</span>
                        </a>
                    </li> --}}
                </ul>
                {{-- End Sidebar --}}
            </div>
            <script>
                function toggleSubmenu(event) {
                    event.preventDefault();
                    const button = event.target.closest('a.dropdown-button');
                    if (!button) return;

                    const submenu = button.parentElement.querySelector('.submenu');
                    const arrow = button.querySelector('.arrow');

                    if (submenu) {
                        submenu.classList.toggle('hidden');
                        arrow.classList.toggle('rotate-90');
                    }
                }
            </script>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
    <div id="sidebar-overlay" class="absolute inset-0 z-[1002] bg-slate-500/30 hidden"></div>
    <header id="page-topbar"
        class="ltr:md:left-vertical-menu rtl:md:right-vertical-menu group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm group-data-[layout=horizontal]:ltr:left-0 group-data-[layout=horizontal]:rtl:right-0 fixed right-0 z-[1000] left-0 print:hidden group-data-[navbar=bordered]:m-4 group-data-[navbar=bordered]:[&.is-sticky]:mt-0 transition-all ease-linear duration-300 group-data-[navbar=hidden]:hidden group-data-[navbar=scroll]:absolute group/topbar group-data-[layout=horizontal]:z-[1004]">
        <div class="layout-width">
            <div
                class="flex items-center px-4 mx-auto bg-topbar border-b-2 border-topbar group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-brand shadow-md h-header shadow-slate-200/50 group-data-[navbar=bordered]:rounded-md group-data-[navbar=bordered]:group-[.is-sticky]/topbar:rounded-t-none group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:border-zink-700 dark:shadow-none group-data-[topbar=dark]:group-[.is-sticky]/topbar:dark:shadow-zink-500 group-data-[topbar=dark]:group-[.is-sticky]/topbar:dark:shadow-md group-data-[navbar=bordered]:shadow-none group-data-[layout=horizontal]:group-data-[navbar=bordered]:rounded-b-none group-data-[layout=horizontal]:shadow-none group-data-[layout=horizontal]:dark:group-[.is-sticky]/topbar:shadow-none">
                <div
                    class="flex items-center w-full group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl navbar-header group-data-[layout=horizontal]:ltr:xl:pr-3 group-data-[layout=horizontal]:rtl:xl:pl-3">
                    <!-- LOGO -->


                    <button type="button"
                        class="inline-flex relative justify-center items-center p-0 text-topbar-item transition-all w-[37.5px] h-[37.5px] duration-75 ease-linear bg-topbar rounded-md btn hover:bg-slate-100 group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:dark:border-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[layout=horizontal]:flex group-data-[layout=horizontal]:md:hidden hamburger-icon"
                        id="topnav-hamburger-icon" onclick="window.history.back()">
                        <i data-lucide="chevrons-left" class="w-5 h-5 group-data-[sidebar-size=sm]:hidden"></i>
                        <i data-lucide="chevrons-right" class="hidden w-5 h-5 group-data-[sidebar-size=sm]:block"></i>
                    </button>

                    <div class="flex gap-3 ms-auto">
                        <div class="relative flex items-center h-header">
                            <button type="button"
                                class="inline-flex relative justify-center items-center p-0 text-topbar-item transition-all w-[37.5px] h-[37.5px] duration-200 ease-linear bg-topbar rounded-md btn hover:bg-topbar-item-bg-hover hover:text-topbar-item-hover group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark"
                                id="light-dark-mode">
                                <i data-lucide="sun"
                                    class="inline-block w-5 h-5 stroke-1 fill-slate-100 group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand"></i>
                            </button>
                        </div>

                        <div class="relative flex items-center dropdown h-header">
                            <button type="button"
                                class="inline-flex justify-center relative items-center p-0 text-topbar-item transition-all w-[37.5px] h-[37.5px] duration-200 ease-linear bg-topbar rounded-md dropdown-toggle btn hover:bg-topbar-item-bg-hover hover:text-topbar-item-hover group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark"
                                id="notificationDropdown" data-bs-toggle="dropdown">
                                <i data-lucide="bell-ring"
                                    class="inline-block w-5 h-5 stroke-1 fill-slate-100 group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand"></i>
                                <span class="absolute top-0 right-0 flex w-1.5 h-1.5">
                                    <span
                                        class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-sky-400"></span>
                                    <span class="relative inline-flex w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                </span>
                            </button>
                            <div class="absolute z-50 hidden ltr:text-left rtl:text-right bg-white rounded-md shadow-md !top-4 dropdown-menu min-w-[20rem] lg:min-w-[26rem] dark:bg-zink-600"
                                aria-labelledby="notificationDropdown">
                                <div class="p-4">
                                    <h6 class="mb-4 text-16">
                                        Notifications
                                        <span
                                            class="inline-flex items-center justify-center w-5 h-5 ml-1 text-[11px] font-medium border rounded-full text-white bg-orange-500 border-orange-500">15</span>
                                    </h6>
                                    <ul class="flex flex-wrap w-full p-1 mb-2 text-sm font-medium text-center rounded-md filter-btns text-slate-500 bg-slate-100 nav-tabs dark:bg-zink-500 dark:text-zink-200"
                                        data-filter-target="notification-list">
                                        <li class="grow">
                                            <a href="javascript:void(0);" data-filter="all"
                                                class="inline-block nav-link px-1.5 w-full py-1 text-xs transition-all duration-300 ease-linear rounded-md text-slate-500 border border-transparent [&.active]:bg-white [&.active]:text-custom-500 hover:text-custom-500 active:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:[&.active]:bg-zink-600 -mb-[1px] active">View
                                                All</a>
                                        </li>
                                        <li class="grow">
                                            <a href="javascript:void(0);" data-filter="mention"
                                                class="inline-block nav-link px-1.5 w-full py-1 text-xs transition-all duration-300 ease-linear rounded-md text-slate-500 border border-transparent [&.active]:bg-white [&.active]:text-custom-500 hover:text-custom-500 active:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:[&.active]:bg-zink-600 -mb-[1px]">Mentions</a>
                                        </li>
                                        <li class="grow">
                                            <a href="javascript:void(0);" data-filter="follower"
                                                class="inline-block nav-link px-1.5 w-full py-1 text-xs transition-all duration-300 ease-linear rounded-md text-slate-500 border border-transparent [&.active]:bg-white [&.active]:text-custom-500 hover:text-custom-500 active:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:[&.active]:bg-zink-600 -mb-[1px]">Followers</a>
                                        </li>
                                        <li class="grow">
                                            <a href="javascript:void(0);" data-filter="invite"
                                                class="inline-block nav-link px-1.5 w-full py-1 text-xs transition-all duration-300 ease-linear rounded-md text-slate-500 border border-transparent [&.active]:bg-white [&.active]:text-custom-500 hover:text-custom-500 active:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:[&.active]:bg-zink-600 -mb-[1px]">Invites</a>
                                        </li>
                                    </ul>
                                </div>
                                <div data-simplebar="" class="max-h-[350px]">
                                    <div class="flex flex-col gap-1" id="notification-list">
                                        <a href="#!"
                                            class="flex gap-3 p-4 product-item hover:bg-slate-50 dark:hover:bg-zink-500 follower">
                                            <div class="w-10 h-10 rounded-md shrink-0 bg-slate-100">
                                                <img src="../theme/admin/html/assets/images/avatar-3.png"
                                                    alt="" class="rounded-md" />
                                            </div>
                                            <div class="grow">
                                                <h6 class="mb-1 font-medium">
                                                    <b>@willie_passem</b> followed you
                                                </h6>
                                                <p class="mb-0 text-sm text-slate-500 dark:text-zink-300">
                                                    <i data-lucide="clock" class="inline-block w-3.5 h-3.5 mr-1"></i>
                                                    <span class="align-middle">Wednesday 03:42 PM</span>
                                                </p>
                                            </div>
                                            <div
                                                class="flex items-center self-start gap-2 text-xs text-slate-500 shrink-0 dark:text-zink-300">
                                                <div class="w-1.5 h-1.5 bg-custom-500 rounded-full"></div>
                                                4 sec
                                            </div>
                                        </a>
                                        <a href="#!"
                                            class="flex gap-3 p-4 product-item hover:bg-slate-50 dark:hover:bg-zink-500 mention">
                                            <div class="w-10 h-10 bg-yellow-100 rounded-md shrink-0">
                                                <img src="../theme/admin/html/assets/images/avatar-5.png"
                                                    alt="" class="rounded-md" />
                                            </div>
                                            <div class="grow">
                                                <h6 class="mb-1 font-medium">
                                                    <b>@caroline_jessica</b> commented on your post
                                                </h6>
                                                <p class="mb-3 text-sm text-slate-500 dark:text-zink-300">
                                                    <i data-lucide="clock" class="inline-block w-3.5 h-3.5 mr-1"></i>
                                                    <span class="align-middle">Wednesday 03:42 PM</span>
                                                </p>
                                                <div
                                                    class="p-2 rounded bg-slate-100 text-slate-500 dark:bg-zink-500 dark:text-zink-300">
                                                    Amazing! Fast, to the point, professional and
                                                    really amazing to work with them!!!
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center self-start gap-2 text-xs text-slate-500 shrink-0 dark:text-zink-300">
                                                <div class="w-1.5 h-1.5 bg-custom-500 rounded-full"></div>
                                                15 min
                                            </div>
                                        </a>
                                        <a href="#!"
                                            class="flex gap-3 p-4 product-item hover:bg-slate-50 dark:hover:bg-zink-500 invite">
                                            <div
                                                class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-md shrink-0">
                                                <i data-lucide="shopping-bag"
                                                    class="w-5 h-5 text-red-500 fill-red-200"></i>
                                            </div>
                                            <div class="grow">
                                                <h6 class="mb-1 font-medium">
                                                    Successfully purchased a business plan for
                                                    <span class="text-red-500">$199.99</span>
                                                </h6>
                                                <p class="mb-0 text-sm text-slate-500 dark:text-zink-300">
                                                    <i data-lucide="clock" class="inline-block w-3.5 h-3.5 mr-1"></i>
                                                    <span class="align-middle">Monday 11:26 AM</span>
                                                </p>
                                            </div>
                                            <div
                                                class="flex items-center self-start gap-2 text-xs text-slate-500 shrink-0 dark:text-zink-300">
                                                <div class="w-1.5 h-1.5 bg-custom-500 rounded-full"></div>
                                                Yesterday
                                            </div>
                                        </a>
                                        <a href="#!"
                                            class="flex gap-3 p-4 product-item hover:bg-slate-50 dark:hover:bg-zink-500 mention">
                                            <div class="relative shrink-0">
                                                <div class="w-10 h-10 bg-pink-100 rounded-md">
                                                    <img src="../theme/admin/html/assets/images/avatar-7.png"
                                                        alt="" class="rounded-md" />
                                                </div>
                                                <div class="absolute text-orange-500 -bottom-0.5 -right-0.5 text-16">
                                                    <i class="ri-heart-fill"></i>
                                                </div>
                                            </div>
                                            <div class="grow">
                                                <h6 class="mb-1 font-medium">
                                                    <b>@scott</b> liked your post
                                                </h6>
                                                <p class="mb-0 text-sm text-slate-500 dark:text-zink-300">
                                                    <i data-lucide="clock" class="inline-block w-3.5 h-3.5 mr-1"></i>
                                                    <span class="align-middle">Thursday 06:59 AM</span>
                                                </p>
                                            </div>
                                            <div
                                                class="flex items-center self-start gap-2 text-xs text-slate-500 shrink-0 dark:text-zink-300">
                                                <div class="w-1.5 h-1.5 bg-custom-500 rounded-full"></div>
                                                1 Week
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-2 p-4 border-t border-slate-200 dark:border-zink-500">
                                    <div class="grow">
                                        <a href="#!">Manage Notification</a>
                                    </div>
                                    <div class="shrink-0">
                                        <button type="button"
                                            class="px-2 py-1.5 text-xs text-white transition-all duration-200 ease-linear btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100">
                                            View All Notification
                                            <i data-lucide="move-right" class="inline-block w-3.5 h-3.5 ml-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative flex items-center dropdown h-header">
                            <button type="button"
                                class="inline-block p-0 transition-all duration-200 ease-linear bg-topbar rounded-full text-topbar-item dropdown-toggle btn hover:bg-topbar-item-bg-hover hover:text-topbar-item-hover group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200"
                                id="dropdownMenuButton" data-bs-toggle="dropdown">
                                <div class="bg-pink-100 rounded-full">
                                    <img src="{{ asset('storage/' . Auth::user()->avt) }}" alt=""
                                        class="w-[37.5px] h-[37.5px] rounded-full" />
                                </div>
                            </button>
                            <div class="absolute z-50 hidden p-4 ltr:text-left rtl:text-right bg-white rounded-md shadow-md !top-4 dropdown-menu min-w-[14rem] dark:bg-zink-600"
                                aria-labelledby="dropdownMenuButton">
                                <ul>
                                    <li>
                                        <a class="block ltr:pr-4 rtl:pl-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:text-custom-500 focus:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:focus:text-custom-500"
                                            href="{{ route('client.viewHome') }}">
                                            <i data-lucide="home" class="inline-block size-4 ltr:mr-2 rtl:ml-2"></i>
                                            Về trang chủ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="block ltr:pr-4 rtl:pl-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:text-custom-500 focus:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:focus:text-custom-500"
                                            href="{{ route('client.account.viewAccount') }}"><i data-lucide="user-2"
                                                class="inline-block size-4 ltr:mr-2 rtl:ml-2"></i>
                                            Tài khoản</a>
                                    </li>
                                    <li>
                                        <a class="block ltr:pr-4 rtl:pl-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:text-custom-500 focus:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:focus:text-custom-500"
                                            href="https://mail.google.com/" target="_blank"><i data-lucide="mail"
                                                class="inline-block size-4 ltr:mr-2 rtl:ml-2"></i>
                                            Email</span></a>
                                    </li>
                                    <li class="pt-2 mt-2 border-t border-slate-200 dark:border-zink-500">
                                        <a class="block ltr:pr-4 rtl:pl-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:text-custom-500 focus:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:focus:text-custom-500"
                                            href="{{ route('auth.logout') }}"><i data-lucide="log-out"
                                                class="inline-block size-4 ltr:mr-2 rtl:ml-2"></i>
                                            Sign Out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
