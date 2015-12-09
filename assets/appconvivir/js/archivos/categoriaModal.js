$(document).ready(function() {
    $('<span class="addCategory-icon" Id="add-category"></span>').insertAfter('#IdCategoria_input_box');
    //$('new_content').insertBefore('#input-tipo');
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
                    '<option value="default">-- Seleccione Tipo --</option>'+
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
 // add the rule here
 $.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg != value;
 }, "Value must not equal arg.");

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
        
        $('#listaTipo').each(function() {
           if ($(this).isChecked)
              alert('this option is selected');
           else
              alert('this is not');
       });
        
        $("#btn-nueva-categoria").on("click", function() {
		if ($("#agrega-categoria-form").valid()) {
                    

		} else {
			return;
		}
	});
        
       
        
//        // add the rule here
//        $.validator.addMethod("valueNotEquals", function(value, element, arg){
//         return arg != value;
//        }, "Value must not equal arg.");
        
//        $.validator.setDefaults({
//            errorPlacement: function (error, element) {
//                if (element.context.id.indexOf('lista-tipo') == -1)
//                    error.insertAfter(element);
//                else
//                    error.appendTo(element.parent());
//            }
//        });
};

function ObtieneTipos (){
    $.ajax({
		url : SiteName+"RecuperaPass/test",
		type : 'POST',
		dataType : 'json',
		data : {
			prueba : 'lalalalasssdd',
                        validaual:true
		},
               
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


