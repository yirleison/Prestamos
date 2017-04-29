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
            nombre: true
          },
          email: {
            required: true
          },
          password: {
            required: true
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
    });
  }
};

var validarCliente = {

  cliente:function () {
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
          email: {
            required: true
          }
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
            required: "Este campo es requerido",
          },
          email: {
            required: "Este campo es obligatorio"
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
    });
  }

}
