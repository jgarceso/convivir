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
		url : "Security/sendEmail",
		type : 'POST',
		dataType : 'json',
		data : {
			email : $("#input-email").val()
		},
            
		success : function(data) {
			if (data.Correcto == false) {
                            alert(data.Mensaje);
			}else{
                            alert(data.Mensaje);
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
};


var nav4 = window.Event ? true : false;



