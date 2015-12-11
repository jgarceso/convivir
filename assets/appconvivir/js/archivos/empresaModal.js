$(document).ready(function() {
    $('<span class="addEmpresa-icon" Id="add-category"></span>').insertAfter('#IdEmpresa_input_box');
});

jQuery(function () {
    $('#add-category').jBox('Tooltip', {
        position: {
			x: 'center',
			y: 'bottom'
		},
        content: '<ul class="user-menu">' +
                '<li><a id="agrega-empresa" href="#">Agregar Empresa</a></li>' +
                '</ul>',
        closeOnMouseleave: true,
        onCreated: function () {
            CrearModalEmpresa();
        }
    });    
});

function CrearModalEmpresa(){
      new jBox('Modal', {
            constructOnInit:true,
            attach: $('#agrega-empresa'),
            title: 'Empresa',
            width:400,
            content: AgregarEmpresaHtml(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosEmpresaForm();
            },
            onClose: function(){
                $("#agrega-empresa-form").validate().resetForm();
            }
     });
};

function AgregarEmpresaHtml(){
    var html = 
   '<form  id="agrega-empresa-form" class="form-login">'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Nombre Empresa</span>'+
                        '</label>'+
                        '<input id="input-nuevaEmpresa" type="text" name="nuevaEmpresa" maxlength="50" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label>'+
                    '<span>Nombre Contacto</span>'+
                    '<input id="input-nombreContacto" type="text" name="nombreContacto" maxlength="50" onpaste="return false;">'+
                '</label>'+
            '</div>'+
            '<div class="form-row">'+
              '<label>'+
                   '<span>Email Contacto</span>'+
                   '<input id="input-emailContacto" type="text" name="emailContacto" maxlength="50" onpaste="return false;">'+
               '</label>'+
           '</div>'+
           '<div class="form-row">'+
              '<label>'+
                   '<span>Teléfono Contacto</span>'+
                   '<input id="input-fonoContacto" type="text" name="fonoContacto" maxlength="12" onpaste="return false;">'+
               '</label>'+
           '</div>'+
           '<div class="form-row">'+
                '<button id="btn-nueva-empresa" type="button">Guardar</button>'+
            '</div>'+
           '</div>'+
    '</form>';
    return html;
};

function SetearEventosEmpresaForm(){
     $("#agrega-empresa-form").validate({
		rules : {
                        nuevaEmpresa:{
                                required: true
                        }
		},
		messages : {
                        nuevaEmpresa:{
                                required: "Debe ingresar el nombre de la empresa."
                        }
		}
	});
        
         $("#btn-nueva-empresa").on("click", function() {
            if ($("#agrega-empresa-form").valid()) {
                  GuardarEmpresa();
            } else {
                    return;
            }
    });  
};

function GuardarEmpresa(){
    $.ajax({
            url: SiteName+"Empresas/index/insert",
            type : 'POST',
            dataType : 'json',
            data : {
                    Nombre : $("#input-nuevaEmpresa").val(),
                    NombreContacto: $("#input-nombreContacto").val(),
                    EmailContacto: $("#input-emailContacto").val(),
                    TelefonoContacto: $("#input-fonoContacto").val(),
            },
            success : function(resultado) {
                      FuncionesComunes.afterSave(resultado.success, resultado.success_message);
                     $('select[name="IdEmpresa"]').val('').change();
                         // alert('if');
                         // $('field-IdEmpresa').val('').change();
                         // $('#field-IdEmpresa').empty().change();
                       //$('#field-IdEmpresa').val($("#field-IdEmpresa").val()).change();
                     


            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
}

