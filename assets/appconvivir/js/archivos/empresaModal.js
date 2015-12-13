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
   this.modal = new jBox('Modal', {
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
    this.modal.open();
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
                        },
                        emailContacto:{
                                email: true
                        }
		},
		messages : {
                        nuevaEmpresa:{
                                required: "Debe ingresar el nombre de la empresa."
                        },
                        email:{
                            email: "Ingrese un email valido.",
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

function GuardarEmpresa(modal){
    var page = this;
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
                      if(resultado.success){
                        //  $('#field-IdEmpresa').remove();
                        //$('#field-IdEmpresa').find('option').remove().end().append('<option value="whatever">text</option>').val('whatever');
                        //$('#field-IdEmpresa').children().remove().end().append('<option selected value="whatever">text</option>') ;
                        //$('#field-IdEmpresa').empty();
//                        $('#field-IdEmpresa')
//                            .find('option')
//                            .remove()
//                            .end()
//                            .append('<option value="whatever">text</option>')
//                            .val('whatever')
//                        ;
//                        $('#field-IdEmpresa option:selected').each( function() {
//                            $('#field-IdEmpresa').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
//                            $(this).remove();
//                        });
//                        document.getElementById("field-IdEmpresa").options.length = 0;
                        page.modal.close();
                      }
                      
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
}

function getEmpresas(){
    $.ajax({
            url: SiteName+"Modales/getEmpresas",
            type : 'POST',
            dataType : 'json',

            success : function(resultado) {
                      FuncionesComunes.afterSave(resultado.success, resultado.success_message);
                      $("#selectBox option[value='option']").remove();
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
}

//var mySelect = document.getElementById('field-IdEmpresa');
//mySelect.options.length = 0;
//mySelect.options[0] = new Option ("Foo (only choice)", "Foo");
//mySelect.options[0].selected="true";

