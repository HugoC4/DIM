<html>
    <head>
        <title>@yield('title') | DIM</title>
		@include('base.css')
    </head>
    <body class="@yield('bodyClasses', '')">
		@yield('layout')
		@include('base.scripts')
    </body>
</html>