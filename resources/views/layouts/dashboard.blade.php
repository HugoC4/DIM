@extends("layouts.base")

@section('title', 'Dashboard')
@section('bodyClasses', 'hold-transition skin-purple-light sidebar-mini')
@section('layout')
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>DIM</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <b>DIM</b>
                </span>
            </a>
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->


            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">Navigatie</li>
                    @yield('menu', '')
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('pageTitle', 'Dashboard')
                    <small>@yield("pageSubTitle", '')</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content', '')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            Gemaakt door <strong><a href="mailto:hugokruis@hotmail.com?subject=DIM">Hugo Kruis</a>,</strong> 2016
        </footer>
    </div>
    <!-- ./wrapper -->
@endsection