$(document).ready(function() {
    $('<span class="addCategory-icon" Id="add-category"></span>').insertAfter('#IdCategoria_input_box');
});

jQuery(function () {
    $('#add-category').jBox('Tooltip', {
        position: {
			x: 'center',
			y: 'bottom'
		},
        content: '<ul class="user-menu">' +
                '<li><a id="agrega-categoria" href="#">Agregar Categor&iacute;a</a></li>' +
                '</ul>',
        closeOnMouseleave: true,
        onCreated: function () {
            CrearModalCategoria();
            ObtieneTipos();
        }
    });    
});

function CrearModalCategoria(){
    
     new jBox('Modal', {
            constructOnInit:true,
            attach: $('#agrega-categoria'),
            title: 'Categoría',
            width:400,
            content: AgregarCategoria(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosCategoriaForm();
            },
            onClose: function(){
                $("#agrega-categoria-form").validate().resetForm();
            }
     });
};

function AgregarCategoria(){
    var html = 
   '<form  id="agrega-categoria-form" class="form-login">'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Nombre Categoría</span>'+
                        '</label>'+
                        '<input id="input-nombreCategoria" type="text" name="nombreCategoria" maxlength="50" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label>'+
                    '<span>Tipo</span>'+
                    '<select name="sometext" id="listaTipo" class="combos_modales" >'+
                    '<option>-- Seleccione Tipo --</option>'+
                    '</select>'+
                '</label>'+
            '</div>'+
           '<div class="form-row">'+
                '<button id="btn-nueva-categoria" type="button">Guardar</button>'+
            '</div>'+
           '</div>'+
    '</form>';
    return html;
};

function SetearEventosCategoriaForm(){
        $("#agrega-categoria-form").validate({
		rules : {
                        nombreCategoria:{
                                required: true
                        },
                        listaTipo:{
                                required: true
                        }
		},
		messages : {
                        nombreCategoria:{
                                required: "Debe ingresar el nombre de la categoría."
                        },
                        listaTipo:{
                                 required: "Debe ingresar el nombre de la categoría."
                        }
		}
	});
        
        $("#btn-nueva-categoria").on("click", function() {
		if ($("#agrega-categoria-form").valid()) {
                    GuardarCategoria();
		} else {
		    return;
		}
	});
};

function ObtieneTipos (){
    $.ajax({
            url : SiteName+"Modales/getTipos",
            type : 'POST',
            dataType : 'json',
            success : function(resultado) {
                    FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje);
                    if(resultado.Correcto){
                        setTimeout(function(){
                            $("#listaTipo").append(resultado.Opciones);
                          }, 2500);
                    }
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
}

function GuardarCategoria(){
    $.ajax({
            url: SiteName+"Categorias/index/insert",
            type : 'POST',
            dataType : 'json',
            data : {
                    Nombre : $("#input-nombreCategoria").val(),
                    IdTipo: $("#listaTipo").val()
            },
            success : function(resultado) {
                      FuncionesComunes.afterSave(resultado.success, resultado.success_message);
                      //$('#selOUH li:first').appendTo('#selOUH');
                      Recargar();
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
}

    function Recargar(){
        $.ajax({
                url: SiteName+"Modales/categoria_dropdown_select",
                type : 'POST',
                dataType : 'json',
                success : function(resultado) {
                          
                            $('#selLS3').find('option:not(:first)').remove();
                           // $("#selOUH").append(resultado.Opciones);
                },
                error : function(xhr, ajaxOptions, thrownError) {
                }
            });
}
