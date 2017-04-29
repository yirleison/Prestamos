@extends('layouts.app')

@section('contenido')

  @section('titulo')
    <div class="titulo-usuario"><h2 class="">Registro Usuarios</h2></div>
  @endsection

  <div class="row ">
    <div class="col-md-12 col-md-offset-9 col-sm-12 col-sm-offset-9 col-xs-12 col-lg-12 col-lg-offset-9">

      @section('botones')
        <a class="btn btn-primary btn-xs" id="registroUsuario"  data-toggle="modal" data-target="#contact">
          <i class="fa fa-users" aria-hidden="true"> Registrar Usuario</i>
        </a>
      @endsection

      <div class="col-md-7 col-md-offset-3 modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
        <div class="modal-global">
          <div class="panel panel-primary">
            <div class="block-header bg-primary-dark">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="titilo-modal-usuario" id="contactLabel"><i class="fa fa-users" aria-hidden="true"></i>
                Registro Usuario</h4>
              </div>
              <form action="#" id="formulario-usuario"  accept-charset="utf-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <div class="modal-body" style="padding: 5px;">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                      <label for="">Nombre</label>
                      <input class="form-control" name="nombre" id="nombre" placeholder="Nombre Usuario" type="text"  />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                      <label for="">E-mail</label>
                      <input class="form-control" name="email" id="email" placeholder="Email" type="email"  />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                      <label for="">Password</label>
                      <input class="form-control" name="password" id="password" placeholder="Password" type="password"  />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                      <label for="">Rol</label>
                      {!!Form::select('rol',$roles,null,['class' => 'form-control','id'=>'rol','placeholder'=>'Seleccione'])!!}
                  </div>
                  </div>
                </div>
                <div class="panel-footer" style="margin-bottom:-14px;">
                  <input type="submit" id="btn-registrar"  class="btn btn-primary" value="Registrar"/>
                  <!--<span class="glyphicon glyphicon-ok"></span>-->
                  <button style="float: right;" type="submit" class="btn btn-danger btn-close" data-dismiss="modal">Cerrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row ">
      <div class="col-md-12 col-xs-12 col-lg-12  margin-movil">
        <div class="block content-tabla table-responsive" >
          <div class="block-content">
                <table class="table table-bordered table-striped table-responsive tbl_usuario text-center " id="users-table" style="width:100%">
                  <thead>
                    <tr >
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Correo</th>
                      <th class="text-center">Rol</th>
                      <th class="text-center">Estado</th>
                      <th class="acc_usuario">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>

    {{-- modal para actualizar --}}
    <div class="col-md-7 col-md-offset-3 modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
      <div class="modal-global">
        <div class="panel panel-primary">
          <div class="block-header bg-primary-dark">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="panel-title" id="contactLabel"><i class="fa fa-user" aria-hidden="true"></i>
              Actualizar Usuario</h4>
            </div>
            {!!Form::open(['id'=>'form-actualizar-usuario'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-body" style="padding: 5px;">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                  <label for="">Nombre</label>
                  <input class="form-control" name="nombre" id="nom" placeholder="Nombre Usuario" type="text"  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                  <label for="">Email</label>
                  <input class="form-control" name="email" id="ema" placeholder="Email" type="email"  />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                  <label for="">Password</label>
                  <input class="form-control" name="password" id="pass" placeholder="Password" type="password"  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                  {!!Form::label('Estado')!!}
                  {!!Form::select('esta', ['0' => 'Inactivo','1'=>'Activo'],'null',['class' => 'form-control','id'=>'esta'])!!}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                  {!!Form::label('Rol')!!}
                  {!!Form::select('rol',$roles,'null',['class' => 'form-control','id'=>'rol'])!!}
                </div>
              </div>
            </div>
            <div class="panel-footer" style="margin-bottom:-14px;">
              <input type="submit" id="actualizar" onclick="" class="btn btn-success" value="Actualizar"/>
              <!--<span class="glyphicon glyphicon-ok"></span>-->
              <button style="float: right;" type="submit" class="btn btn-danger btn-close" data-dismiss="modal">Cerrar</button>
            </div>
            {!!Form::close()!!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script>
  usuarios.tabla_usuarios();
  
  </script>

@endsection
