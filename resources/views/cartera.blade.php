
@extends('layouts.app')

@section('contenido')

@section('titulo')
<div class="row titulo-prestamo" >
  <div class="col-md-12 col-xs-12 col-lg-12">
    <h2>Estado Cartera</h2>
  </div>
</div>
@endsection

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
