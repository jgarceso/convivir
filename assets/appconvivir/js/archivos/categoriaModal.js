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
                    '<select name="listaTipo" id="listaTipo" class="combos_modales" >'+
                    '<option value="0">-- Seleccione Tipo --</option>'+
                    '</select>'+
                '</label>'+
                '<label>'+
                            '<span id="idValidaTipo"></span>'+
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
                    if($("#listaTipo").val()!=0){
                        $("#validaTipo").remove();
                        $('#listaTipo').removeClass('selectRojo');
                        GuardarCategoria();
                    }else{
                        $('#listaTipo').addClass('selectRojo');
                        $("#validaTipo").remove();
                        $("#idValidaTipo").append("<p class='textoRojo' id='validaTipo'>Debe Seleccionar un tipo de Categoría.</p>");
                    }
                    
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
                      //var page = this;
                        if($("#field-IdTipo").val()!=0){
                             $('#field-IdTipo').val($("#field-IdTipo").val()).change();
                        }
                     //page.modal.close();
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
}