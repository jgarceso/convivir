$(document).ready(function() {
    //eventos botones
        $("#btn-email").on("click", function() {
		if ($("#email-form").valid()) {
                       enviarEmail();
		} else {
			return;
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
        
       
});

function enviarEmail() {
	$.ajax({
		url : "EnviaPass/sendMailGmail",
		type : 'POST',
		dataType : 'json',
		data : {
			email : $("#input-email").val()
		},
            
		success : function(data) {
			if (data.Correcto == false) {
                            alert("No enviado");
			}else{
                            alert("enviado");
			}
			
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
};

function guardarPass() {
	$.ajax({
		url : "RecuperaPass/changePass",
		type : 'POST',
		dataType : 'json',
		data : {
			pass : $("#input-newPass").val(),
                        validaPassActual:false
		},
               
		success : function(data) {
			if (data.Correcto == false) {
		   	     alert(data.Mensaje);
 			}else{
                            alert(data.Mensaje);
                            window.location = data.Url;
			}
			
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
};

var nav4 = window.Event ? true : false;
function AceptaNumero(evt) {
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57));
};

//function redirectPass() {
//  header('Location: http://www.commentcamarche.net/forum/');  
//};

