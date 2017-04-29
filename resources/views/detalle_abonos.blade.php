@extends('layouts.app')

@section('contenido')

@section('titulo')
<div class="row titulo-prestamo" >
  <div class="col-md-12 col-xs-12 col-lg-12">
    <h2>Detalle Abonos</h2>
  </div>
</div>
@endsection

<div class="row">
  <div class="col-md-2">
    <a href="/consultar/abonos" class="fa fa-arrow-left btn btn-info btn-regresar"> Regresar</a>
  </div> 
</div>

<div class="row nomb_cl_abn">
   <div class="col-md-5">
    <h3>{{$nombre}}</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-xs-12 col-lg-12  margin-movil">
    <div class="block content-tabla table-responsive">
      <div class="block-content table-responsive ">
        <table class="display table table-hover table table-striped table-borderless table-header-bg tabla-prestamos text-center " id="tbl_abono" style="width:100%">
          <thead>
            <tr>
              <th class="text-center">Fecha</th>
              <th class="text-center">Valor Abono</th>
              <th class="text-center">Saldo P.</th>
              <th class="text-center">Abono I</th>
              <th class="text-center">Abono C.</th>
              <th class="text-center">Interes Abono</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody id="tbody">
           @foreach ($de_pre as $value)
           <tr>
            <td>{{$value->fecha}}</td>
            <td>{{$value->valor_abono}}</td>
            <td>{{$value->saldo_prestamo}}</td>
            <td>{{$value->abono_interes}}</td>
            <td>{{$value->abono_capital}}</td>
            <td>{{$value->nuevo_interes_mensual}}</td>
            <td><a href="#" class="bt btn-primary btn-xs botones" id="editar_abono" title="Editar abono" ><i class="fa fa-edit" onclick="abonos.editar({{$value->id_abono}})" aria-hidden="true"></i>
            </a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

{{-- modal para editar el  abono --}}
<div class="row">
  <div class="col-md-9 col-sm-12 col-lg-12">
    <div class="modal fade" id="md-editar-abono" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg">
        <div class="modal-content col-md-10 col-md-offset-2 col-sm-10 col-lg-10 modal-global">
          <div class="block-header bg-primary-dark">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="" id="myModalLabel"><i class="fa fa-credit-card-alt" aria-hidden="true"> </i>      Editar Abono</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!!Form::label('Valor')!!}
                  {!!Form::number('valor_abono',null,['class'=>'form-control', 'id'=>'valor_abono'])!!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!!Form::label('Fecha')!!}
                  <div class="input-group date" id="sandbox-container">
                    <input type="text" name="fecha" data-date-format='yy-mm-dd' class="form-control" id="fecha"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                  </div>
                </div>
              </div>
            </div>          
          </div>          
          {!! Form::close() !!}
          <div id="area-example"></div>
          <div class="modal-footer">
            {!!Form::button(' Actualizar',['class'=>'btn btn-primary fa fa-database','onclick'=>'abonos.actualizar();', "style"=>"font-weight:bold"])!!}
            <button type="button" class="btn btn-danger fa fa-remove" style="font-weight:bold" data-dismiss="modal"> Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script type="text/javascript">
  abonos.Init();
</script>
@endsection
