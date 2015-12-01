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
   this.modal =  new jBox('Modal', {
            constructOnInit:true,
            title: 'Certificación',
            width: 600,
            content: ObtenerHtmlAlerta(),
            closeButton:'title',
            onCreated: function () {
                CrearGrilla(data);
                SetearEventos();
            },
            onClose: function(){
                
            }
     });
     this.modal.open();
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

function ObtenerHtmlAlerta(){
    var html ='<div>'+ 
                    '<div style="margin-bottom:10px;">La certificación de los siguientes productos está próxima a vencer</div>'+
                    '<div id="grid-productos-alerta" style="width: 100%; height: 200px;"></div>'+
                    '<div style="margin-top:10px;">'+
                        '<div style="float:left;">'+
                            '<label style="padding-right:8px;" for="alerta-selector">Recordar en</label>'+
                            '<select id="alerta-selector">'+
                                '<option value="1">1 día</option>'+
                                '<option value="2">2 días</option>'+
                                '<option value="3">3 días</option>'+
                                '<option value="4">Siempre</option>'+
                                '<option value="5">No volver a recordar</option>'+
                            '</select>'+
                        '</div>'+
                        '<div style="float:right;" class="default-btn">'+
                            '<button id="btn-alerta" type="button">Guardar</button>'+
                        '</div>'+
                    '</div>'+
            '</div>';
    return html;
}

function SetearEventos(modal){
    var page = this;
    $("#btn-alerta").on("click", function() {
            page.modal.close();
	});
}
