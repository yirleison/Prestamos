
  <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
    <!-- Side Overlay-->
    <aside id="side-overlay">
      <!-- Side Overlay Scroll Container -->
      <div id="side-overlay-scroll">
        <!-- Side Header -->
        <div class="side-header side-content">
          <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
          <button class="btn btn-default pull-right" type="button" data-toggle="layout" data-action="side_overlay_close">
            <i class="fa fa-times"></i>
          </button>
          <span>
            <img class="img-avatar img-avatar32" src="/assets/img/avatars/avatar10.jpg" alt="">
            <span class="font-w600 push-10-l">{{Auth::user()->nombre}}</span>
          </span>
        </div>
        <!-- END Side Header -->

        <!-- Side Content -->
        <div class="side-content remove-padding-t">
          <!-- Notifications -->
          <div class="block pull-r-l">
            <div class="block-header bg-gray-lighter">
              <ul class="block-options">
                <li>
                  <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                </li>
                <li>
                  <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                </li>
              </ul>
              <h3 class="block-title">Notificaciones</h3>
            </div>
            <div class="block-content">
              <!-- Activity List -->
              <ul class="list list-activity" id="pnotificaciones">



              </ul>
              <div class="text-center">
                <small><a href="javascript:void(0)">Cargar mas..</a></small>
              </div>
              <!-- END Activity List -->
            </div>
          </div>
          <!-- END Notifications -->
        </div>
        <!-- END Side Content -->
      </div>
      <!-- END Side Overlay Scroll Container -->
    </aside>

    <!-- END Side Overlay -->

    <!-- Sidebar -->
    <nav id="sidebar">
      <!-- Sidebar Scroll Container -->
      <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
        <div class="sidebar-content">
          <!-- Side Header -->
          <div class="side-header side-content bg-white-op">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
              <i class="fa fa-times"></i>
            </button>
            <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
            <div class="btn-group pull-right">
              <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button">
                <i class="si si-drop"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right font-s13 sidebar-mini-hide">
                <li>
                  <a data-toggle="theme" data-theme="default" tabindex="-1" href="javascript:void(0)">
                    <i class="fa fa-circle text-default pull-right"></i> <span class="font-w600">Default</span>
                  </a>
                </li>
                <li>
                  <a data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" tabindex="-1" href="javascript:void(0)">
                    <i class="fa fa-circle text-amethyst pull-right"></i> <span class="font-w600">Amethyst</span>
                  </a>
                </li>
                <li>
                  <a data-toggle="theme" data-theme="assets/css/themes/city.min.css" tabindex="-1" href="javascript:void(0)">
                    <i class="fa fa-circle text-city pull-right"></i> <span class="font-w600">City</span>
                  </a>
                </li>
                <li>
                  <a data-toggle="theme" data-theme="assets/css/themes/flat.min.css" tabindex="-1" href="javascript:void(0)">
                    <i class="fa fa-circle text-flat pull-right"></i> <span class="font-w600">Flat</span>
                  </a>
                </li>
                <li>
                  <a data-toggle="theme" data-theme="assets/css/themes/modern.min.css" tabindex="-1" href="javascript:void(0)">
                    <i class="fa fa-circle text-modern pull-right"></i> <span class="font-w600">Modern</span>
                  </a>
                </li>
                <li>
                  <a data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" tabindex="-1" href="javascript:void(0)">
                    <i class="fa fa-circle text-smooth pull-right"></i> <span class="font-w600">Smooth</span>
                  </a>
                </li>
              </ul>
            </div>
            <a class="h5 text-white" href="index.html">
              <i class="fa fa-circle-o-notch text-primary"></i> <span class="h4 font-w600 sidebar-mini-hide">ne</span>
            </a>
          </div>
          <!-- END Side Header -->

          <!-- Side Content -->
          <div class="side-content">
            <ul class="nav-main">
              <li>
                <a href="{!!url('home')!!}"><i class="fa fa-home" aria-hidden="true"></i><span class="sidebar-mini-hide">Inicio</span></a>
              </li>
              <li>
                <a href="#" class="nav-submenu" data-toggle="nav-submenu"><i class="fa fa-users" aria-hidden="true"></i><span class="sidebar-mini-hide"> Usuarios</span></a>
                <ul>
                  <li><a href="/usuarios"><i class="fa fa-user"></i><span class="sidebar-mini-hide">Gestionar Usuarios</span></a></li>
                </ul>
              </li>
              <li>
                <a href="/clientes"><i class="fa fa-user-plus"></i></i><span class="sidebar-mini-hide">Clientes</span></a>
              </li>
              <li>
                <a href="#" class="nav-submenu" data-toggle="nav-submenu"><i class="fa fa-money" aria-hidden="true"></i><span class="sidebar-mini-hide"> Gestionar Prestamos</span></a>
                <ul>
                  <li><a href="/prestamos"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span class="sidebar-mini-hide">Asignar Prestamos</span></a></li>
                  <li><a href="/prestamo/consultar/cliente"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span class="sidebar-mini-hide">Consultar Prestamos</span></a></li>
                </ul>
              </li>
              <li>
                <a href="#" class="nav-submenu" data-toggle="nav-submenu"><i class="fa fa-money" aria-hidden="true"></i><span class="sidebar-mini-hide">Abonos</span></a>
                <ul>
                  <li><a href="/abono/prestamos"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span class="sidebar-mini-hide">Registrar Abono</span></a></li>
                  <li><a href="/consultar/abonos"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span class="sidebar-mini-hide">Consultar Abono</span></a></li>
                </ul>
              </li>
              <li>
                <a href="#" class="nav-submenu" data-toggle="nav-submenu"><i class="fa fa-money" aria-hidden="true"></i><span class="sidebar-mini-hide">Cartera</span></a>
                <ul>
                  <li><a href="/estado/cartera"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span class="sidebar-mini-hide">Estado Cartera</span></a></li>
                </ul>
              </li>


            </div>
            <!-- END Side Content -->
          </div>
          <!-- Sidebar Content -->
        </div>
        <!-- END Sidebar Scroll Container -->
      </nav>
      <!-- END Sidebar -->

      <!-- Header -->
      <header id="header-navbar" class="content-mini content-mini-full ">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right ">
          <li>
            <div class="btn-group">
              <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                <img src="/assets/img/avatars/avatar10.jpg" alt="Avatar">{{Auth::user()->nombre}}
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">Profile</li>
                <li>
                  <a tabindex="-1" href="base_pages_inbox.html">
                    <i class="si si-envelope-open pull-right"></i>
                    <span class="badge badge-primary pull-right">3</span>Inbox
                  </a>
                </li>
                <li>
                  <a tabindex="-1" href="base_pages_profile.html">
                    <i class="si si-user pull-right"></i>
                    <span class="badge badge-success pull-right">1</span>Profile
                  </a>
                </li>
                <li>
                  <a tabindex="-1" href="javascript:void(0)">
                    <i class="si si-settings pull-right"></i>Settings
                  </a>
                </li>
                <li class="divider"></li>
                <li class="dropdown-header">Actions</li>
                <li>
                  <a tabindex="-1" href="base_pages_lock.html">
                    <i class="si si-lock pull-right"></i>Lock Account
                  </a>
                </li>
                <li>
                  <div style="" class=" hidden-xs">
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary btn-block">
                     Cerrar sesión  <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                     <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="side_overlay_toggle" type="button">
              <i class="fa fa-bell" style="font-size: 17px;"></i>
              <span class="label label-danger" id="can_clientes" title="Clientes en mora" ></span>
            </button>
          </li>
        </ul>
        <!-- END Header Navigation Right -->

        <!-- Header Navigation Left -->
        <ul class="nav-header pull-left ">
          <li class="hidden-md hidden-lg">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
              <i class="fa fa-navicon"></i>
            </button>
          </li>
          <li class="hidden-xs hidden-sm">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
              <i class="fa fa-ellipsis-v"></i>
            </button>
          </li>
          <li>
            <!-- Opens the Apps modal found at the bottom of the page, before including JS code -->
            <button class="btn btn-default pull-right" data-toggle="modal" data-target="#apps-modal" type="button">
              <i class="si si-grid"></i>
            </button>
          </li>
      {{-- <li class="visible-xs">
        <!-- Toggle class helper (for .js-header-search below), functionality initialized in App() -> uiToggleClass() -->
        <button class="btn btn-default" data-toggle="class-toggle" data-target=".js-header-search" data-class="header-search-xs-visible" type="button">
          <i class="fa fa-search"></i>
        </button>
      </li> --}}
      <li class="titulo">
        @yield('botones')
      </li>

    </ul>
    <div class="row titulo-usuario">
      @yield('titulo')
    </div>
    <!-- END Header Navigation Left -->
  </header>
  <!-- END Header -->

  <!-- Main Container -->
  <main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">

      <!-- END Page Header -->

      <!-- Page Content -->
      <div class="content">
        @yield('contenido')
      </div>
      <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <!--<footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
      <div class="pull-right">
        Crafted with <i class="fa fa-heart text-city"></i> by <a class="font-w600" href="http://goo.gl/vNS3I" target="_blank">pixelcave</a>
      </div>
      <div class="pull-left">
        <a class="font-w600" href="javascript:void(0)" target="_blank">OneUI 1.0</a> &copy; <span class="js-year-copy"></span>
      </div>
    </footer>
    -->
    <!-- END Footer -->
  </div>


  <!-- END Page Container -->

  <!-- Modal para notificaciones del estado de cuentas de los clientes -->
  <div class="row">
    <div class="col-md-10 col-sm-10 col-lg-10">
      <div class="modal fade" style="margin-right:200px;" id="modal-noti-cliente" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content col-md-10 col-md-offset-2 col-sm-10 col-lg-10 modal-global">
            <div class="block-header bg-primary-dark">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="t_cliente"><i class="fa fa-credit-card-alt" ide="" aria-hidden="true"></i></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12" id="tbl_cuota_cliente">

                </div>
              </div>
            </div>
          {!! Form::close() !!}
          <div id="area-example"></div>
          <hr>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- END Modal para estado cuotas clientes -->

  <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
<script src="/assets/js/moment.js"></script>
<script type="text/javascript" src="/assets/js/client.js"></script>
