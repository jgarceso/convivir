FuncionesComunes = {
    CrearNotice: function (segundos, contenido, fnClose) {
        var notice = new jBox('Notice', {
            content: contenido,
            autoClose: 1000 * segundos,
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
        return notice;
    }
};

