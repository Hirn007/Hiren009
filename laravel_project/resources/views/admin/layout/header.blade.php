<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="tailwind,tailwindcss,tailwind css,css,starter template,free template,admin templates, admin template, admin dashboard, free tailwind templates, tailwind example">
    <!-- Css -->
    <link rel="stylesheet" href="{{url('admin/dist/styles.css')}}">
    <link rel="stylesheet" href="{{url('admin/dist/all.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i,700,700i" rel="stylesheet">
    <title>Dashboard | Tailwind Admin</title>
</head>

<body>

@include('sweetalert::alert')
<!--Container -->
<div class="mx-auto bg-grey-400">
    <!--Screen-->
    <div class="min-h-screen flex flex-col">
        <!--Header Section Starts Here-->
        <header class="bg-nav">
            <div class="flex justify-between">
                <div class="p-1 mx-3 inline-flex items-center">
                    <i class="fas fa-bars pr-2 text-white" onclick="sidebarToggle()"></i>
                    <h1 class="text-white p-2">home</h1>
                </div>
                <div class="p-1 flex flex-row items-center">
                    <a href="https://github.com/tailwindadmin/admin" class="text-white p-2 mr-2 no-underline hidden md:block lg:block">Github</a>


                    <img onclick="profileToggle()" class="inline-block h-8 w-8 rounded-full" src="https://avatars0.githubusercontent.com/u/4323180?s=460&v=4" alt="">
                    <a href="#" onclick="profileToggle()" class="text-white p-2 no-underline hidden md:block lg:block">Adam Wathan</a>
                    <div id="ProfileDropDown" class="rounded hidden shadow-md bg-white absolute pin-t mt-12 mr-1 pin-r">
                        <ul class="list-reset">
                          <li><a href="#" class="no-underline px-4 py-2 block text-black hover:bg-grey-light">My account</a></li>
                          <li><a href="#" class="no-underline px-4 py-2 block text-black hover:bg-grey-light">Notifications</a></li>
                          <li><hr class="border-t mx-2 border-grey-ligght"></li>
                          <li><a href="{{ route('admin.logout') }}" class="no-underline px-4 py-2 block text-black hover:bg-grey-light">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!--/Header-->

        <div class="flex flex-1">
            <!--Sidebar-->
            <aside id="sidebar" class="bg-side-nav w-1/2 md:w-1/6 lg:w-1/6 border-r border-side-nav hidden md:block lg:block">

                <ul class="list-reset flex flex-col">
                    <li class=" w-full h-full py-3 px-2 border-b border-light-border bg-white">
                        <a href="{{ url('dashboard') }}"
                           class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                            <i class="fas fa-tachometer-alt float-left mx-2"></i>
                            Dashboard
                            <span><i class="fas fa-angle-right float-right"></i></span>
                        </a>
                    </li>
                    <li class="w-full h-full py-3 px-2 border-b border-light-border">
                        <a href="{{ url('add-category') }}"
                           class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                            <i class="fas fa-grip-horizontal float-left mx-2"></i>
                            Add Category
                            <span><i class="fa fa-angle-right float-right"></i></span>
                        </a>
                    </li>
                    <li class="w-full h-full py-3 px-2 border-b border-light-border">
                        <a href="{{ url('add-products') }}"
                           class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                            <i class="fas fa-table float-left mx-2"></i>
                            Add Product
                            <span><i class="fa fa-angle-right float-right"></i></span>
                        </a>
                    </li>
                    <li class="w-full h-full py-3 px-2 border-b border-light-border">
                        <a href="{{ url('category-management') }}"
                           class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                            <i class="fab fa-uikit float-left mx-2"></i>
                            Category Management
                            <span><i class="fa fa-angle-right float-right"></i></span>
                        </a>
                    </li>
                    <li class="w-full h-full py-3 px-2 border-b border-300-border">
                        <a href="{{ url('product-management') }}" class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                            <i class="fas fa-square-full float-left mx-2"></i>
                            Product Management
                            <span><i class="fa fa-angle-right float-right"></i></span>
                        </a>
                    </li>
                    <li class="w-full h-full py-3 px-2">
    <a href="{{ url('order-management') }}"
       class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
        <i class="far fa-file float-left mx-2"></i>
        Order Management
        <span><i class="fa fa-angle-down float-right"></i></span>
    </a>

    <ul class="list-reset -mx-2 bg-white-medium-dark">

        <!-- ⭐ Order List -->
        <li class="border-t mt-2 border-light-border w-full h-full px-2 py-3">
            <a href="{{ url('admin/orders') }}"
               class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                Order List
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>

        <!-- ⭐ Add Order -->
        <li class="border-t border-light-border w-full h-full px-2 py-3">
            <a href="{{ url('admin/order/add') }}"
               class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                Add Order
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>

        <!-- ⭐ UPDATED LOGIN PAGE (FIXED) -->
        <li class="border-t border-light-border w-full h-full px-2 py-3">
            <a href="{{ route('admin.login') }}"
               class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                Login Page
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>

        <!-- User Management -->
        <li class="border-t border-light-border w-full h-full px-2 py-3">
            <a href="{{ url('admin/users') }}"
               class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                User Management
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>

        <!-- Slider -->
        <li class="border-t border-light-border w-full h-full px-2 py-3">
            <a href="#"
               class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                Slider Management
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>

        <!-- Logout -->
        <li class="border-t border-light-border w-full h-full px-2 py-3">
            <a href="{{ route('admin.logout') }}"
               class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                Logout
                <span><i class="fa fa-angle-right float-right"></i></span>
              </a>
          </li>

      </ul>

   </li>
     </ul>

       </aside>
            <!--/Sidebar-->
