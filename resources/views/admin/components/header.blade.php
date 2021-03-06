<!doctype html>
<html lang="en" class="fixed left-sidebar-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/admin/favicon/apple-icon-120x120.png') }}">
    <!--load progress bar-->
    <script src="{{ asset('assets/admin/vendor/pace/pace.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin/loader-css.css') }}">
    <link href="{{ asset('assets/admin/vendor/pace/pace-theme-minimal.css') }}" rel="stylesheet"/>

    <!--BASIC css-->
    <!-- ========================================================= -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/animate.css/animate.css') }}">

    <!--Date picker-->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap_date-picker/css/bootstrap-datepicker3.min.css')}}">
    <!--Select picker-->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
    <!--summernote-->
    <link href="{{asset('assets/admin/summernote/dist/summernote.css')}}" rel="stylesheet">
    <!--dataTable-->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/data-table/media/css/dataTables.bootstrap.min.css')}}">


    <!--SECTION css-->
    <!-- ========================================================= -->
    <!--Notification msj-->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/toastr/toastr.min.css') }}">
    <!--Magnific popup-->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/magnific-popup/magnific-popup.css') }}">
    <!--TEMPLATE css-->
    <!-- ========================================================= -->
    <link rel="stylesheet" href="{{ asset('assets/admin/stylesheets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.toggle.min.css') }}">

</head>

<body>
<div class="wrap">
    <!-- page HEADER -->
    <!-- ========================================================= -->
    <div class="page-header">
        <!-- LEFTSIDE header -->
        <div class="leftside-header">
            <div class="logo">
                <a target="_blank" href="{{route('index')}}" class="on-click">
                   <h3 style="margin-left: 10px; color: hotpink;">Online Shop</h3>
                </a>
            </div>
            <div id="menu-toggle" class="visible-xs toggle-left-sidebar" data-toggle-class="left-sidebar-open" data-target="html">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <!-- RIGHTSIDE header -->
        <div class="rightside-header">
            @foreach($profiles as $profile)
            <div class="header-middle"></div>

            <!--USER HEADERBOX -->
            <div class="header-section" id="user-headerbox">

                <div class="user-header-wrap">
                    <div class="user-photo">
                        <img alt="profile photo" src="{{ asset('uploads/profile/'.$profile->image)}}"/>
                    </div>
                    <div class="user-info">

                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-profile">{{ auth()->user()->is_admin === 1 ? 'Admin':'Super Admin' }}</span>
                    </div>
                    <i class="fa fa-plus icon-open" aria-hidden="true"></i>
                </div>
                <div class="user-options dropdown-box">
                    <div class="drop-content basic">
                        <ul >
                            <li ><a  href="{{route('profiles.manage')}}"><i  class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="header-separator"></div>
            <!--Log out -->
            <div class="header-section">
                <a href="{{ route('logout') }}" data-toggle="tooltip" data-placement="left" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fa fa-sign-out log-out" aria-hidden="true"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
                <h5>{{$profile->name}}</h5>
            @endforeach
        </div>
    </div>
    <!-- page BODY -->
    <!-- ========================================================= -->
    <div class="page-body">
        <!-- LEFT SIDEBAR -->
        <!-- ========================================================= -->
        <div class="left-sidebar">
            <!-- left sidebar HEADER -->
            <div class="left-sidebar-header">
                <div  class="left-sidebar-title">Navigation</div>
                <div class="left-sidebar-toggle c-hamburger c-hamburger--htla hidden-xs" data-toggle-class="left-sidebar-collapsed" data-target="html">
                    <span></span>
                </div>

            </div>
            <!-- NAVIGATION -->
            <!-- ========================================================= -->
            <div id="left-nav" class="nano">
                <div class="nano-content">
                    <nav>
                        <ul class="nav nav-left-lines" id="main-nav">
                            <!--HOME-->
                            <li class="{{ request()->is('home') ? 'active-item':'' }}"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a></li>
                            <!--BRANDS-->
                            <li class="has-child-item {{ request()->is('brands','brands/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-life-bouy" aria-hidden="true"></i><span>Brands</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('brands/add','brands/edit/*') ? 'active-item':'' }}"><a href="{{ route('brand.create') }}">Add Brand</a></li>
                                    <li class="{{ request()->is('brands') ? 'active-item':'' }}"><a href="{{ route('brand.manage') }}">Manage Brands</a></li>
                                </ul>
                            </li>

                            <!--CATEGORIES-->
                            <li class="has-child-item {{ request()->is('categories','categories/*','sub-categories','sub-categories/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-list" aria-hidden="true"></i><span>Categories</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('categories/add','categories/edit/*') ? 'active-item':'' }}"><a href="{{ route('categories.create') }}">Add Category</a></li>
                                    <li class="{{ request()->is('categories') ? 'active-item':'' }}"><a href="{{ route('categories.manage') }}">Manage Categories</a></li>
                                    <li class="{{ request()->is('sub-categories/add','sub-categories/edit/*') ? 'active-item':'' }}"><a href="{{ route('sub.category.create') }}">Add Sub Category</a></li>
                                    <li class="{{ request()->is('sub-categories') ? 'active-item':'' }}"><a href="{{ route('sub.category.manage') }}">Manage Sub Categories</a></li>
                                </ul>
                            </li>
                            <!--SLIDERS-->
                            <li class="has-child-item {{ request()->is('sliders','sliders/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-gift" aria-hidden="true"></i><span>Sliders</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('sliders/add','sliders/edit/*') ? 'active-item':'' }}"><a href="{{ route('sliders.create') }}">Add Slider</a></li>
                                    <li class="{{ request()->is('sliders') ? 'active-item':'' }}"><a href="{{ route('sliders.manage') }}">Manage Sliders</a></li>
                                </ul>
                            </li>

                            <!--PRODUCTS-->
                            <li class="has-child-item {{ request()->is('products','products/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-list" aria-hidden="true"></i><span>Products</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('products/add','products/edit/*') ? 'active-item':'' }}"><a href="{{ route('products.create') }}">Add Product</a></li>
                                    <li class="{{ request()->is('products') ? 'active-item':'' }}"><a href="{{ route('products.manage') }}">Manage Products</a></li>
                                </ul>
                            </li>

                            <!--ORDERS-->
                            <li class="has-child-item {{ request()->is('checkout/orders/invoice/*','checkout/orders/view/*','checkout/orders/manage','checkout/customers/manage') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-mail-forward" aria-hidden="true"></i><span>Checkout</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('checkout/orders/manage') ? 'active-item':'' }}"><a href="{{ route('checkout.orders.manage') }}">Manage Orders </a></li>
                                    <li class="{{ request()->is('checkout/customers/manage') ? 'active-item':'' }}"><a href="{{ route('checkout.customers.manage') }}">Manage Customers </a></li>
                                </ul>
                            </li>


                            <!--Mail-->
                            <li class="has-child-item {{ request()->is('mails','mails/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-envelope" aria-hidden="true"></i><span>Mails</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('mails/manage') ? 'active-item':'' }}"><a href="{{ route('mails.manage') }}">Mails Manage</a></li>
                                </ul>
                            </li>

                            <!--About Online Shop-->
                            <li class="has-child-item {{ request()->is('profiles','profiles/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-phone-square" aria-hidden="true"></i><span>Contact Us</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('profiles/add','profiles/edit/*') ? 'active-item':'' }}"><a href="{{ route('profiles.create') }}">Add Contact Us</a></li>
                                    <li class="{{ request()->is('profiles') ? 'active-item':'' }}"><a href="{{ route('profiles.manage') }}">Manage Contact Us</a></li>
                                </ul>
                            </li>
                            <!--ABOUT ONLINE SHOP-->
                            <li class="has-child-item {{ request()->is('abouts','abouts/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-user" aria-hidden="true"></i><span>About Online Shop</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('abouts/add','abouts/edit/*') ? 'active-item':'' }}"><a href="{{ route('abouts.create') }}">Add About</a></li>
                                    <li class="{{ request()->is('abouts') ? 'active-item':'' }}"><a href="{{ route('abouts.manage') }}">Manage About</a></li>
                                </ul>
                            </li>

                            <!--Terms & Conditions-->
                            <li class="has-child-item {{ request()->is('conditions','conditions/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-tencent-weibo" aria-hidden="true"></i><span>Terms & Conditions</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('conditions/add','conditions/edit/*') ? 'active-item':'' }}"><a href="{{ route('conditions.create') }}">Add Condition</a></li>
                                    <li class="{{ request()->is('conditions') ? 'active-item':'' }}"><a href="{{ route('conditions.manage') }}">Manage Conditions</a></li>
                                </ul>
                            </li>
                            <!------------------------->

                            <!--Terms & Conditions-->
                            <li class="has-child-item {{ request()->is('policies','policies/*') ? 'open-item active-item':'' }} close-item">
                                <a><i class="fa fa-key" aria-hidden="true"></i><span>Privacy & Policy</span></a>
                                <ul class="nav child-nav level-1">
                                    <li class="{{ request()->is('policies/add','policies/edit/*') ? 'active-item':'' }}"><a href="{{ route('policies.create') }}">Add Policy</a></li>
                                    <li class="{{ request()->is('policies') ? 'active-item':'' }}"><a href="{{ route('policies.manage') }}">Manage Policy</a></li>
                                </ul>
                            </li>
                            <!------------------------->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

