
var id_prestamo,
id_abono,idab;

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

					$("#tbody").append("<tr><td>"+el.documento+"</td><td>"+el.nombre +' '+el.primer_apellido+"</td><td>"+el.fecha_prestamo+"</td><td>"+el.valor_prestamo+"</td><td>"+el.interes +" %"+"</td><td>"+el.valor_interes_mensual+"</td><td><span class='label label-success'>"+esta+"</span></td><td><button class=' btn btn-primary fa fa-pencil' title='Crear abono' onclick='abonos.md_crear("+el.id_prestamo+")'></button></td></tr>");

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
			//console.log(datos);
			if (datos.resp == 1) {
				new PNotify({
					title: "Abono",
					text: "Abono registrado con exito",
					type: "success",
				});
				$("#md-crear-abono").modal("toggle");
				$("#valor_abono").val("");
				$("#fecha").val("");

				socket.emit('refrescar', datos);
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
						esta = "Activo";
					}

					$("#tbody").append("<tr><td>"+el.documento+"</td><td>"+el.nombre +' '+el.primer_apellido+"</td><td>"+el.fecha_prestamo+"</td><td>"+el.valor_prestamo+"</td><td>"+el.interes +" %"+"</td><td>"+el.valor_interes_mensual+"</td><td><span class='label label-danger'>"+esta+"</span></td><td><a href='/detalle/abonos/"+el.id_prestamo+"' class='fa fa-eye btn_eyed'></a></td></tr>");
					console.log(el.id_prestamo);
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

		abonos.estado_prestamo();
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
	},

	estado_prestamo:function(id) {

		$.ajax({
			url: '/estado/prestamo/'+id,
			type: 'get',
			dataType: 'json',
		}).done(function(r) {
			$("#total_interesop").text(r[0].interes);
			$("#total_capital").text(r[0].abono_capital);
			//console.log(r);
		});

	},

	prox_cuota: function(id) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: '/consultar/cuota',
			type: 'post',
			dataType:'json',
			data:{id_prestamo:id}
		}).done(function(r) {
			//console.log(r);
			$("#fecha_cuota").text("Fecha Pago:  " + r[0].fecha_cuota);
			$("#valor_interes").text("Valor Interes: " + r[0].nuevo_interes_mensual);
			$("#md-fecha").modal();

		});
	}

}


//md-editar-abono
