$(document).ready(function() {
	$("#btn-login").on("click", function() {
		if ($("#login-form").valid()) {
			IniciarSesion();
		} else {
			return;
		}
	});

	/*$("#input-usuario").on('blur keyup', function() {
		CheckButton();
	});

	$("#input-password").on('blur keyup', function() {
		CheckButton();
	});
*/
	$("#login-form").validate({
		rules : {
			usuario : {
				required : true,
				minlength : 4
			},
			password : {
				required : true,
				minlength : 4
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
			}
		}
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
		url : "php/validar.php",
		type : 'POST',
		dataType : 'json',
		data : {
			usuario : $("#input-usuario").val(),
			password : $("#input-password").val()
		},
		success : function(data) {
			if (data.Correcto == false) {
				alert("Usuario o password incorrectos");
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

function MostrarResultadoConsulta(data) {
	$("#nombre-compania").text(data.Compania);
	$("#imagen-compania").attr("src", data.ImgUrl);
};

function BorrarResultado() {
	$("#nombre-compania").text("");
	$("#imagen-compania").attr("src", "");
};

var nav4 = window.Event ? true : false;
function AceptaNumero(evt) {
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57));
};
