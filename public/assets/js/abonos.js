
var id_prestamo;
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

      console.log(datos);
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
    });
				 
	},

  Init:function(){
   
      $("#tbl_abono").dataTable();
   
  }


}