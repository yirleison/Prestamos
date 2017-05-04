
function login () {
	
	var datos = {
		nombre: $("#nombre_usuario").val(),
		password: $("#password").val()
	};

	  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
	
	$.ajax({
		url: '/login',
		type: 'post',
		dataType: 'json',
		data: datos,
	})
	.done(function(resp) {
		console.log(resp);
	})

}