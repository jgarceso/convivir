function success_message(success_message) {
	noty({
		text : success_message,
		type : 'success',
		dismissQueue : true,
		layout : 'top',
		callback : {
			afterShow : function() {

				setTimeout(function() {
					$.noty.closeAll();
				}, 2000);
			}
		}
	});
}

function error_message(error_message) {
	noty({
		text : error_message,
		type : 'error',
		layout : 'top',
		dismissQueue : true
	});
}

function form_success_message(success_message) {
	/*$('#report-success').slideUp('fast');
	 $('#report-success').html(success_message);

	 if ($('#report-success').closest('.ui-dialog').length !== 0) {
	 $('.go-to-edit-form').click(function(){

	 fnOpenEditForm($(this));

	 return false;
	 });
	 }

	 $('#report-success').slideDown('normal');
	 $('#report-error').slideUp('fast').html('');*/

	noty({
		text : "Sus datos han sido guardados correctamente.",
		type : 'success',
		dismissQueue : true,
		layout : 'top',
		callback : {
			afterShow : function() {

				setTimeout(function() {
					$.noty.closeAll();
				}, 2000);
			}
		}
	});
}

function form_error_message(error_message) {
	/*
	 $('#report-error').slideUp('fast');
	 $('#report-error').html(error_message);
	 $('#report-error').slideDown('normal');
	 $('#report-success').slideUp('fast').html('');*/

	noty({
		text : "El formulario tiene errores. Verifique los campos requeridos.",
		type : 'error',
		modal : true,
		dismissQueue : true,
		layout : 'top',
		closeWith : ['button', 'click'],
		callback : {
			afterShow : function() {
			}
		}
	});
}

function confirmar(message, successfn) {

	var confirmed = false;
	noty({
		text : message,
		type : 'alert',
		modal : true,
		dismissQueue : true,
		buttons : [{
			addClass : 'btn btn-primary',
			text : 'Aceptar',
			onClick : function($noty) {
				successfn.call();
				$noty.close();
			}
		}, {
			addClass : 'btn btn-danger',
			text : 'Cancelar',
			onClick : function($noty) {
				$noty.close();
			}
		}]
	});
}