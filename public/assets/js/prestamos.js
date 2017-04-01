
//  Declaracion variables.....
var tabla = null;
var id_cliente_editar,
cuenta_id,
id_usuario,
cliente_id;
var valor = 0 ,tasa_interes,valor_interes = 0,total_intereses = 0,valor_pagar = 0,plazo;

//MEDIA QUERIES
if (window.matchMedia("(max-width:412px)").matches){
  $("#registroUsuario i").html(" Usuario");
  $(".titulo-usuario").css('margin-right','10px');
}

var usuarios = {

  tabla_usuarios:function(){
    $(function() {
      tabla = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/usuarios/tabla/usuarios',
        columns: [
          { data: 'nombre', name: 'nombre' },
          { data: 'email', name: 'email' },
          { data: 'rol', name: 'rol' },
          { data: 'estado', name: 'estado' },
          {data: 'action', name: 'action',class:'td', orderable: false, searchable: false}
        ],
        'language': traduccion
      });
    });

    var traduccion = {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    };
  },

  registrar_usuario:function () {
    var datos = {
      nombre: $('#nombre').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      rol: $('#rol').val(),
    };

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '/usuarios',
      type: 'post',
      data: datos,
    }).done(function(success){
      if(success!= null){
        new PNotify({
          title: "Felicidades",
          text: "Registro ha sido exitoso",
          type: "success",
        });
      }else {
        new PNotify({
          title: "Error",
          text: "No se pudo guardar el usuario",
          type: "danger",
        });
      }
      tabla.ajax.reload();
      console.log(success);
    });
  },

  editar_usuario:function (id) {
    // metodo para editar....
    var nombre= $('#nombre'),
    email= $('#email'),
    password = $('#password'),
    datos = id;
    id_usuario = id;
    $.ajax({
      url: '/usuarios/'+datos+'/edit',
      type: 'get',
      dataType: 'json',
    }).done(function(success){
      console.log(success);
      var option;
      var da = success;
      $('#nom').val(da.nombre);
      $('#ema').val(da.email);
      $('#pass').val(da.password);
      $('#roll').val(da.rol_id);
      $('#esta').val(da.estado);
      console.log(da.rol_id);
      // abro el modal para actualizar con los datos cargados...
      $('#modal_edit').modal();
    });

  },

  actualizar_usuario:function () {
    var datos = {
      nombre:  $('#nom').val(),
      email:  $('#ema').val(),
      password:  $('#pass').val(),
      rol:  $('#rol').val(),
      estado:  $('#esta').val()
    };
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '/usuarios/'+id_usuario,
      type: 'put',
      dataType: 'json',
      data:datos
    })
    .done(function(dato) {
      if(dato.mensaje == 1){
        new PNotify({
          title: "Actualización",
          text: "Actualización realizada con exito",
          type: "info",
        });
      }
      if (dato.mensaje == 2) {
        new PNotify({
          title: "Actualización",
          text: "No se pudo realizar la Actualización",
          type: "danger",
        });
      }
      $('#modal_edit').modal('toggle');
    });

  },

  cambiar_estado:function (id,estado) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/usuarios/estado/'+id,
      type: 'post',
      dataType: 'json',
      data: {estado:estado}
    })
    .done(function(estado) {
      if (estado.mensaje==1) {
        new PNotify({
          title: "Actualización",
          text: "Se ha cambiado el estado",
          type: "success",
        });
        tabla.ajax.reload();
      }else {
        if (estado.mensaje==2) {
          new PNotify({
            title: "Actualización",
            text: "Ha ocurrido un error no se pudo realizar esta operación",
            type: "info",
          });
        }
      }
    });
  },

  eliminar:function (id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    (new PNotify({
      title: 'Confirmacion eliminación',
      text: 'Esta seguro que desea eliminar este registro?',
      icon: 'glyphicon glyphicon-question-sign',
      hide: false,
      type:"info",
      confirm: {
        confirm: true
      },
      buttons: {
        closer: 'false',
        sticker: false
      },
      history: {
        history: false
      },
      addclass: 'stack-modal',
      stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
    })).get().on('pnotify.confirm', function(){
      $.ajax({
        url: '/usuarios/'+id,
        type: 'DELETE',
        dataType: 'json'
      })

      .done(function(success) {
        tabla.ajax.reload();
        console.log(success);
      });
    }).on('pnotify.cancel', function(){

    });

  }
};


var cliente = {

  tabla_clientes:function () {

    $(function() {

      tabla = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/clientes/tabla/clientes',
        columns: [
          { data: 'nombre', name: 'nombre' },
          { data: 'primer_apellido', name: 'primer_apellido' },
          { data: 'documento', name: 'documento' },
          { data: 'celular', name: 'celular' },
          { data: 'estado', name: 'estado' },
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        'language': traduccion
      });
    });

    var traduccion = {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    };
  },

  registrar:function(){

    var datos = {
      nombre: $('#nombre').val(),
      primer_apellido: $('#primer_apellido').val(),
      segundo_apellido: $('#segundo_apellido').val(),
      tipo_documento: $('#tipo_documento').val(),
      documento: $('#documento').val(),
      direccion: $('#direccion').val(),
      telefono: $('#telefono').val(),
      celular: $('#celular').val(),
      email: $('#email').val(),
      tipo_cuenta: $('#tipo_cuenta').val(),
      cuenta: $('#cuenta').val()
    };
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '/clientes',
      type: 'post',
      dataType: 'json',
      data: datos
    })
    .done(function(respuesta) {
      if(respuesta.respuesta==1){
        new PNotify({
          title: "Registro",
          text: "Registro exitoso",
          type: "success",
        });

        $('#nombre').val(''),
        $('#primer_apellido').val(''),
        $('#segundo_apellido').val(''),
        $('#tipo_documento').val(''),
        $('#documento').val(''),
        $('#direccion').val(''),
        $('#telefono').val(''),
        $('#celular').val(''),
        $('#email').val(''),
        $('#tipo_cuenta').val(''),
        $('#cuenta').val('')

        tabla.ajax.reload();

      }if(respuesta.respuesta==2){
        new PNotify({
          title: "Registro",
          text: "Ha ocurrido un error ",
          type: "info",
        });
      } if(respuesta.respuesta==3){
        new PNotify({
          title: "Registro",
          text: "No se ha podido realizar el registro",
          type: "info",
        });
      }
    });
  },

  editar:function(id){

    var
    nombre_editar = $('#nombre_editar'),
    primer_apellido_editar = $('#primer_apellido_editar'),
    segundo_apellido_editar = $('#segundo_apellido_editar'),
    tipo_documento_editar = $('#tipo_documento_editar'),
    documento_editar = $('#documento_editar'),
    direccion_editar = $('#direccion_editar'),
    telefono_editar = $('#telefono_editar'),
    celular_editar = $('#celular_editar'),
    email_editar = $('#email_editar'),
    tipo_cuenta_editar = $('#tipo_cuenta_editar');
    cuenta_editar = $('#cuenta_editar');
    estado_editar = $('#estado_editar');

    $.ajax({
      url: '/clientes/'+id+'/edit',
      type: 'GET',
      dataType: 'json'
    })
    .done(function(datos) {
      console.log(datos);
      id_cliente_editar = datos.cliente[0].id;
      nombre_editar.val(datos.cliente[0].nombre);
      primer_apellido_editar.val(datos.cliente[0].primer_apellido);
      segundo_apellido_editar.val(datos.cliente[0].segundo_apellido);
      tipo_documento_editar.val(datos.cliente[0].tipo_documento_id);
      documento_editar.val(datos.cliente[0].documento);
      direccion_editar.val(datos.cliente[0].direccion);
      telefono_editar.val(datos.cliente[0].telefono);
      celular_editar.val(datos.cliente[0].celular);
      email_editar.val(datos.cliente[0].email);
      tipo_cuenta_editar.val(datos.cliente[0].id_tipo_cuenta);
      cuenta_editar.val(datos.cliente[0].cuenta);
      cuenta_id = datos.cliente[0].cuenta_id;
      estado_editar.val(datos.cliente[0].estado);

    });
    $('#mod_editar').modal();
  },

  actualizar_datos:function () {
    let datos = {
      id_cliente_editar: id_cliente_editar,
      nombre_editar: $('#nombre_editar').val(),
      primer_apellido_editar: $('#primer_apellido_editar').val(),
      segundo_apellido_editar: $('#segundo_apellido_editar').val(),
      tipo_documento_editar: $('#tipo_documento_editar').val(),
      documento_editar: $('#documento_editar').val(),
      direccion_editar: $('#direccion_editar').val(),
      telefono_editar: $('#telefono_editar').val(),
      celular_editar: $('#celular_editar').val(),
      email_editar: $('#email_editar').val(),
      tipo_cuenta_editar: $('#tipo_cuenta_editar').val(),
      cuenta_editar: $('#cuenta_editar').val(),
      cuenta_id: cuenta_id,
      estado_editar: estado_editar.val()
    };
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: 'clintes/clientes/actualizar',
      type: 'post',
      dataType: 'json',
      data: datos
    })
    .done(function(dato) {
      if(dato.mensaje == 1){
        new PNotify({
          title: "Actualización",
          text: "Actualización realizada con exito",
          type: "info",
        });
      }
      if (dato.mensaje == 2) {
        new PNotify({
          title: "Actualización",
          text: "No se pudo realizar la Actualización",
          type: "danger",
        });
      }
      if (dato.mensaje == 3) {
        new PNotify({
          title: "Actualización",
          text: "No se pudo realizar la Actualización",
          type: "danger",
        });
      }
      if (dato.mensaje == 4) {
        new PNotify({
          title: "Actualización",
          text: "Ha ocurrido un error intente nuevamente",
          type: "danger",
        });
      }
    });
  },
  cambiar_estado:function (id,estado) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/clientes/'+id,
      type: 'PUT',
      dataType: 'json',
      data: {estado:estado}
    })
    .done(function(estado) {
      if (estado.mensaje==1) {
        new PNotify({
          title: "Actualización",
          text: "Se ha cambiado el estado",
          type: "success",
        });
        tabla.ajax.reload();
      }else {
        if (estado.mensaje==2) {
          new PNotify({
            title: "Actualización",
            text: "Ha ocurrido un error no se pudo realizar esta operación",
            type: "info",
          });
        }
      }
    });
  }
};

var prestamos = {
  tabla_prestamos_clientes:function () {
    $(function() {
      tabla = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/prestamos/tabla/clientes',
        columns: [
          { data: 'documento', name: 'documento' },
          { data: 'nombre', name: 'nombre' },
          { data: 'primer_apellido', name: 'primer_apellido' },
          { data: 'celular', name: 'celular' },
          { data: 'estado', name: 'estado' },
          {data: 'action', name: 'action',class:'td', orderable: false, searchable: false}
        ],
        'language': traduccion
      });
    });

    var traduccion = {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    };
  },

  crear:function (id) {
    $.ajax({
      url: 'prestamos/clientes',
      type: 'get',
      dataType: 'json',
      data: {id: id}
    })
    .done(function(datos) {
      console.log(datos);
      $('#nombres').val(datos.nombre +' '+ datos.primer_apellido);
      $('#documento').val(datos.documento);
      cliente_id = id;

      $('#modal-prestamos-crear').modal();
    });
  },

  calcular:function () {

    $('interes').empty();
    plazo = $('#plazo').val();
    valor =  parseFloat($('#valor').val());
    tasa_interes = parseFloat($('#interes option:selected').text());
    valor_interes = ((valor) * (tasa_interes)/100);
    total_intereses = ((valor_interes) * (plazo));
    valor_pagar = ((total_intereses) + (valor));
    $('#valor-interes').val(total_intereses);
    $('#valor-pagar').val(valor_pagar);
    $('interes').empty();

  },

  crear_prestamo:function () {
    var datos = {
      cliente_id: cliente_id,
      valor: parseFloat($('#valor').val()),
      fecha_prestamo: $('#fecha_prestamo').val(),
      palzo: $('#plazo').val(),
      total_intereses: total_intereses,
      valor_pagar: valor_pagar,
      tasa_interes_id: $('#interes').val()
    };
    console.log(datos);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: 'crear/prestamo',
      type: 'post',
      dataType: 'json',
      data:datos
    })
    .done(function(respuesta) {
      console.log(respuesta);
    });
  }
}
