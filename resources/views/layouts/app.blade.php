<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
        <meta charset="utf-8">

        <title>Prestamos S.A.S</title>


        <meta name="description" content="OneUI - Admin Dashboard Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="/assets/img/favicons/favicon.png">

        <link rel="icon" type="image/png" href="/assets/img/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="/assets/img/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/assets/img/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/assets/img/favicons/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="/assets/img/favicons/favicon-192x192.png" sizes="192x192">

        <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/assets/img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/assets/img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Web fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap and OneUI CSS framework -->

        <link rel="stylesheet" href="/assets/css/bootstrap.css">


        <link rel="stylesheet" id="css-main" href="/assets/css/oneui.css">
        {{-- css para jquery dataTable --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>
        {{-- fin css para jquery dataTable --}}
        <link rel="stylesheet" href="/assets/pnotify/pnotify.custom.min.css"/>
        <link rel="stylesheet" href="/assets/alertifyjs/css/alertify.css"/>
        <link rel="stylesheet" href="/assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="/assets/js/plugins/select2/select2.css">
        <link rel="stylesheet" href="/assets/css/principal.css">

        <script>
        window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
        ]); ?>
        </script>
    </head>
<body>

    @include('layouts.sidebar')

</body>
     <!-- script para el login y en general -->
     <script src="/assets/js/core/jquery.min.js"></script>
     {{-- libreria jquery dataTable --}}
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
     <script src="/assets/js/core/bootstrap.min.js"></script>
     <script src="/assets/js/core/jquery.slimscroll.min.js"></script>
     <script src="/assets/js/core/jquery.scrollLock.min.js"></script>
     <script src="/assets/js/core/jquery.appear.min.js"></script>
     <script src="/assets/js/core/jquery.countTo.min.js"></script>
     <script src="/assets/js/core/jquery.placeholder.min.js"></script>
     <script src="/assets/js/core/js.cookie.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
     <script src="/assets/js/app.js"></script>
    <!-- script para el login y en general -->
    <script type="text/javascript" src="/assets/pnotify/pnotify.custom.min.js"></script>
    <script type="text/javascript" src="/assets/alertifyjs/alertify.min.js"></script>
    <script type="text/javascript" src="/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/assets/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-validate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-validate/additional-methods.min.js"></script>
    <script type="text/javascript" src="/assets/js/prestamos.js"></script>
    <script type="text/javascript" src="/assets/js/abonos.js"></script>
    <script type="text/javascript" src="/assets/js/validaciones.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/select2/select2.js"></script>



    @if (Session::has('notifier.notice'))
        <script>
            new PNotify({!! Session::get('notifier.notice') !!});
        </script>
    @endif


    @yield('scripts')

</html>
