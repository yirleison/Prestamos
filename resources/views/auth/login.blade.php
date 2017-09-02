<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>OneUI - shared on themelock.com</title>

    <meta name="description" content="OneUI - Admin Dashboard Template & UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

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

    <!-- OneUI CSS framework -->
    <link rel="stylesheet" id="css-main" href="/assets/css/oneui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
          ]); ?>
      </script>

      <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
      <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
      <!-- END Stylesheets -->
  </head>
  <body id="page-container">
    <!-- Login Content -->
    <div class="content overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <!-- Login Block -->
                <div class="block block-themed animated fadeIn">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Ingresar</h3>
                    </div>
                    <div class="block-content block-content-full block-content-narrow">
                        <!-- Login Title -->
                        <h1 class="h2 font-w600 push-30-t push-5">Bienvenido</h1>
                        <p>Por favor Ingresa</p>
                        <!-- END Login Title -->

                        <!-- Login Form -->
                        <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        
                            <div class=" form-horizontal push-30-t push-50" >
                               
                               <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="text" id="email" name="email">
                                        <label for="login-username">Nombre de usuario</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="password" id="password" name="password">
                                        <label for="login-password">Contraseña</label>
                                    </div>
                                </div>
                            </div>
                          <!--  <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox" id="login-remember-me" name="login-remember-me"><span></span> Recordar ?
                                    </label>
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <div class="col-xs-7 col-sm-7 col-md-4">
                                    <button type="submit" id="btn_login"  class="btn btn-block btn-primary"  style="padding-left: 3px;"><i class="si si-login pull-right"></i>       Ingresar</button>
                                </div>
                            </div>
                            <div class="alert alert-error alert-danger" role="alert" id="success-alert" style="display: none; padding: 0;
                            margin: 0;
                            font-size: 12px;
                            font-weight: bold;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error! </strong>  
                        </div>
                    </div>
                
                <!-- END Login Form -->
            </div>
        </div>
        <!-- END Login Block -->
    </div>
</div>
</div>
<!-- END Login Content -->

<!-- Login Footer -->

<!-- END Login Footer -->

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="/assets/js/core/jquery.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>

<script src="/assets/js/core/jquery.slimscroll.min.js"></script>
<script src="/assets/js/core/jquery.scrollLock.min.js"></script>
<script src="/assets/js/core/jquery.appear.min.js"></script>
<script src="/assets/js/core/jquery.countTo.min.js"></script>
<script src="/assets/js/core/jquery.placeholder.min.js"></script>
<script src="/assets/js/core/js.cookie.min.js"></script>
<script src="/assets/js/app.js"></script>


<!-- Page JS Plugins -->
<script src="/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Page JS Code -->
<script src="/assets/js/pages/base_pages_login.js"></script>
<script type="text/javascript" src="/assets/js/login_prestamo.js"></script>
</body>
</html>

@section('scripts')

@stop