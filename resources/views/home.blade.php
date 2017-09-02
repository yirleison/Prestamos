<link rel="stylesheet" href="/assets/css/style.css">
@extends('layouts.app')
@section('contenido')

<div class="row clearfix">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="a">
  <a href="/usuarios">
    <div class="info-box bg-success hover-expand-effect">
      <div class="icon">
        <i class="material-icons">person_add</i>
      </div>

      <div class="content">
        <div class="text"><h4 style="color:white;cursor: pointer;">Usuarios</h4></div>
        <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20" style="color:white">{{$cant_user}}</div>
      </div>
    </div>
      </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a href="/clientes">
    <div class="info-box bg-cyan hover-expand-effect">
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <div class="content">
        <div class="text"><h4 style="color:white;cursor: pointer;">Clientes</h4></div>
        <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">{{$cnat_clientes}}</div>
      </div>
    </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a href="/prestamos">
    <div class="info-box bg-light-green hover-expand-effect">
      <div class="icon">
        <i class="fa fa-usd"></i>
      </div>
      <div class="content">
        <div class="text"><h4 style="color:white;cursor: pointer;">Prestamos</h4></div>
      </div>
    </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a href="/abono/prestamos">
    <div class="info-box bg-success hover-expand-effect">
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <div class="content">
        <div class="text text-justify"><h4 style="color:white">Abonos</h4></div>
      </div>
    </div>
  </div>
  </a>
</div>
<div class="row">
  <div class="col-md-12 col-xs-12 col-lg-12  margin-movil">
    <div class="block content-tabla table-responsive">
      <div class="block-content table-responsive ">
        <table class="display table table-hover table table-striped table-borderless table-header-bg tabla-prestamos text-center " id="tbl_abono" style="width:100%">
          <thead>
            <tr>
              <th class="text-center">Mes</th>
              <th class="text-center">Ganancia Intereses</th>
              <th class="text-center">Cartera Capital </th>
              <th class="text-center">Total Devengado </th>
            </tr>
          </thead>
          <tbody id="tbody">

            @foreach ($d as $k => $value)

            <?php $d_intereses = 0; $d_capital =0; $t_devengado = 0; $mes = ""; ?>

            @foreach ($value as $k1 => $v1)

            <?php if ($k1 > 0 && $k1 <= 12) {

              foreach ($v1 as $k2 => $v2) {

                 $d_intereses += $v2->abono_interes;
                 $d_capital += $v2->abono_capital;
                 $t_devengado = ( $d_intereses + $d_capital);
              }

            }
              $mes = $value["mes"];
            ?>
            {{-- expr --}}
            @endforeach
            <tr><td><?php echo $mes?></td><td> <?php echo $d_intereses?></td><td> <?php echo $d_capital ?> </td><td> <?php echo $t_devengado ?> </td></tr>

            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection
