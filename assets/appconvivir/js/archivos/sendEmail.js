var mailPage = {
    inicializar: function () {
        var me = this;
        $("#btn-email").on("click", function () {
            if ($("#email-form").valid()) {
                me.enviarEmail();
            } else {
                return;
            }
        });

        $("#email-form").validate({
            rules: {
                email: {
                    required: true,
                    minlength: 10,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Debe escribir un email.",
                    minlength: jQuery.validator.format("El email debe tener al menos {0} caracteres"),
                    email: jQuery.validator.format("Debe ingresar una dirección de correo electrónico válida")
                }
            }
        });
    },
    enviarEmail: function () {
        $.ajax({
            url: "Security/sendEmailRecuperaPassword",
            type: 'POST',
            dataType: 'json',
            data: {
                email: $("#input-email").val()
            },
            success: function (resultado) {
                FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje, 3);
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    }
};

jQuery(function () {
    mailPage.inicializar();
});