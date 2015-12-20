var empresa = {
    inicializar: function () {
        var me = this;
        me.modal = new jBox('Modal', {
            constructOnInit: true,
            attach: $('#agregar-empresa'),
            title: 'Empresa',
            width: 400,
            content: me.agregarEmpresaHtml(),
            closeButton: 'title',
            onCreated: function () {
                me.setearEventosEmpresaForm();
            },
            onClose: function () {
                $("#agrega-empresa-form").validate().resetForm();
            }
        });
    },
    agregarEmpresaHtml: function () {
        var html =
    '<form  id="agrega-empresa-form" class="form-login">'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Nombre Empresa</span>'+
                        '</label>'+
                        '<input id="input-nuevaEmpresa" type="text" name="nuevaEmpresa" maxlength="50" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label>'+
                    '<span>Nombre Contacto</span>'+
                    '<input id="input-nombreContacto" type="text" name="nombreContacto" maxlength="50" onpaste="return false;">'+
                '</label>'+
            '</div>'+
            '<div class="form-row">'+
              '<label>'+
                   '<span>Email Contacto</span>'+
                   '<input id="input-emailContacto" type="text" name="emailContacto" maxlength="50" onpaste="return false;">'+
               '</label>'+
           '</div>'+
           '<div class="form-row">'+
              '<label>'+
                   '<span>Teléfono Contacto</span>'+
                   '<input id="input-fonoContacto" type="text" name="fonoContacto" maxlength="12" onpaste="return false;">'+
               '</label>'+
           '</div>'+
           '<div class="form-row">'+
                '<button id="btn-nueva-empresa" type="button">Guardar</button>'+
            '</div>'+
           '</div>'+
    '</form>';
        return html;
    },
    setearEventosEmpresaForm: function () {
        var me = this;
        $("#agrega-empresa-form").validate({
            rules: {
                nuevaEmpresa: {
                    required: true
                },
                emailContacto: {
                    email: true
                }
            },
            messages: {
                nuevaEmpresa: {
                    required: "Debe ingresar el nombre de la empresa."
                },
                email: {
                    email: "Ingrese un email valido.",
                }
            }
        });

        $("#btn-nueva-empresa").on("click", function () {
            if ($("#agrega-empresa-form").valid()) {
                me.guardarEmpresa();
            } else {
                return;
            }
        });
    },
    guardarEmpresa: function () {
        var me = this;
        $.ajax({
            url: SiteName + "Empresas/index/insert",
            type: 'POST',
            dataType: 'json',
            data: {
                Nombre: $("#input-nuevaEmpresa").val(),
                NombreContacto: $("#input-nombreContacto").val(),
                EmailContacto: $("#input-emailContacto").val(),
                TelefonoContacto: $("#input-fonoContacto").val(),
            },
            success: function (resultado) {
                FuncionesComunes.afterSave(resultado.success, resultado.success_message);
                if (resultado.success) {
                    $('#field-IdEmpresa').append($('<option>').text($("#input-nuevaEmpresa").val()).attr('value', resultado.insert_primary_key));
                    $('#field-IdEmpresa').trigger('liszt:updated');
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
    $('<span class="add-icon" Id="agregar-empresa" title="Agregar Empresa"></span>').insertAfter('#IdEmpresa_input_box');
    empresa.inicializar();
});
