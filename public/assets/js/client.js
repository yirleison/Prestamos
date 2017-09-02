

var socket = io.connect("http://127.0.0.1:8080");

console.log("cliente")

socket.connect("http://127.0.0.1:8080", () => {
	console.log("conectado");
});

var datos = "";
var cant_clientes = 0;
var tabla_cuotas_cliente = "";

socket.on('message', function (data) {

	cant_clientes = data.length;
	var element = $("#can_clientes");
	
	if (jQuery.isEmptyObject(data)) {
		
		element.hide();
		$("#pnotificaciones").empty();
	}
	else {

		$.each(data, function (e, i) {

			if (element.text() ==='0') {
				element.hide();
			} else {
				element.show();
			}

			datos += '<li><i class="fa fa-user text-success"></i>\
			<a href="#" onclick=datos_deuda('+ i.id + ',"' + i.nombre + '","' + i.primer_apellido + '")>\
			<div class="font-w600">'+ i.nombre + " " + i.primer_apellido + '</div><div></div>\
			</a></li>';
			$("#pnotificaciones").html(datos);

			element.text(cant_clientes);

		});
	}

	datos ="";
});

socket.on('ref', function (data) {
	
	var element = $("#can_clientes");
	cant_clientes = data.length;

	if (jQuery.isEmptyObject(data)) {
		
		element.hide();
		$("#pnotificaciones").empty();
	}
	else {
		console.log("entro a el on ref");
		if (element.text() ==='0') {
			element.hide();
		} else {
			element.show();
		}
		$.each(data, function (e, i) {

			datos += '<li><i class="fa fa-user text-success"></i>\
			<a href="#" onclick=datos_deuda('+ i.id + ',"' + i.nombre + '","' + i.primer_apellido + '")>\
			<div class="font-w600">'+ i.nombre + " " + i.primer_apellido + '</div><div></div>\
			</a></li>';
			$("#pnotificaciones").html(datos);

			element.text(cant_clientes);

		});
		datos ="";
	}

});

function datos_deuda(id, nombre, p_apellido) {

	var  fecha_actual =  moment().format('YYYY-MM-DD');

	$("#t_cliente").text("Estado cuenta : " + nombre + " " + p_apellido);

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: '/notificaciones',
		type: 'post',
		dataType: 'json',
		data: { id: id }
	}).done(function (datos) {
		console.log(datos);
		$.each(datos.datos, function (index, i) {

			f = moment(i.fecha_cuota).add(1, 'days').format('YYYY-MM-DD');

			var mesFechaCuota = moment(i.fecha_cuota).month();

			if (moment(f).isSame(moment(fecha_actual)) || mesFechaCuota == moment().month()) {
				console.log(moment().month());
				tabla_cuotas_cliente += `<div class='block content-tabla table-responsive'>
				<div class='block-content table-responsive'>
				<table class='display table table-hover table table-striped table-borderless table-header-bg tabla-prestamos text-center' id='tbl_abono' style='width:100%'>
				<thead>
				<tr>
				<th class='text-center'>Fecha cuota</th>
				<th class='text-center'>Valor intereses</th>
				<th class='text-center'>Acciones</th>

				</tr>
				</thead>
				<tbody id='tbody'>
				<tr>
				<td>${i.fecha_cuota}</td>
				<td>${i.nuevo_interes_mensual}</td>
				<td>
				<button class='btn  label label-danger' style='font-weight:bold;font-size:16px;'onclick='sumarMes(${i.id_prestamo});'>Sumar Mes</button>
				<button class='btn  label label-success' style='font-weight:bold;font-size:16px;' onclick='esperar()'>Esperar</button>
				</td>
				</tr>
				</tbody>
				</table>
				</div>
				</div>`;

			}

		});

		$("#tbl_cuota_cliente").html(tabla_cuotas_cliente);
		$("#modal-noti-cliente").modal();
		tabla_cuotas_cliente="";
	});


}

function sumarMes(id) {
	$.ajax({
		url: '/suamarmes',
		type: 'post',
		dataType: 'json',
		data: { id: id }
	}).success((data) => {

		if (data.resp == 1) {
			socket.emit('refrescar', data);
		}

	});
}

function esperar(){

	new PNotify({
		title: "Posponer",
		text: "Se pospone el cobro de cuota de este cliente",
		type: "info",
	});
}
