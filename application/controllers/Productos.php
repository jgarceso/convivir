<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Productos extends BaseController {

    private $archivos_css = array(
        "convivir.css",
        "demo.css",
        "form-validation.css"
    );
    private $archivos_js = array(
    );

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "Productos";
    }

    public function index() {
        try {
            $this->grocery_crud->set_model('producto_model');
            $this->grocery_crud->set_table('producto');
            $this->grocery_crud->set_subject('Productos');
            $this->grocery_crud->columns('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
            $this->grocery_crud->fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion','FechaModificacion');
            $this->grocery_crud->display_as('Descripcion', 'Producto')->display_as('IdEmpresa', 'Empresa')->display_as('IdCategoria', 'Categoría')
                    ->display_as('IdSubcategoria', 'SubCategoría')->display_as('IdTipo', 'Tipo')->display_as('IdEstadoCertificacion', 'Estado')->display_as('FechaModificacion', 'Última Actualización');
            $this->grocery_crud->add_fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
            $this->grocery_crud->required_fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
            $this->grocery_crud->set_relation('IdTipo', 'tipoproducto', 'Nombre');
            $this->grocery_crud->set_relation('IdCategoria', 'categoriaproducto', 'Nombre');
            $this->grocery_crud->set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
            $this->grocery_crud->set_relation('IdEmpresa', 'empresa', 'Nombre');
            $this->grocery_crud->callback_column($this->unique_field_name('IdEstadoCertificacion'), array($this, 'showImage'));
            $this->grocery_crud->set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
            $this->grocery_crud->order_by('Descripcion', 'asc');
            $this->grocery_crud->change_field_type('FechaModificacion','readonly',date('d-m-Y H:i:s'));
            $this->grocery_crud->callback_after_insert(array($this, 'log_producto_after_insert'));
            $this->grocery_crud->callback_after_update(array($this, 'log_producto_after_update'));
            $this->grocery_crud->callback_before_delete(array($this, 'log_producto_before_delete'));
            $this->set_css_files($this->archivos_css);
            $this->set_js_files($this->archivos_js);
            $output = $this->grocery_crud->render();
            $this->mostrar_pagina("productos", $output);
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

    function log_producto_after_insert($post_array, $primary_key) {
        $log_producto = $this->obtener_array_log_producto($primary_key,(object)$post_array, "Ingresar");
        $this->db->insert('log_producto', $log_producto);
        return true;
    }

    function log_producto_after_update($post_array, $primary_key) {      
        $log_producto = $this->obtener_array_log_producto($primary_key,(object)$post_array, "Actualizar");
        $this->db->insert('log_producto', $log_producto);
        return true;
    }

    function log_producto_before_delete($primary_key) {
        $this->db->where('IdProducto', $primary_key);
        $prod = $this->db->get('producto')->row();

        if (empty($prod))
            return false;

        $log_producto = $this->obtener_array_log_producto($primary_key,$prod, "Eliminar");
        $this->db->insert('log_producto', $log_producto);
        return true;
    }
    
    private function obtener_array_log_producto ($primary_key,$prod, $accion){
         $log_producto = array(
            "IdProducto" => $primary_key,
            "Descripcion" => $prod->Descripcion,
            "IdTipo" => $prod->IdTipo,
            "IdSubcategoria" => $prod->IdSubcategoria,
            "IdEmpresa" => $prod->IdEmpresa,
            "IdCategoria" => $prod->IdCategoria,
            "IdEstadoCertificacion" => $prod->IdEstadoCertificacion,
            "UsuarioModifica" => $_SESSION["usuario"],
            "Accion" => $accion
        );
       return $log_producto;
    }

}
