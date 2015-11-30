jQuery(function () {
    $('#icono-usuario').jBox('Tooltip', {
        position: {
			x: 'center',
			y: 'bottom'
		},
        content: '<ul class="user-menu">' +
                '<li><a id="usuario-datos" href="#">Mis datos</a></li>' +
                '<li><a id="cambio-clave" href="#">Cambiar Contraseña</a></li>' +
                '</ul>',
        closeOnMouseleave: true,
        onCreated: function () {
            CrearModales();
        }
    });    
});

function CrearModales(){
    new jBox('Modal', {
            constructOnInit:true,
            attach: $('#cambio-clave'),
            title: 'Cambiar Contraseña',
            width:400,
            content: ObtenerCambioClaveHtml(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosFormulario();
            },
            onClose: function(){
                $("#cambiar-pass-form").validate().resetForm();
            }
     });        
};

function ObtenerCambioClaveHtml(){
    var html = 
   '<form  id="cambiar-pass-form" >'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Contraseña Actual</span>'+
                        '</label>'+
                        '<input id="input-usuario" type="password" name="claveActual" maxlength="12" onpaste="return false;">'+
                        
                    '</div>'+

                    '<div class="form-row">'+
                       '<label>'+
                            '<span>Nueva Contraseña</span>'+
                            '<input id="input-password" type="password" name="claveNueva" maxlength="12" onpaste="return false;">'+
                        '</label>'+
                    '</div>'+
                     '<div class="form-row">'+
                       '<label>'+
                            '<span>Confirme Contraseña</span>'+
                            '<input id="input-password" type="password" name="confClave" maxlength="12" onpaste="return false;">'+
                        '</label>'+
                    '</div>'+
                    '<div class="form-row">'+
                        '<button id="btn-cambio-clave" type="button">Cambiar</button>'+
                    '</div>'+
          '</div>'+
    '</form>';
            return html;
};

function SetearEventosFormulario(){
     $("#cambiar-pass-form").validate({
		rules : {
                        claveActual:{
                                required: true
                        },
                        claveNueva:{
                                required: true,
                                pwcheck: true,
                                minlength: 6
                        },
                        confClave:{
                                required: true,
                                equalTo: "#claveNueva"
                        }
		},
		messages : {
                        claveActual:{
                                required: "Debe escribir su contraseña actual"
                        },
                        claveNueva : {
				required: "Especifique la contraseña",
                                pwcheck: "La contraseña no cumple los criterios.",
                                minlength: "Largo mínimo 6 caracteres."
                                
			},
                        confClave : {
				required: "Especifique la contraseña",
                                equalTo: "Las contraseñas no coinciden"
			}
		}
	});
        
        $.validator.addMethod("pwcheck",
                        function(value, element) {
                            return /^[A-Za-z0-9\d=!\-@._*]+$/.test(value);
        });
        
        $("#btn-cambio-clave").on("click", function() {
		if ($("#cambiar-pass-form").valid()) {
                       CambiarClave();
		} else {
			return;
		}
	});
};

function CambiarClave (){
    
}
