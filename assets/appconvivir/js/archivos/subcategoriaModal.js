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
                    '<input id="input-tipo" type="text" name="categoria" maxlength="50" onpaste="return false;">'+
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
                       alert('lalal');
		} else {
			return;
		}
	});
}