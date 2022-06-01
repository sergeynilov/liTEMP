


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LV &#124; Номинации</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LV - description">
    <link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css">-->
    <link rel="stylesheet" href="/css/main.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/lib/jquery.min.js"></script>

</head>

<body>




<div class="wrapper">

    <div class="wrapper__content">

        <x-frontend.header />

        @yield('content')

    </div>  <!-- wrapper__content -->

    <x-frontend.footer />

</div> <!-- wrapper-->
    <script src="/js/lib/jquery-ui.min.js"></script>
    <script src="/js/plugins/slick-carousel/slick.min.js"></script>
    <script src="/js/lib/masonry.pkgd.min.js"></script>
    <script src="/js/libs.min.js"></script>
    <script src="/js/script.js"></script>
@yield('scripts')

</body>

</html>
