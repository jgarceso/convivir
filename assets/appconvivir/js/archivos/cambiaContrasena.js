$(document).ready(function() {
	$("#btn-newPass").on("click", function() {
		if ($("#newPass-form").valid()) {
                       guardarPass();
		} else {
			return;
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
});

function guardarPass() {
     $aux = getUrlVars()["username"];
	$.ajax({
		url : "Security/cambiarPassword",
		type : 'POST',
		dataType : 'json',
		data : {
			pass : $("#input-newPass").val(),
                        validaPassActual:false,
                        username:$aux 
		},
		success : function(resultado) {
		FuncionesComunes.afterSave(resultado.Correcto, resultado.Mensaje);
                 setTimeout(function(){
                                window.location = resultado.Url;
                              }, 2500);		
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});
};

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}