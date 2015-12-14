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
   this.modal = new jBox('Modal', {
                constructOnInit:true,
                attach: $('#agrega-subcategoria'),
                title: 'SubCategor&iacute;a',
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
                                $("#listaCategorias").append(resultado.Opciones);
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
                            '<span>Nombre SubCategor&iacute;a</span>'+
                        '</label>'+
                        '<input id="input-nombreSubCategoria" type="text" name="nombreSubCategoria" maxlength="50" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label>'+
                    '<span>Categor&iacute;a</span>'+
                    '<select name="listaCategorias" id="listaCategorias" class="combos_modales" >'+
                    '<option class="options_modales" value="0">-- Seleccione Categor&iacute;a --</option>'+
                    '</select>'+
                '</label>'+
                 '<label>'+
                            '<span id="idValidaCategoria"></span>'+
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
                                required: "Debe ingresar el nombre de la subcategor&iacute;a."
                        },
                        categoria:{
                                required: "Debe ingresar una categor&iacute;a."
                        }
		}
	});
         
        $("#btn-nueva-subcategoria").on("click", function() {
		if ($("#agrega-subcategoria-form").valid()) {
                     if($("#listaCategorias").val()!=0){
                        $("#validaCategoria").remove();
                        $('#listaCategorias').removeClass('selectRojo');
                         GuardarSubCategoria();
                    }else{
                        $('#listaCategorias').addClass('selectRojo');
                        $("#validaCategoria").remove();
                        $("#idValidaCategoria").append("<p class='textoRojo' id='validaCategoria'>Debe Seleccionar una Categor&iacute;a.</p>");
                    }
		} else {
			return;
		}
	});     
}

function GuardarSubCategoria(modal){
   var page = this;
    $.ajax({
		url: SiteName+"SubCategorias/index/insert",
		type : 'POST',
		dataType : 'json',
		data : {
			Nombre : $("#input-nombreSubCategoria").val(),
                        IdCategoria: $("#listaCategorias").val()
		},
               
		success : function(resultado) {
			  FuncionesComunes.afterSave(resultado.success, resultado.success_message); 
                          if(resultado.success){
                             $('select[name="IdCategoria"]').val($('select[name="IdCategoria"]').val()).change(); 
                          }
                          page.modal.close();
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
}