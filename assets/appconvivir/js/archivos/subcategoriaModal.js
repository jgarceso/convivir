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
                    '<input id="input-tipo" type="text" name="tipo" maxlength="50" onpaste="return false;">'+
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
         
//        $("#btn-nueva-empresa").on("click", function() {
//		if ($("#agrega-empresa-form").valid()) {
//                      // CambiarClave();
//		} else {
//			return;
//		}
//	});
}