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
                SetearEventosFormulario();
            },
            onClose: function(){
                $("#agrega-categoria-form").validate().resetForm();
            }
     });
     
      new jBox('Modal', {
            constructOnInit:true,
            attach: $('#agrega-empresa'),
            title: 'Empresa',
            width:400,
            content: AgregarEmpresaHtml(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosFormulario();
            },
            onClose: function(){
                $("#agrega-empresa-form").validate().resetForm();
            }
     });
     
     new jBox('Modal', {
            constructOnInit:true,
            attach: $('#agrega-subcategoria'),
            title: 'SubCategoría',
            width:400,
            content: AgregarSubCategoria(),
            closeButton:'title',
            onCreated: function () {
                SetearEventosCategoriaForm();
            },
            onClose: function(){
                $("#agrega-subcategoria-form").validate().resetForm();
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
                    '<input id="input-tipo" type="text" name="tipo" maxlength="50" onpaste="return false;">'+
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
};

