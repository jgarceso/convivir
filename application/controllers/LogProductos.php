<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class LogProductos extends BaseController {

    private $archivos_css = array(
        "convivir.css",
        "demo.css"
    );
    private $archivos_js = array(
    );

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "LogProductos";
    }

    public function index() {
        try {
            
            $this->grocery_crud->set_table('log_producto');
            $this->grocery_crud->set_subject('Log Productos');
             $this->grocery_crud->unset_add();
            $this->grocery_crud->unset_edit();
            $this->grocery_crud->unset_delete();
            $this->grocery_crud->columns('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion','FechaModificacion',
                     'Accion');
            $this->grocery_crud->fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion',
                    'Accion');
            $this->grocery_crud->display_as('Descripcion', 'Producto')->display_as('IdEmpresa', 'Empresa')->display_as('IdCategoria', 'Categoría')
                    ->display_as('IdSubcategoria', 'SubCategoría')->display_as('IdTipo', 'Tipo')->display_as('IdEstadoCertificacion', 'Estado')->display_as('FechaModificacion', 'Fecha Movimiento');
            $this->grocery_crud->set_relation('IdTipo', 'tipoproducto', 'Nombre');
            $this->grocery_crud->set_relation('IdCategoria', 'categoriaproducto', 'Nombre');
            $this->grocery_crud->set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
            $this->grocery_crud->set_relation('IdEmpresa', 'empresa', 'Nombre');
            $this->grocery_crud->callback_column($this->unique_field_name('IdEstadoCertificacion'), array($this, 'showImage'));
            $this->grocery_crud->set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
            $this->grocery_crud->order_by('FechaModificacion', 'desc');
            $this->set_css_files($this->archivos_css);
            $this->set_js_files($this->archivos_js);
            $output = $this->grocery_crud->render();
            $this->mostrar_pagina("logProductos", $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function showImage($value) {
        if ($value == 'Vigente') {
            return '<div class="circulo-estado-verde" title="' . $value . '"></div>';
        } else if ($value == 'Caducada') {
            return '<div class="circulo-estado-rojo" title="' . $value . '"></div>';
        } else if ($value == 'En Renovación') {
            return '<div class="circulo-estado-amarillo" title="' . $value . '"></div>';
        }
    }

}
