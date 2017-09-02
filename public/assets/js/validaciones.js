var validacion_usuarios = {

  crear_usuario:function () {

    $(document).ready(function(){

      jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
      });
      $('#formulario-usuario').validate({
        rules:{
          nombre:{
            required: true,
            nombre: true,
          },
          email: {
            required: true,
            validarEmail:true
          },
          password: {
            required: true,
            maxlength: 10,
          },
          confirm_password: {
            required: true,
            maxlength: 10,
            equalTo: "#password"
          },
          rol: {
           selectcheck: true
         }
       },
       submitHandler: function (form) {
        usuarios.registrar_usuario();
      },

      highlight: function (element) {
        $(element).parent().removeClass('has-success').addClass('has-error');
      },

      success: function (element) {
        $(element).parent().removeClass('has-error').addClass('has-success');
      },
      messages:{
        nombre:{
          required: "Este campo es requerido"
        },
        email: {
          required: "Este campo es obligatorio",
        },
        password: {
          required:"Este campo es obligatorio",
          minlength: "La contraseña debe de tener minimo 6 digitos"
        },
        confirm_password:{
          required:"Este campo es obligatorio",
          minlength: "La contraseña debe de tener minimo 6 digitos",
          equalTo: "Las contraseñas no coinciden"
        },
      },
    });
      jQuery.validator.addMethod("", function (value, element) {
        return this.optional(element) || /^[0-9]{7}$/.test(value);
      }, 'Solo se admiten números');

      jQuery.validator.addMethod("nombre", function(value, element) {
        return this.optional(element) || /^[a-z-0-9]+$/i.test(value);
      }, "Ingrese nombre correcto");

      jQuery.validator.addMethod("email", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^[_a-zA-Z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/.test( value );
      }, 	'Ingrese un correo correcto');

      jQuery.validator.addMethod('selectcheck', function (value) {
        if( $("#rol").val() >= 1){
          return true;
        } else {
          return false;
        }
      }, "Por favor selecciona un rol");

      jQuery.validator.addMethod( "validarEmail", function( value, element ) {
        var validar = false,d;

        $.ajax({
          type : 'get',
          datatype :'json',
          data : {"_token" : $("#_token").val() , email : $("#email").val() },
          url : '/validar/email',
          async : false
        }).done(function(datos){
          var d = JSON.parse(datos);
          if (d.existe == 1) {
            validar = false;
          }else{
            validar = true;
          }
        });

        return validar;
      }, "Ya existe este Email" );

      jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/i.test(value);
      }, "Solo se admiten letras");
    });
  },

  actualizar_usuario:function(){

    $(document).ready(function(){
      jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
      });
      $('#form-actualizar-usuario').validate({
        rules:{
          nombre:{
            required: true,
            nombre: true
          },
          email: {
            required: true
          },
          password: {
            required: true
          },
          rol: {
           selectcheck: false
         }
       },
       submitHandler: function (form) {
        usuarios.actualizar_usuario();
      },

      highlight: function (element) {
        $(element).parent().removeClass('has-success').addClass('has-error');
      },

      success: function (element) {
        $(element).parent().removeClass('has-error').addClass('has-success');
      },
      messages:{
        nombre:{
          required: "Este campo es requerido",
        },
        email: {
          required: "Este campo es obligatorio"
        },
        password: {
          required:"Este campo es obligatorio"
        }
      },
    });
      jQuery.validator.addMethod("", function (value, element) {
        return this.optional(element) || /^[0-9]{7}$/.test(value);
      }, 'Solo se admiten números');

      jQuery.validator.addMethod("nombre", function(value, element) {
        return this.optional(element) || /^[a-z-0-9]+$/i.test(value);
      }, "Ingrese nombre correcto");

      jQuery.validator.addMethod("email", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^[_a-zA-Z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/.test( value );
      }, 	'Ingrese un correo correcto');

      jQuery.validator.addMethod('selectcheck', function (value) {
        if( $("#rol").val() >= 1){
          return true;
        } else {
          return false;
        }
      }, "Por favor selecciona un rol");
    });
  }
};

var validarCliente = {

  cliente:function(){

   $(document).ready(function(){

    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });
    $('#form_cliente').validate({

      rules:{

        nombre:{
          required: true,
          nombre: true
        },

        primer_apellido:{
          required: true,
        },

        segundo_apellido:{
          required: true,
        },

        id_tipo_documento:{
          tipoDocumentoC:true
        },

        documento:{
          required:true,
          number:true
        },

        direccion:{
          required:true
        },

        telefono:{
          required:true,
          soloNumeros:true,
          maxlength:7
        },

        celular:{
          required:true,
          number:true,
          maxlength:10
        },

        id_tipo_cuenta:{
          validarTipoCuenta: true
        },

        cuenta:{
          required: true,
          maxlength: 12,
          number: true
        },

        email: {
          required: true,
          validarEmailCLiente: true
        },
      },

      submitHandler: function (form) {
       cliente.registrar();
     },

     highlight: function (element) {
      $(element).parent().removeClass('has-success').addClass('has-error');
    },

    success: function (element) {
      $(element).parent().removeClass('has-error').addClass('has-success');
    },
    messages:{

      nombre:{
        required: "Este campo es requerido"
      },

      primer_apellido:{
       required: "Este campo es requerido"
     },

     segundo_apellido:{
       required: "Este campo es requerido"
     },

     documento:{
      required: "Este campo es requerido",
      number: "Solo se admiten numeros"
    },

    direccion:{
      required: "Este campo es requerido"
    },

    telefono:{
      required: "Este campo es requerido",
      maxlength: "Solo se admite un nuemro maximo de 7 digitos"
    },

    celular:{
      required: "Este campo es requerido",
      maxlength: "Solo se admite un numero maximo de 10 digitos",
      number: "Solo se admiten numeros"
    },

    cuenta:{
      required: "Este campo es requerido",
      maxlength: "Solo se admite un numero maximo de 12 digitos",
      number: "Solo se admiten numeros"
    },

    email: {
      required: "Este campo es obligatorio"
    },
  },
});
    jQuery.validator.addMethod("", function (value, element) {
      return this.optional(element) || /^[0-9]{7}$/.test(value);
    }, 'Solo se admiten números');

    jQuery.validator.addMethod("nombre", function(value, element) {
      return this.optional(element) || /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]*$/.test(value);
    }, "Ingrese nombre correcto");

    jQuery.validator.addMethod("email", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^[_a-zA-Z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/.test( value );
      },  'Ingrese un correo correcto');

    jQuery.validator.addMethod('tipo', function (value) {
      if( $("#documento").val() >= 1){
        return true;
      } else {
        return false;
      }
    }, "Por favor selecciona un rol");

    jQuery.validator.addMethod('tipoDocumentoC', function (value) {
      if( $("#tipo_documento").val() >= 1){
        return true;
      } else {
        return false;
      }
    }, "Por favor selecciona un un tipo de documento");

    jQuery.validator.addMethod("soloNumeros", function (value, element) {
      return this.optional(element) || /^[0-9]{7}$/.test(value);
    }, 'Solo se admiten números');

    jQuery.validator.addMethod('validarTipoCuenta', function (value) {
      if( $("#tipo_cuenta").val() >= 1){
        return true;
      } else {
        return false;
      }
    }, "Por favor selecciona un un tipo de cuenta");

     jQuery.validator.addMethod( "validarEmailCLiente", function( value, element ) {
        var validar = false,d;

        $.ajax({
          type : 'get',
          datatype :'json',
          data : {"_token" : $("#_token").val() , email : $("#email").val() },
          url : '/validar/email',
          async : false
        }).done(function(datos){
          var d = JSON.parse(datos);
          if (d.existe == 1) {
            validar = false;
          }else{
            validar = true;
          }
        });

        return validar;
      }, "Ya existe este Email" );

  });
 },

  editar_cliente:function() {

  $(document).ready(function(){

    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });
    $('#form_actualizar_cliente').validate({

      rules:{

        nombre_editar:{
          required: true,
          nombreEditar: true
        },

        primer_apellido_editar:{
          required: true,
        },

        id_tipo_documento_editar:{
          tipoDocumento:true
        },

        documento_editar:{
          required:true,
          number:true,
          maxlength: 12
        },

        direccion_editar:{
          required:true
        },

        telefono_editar:{
          required:true,
          number:true,
          maxlength:7
        },

        celular_editar:{
          required:true,
          number:true,
          maxlength:10
        },

        id_tipo_cuenta:{
          validarTipoCuentaEditar: true
        },

        cuenta_editar:{
          required: true,
          maxlength: 12,
          number: true
        },

        email_editar: {
          required: true,
          email:true
        },
      },

      submitHandler: function (form) {
       cliente.actualizar_datos();
     },

     highlight: function (element) {
      $(element).parent().removeClass('has-success').addClass('has-error');
    },

    success: function (element) {
      $(element).parent().removeClass('has-error').addClass('has-success');
    },
    messages:{

      nombre_editar:{
        required: "Este campo es requerido"
      },

      primer_apellido_editar:{
       required: "Este campo es requerido"
     },

     documento_editar:{
      required: "Este campo es requerido",
      number: "Solo se admiten numeros",
      maxlength: "Solo se admite un nuemro maximo de 12 digitos"
    },

    direccion_editar:{
      required: "Este campo es requerido"
    },

    telefono_editar:{
      required: "Este campo es requerido",
      number: "Solo se admiten numeros",
      maxlength: "Solo se admite un nuemro maximo de 7 digitos"
    },

    celular_editar:{
      required: "Este campo es requerido",
      maxlength: "Solo se admite un numero maximo de 10 digitos",
      number: "Solo se admiten numeros"
    },

    cuenta_editar:{
      required: "Este campo es requerido",
      maxlength: "Solo se admite un numero maximo de 12 digitos",
      number: "Solo se admiten numeros"
    },

    email_editar: {
      required: "Este campo es obligatorio"
    },
  },
});

    jQuery.validator.addMethod("nombreEditar", function(value, element) {
      return this.optional(element)|| /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]*$/.test(value);
    }, "Ingrese nombre correcto");

    jQuery.validator.addMethod("email", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^[_a-zA-Z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/.test( value );
      },  'Ingrese un correo correcto');

    jQuery.validator.addMethod('tipo', function (value) {
      if( $("#documento").val() >= 1){
        return true;
      } else {
        return false;
      }
    }, "Por favor selecciona un rol");

    jQuery.validator.addMethod('tipoDocumento', function (value) {
      if( $("#tipo_documento_editar").val() >= 1){
        return true;
      } else {
        return false;
      }
    }, "Por favor selecciona un un tipo de documento");

    jQuery.validator.addMethod("soloNumeros", function (value, element) {
      return this.optional(element) || /^[0-9]{7}$/.test(value);
    }, 'Solo se admiten números');

    jQuery.validator.addMethod('validarTipoCuentaEditar', function (value) {
      if( $("#cuenta_editar").val() >= 1){
        return true;
      } else {
        return false;
      }
    }, "Por favor selecciona un un tipo de cuenta");

     jQuery.validator.addMethod( "validarEmailCLiente", function( value, element ) {
        var validar = false,d;

        $.ajax({
          type : 'get',
          datatype :'json',
          data : {"_token" : $("#_token").val() , email : $("#email_editar").val() },
          url : '/validar/email',
          async : false
        }).done(function(datos){
          var d = JSON.parse(datos);
          if (d.existe == 1) {
            validar = false;
          }else{
            validar = true;
          }
        });

        return validar;
      }, "Ya existe este Email" );

  });
}

}


