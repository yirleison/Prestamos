@extends('layouts.app')

@section('contenido')
  @section('titulo')
    <div class="row titulo-prestamo" >
      <div class="col-md-12 col-xs-12 col-lg-12">
        <h2>Consultar Prestamos</h2>
      </div>
    </div>
  @endsection

  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <select class="form-control" id="prestamo" onchange="prestamos.consultar_prestamo()" name="">
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
          <table class="display table table table-striped table-borderless table-header-bg tabla-prestamos text-center " id="tbl-prestamo-cerrado" style="width:100%">
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

  <div class="row">
  <div class="col-md-12 col-xs-12 col-lg-12  margin-movil">
    <div class="block content-tabla table-responsive">
      <div class="block-content table-responsive ">
        <table class="table table-striped text-center" id="" style="width:100%">
          <thead>
            <tr>
              <th class="text-center">Cartera Capital</th>
              <th class="text-center">Abono Devengado</th>
              <th class="text-center">Interese Devengado</th>

            </tr>
          </thead>
          <tbody id="tbody_p">
           
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

  {{-- modal para editar prestamo --}}
  <div class="row">
    <div class="col-md-10 col-sm-10 col-lg-10">
      <div class="modal fade" id="md-editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content col-md-10 col-md-offset-2 col-sm-10 col-lg-10 modal-global centrar_modal">
            <div class="block-header bg-primary-dark">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="" id="myModalLabel"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>    Editar Prestamo</h4>
            </div>
           <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!!Form::label('Nombre')!!}
                  {!!Form::input('text','nombres',null,['class'=>'form-control','id'=>'nombres'])!!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!!Form::label('Documento')!!}
                  {!!Form::input('text','documento',null,['class'=>'form-control','id'=>'documento'])!!}
                </div>
              </div>
            </div>
            <div class="row">   
              <div class="col-md-6">
                <div class="form-group">
                  {!!Form::label('Valor')!!}
                  {!!Form::number('valor',null,['class'=>'form-control','id'=>'valor'])!!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!!Form::label('Tasa interes')!!}
                  <div class="input-group">
                    {!!Form::select('id',$interes,null,['class'=>'form-control','onchange'=>'prestamos.calcular()','id'=>'interes','placeholder'=>'Seleccione'])!!}
                    <span class="input-group-addon group-ip"><label for="">%</label></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Interes Mensual</label>
                 <input type="text" class="form-control" name="interes_mensual" id="interes_mensual">
               </div>
             </div>
             <div class="col-md-6">
              <div class="form-group">
                {!!Form::label('Fecha')!!}
                <div class="input-group date" id="sandbox-container">
                  <input type="text" name="fecha_prestamo" data-date-format='yy-mm-dd' class="form-control" id="fecha_prestamo"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
              </div>
            </div>
          </div>
        </div>
            {!! Form::close() !!}
            <div id="area-example"></div>
            <div class="modal-footer">
              {!!Form::button(' Actualizar',['class'=>'btn btn-primary fa fa-database','onclick'=>'prestamos.actualizar_prestamo();', "style"=>"font-weight:bold"])!!}
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

  $('#sandbox-container').datepicker({
    language: "es",
    format: 'yyyy-mm-dd'
  });

  $("#prestamo").select2();
  </script>
@endsection
