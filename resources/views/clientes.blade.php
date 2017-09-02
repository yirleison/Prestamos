@extends('layouts.app')

@section('contenido')

  @section('titulo')
    <div class="titulo-cliente"><h2>Registro Clientes</h2></div>
  @endsection

    <div class="row">
      <div class="col-md-12 col-md-offset-9 col-sm-12 col-sm-offset-9 col-xs-12 col-lg-12 col-lg-offset-9">

        @section('botones')
          <a class="btn btn-primary btn-xs "  class="btn btn-primary" data-toggle="modal" data-target=".charts-modal"><i class="fa fa-users" aria-hidden="true"></i>
            Crear Cliente
          </a>
        @endsection

        {{-- Modal registro cliente --}}
        <div class="modal fade charts-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content modal-global">
              <div class="block-header bg-primary-dark">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="md_crearCliente"><i class="fa fa-user" aria-hidden="true"></i> Registro Cliente</h4>
              </div>
              <div class="modal-body">
                {!! Form::open(['id'=>'form_cliente']) !!}
                <div class="row">
                  <div class="col-md-12"  style="padding-bottom: 10px">
                    {!!form::label('Nombre')!!}
                    {!!form::text('nombre',null,['class'=>'form-control','id'=>'nombre','placeholder'=>'Nombre'])!!}
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6"  style="padding-bottom: 10px">
                    {!!form::label('Primer apellido')!!}
                    {!!form::text('primer_apellido',null,['class'=>'form-control','id'=>'primer_apellido','placeholder'=>'Primer apellido'])!!}
                  </div>
                  <div class="col-md-6">
                    {!!form::label('Segundo apellido')!!}
                    {!!form::text('segundo_apellido',null,['class'=>'form-control','id'=>'segundo_apellido','placeholder'=>'Segundo apellido'])!!}
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6"  style="padding-bottom: 10px">
                    {!!Form::label('Tipo documento')!!}
                    {!!form::select('id_tipo_documento',$document,null,['class'=>'form-control','id'=>'tipo_documento','placeholder'=>'Seleccione'])!!}
                  </div>
                  <div class="col-md-6">
                    {!!form::label('Documento')!!}
                    {!!form::text('documento',null,['class'=>'form-control','id'=>'documento','placeholder'=>'Documento'])!!}
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Dirección')!!}
                  {!!form::text('direccion',null,['class'=>'form-control','id'=>'direccion','placeholder'=>'Direcció'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Teléfono')!!}
                  {!!form::text('telefono',null,['class'=>'form-control','id'=>'telefono','placeholder'=>'Teléfono'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Celular')!!}
                  {!!form::text('celular',null,['class'=>'form-control','id'=>'celular','placeholder'=>'Celular'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Email')!!}
                  {!!form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Email'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!Form::label('Tipo cuenta')!!}
                  {!!form::select('id_tipo_cuenta',$cuenta,null,['class'=>'form-control','id'=>'tipo_cuenta','placeholder'=>'Seleccione'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Cuenta')!!}
                  {!!form::text('cuenta',null,['class'=>'form-control','id'=>'cuenta','placeholder'=>'Numero cuenta'])!!}
                </div>
              </div>
            </div>
            <div id="area-example"></div>
            <div class="modal-footer">
               <input type="submit" id="btn-registrar"  class="btn btn-primary" value="Registrar"/>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>


  <div class="row">
  <div class="col-md-12 col-xs-12 col-lg-12 margin-movil">
  <div class="block content-tabla table-responsive" >
    <div class="block-content">
          <table class="table table-bordered table-striped table-responsive tabla-prestamos" id="tbl_cliente" style="width:100%">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>primer apellido</th>
                <th>Documento</th>
                <th>Celular</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      <!-- DataTables init on table by adding .js-dataTable-simple class, functionality initialized in js/pages/base_tables_datatables.js -->
    </div>
  </div>
  </div>

  <!-- END Dynamic Table Simple -->

  {{-- modal para actualizar --}}
  <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
      <div class="modal fade" id="mod_editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content modal-global">
            <div class="block-header bg-primary-dark">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user" aria-hidden="true"></i> Información Cliente</h4>
            </div>
            <div class="modal-body">
                  {!! Form::open(['id'=>'form_actualizar_cliente']) !!}
              <div class="row">
                <div class="col-md-6"  style="padding-bottom: 10px">
                  {!!form::label('Nombre')!!}
                  {!!form::text('nombre_editar',null,['class'=>'form-control','id'=>'nombre_editar','placeholder'=>'Nombre'])!!}
                </div>
                <div class="col-md-6"  style="padding-bottom: 10px">
                  {!!form::label('Primer apellido')!!}
                  {!!form::text('primer_apellido_editar',null,['class'=>'form-control','id'=>'primer_apellido_editar','placeholder'=>'Primer apellido'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  {!!form::label('Segundo apellido')!!}
                  {!!form::text('segundo_apellido_editar',null,['class'=>'form-control','id'=>'segundo_apellido_editar','placeholder'=>'Segundo apellido'])!!}
                </div>
                <div class="col-md-6"  style="padding-bottom: 10px">
                  {!!Form::label('Tipo documento')!!}
                  {!!form::select('id_tipo_documento_editar',$document,'Seleccione',['class'=>'form-control','id'=>'tipo_documento_editar','placeholder'=>'Seleccione'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  {!!form::label('Documento')!!}
                  {!!form::text('documento_editar',null,['class'=>'form-control','id'=>'documento_editar','placeholder'=>'Documento'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Dirección')!!}
                  {!!form::text('direccion_editar',null,['class'=>'form-control','id'=>'direccion_editar','placeholder'=>'Direcció'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Teléfono')!!}
                  {!!form::text('telefono_editar',null,['class'=>'form-control','id'=>'telefono_editar','placeholder'=>'Teléfono'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Celular')!!}
                  {!!form::text('celular_editar',null,['class'=>'form-control','id'=>'celular_editar','placeholder'=>'Celular'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Email')!!}
                  {!!form::text('email_editar',null,['class'=>'form-control','id'=>'email_editar','placeholder'=>'Email'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!Form::label('Tipo cuenta')!!}
                  {!!form::select('id_tipo_cuenta',$cuenta,null,['class'=>'form-control','id'=>'tipo_cuenta_editar','placeholder'=>'Seleccione'])!!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Cuenta')!!}
                  {!!form::text('cuenta_editar','cuenta_id',['class'=>'form-control','id'=>'cuenta_editar','placeholder'=>'Numero cuenta'])!!}
                </div>
                <div class="col-md-6" style="padding-bottom: 10px">
                  {!!form::label('Estado')!!}
                  {!!form::select('esatdo',['0'=>'Inactivo','1'=>'Activo'],null,['class'=>'form-control','id'=>'estado_editar'])!!}
                </div>
              </div>
            </div>
            <div id="area-example"></div>
            <div class="modal-footer">
              {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script>
  cliente.tabla_clientes();
  validarCliente.cliente();
  validarCliente.editar_cliente();
  </script>

@endsection
