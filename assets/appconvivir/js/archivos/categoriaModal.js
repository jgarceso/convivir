var categoria = {    
    inicializar: function(){
        var me = this;
        me.modal = new jBox('Modal', {
                constructOnInit:true,
                attach: $('#agregar-categoria'),
                title: 'Categor&iacute;a',
                width:400,
                content: me.obtenerModalHtml(),
                closeButton:'title',
                onCreated: function () {
                    me.obtenerTipos();
                    me.setearEventosCategoriaForm();
                },
                onClose: function(){
                    $("#agrega-categoria-form").validate().resetForm();
                }
     });
    },
    obtenerModalHtml: function(){
        var html = 
   '<form  id="agrega-categoria-form" class="form-login">'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Nombre Categor&iacute;a</span>'+
                        '</label>'+
                        '<input id="input-nombreCategoria" type="text" name="nombreCategoria" maxlength="50" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label class="selector">'+
                    '<span>Tipo</span>'+
                    '<select name="listaTipo" id="listaTipo" class="required combos_modales">'+
                    '<option value="">-- Seleccione Tipo --</option>'+
                    '</select>'+
                '</label>'+
            '</div>'+
           '<div class="form-row">'+
                '<button id="btn-nueva-categoria" type="button">Guardar</button>'+
            '</div>'+
           '</div>'+
    '</form>';
    return html;
    },
    setearEventosCategoriaForm: function(){
        var me = this;
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
                                required: "Debe ingresar el nombre de la categor&iacute;a."
                        },
                        listaTipo:{
                                 required: "Debe seleccionar el tipo."
                        }
		}
	});
        
        $("#btn-nueva-categoria").on("click", function() {
		if ($("#agrega-categoria-form").valid()) {
                    me.guardarCategoria();                  
		} else {
		    return;
		}
	});
    },
    obtenerTipos: function(){
         $.ajax({
            url : SiteName+"Data/getTipos",
            type : 'POST',
            dataType : 'json',
            success : function(resultado) {
                var html = '';
                for (var i = 0, len = resultado.Data.length; i < len; ++i) {
                    html += '<option value="' + resultado.Data[i]['IdTipo'] + '">' + resultado.Data[i]['Nombre'] + '</option>';
                }   
                $("#listaTipo").append(html);
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});
    }, 
   guardarCategoria: function(){
    var me = this;
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
                      if(resultado.success){
                        if($("#field-IdTipo").val()!=0){
                             $('#field-IdTipo').val($("#field-IdTipo").val()).change();
                        }
                        FuncionesComunes.delayAction(function(){
                            me.modal.close();    
                        }, 2500);                       
                      }
            },
            error : function(xhr, ajaxOptions, thrownError) {
            }
	});   
   }   
};

jQuery(function () {
    $('<span class="add-icon" Id="agregar-categoria" title="Agregar Categoría"></span>').insertAfter('#IdCategoria_input_box');   
    categoria.inicializar();
});
