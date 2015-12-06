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
        width: 800,
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
        {id: 5, text: 'No recordar'}
    ];
    $('#grid-productos-alerta').w2grid({
        name: 'grid',
        fixedBody: true,
        columns: [
            {field: 'Descripcion', caption: 'Producto', size: '150px'},
            {field: 'Empresa', caption: 'Empresa', size: '100px'},
            {field: 'FechaVencimiento', caption: 'Vencimiento', size: '85px'},
            {field: 'NombreContacto', caption: 'Contacto', size: '110px'},
            {field: 'EmailContacto', caption: 'Email', size: '115px', 
            render: function (record, index, col_index) {
                    var html = '<a href="mailto:'+record.EmailContacto+'">'+record.EmailContacto+'</a>';
                    return html;
                }
            },
            {field: 'TelefonoContacto', caption: 'Teléfono', size: '90px'},
            {field: 'IdOpcionAlerta', caption: 'Recordar', size: '120px', editable: {type: 'select', items: opciones},
                render: function (record, index, col_index) {
                    var html = '<span class="icon-mano" id="icono-usuario" onClick="w2ui.grid.editField('+record.recid+','+col_index+');" title="Elegir recordatorio"></span>';
                    for (var p in opciones) {
                        if (opciones[p].id == this.getCellValue(index, col_index))
                            html = '<div title="Click para editar" onClick="w2ui.grid.editField('+record.recid+','+col_index+');">'+opciones[p].text+'</div>';
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
                    '<button id="btn-alerta" type="button">Cerrar</button>' +
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
    var alerta = w2ui['grid'].getChanges()[0];
    
    if(alerta.IdOpcionAlerta == "")
    {
       w2ui.grid.save();//guardar solo en forma local
       return; 
    }
    
    $.ajax({
        url: "Alerta/guardar_alertas",
        type: 'POST',
        dataType: 'json',
        data: {
            alerta: JSON.stringify(alerta)
        },
        success: function (exitoso) {
            if(exitoso)
                w2ui.grid.save();
            FuncionesComunes.afterSave(exitoso);
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}

