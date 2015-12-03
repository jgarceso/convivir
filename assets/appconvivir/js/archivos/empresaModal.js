//$(document).ready(function() {
//    //eventos botones
//	$("#link-Empresa").on("click", function() {
//            //alert('yessss   ');
//		CrearModales();
//	});
//});

jQuery(function () {
    $('#link-Empresa').jBox('Tooltip', {
        position: {
			x: 'center',
			y: 'bottom'
		},
        content: '<ul class="nu">' +
                '<li><a id="agrega-empresa" href="#">Agregar Empresa</a></li>' +
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
            attach: $('#agrega-empresa'),
            title: 'Empresa',
            width:400,
            content: ObtenerCambioClaveHtml(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosFormulario();
            },
            onClose: function(){
                $("#agrega-empresa-form").validate().resetForm();
            }
     });        
};

function ObtenerCambioClaveHtml(){
    var html = 
   '<form  id="agrega-empresa-form" class="form-login">'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Contraseña Actual</span>'+
                        '</label>'+
                        '<input id="input-nuevaEmpresa" type="password" name="claveActual" maxlength="12" onpaste="return false;">'+
                        
                    '</div>'+
                    '<div class="form-row">'+
                        '<button id="btn-nueva-empresa" type="button">Cambiar</button>'+
                    '</div>'+
          '</div>'+
    '</form>';
            return html;
};

function SetearEventosFormulario(){
     $("#agrega-empresa-form").validate({
		rules : {
                        claveActual:{
                                required: true
                        }
		},
		messages : {
                        claveActual:{
                                required: "Debe escribir su contraseña actual"
                        }
		}
	});
        
              
        $("#btn-nueva-empresa").on("click", function() {
		if ($("#agrega-empresa-form").valid()) {
                      // CambiarClave();
		} else {
			return;
		}
	});
};

