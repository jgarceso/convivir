jQuery(function () {
    ObtenerProductosAlerta();
});

function ObtenerProductosAlerta() {
    $.ajax({
        url: "Alerta/obtener_productos_alerta",
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {
                MostrarModalAlerta(data);
            }
            //$.loader.close();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //$.loader.close();
        }
    });
}

function MostrarModalAlerta(data) {
    this.modal = new jBox('Modal', {
        constructOnInit: true,
        closeOnEsc:false,
        closeOnClick:false,
        title: 'Certificación',
        width: 600,
        content: ObtenerHtmlAlerta(),
        closeButton: 'title',
        onCreated: function () {
            CrearGrilla(data);
            SetearEventos();
        },
        onClose: function () {

        }
    });
    this.modal.open();
}
;

function CrearGrilla(data) {
    var opciones = [
        {id: 1, text: '1 día'},
        {id: 2, text: '2 días'},
        {id: 3, text: '3 días'},
        {id: 4, text: 'Siempre'},
        {id: 5, text: 'No volver a recordar'}
    ];
    $('#grid-productos-alerta').w2grid({
        name: 'grid',
        fixedBody: true,
        columns: [
            {field: 'Descripcion', caption: 'Producto', size: '30%'},
            {field: 'Empresa', caption: 'Empresa', size: '30%'},
            {field: 'NombreContacto', caption: 'Contacto', size: '30%'},
            {field: 'EmailContacto', caption: 'Email', size: '40%', 
            render: function (record, index, col_index) {
                    var html = '<a href="mailto:'+record.EmailContacto+'">'+record.EmailContacto+'</a>';
                    return html;
                }
            },
            {field: 'TelefonoContacto', caption: 'Teléfono', size: '120px'},
            {field: 'IdOpcionAlerta', caption: 'Recordar', size: '120px', editable: {type: 'select', intag:'Seleccione...', items: opciones},
                render: function (record, index, col_index) {
                    var html = '';
                    for (var p in opciones) {
                        if (opciones[p].id == this.getCellValue(index, col_index))
                            html = opciones[p].text;
                    }
                    return html;
                }
            }
        ],
        records: data,
        onChange: function (target, event) {
            event.onComplete = function () {
                GuardarAlertas();
            }
        }
    });
}

function ObtenerHtmlAlerta() {
    var html = '<div>' +
                '<div style="margin-bottom:10px;">La certificación de los siguientes productos está próxima a vencer</div>' +
                    '<div id="grid-productos-alerta" style="width: 100%; height: 200px;"></div>' +
                    '<div style="margin-top:10px;">' +
                    
                    '<div style="float:right;" class="default-btn">' +
                    '<button id="btn-alerta" type="button">Cancelar</button>' +
                    '</div>' +
                '</div>' +
            '</div>';
    return html;
}

function SetearEventos(modal) {
    var page = this;
    $("#btn-alerta").on("click", function () {
        page.modal.close();
    });
}

function GuardarAlertas() {
    $.ajax({
        url: "Alerta/guardar_alertas",
        type: 'POST',
        dataType: 'json',
        data: {
            alerta: JSON.stringify(w2ui['grid'].getChanges()[0])
        },
        success: function (exitoso) {
            AfterSave(exitoso);
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}

function AfterSave(exitoso){
    var mensaje; var color;
    if(exitoso){
       w2ui.grid.save();
       mensaje = "Cambios guardados.";
       color = 'green';
     }else{
       mensaje = "Ha ocurrido un error al actualizar.";
       color = 'red';       
    }
    FuncionesComunes.MostrarNotificacion(1.5,color, mensaje);
}

function ObtenerProductos() {
    var records = w2ui['grid'].records;
    var arrIds = [];
    for (var i = 0; i < records.length; i++) {
        arrIds.push(records[i].recid);
    }
    return arrIds;
}
