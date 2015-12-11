$(document).ready(function() {
    $('<span class="addSubCategory-icon" Id="add-subCategory"></span>').insertAfter('#IdSubcategoria_input_box');
});

jQuery(function () {
    $('#add-subCategory').jBox('Tooltip', {
        position: {
			x: 'center',
			y: 'bottom'
		},
        content: '<ul class="user-menu">' +
                '<li><a id="agrega-subcategoria" href="#">Agregar SubCategor&iacute;a</a></li>' +
                '</ul>',
        closeOnMouseleave: true,
        onCreated: function () {
            CrearSubCategoriaModal();
            ObtieneCategorias();
        }
    });    
});

function CrearSubCategoriaModal(){
          new jBox('Modal', {
            constructOnInit:true,
            attach: $('#agrega-subcategoria'),
            title: 'SubCategoría',
            width:400,
            content: AgregarSubCategoria(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosSubCateForm();
            },
            onClose: function(){
                $("#agrega-subcategoria-form").validate().resetForm();
            }
     });
};

function ObtieneCategorias(){
    $.ajax({
		url : SiteName+"Modales/getCategorias",
		type : 'POST',
		dataType : 'json',
		success : function(resultado) {
			FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje);
                        if(resultado.Correcto){
                            setTimeout(function(){
                                $("#comboSubCategorias").append(resultado.Opciones);
                              }, 2500);
                        }
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
}

function AgregarSubCategoria(){
    var html = 
   '<form  id="agrega-subcategoria-form" class="form-login">'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Nombre SubCategoría</span>'+
                        '</label>'+
                        '<input id="input-nombreSubCategoria" type="text" name="nombreSubCategoria" maxlength="50" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label>'+
                    '<span>Categoría</span>'+
                    '<select name="comboSubCategorias" id="comboSubCategorias" class="combos_modales" >'+
                    '<option class="options_modales">-- Seleccione Categoría --</option>'+
                    '</select>'+
                '</label>'+
            '</div>'+
           '<div class="form-row">'+
                '<button id="btn-nueva-subcategoria" type="button">Guardar</button>'+
            '</div>'+
           '</div>'+
    '</form>';
    return html;
};

function SetearEventosSubCateForm(){
        $("#agrega-subcategoria-form").validate({
		rules : {
                        nombreSubCategoria:{
                                required: true
                        },
                        categoria:{
                                required: true
                        },
		},
		messages : {
                        nombreSubCategoria:{
                                required: "Debe ingresar el nombre de la subcategoría."
                        },
                        categoria:{
                                required: "Debe ingresar una categoría."
                        }
		}
	});
         
        $("#btn-nueva-subcategoria").on("click", function() {
		if ($("#agrega-subcategoria-form").valid()) {
                       GuardarSubCategoria();
		} else {
			return;
		}
	});
}

function GuardarSubCategoria(){
    alert($("#comboSubCategorias").val());
    $.ajax({
		url: SiteName+"SubCategorias/index/insert",
		type : 'POST',
		dataType : 'json',
		data : {
			Nombre : $("#input-nombreSubCategoria").val(),
                        IdCategoria: $("#comboSubCategorias").val()
		},
               
		success : function(resultado) {
			  FuncionesComunes.afterSave(resultado.success, resultado.success_message); 
                           $('select[name="IdCategoria"]').val($('select[name="IdCategoria"]').val()).change();
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
}