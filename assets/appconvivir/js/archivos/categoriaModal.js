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
                    '<select name="sometext" id="lista-tipo" class="combos_modales" >'+
                    '<option value="default">-- Seleccione Tipo --</option>'+
                    '<option>Alimentos</option>'+
                    '<option>Medicamentos</option>'+
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
                        tipo:{
                                SelectName: { valueNotEquals: "default" }
                        }
		},
		messages : {
                        nombreCategoria:{
                                required: "Debe ingresar el nombre de la categoría."
                        },
                        tipo:{
                                SelectName: { valueNotEquals: "Porfavor seleccione un tipo de <categoría." }
                        }
		}
	});
        
        $("#btn-nueva-categoria").on("click", function() {
		if ($("#agrega-categoria-form").valid()) {
                       alert('catt');
		} else {
			return;
		}
	});
};

function ObtieneTipos (){
    $.ajax({
		url : SiteName+"RecuperaPass/test",
		type : 'POST',
		dataType : 'json',
		data : {
			prueba : 'lalalalasssddddddddddddddd dsdvedbg vsgb',
                        validaual:true
		},
               
		success : function(data) {
			if (data.Correcto == false) {
			    //alert(data.Mensaje);
                            $("#mySelect").append('<option value=1>My option</option>');
			}else{
                            alert(data.Mensaje);
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
}


