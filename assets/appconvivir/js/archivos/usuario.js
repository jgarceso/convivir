var menuUsuario = {
  inicializar: function(){
      var me = this;
       $('#icono-usuario').jBox('Tooltip', {
        position: {
			x: 'center',
			y: 'bottom'
		},
        content: '<ul class="user-menu">' +
                '<li><a id="usuario-datos" href="#">Mis datos</a></li>' +
                '<li><a id="cambio-clave" href="#">Cambiar Contraseña</a></li>' +
                '<li><a id="config-sistema" href="#">Configuración</a></li>' +
                '</ul>',
        closeOnMouseleave: true,
        onCreated: function () {
            me.crearModales();
        }
    });    
  }, 
  
crearModales: function(){
    var me = this;
    new jBox('Modal', {
            constructOnInit:true,
            attach: $('#cambio-clave'),
            title: 'Cambiar Contraseña',
            width:400,
            content: me.obtenerCambioClaveHtml(),
            closeButton:'title',
            onCreated: function () {
                me.setearEventosFormulario();
            },
            onClose: function(){
                $("#cambiar-pass-form").validate().resetForm();
            }
     }); 
     
     new jBox('Modal', {
            constructOnInit:true,
            attach: $('#config-sistema'),
            title: 'Configuración Sistema',
            width:400,
            content: me.obtenerHtmlConfig(),
            closeButton:'title',
            onCreated: function () {
                me.obtenerSettings();
                me.setearEventosConfig(this);
            },
            onClose: function(){
                
            }
     });
},
obtenerCambioClaveHtml: function(){
    var html = 
   '<form  id="cambiar-pass-form" >'+

         '<div class="default-form">'+
            '<div class="form-row">'+
                        '<label>'+
                            '<span>Contraseña Actual</span>'+
                        '</label>'+
                        '<input id="input-passwordActual" type="password" name="claveActual" maxlength="12" onpaste="return false;">'+
            '</div>'+
            '<div class="form-row">'+
               '<label>'+
                    '<span>Nueva Contraseña</span>'+
                    '<input id="input-password" type="password" name="claveNueva" maxlength="12" onpaste="return false;">'+
                '</label>'+
            '</div>'+
            '<div class="form-row">'+
              '<label>'+
                   '<span>Confirme Contraseña</span>'+
                   '<input id="input-confirmPass" type="password" name="confClave" maxlength="12" onpaste="return false;">'+
               '</label>'+
           '</div>'+
           '<div class="form-row">'+
                '<button id="btn-cambio-clave" type="button">Cambiar</button>'+
            '</div>'+
           '</div>'+
    '</form>';
            return html;
},
setearEventosFormulario: function(){
    var me = this;
     $("#cambiar-pass-form").validate({
		rules : {
                        claveActual:{
                                required: true
                        },
                        claveNueva:{
                                required: true,
                                pwcheck: true,
                                minlength: 6
                        },
                        confClave:{
                                required: true,
                                equalTo: "#input-password"
                        }
		},
		messages : {
                        claveActual:{
                                required: "Debe escribir su contraseña actual"
                        },
                        claveNueva : {
				required: "Especifique la contraseña",
                                pwcheck: "La contraseña no cumple los criterios.",
                                minlength: "Largo mínimo 6 caracteres."
                                
			},
                        confClave : {
				required: "Especifique la contraseña",
                                equalTo: "Las contraseñas no coinciden"
			}
		}
	});
        
        $.validator.addMethod("pwcheck",
                        function(value, element) {
                            return /^[A-Za-z0-9\d=!\-@._*]+$/.test(value);
        });
        
        $("#btn-cambio-clave").on("click", function() {
		if ($("#cambiar-pass-form").valid()) {
                       me.cambiarClave();
		} else {
			return;
		}
	});
},
cambiarClave: function (){
    $.ajax({
		url : SiteName+"Security/cambiarPassword",
		type : 'POST',
		dataType : 'json',
		data : {
			pass : $("#input-password").val(),
                        validaPassActual:true,
                        passActual:$("#input-passwordActual").val()
		},
               
		success : function(resultado) {
		FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje);
                        if(resultado.Correcto){
                        FuncionesComunes.delayAction(function(){
                                window.location = resultado.Url;
                              }, 2500);
                        }                        
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
},
obtenerHtmlConfig: function() {
    var html = '<div>' +
                '<div style="margin-bottom:10px;">En esta grilla puede modificar parámetros usados por el sistema</div>' +
                    '<div id="grid-configuracion" style=" width:370px; height: 200px;"></div>' +
                    '<div style="margin-top:10px;">' +
                    
                    '<div style="float:right;" class="default-btn">' +
                    '<button id="btn-config" type="button">Cerrar</button>' +
                    '</div>' +
                '</div>' +
            '</div>';
    return html;
},

obtenerSettings: function() {
    var me = this;
    $.ajax({
        url: SiteName+"Setting/obtener_settings",
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {
                me.crearGrillaConfig(data);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        }
    });
},
crearGrillaConfig:function(data) {
    var me = this;
    $('#grid-configuracion').w2grid({
        name: 'gridConfig',
        fixedBody: true,
        columns: [
            {field: 'Descripcion', caption: 'Setting', size: '300px'},
            {field: 'Valor', caption: 'Valor', size: '68px',render: 'int', editable: { type: 'int', min: 0, max: 1000 },
            render: function (record, index, col_index) {
                    var html = '<div style="cursor:pointer;" title="Click para editar" onClick="w2ui.gridConfig.editField('+record.recid+','+col_index+');">'+record.Valor+'</div>';
                    return html;
                }}
        ],
        records: data,
        onChange: function (target, event) {
            event.onComplete = function () {
                me.guardarSetting();
            };
        }
    });
 },
 
 setearEventosConfig: function(modal) {
       $("#btn-config").on("click", function () {
        modal.close();
    });
},

guardarSetting: function() {
    var setting = w2ui['gridConfig'].getChanges()[0];
     if(setting.Valor === "")
    {
       return; 
    }
    
    $.ajax({
        url: SiteName+"Setting/guardar_settings",
        type: 'POST',
        dataType: 'json',
        data: {
            setting: JSON.stringify(setting)
        },
        success: function (resultado) {
            if(resultado.Correcto)
                w2ui['gridConfig'].save();
            FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje);
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
};

jQuery(function () {
    menuUsuario.inicializar();   
});