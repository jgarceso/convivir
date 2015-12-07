FuncionesComunes = {
    mostrarNotificacion: function (segundos, color, contenido, fnClose) {
        new jBox('Notice', {
            content: contenido,
            width: 200,
            color: color,
            position: {
                x: 'center',
                y: 'top'
            },
            offset: {x: 15, y: 100},
            autoClose: segundos * 1000,
            onCloseComplete: function () {
                if (jQuery.isFunction(fnClose)) {
                    fnClose.call();
                }
            }
        });
    },
    afterSave: function (exitoso, mensaje, tiempo) {
        if (tiempo == null || tiempo == undefined) {
            tiempo = 2;
        }
        var color = exitoso ? 'green' : 'red';
        this.mostrarNotificacion(tiempo, color, mensaje);
    }
};

