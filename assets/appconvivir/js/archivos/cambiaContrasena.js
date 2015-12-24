var contrasenaPage = {
    inicializar: function () {
        var me = this;
        $("#btn-newPass").on("click", function () {
            if ($("#newPass-form").valid()) {
                me.guardarPass();
            } else {
                return;
            }
        });
        $("#newPass-form").validate({
            rules: {
                newPass: {
                    required: true,
                    pwcheck: true,
                    minlength: 8
                },
                newPassConfirm: {
                    required: true,
                    equalTo: "#input-newPass"
                }
            },
            messages: {
                newPass: {
                    required: "Especifique la contraseña",
                    pwcheck: "La contraseña no cumple los criterios.",
                    minlength: "La contraseña no cumple los criterios."

                },
                newPassConfirm: {
                    required: "Especifique la contraseña",
                    equalTo: "Las contraseñas no coinciden"
                }
            }
        });

        $.validator.addMethod("pwcheck",
                function (value) {
                    return /^[A-Za-z0-9\d=!\-@._*]+$/.test(value);
                });
    },
    guardarPass: function () {
        $user = FuncionesComunes.getUrlVars()["username"];
        $.ajax({
            url: "Security/cambiarPassword",
            type: 'POST',
            dataType: 'json',
            data: {
                pass: $("#input-newPass").val(),
                validaPassActual: false,
                username: $user
            },
            success: function (resultado) {
                FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje);
                if (resultado.Correcto) {
                    FuncionesComunes.delayAction(function () {
                        window.location = resultado.Url;
                    }, 2500);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    }
};

jQuery(function () {
    contrasenaPage.inicializar();
});
