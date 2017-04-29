@extends('layouts.app')

@section('contenido')
  @section('titulo')
    <div class="row titulo-prestamo" >
      <div class="col-md-12 col-xs-12 col-lg-12">
        <h2>Consultar Abonos</h2>
      </div>
    </div>
  @endsection

  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <select class="form-control" id="prestamo" onchange="abonos.consul_pr_abn()" name="">
          <option value="">Seleccione</option>
          @foreach ($clientes as $key => $value)
            <option value="{!!$value->id!!}">{!!$value->nombre!!}  {!! $value->primer_apellido !!}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12  margin-movil">
      <div class="block content-tabla table-responsive">
        <div class="block-content table-responsive ">
          <table class="display table table table-striped table-borderless table-header-bg tabla-prestamos text-center " id="tbl_abono" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">Documento</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Tasa Interes</th>
                <th class="text-center">Interes Mensual</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script type="text/javascript">

  $('#sandbox-container').datepicker({
    language: "es",
    format: 'yyyy-mm-dd'
  });

  $("#prestamo").select2();
   abonos.Init();
  </script>
@endsection
