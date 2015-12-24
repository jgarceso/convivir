var subcategoria = {
    inicializar: function () {
        var me = this;
        me.modal = new jBox('Modal', {
            constructOnInit: true,
            attach: $('#agregar-subcategoria'),
            title: 'SubCategor&iacute;a',
            width: 400,
            content: me.obtenerModalHtml(),
            closeButton: 'title',
            onCreated: function () {
                me.obtieneCategorias();
                me.setearEventosSubCateForm();
            },
            onClose: function () {
                $("#agrega-subcategoria-form").validate().resetForm();
            }
        });
    },
    obtieneCategorias: function () {
        $.ajax({
            url: SiteName + "Data/getCategorias",
            type: 'POST',
            dataType: 'json',
            success: function (resultado) {
                var html = '';
                for (var i = 0, len = resultado.Data.length; i < len; ++i) {
                    html += '<option value="' + resultado.Data[i]['IdCategoria'] + '">' + resultado.Data[i]['Nombre'] + '</option>';
                }
                $("#listaCategorias").append(html);
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    },
    obtenerModalHtml: function () {
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
               '<label class="selector">'+
                    '<span>Categor&iacute;a</span>'+
                    '<select name="listaCategorias" id="listaCategorias" class="required combos_modales" >'+
                    '<option class="options_modales" value="">-- Seleccione Categor&iacute;a --</option>'+
                    '</select>'+
                '</label>'+
            '</div>'+
           '<div class="form-row">'+
                '<button id="btn-nueva-subcategoria" type="button">Guardar</button>'+
            '</div>'+
           '</div>'+
        '</form>';
        return html;
    },
    setearEventosSubCateForm: function () {
        var me = this;
        $("#agrega-subcategoria-form").validate({
            rules: {
                nombreSubCategoria: {
                    required: true
                },
                listaCategorias: {
                    required: true
                },
            },
            messages: {
                nombreSubCategoria: {
                    required: "Debe ingresar el nombre de la subcategor&iacute;a."
                },
                listaCategorias: {
                    required: "Debe seleccionar una categor&iacute;a."
                }
            }
        });

        $("#btn-nueva-subcategoria").on("click", function () {
            if ($("#agrega-subcategoria-form").valid()) {
                me.guardarSubCategoria();
            } else {
                return;
            }
        });
    },
    guardarSubCategoria: function () {
        var me = this;
        $.ajax({
            url: SiteName + "SubCategorias/index/insert",
            type: 'POST',
            dataType: 'json',
            data: {
                Nombre: $("#input-nombreSubCategoria").val(),
                IdCategoria: $("#listaCategorias").val()
            },
            success: function (resultado) {
                FuncionesComunes.afterSave(resultado.success, resultado.success_message);
                if (resultado.success) {
                    $('select[name="IdCategoria"]').val($('select[name="IdCategoria"]').val()).change();
                    FuncionesComunes.delayAction(function(){
                            me.modal.close();    
                        }, 2500);
                }               
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    }
};

jQuery(function () {
    $('<span class="add-icon" Id="agregar-subcategoria" title="Agregar SubCategoría"></span>').insertAfter('#IdSubcategoria_input_box');
    subcategoria.inicializar();
});