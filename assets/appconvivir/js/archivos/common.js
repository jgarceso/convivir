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
        if (tiempo === null || tiempo === undefined) {
            tiempo = 2;
        }
        var color = exitoso ? 'green' : 'red';
        this.mostrarNotificacion(tiempo, color, mensaje);
    },
    delayAction: function (fn, time) {
        if (time === undefined || time === null)
            time = 2000;
        setTimeout(function () {
            fn.call();
        }, time);
    },
    getUrlVars: function () {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
};

