<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> @yield('title') </title>

    @include('user.layout.style')

</head>

<body class="animsition">
<div class="page-wrapper">

    @include('user.layout.mobile_header')

    @include('user.layout.sidebar')

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        @include('user.layout.header')

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                @yield('content')
            </div>
        </div>
        <!-- END MAIN CONTENT-->

    </div>
    <!-- END PAGE CONTAINER-->

    @include('user.layout.footer')

    @include('user.layout.script')

</div>
</body>

</html>
