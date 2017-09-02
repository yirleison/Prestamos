
$("#email").bind('change',function(){

	var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(this.value);

	if(!re) {
		$("#success-alert").show();
		$("#success-alert").html("<strong>Error! </strong> Por favor ingresa una dirección de correo valida");
		return false;
	} else {
		$('#success-alert').hide();
		return true;
	}

});



$("#btn_login").click(function(){

	if ($("#email").val() == '' && $("#password").val() == '') {
		$("#success-alert").show();
		$("#success-alert").html("<strong>Error! </strong> Por favor llena los campos");
		return false;
	}
	

	else if( $("#email").val()==''){
		$("#success-alert").show();
		$("#success-alert").html("<strong>Error! </strong> Por favor ingresa el correo");
		return false;
	}
	else if( $("#password").val()==''){
		$("#success-alert").show();
		$("#success-alert").html("<strong>Error! </strong> Por favor ingresa la contraseña");
		return false;
	}
	else{

		$("#success-alert").hide();
		
		var datos = {
			email: $("#email").val(),
			password: $("#password").val()
		};

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: 'login',
			type: 'post',
			dataType: 'json',
			data: datos,
		})
		.done(function(resp) {
			console.log(resp);

			if (resp.resp == 1) {
				$("#success-alert").show();
				$("#success-alert").html("<strong>Error! </strong> No se encontraron datos");
			}
			else {
				window.location.href = "/home";
			}
		});
		return true;
	}

});


