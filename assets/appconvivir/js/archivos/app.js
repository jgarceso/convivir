$(document).ready(function() {
    //eventos botones
	$("#btn-login").on("click", function() {
		if ($("#login-form").valid()) {
			IniciarSesion();
		} else {
			return;
		}
	});
        
        $("#btn-email").on("click", function() {
		if ($("#email-form").valid()) {
                       enviarEmail();
		} else {
			return;
		}
	});
        
        $("#btn-newPass").on("click", function() {
		if ($("#newPass-form").valid()) {
                       guardarPass();
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
        
        $("#email-form").validate({
		rules : {
                        email:{
                                required: true,
                                minlength : 10,
                                email:true
                        }
		},
		messages : {
                        email : {
				required : "Debe escribir un email.",
				minlength : jQuery.validator.format("El email debe tener al menos {0} caracteres"),
                                email : jQuery.validator.format("Debe ingresar una dirección de correo electrónico válida")
			}
		}
	});
        
        $("#newPass-form").validate({
		rules : {
                        newPass:{
                                required: true,
                                pwcheck: true,
                                minlength: 8
                        },
                        newPassConfirm:{
                                required: true,
                                equalTo: "#input-newPass"
                        }
		},
		messages : {
                        newPass : {
				required: "Especifique la contraseña",
                                pwcheck: "La contraseña no cumple los criterios.",
                                minlength: "La contraseña no cumple los criterios."
                                
			},
                        newPassConfirm : {
				required: "Especifique la contraseña",
                                equalTo: "Las contraseñas no coinciden"
			}
		}
	});
        
        $.validator.addMethod("pwcheck",
                        function(value, element) {
                            return /^[A-Za-z0-9\d=!\-@._*]+$/.test(value);
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

function enviarEmail() {
	//$("#validar-celular").loader();
       // alert($("#input-email").val());
	$.ajax({
		url : "EnviaPass/sendMailGmail",
		type : 'POST',
		dataType : 'json',
		data : {
			email : $("#input-email").val()
		},
            
		success : function(data) {
                    alert(data.Correcto);
			if (data.Correcto == false) {
                          //  $("#captcha-result").attr("src","Security/obtenerCaptcha?rnd=" + Math.random());
			//	alert(data.Mensaje);
                            alert("No enviado");
			}else{
                            alert(" enviado");
				//window.location = data.Url;
			}
			
			//$.loader.close();
		},
		error : function(xhr, ajaxOptions, thrownError) {
			//$.loader.close();
		}
	});
};

function guardarPass() {
	//$("#validar-celular").loader();
        alert("1111");
	$.ajax({
		url : "RecuperaPass/changePass",
		type : 'POST',
		dataType : 'json',
		data : {
			newPass : $("#input-newPass").val()
		},
               
		success : function(data) {
                     alert('22222');
                    alert(data.Correcto);
			if (data.Correcto == false) {
                          //  $("#captcha-result").attr("src","Security/obtenerCaptcha?rnd=" + Math.random());
			//	alert(data.Mensaje);
                                      alert(" NO hecho");    
			}else{
                            alert(" hecho");
				//window.location = data.Url;
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
