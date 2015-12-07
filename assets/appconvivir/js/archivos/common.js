FuncionesComunes = {
    mostrarNotificacion: function (segundos, color, contenido, fnClose) {
        new jBox('Notice', {
            content: contenido,
            color: color,
            autoClose: segundos * 1000,
            position: {
                x: 'center',
                y: 'center'
            },
            onCloseComplete: function(){
                if(jQuery.isFunction(fnClose)){
                    fnClose.call();
                }
            } 
        });
    },
    afterSave: function (exitoso, mensaje){
    var color = exitoso?'green':'red';
    this.mostrarNotificacion(1.5,color, mensaje);
    }
};

