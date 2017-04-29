
var id_prestamo,
    id_abono;
var abonos = {

	consultar_prestamo:function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/consultar/prestamo',
      type: 'post',
      dataType: 'json',
      data:{id:$("#prestamo").val()}
    })
    .done(function(datos) {

      var  tipo ="";
      var esta = "";
      var tasa = null;

      $.each(datos,function(i, e) {

        $("#tbody").empty();

        $.each(datos[i],function(a, el) {

          if (el.estado == 1) {
            esta = "activo";
          }
          
          $("#tbody").append("<tr><td>"+el.documento+"</td><td>"+el.nombre +' '+el.primer_apellido+"</td><td>"+el.fecha_prestamo+"</td><td>"+el.valor_prestamo+"</td><td>"+el.interes +" %"+"</td><td>"+el.valor_interes_mensual+"</td><td>"+esta+"</td><td><button class=' btn btn-primary fa fa-pencil' title='Crear abono' onclick='abonos.md_crear("+el.id_prestamo+")'></button></td></tr>");
          
        });        
      });

    })
  },

  md_crear:function(id){
    id_prestamo = id;
    $("#md-crear-abono").modal();
  },

  registrar:function(){

    var datos = {
     valor_abono: $("#valor_abono").val(),
     fecha: $("#fecha").val(),
     id_prestamo: id_prestamo
   };

   $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

   $.ajax({
    url: '/crear/abono',
    type: 'post',
    dataType: 'json',
    data: datos
  })
   .done(function(datos) {
    console.log(datos);
    if (datos.resp == 1) {
      new PNotify({
        title: "Abono",
        text: "Abono registrado con exito",
        type: "success",
      });
      $("#md-crear-abono").modal("toggle");
      $("#valor_abono").val("");
      $("#fecha").val("");
    }
    if (datos.resp == 3) {

     new PNotify({
      title: "Cancelación Prestamo",
      text: "Prestamo cancelado con exito sobrante " + datos.sobr ,
      type: "success",
    });
     $("#md-crear-abono").modal("toggle");
     $("#valor_abono").val("");
     $("#fecha").val("");
   }
 });

 },

 consul_pr_abn:function(){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/consultar/prestamo',
    type: 'post',
    dataType: 'json',
    data:{id:$("#prestamo").val()}
  })
  .done(function(datos) {

    var  tipo ="";
    var esta = "";
    var tasa = null;

    $.each(datos,function(i, e) {

      $("#tbody").empty();

      $.each(datos[i],function(a, el) {

        if (el.estado == 1) {
          esta = "activo";
        }

        $("#tbody").append("<tr><td>"+el.documento+"</td><td>"+el.nombre +' '+el.primer_apellido+"</td><td>"+el.fecha_prestamo+"</td><td>"+el.valor_prestamo+"</td><td>"+el.interes +" %"+"</td><td>"+el.valor_interes_mensual+"</td><td>"+esta+"</td><td><a  href='/detalle/abonos/"+el.id_prestamo+"' class='fa fa-eye btn_eyed'></a></td></tr>");

      });        
    });

  })
},

Init:function(){

  $("#tbl_abono").dataTable({

    "language": {
      "sProcessing":    "Procesando...",
      "sLengthMenu":    "Mostrar _MENU_ registros",
      "sZeroRecords":   "No se encontraron resultados",
      "sEmptyTable":    "Ningún dato disponible en esta tabla",
      "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":   "",
      "sSearch":        "Buscar:",
      "sUrl":           "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":    "Último",
        "sNext":    "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });
},

  editar:function(id){
    $.ajax({
      url: '/editar/abono/'+id,
      type: 'get',
      dataType: 'json',
    })
    .done(function(datos) {
    id_abono = datos.id;
      $("#valor_abono").val(datos.valor_abono);
      $("#fecha").val(datos.fecha);
      $("#md-editar-abono").modal();
    });   
  }
}

//md-editar-abono