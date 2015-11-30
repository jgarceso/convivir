jQuery(function () {
   ObtenerProductosAlerta();
});

function ObtenerProductosAlerta(){
    $.ajax({
		url : "Inicio/obtener_productos_alerta",
		type : 'POST',
		dataType : 'json',
		success : function(data) {
                if(data.length > 0){
                    MostrarModalAlerta(data);
                }
			//$.loader.close();
		},
		error : function(xhr, ajaxOptions, thrownError) {
			//$.loader.close();
		}
	});
}

function MostrarModalAlerta(data){
    new jBox('Modal', {
            constructOnInit:true,
            title: 'Certificación',
            width:600,
            content: '<div id="grid-productos-alerta" style="width: 100%; height: 200px;"></div>',
            closeButton:'title',
            onCreated: function () {
                CrearGrilla(data);
            },
            onClose: function(){
                
            }
     }).open();        
};

function CrearGrilla(data){
    $('#grid-productos-alerta').w2grid({ 
        name: 'grid',
        fixedBody: true,
        columns: [                
            { field: 'Descripcion', caption: 'Producto', size: '30%' },
            { field: 'Empresa', caption: 'Empresa', size: '30%' },
            { field: 'NombreContacto', caption: 'Contacto', size: '30%' },
            { field: 'EmailContacto', caption: 'Email', size: '40%' },
            { field: 'TelefonoContacto', caption: 'Teléfono', size: '120px' }
        ],
        records:data
    });    
}

