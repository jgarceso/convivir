$(document).ready(function() {
	$("#btn-login").on("click", function() {
		if ($("#login-form").valid()) {
			IniciarSesion();
		} else {
			return;
		}
	});

	$("#login-form").validate({
		rules : {
			usuario : {
				required : true,
				minlength : 4
			},
			password : {
				required : true,
				minlength : 4
			},
                        captcha:{
                                required: true,
                                minlength : 5
                        }
		},
		messages : {
			usuario : {
				required : "Debe escribir un usuario",
				minlength : jQuery.validator.format("El usuario debe tener al menos {0} caracteres")
			},
			password : {
				required : "Debe escribir un password",
				minlength : jQuery.validator.format("El password debe tener al menos {0} caracteres")
			},
                        captcha : {
				required : "Debe escribir el código de verificación",
				minlength : jQuery.validator.format("El código de verificación debe tener al menos {0} caracteres")
			}
		}
	});
        
        $("#refresh-captcha").on("click", function(){
            $("#captcha-result").attr("src","Security/obtenerCaptcha?rnd=" + Math.random());
        });
});

function CheckButton() {
	if ($("#login-form").valid()) {
		$('#btn-login').prop('disabled', false);
	} else {
		$('#btn-login').prop('disabled', 'disabled');
	}
};

function IniciarSesion() {
	//$("#validar-celular").loader();
	$.ajax({
		url : "Security/login",
		type : 'POST',
		dataType : 'json',
		data : {
			usuario : $("#input-usuario").val(),
			password : $("#input-password").val(),
                        captcha: $("#input-captcha").val()
		},
		success : function(data) {
			if (data.Correcto == false) {
                            $("#captcha-result").attr("src","Security/obtenerCaptcha?rnd=" + Math.random());
				alert(data.Mensaje);
			}else{
				window.location = data.Url;
			}
			
			//$.loader.close();
		},
		error : function(xhr, ajaxOptions, thrownError) {
			//$.loader.close();
		}
	});
};

var nav4 = window.Event ? true : false;
function AceptaNumero(evt) {
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57));
};
