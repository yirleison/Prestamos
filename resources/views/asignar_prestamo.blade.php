@extends('layouts.app')

@section('contenido')
  @section('titulo')
    <div class="row titulo-prestamo" >
      <div class="col-md-12 col-xs-12 col-lg-12">
        <h2>Gestionar Prestamos</h2>
      </div>
    </div>
  @endsection

  <div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12  margin-movil">
      <div class="block content-tabla table-responsive">
        <div class="block-content table-responsive ">
          <table class="table table-bordered table-striped table-responsive  " id="users-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">Documento</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Primer apellido</th>
                <th class="text-center">Celular</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>

      </div>

    </div>
  </div>

  <div class="row">
    <div class="col-md-10 col-sm-10 col-lg-10">
      <div class="modal fade" id="modal-prestamos-crear" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content col-md-10 col-md-offset-2 col-sm-10 col-lg-10 modal-global">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>    Crear Prestamo</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    {!!Form::label('Nombre')!!}
                    {!!Form::input('text','nombres',null,['class'=>'form-control','id'=>'nombres'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    {!!Form::label('Documento')!!}
                    {!!Form::input('text','documento',null,['class'=>'form-control','id'=>'documento'])!!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {!!Form::label('Valor')!!}
                    {!!Form::number('valor',null,['class'=>'form-control','id'=>'valor'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    {!!Form::label('plazo')!!}
                    {!!Form::number('plazo',null,['class'=>'form-control', 'id'=>'plazo'])!!}
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
                <div class="col-md-6" >
                  <div class="form-group">
                    {!!Form::label('Valor  intereses')!!}
                    {!!Form::number('valor-interes',null,['class'=>'form-control', 'id'=>'valor-interes'])!!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {!!Form::label('Valor a pagar')!!}
                    {!!Form::number('valor-pagar',null,['class'=>'form-control', 'id'=>'valor-pagar'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12" >
                  <div class="form-group">
                    {!!Form::label('Fecha')!!}
                    <div class="input-group date" id="sandbox-container">
                      <input type="text" name="fecha_prestamo" data-date-format='yy-mm-dd' class="form-control" id="fecha_prestamo"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
            </div>
            <div id="area-example"></div>
            <div class="modal-footer">
              {!!Form::button('Registrar',['class'=>'btn btn-primary','onclick'=>'prestamos.crear_prestamo();'])!!}
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script type="text/javascript">
  prestamos.tabla_prestamos_clientes();
  $('#sandbox-container').datepicker({
    language: "es",
    format: 'yyyy-mm-dd'
  });
  </script>
@endsection
