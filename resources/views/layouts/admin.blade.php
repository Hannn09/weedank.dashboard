<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="./assets/compiled/png/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="./assets/extensions/filepond/filepond.css">
    <link rel="stylesheet" href="./assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="./assets/extensions/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="./assets/extensions/toastify-js/src/toastify.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="#"><img src="./assets/compiled/png/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item @if (Request::routeIs('dashboard')) active @endif">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub @if (Request::routeIs('ingredients', 'product')) active @endif">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-box-seam-fill"></i>
                                <span>Product</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item  @if (Request::routeIs('product')) active @endif">
                                    <a href="{{ route('product') }}" class="submenu-link">Product</a>
                                </li>
                                <li class="submenu-item @if (Request::routeIs('ingredients')) active @endif">
                                    <a href="{{ route('ingredients') }}" class="submenu-link">Ingredients</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub @if (Request::routeIs('manufacturing', 'materials')) active @endif">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-diagram-3-fill"></i>
                                <span>Manufacturing</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item  @if (Request::routeIs('materials')) active @endif">
                                    <a href="{{ route('materials') }}" class="submenu-link">Bill Of Materials</a>
                                </li>
                                <li class="submenu-item @if (Request::routeIs('manufacturing')) active @endif">
                                    <a href="{{ route('manufacturing') }}" class="submenu-link">MO</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub @if (Request::routeIs('vendor', 'quotation', 'purchase', 'payment')) active @endif">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-cart-dash-fill"></i>
                                <span>Purchase</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item  @if (Request::routeIs('vendor')) active @endif">
                                    <a href="{{ route('vendor') }}" class="submenu-link">Vendor</a>
                                </li>
                                <li class="submenu-item  @if (Request::routeIs('quotation')) active @endif">
                                    <a href="{{ route('quotation') }}" class="submenu-link">RFQ</a>
                                </li>
                                <li class="submenu-item @if (Request::routeIs('purchase')) active @endif">
                                    <a href="{{ route('purchase') }}" class="submenu-link">Purchase Order</a>
                                </li>
                                <li class="submenu-item @if (Request::routeIs('payment')) active @endif">
                                    <a href="{{ route('payment') }}" class="submenu-link">Payment Order</a>
                                </li>
                            </ul>
                        </li>


                        <li class="sidebar-item has-sub @if (Request::routeIs('customer', 'sales-quotation', 'sales-order', 'delivery', 'validate')) active @endif">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-cash-stack"></i>
                                <span>Sales</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item  @if (Request::routeIs('customer')) active @endif">
                                    <a href="{{ route('customer') }}" class="submenu-link">Customer</a>
                                </li>
                                <li class="submenu-item  @if (Request::routeIs('sales-quotation')) active @endif">
                                    <a href="{{ route('sales-quotation') }}" class="submenu-link">Sales Quotation</a>
                                </li>
                                <li class="submenu-item  @if (Request::routeIs('sales-order')) active @endif">
                                    <a href="{{ route('sales-order') }}" class="submenu-link">Sales Order</a>
                                </li>
                                <li class="submenu-item  @if (Request::routeIs('delivery')) active @endif">
                                    <a href="{{ route('delivery') }}" class="submenu-link">Delivery</a>
                                </li>
                                <li class="submenu-item  @if (Request::routeIs('validate')) active @endif">
                                    <a href="{{ route('validate') }}" class="submenu-link">Validate</a>
                                </li>
                            
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub @if (Request::routeIs('invoice-sales', 'invoice-purchase')) active @endif">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-receipt"></i>
                                <span>Invoice</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item  @if (Request::routeIs('invoice-sales')) active @endif">
                                    <a href="{{ route('invoice-sales') }}" class="submenu-link">Invoice Sales</a>
                                </li>
                                <li class="submenu-item  @if (Request::routeIs('invoice-purchase')) active @endif">
                                    <a href="{{ route('invoice-purchase') }}" class="submenu-link">Invoice Purchase</a>
                                </li>
                                
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>@yield('heading')</h3>
            </div>
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="./assets/static/js/components/dark.js"></script>
    <script src="./assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="./assets/compiled/js/app.js"></script>
    @yield('script')

    <script src="assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
    <script src="assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
    <script src="assets/extensions/filepond/filepond.js"></script>
    <script src="assets/extensions/toastify-js/src/toastify.js"></script>
    <script src="assets/static/js/pages/toastify.js"></script>
    <script src="assets/static/js/pages/filepond.js"></script>
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>>
    <script src="assets/static/js/pages/sweetalert2.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

</body>

</html>
