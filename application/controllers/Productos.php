<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Productos extends BaseController {
    
    private $archivos_js = array(
        "lib/jquery-1.10.2.min.js",
        "lib/jquery.validate.min.js",
        "archivos/empresaModal.js"
    );
        

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "Productos";
    }

    public function index() {
        try {
            $this->set_js_files($this->archivos_js);
            $this->grocery_crud->set_model('producto_model');
            $this->grocery_crud->set_table('producto');
            $this->grocery_crud->set_subject('Productos');
            $this->grocery_crud->columns('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
            $this->grocery_crud->fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion', 'FechaModificacion');
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
            
           // $this->grocery_crud->callback_add_field('IdCategoria', array($this, 'empty_categoria_dropdown_select'));
             $this->grocery_crud->callback_add_field('IdCategoria', array($this, 'empty_categoria_dropdown_select'));
            $this->grocery_crud->callback_add_field('IdEmpresa',array($this,'add_field_callback_1'));
            
           
          //  $this->grocery_crud->callback_edit_field('IdCategoria', array($this, 'empty_categoria_dropdown_select'));
            $this->grocery_crud->callback_add_field('IdSubcategoria', array($this, 'empty_subcategoria_select'));
            $this->grocery_crud->callback_edit_field('IdSubcategoria', array($this, 'empty_subcategoria_select'));
            $this->grocery_crud->order_by('Descripcion', 'asc');
            $this->grocery_crud->change_field_type('FechaModificacion', 'readonly', date('d-m-Y H:i:s'));
            $this->grocery_crud->callback_after_insert(array($this, 'log_producto_after_insert'));
            $this->grocery_crud->callback_after_update(array($this, 'log_producto_after_update'));
            $this->grocery_crud->callback_before_delete(array($this, 'log_producto_before_delete'));
            $output = $this->grocery_crud->render();
            $dd_data = array(
                'dd_state' => $this->grocery_crud->getState(),
                'dd_dropdowns' => array('IdTipo', 'IdCategoria', 'IdSubcategoria'),
                'dd_url' => array('', site_url() . $this->controllerName.'/get_categorias/', site_url() . $this->controllerName.'/get_subcategorias/'),
                'dd_ajax_loader' => $this->config->site_url() . $this->convivir->imagenes_path . 'ajax-loader.gif'
            );
            $output->dropdown_setup = $dd_data;
            $this->mostrar_pagina("productos", $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    
    
function add_field_callback_1()
{
   return '<a href="#" style="color:black;" id="link-Empresa">Tizag Home</a>';
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
        $log_producto = $this->obtener_array_log_producto($primary_key, (object) $post_array, "Ingresar");
        $this->db->insert('log_producto', $log_producto);
        return true;
    }

    function log_producto_after_update($post_array, $primary_key) {
        $log_producto = $this->obtener_array_log_producto($primary_key, (object) $post_array, "Actualizar");
        $this->db->insert('log_producto', $log_producto);
        return true;
    }

    function log_producto_before_delete($primary_key) {
        $this->db->where('IdProducto', $primary_key);
        $prod = $this->db->get('producto')->row();

        if (empty($prod))
            return false;

        $log_producto = $this->obtener_array_log_producto($primary_key, $prod, "Eliminar");
        $this->db->insert('log_producto', $log_producto);
        return true;
    }

    function empty_categoria_dropdown_select() {
        $empty_select = '<select name="IdCategoria" class="chosen-select" data-placeholder="Seleccione Categor&iacute;a">';
        $empty_select_closed = '</select>';
        $listingID = $this->uri->segment(4);
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        if (isset($listingID) && $state == "edit") {
            $this->db->select('IdTipo, IdCategoria')
                    ->from('producto')
                    ->where('IdProducto', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $idTipo = $row->IdTipo;
            $idCategoria = $row->IdCategoria;

            $this->db->select('*')
                    ->from('categoriaproducto')
                    ->where('IdTipo', $idTipo)
                    ->order_by('Nombre');
            $db = $this->db->get();

            foreach ($db->result() as $row):
                if ($row->IdCategoria == $idCategoria) {
                    $empty_select .= '<option value="' . $row->IdCategoria . '" selected="selected">' . $row->Nombre . '</option>';
                } else {
                    $empty_select .= '<option value="' . $row->IdCategoria . '">' . $row->Nombre . '</option>';
                }
            endforeach;
            return $empty_select . $empty_select_closed;
        } else {
            return $empty_select . $empty_select_closed;
        }
    }

    function empty_subcategoria_select() {
        $empty_select = '<select name="IdSubcategoria" class="chosen-select" data-placeholder="Seleccione SubCategor&iacute;a">';
        $empty_select_closed = '</select>';
        $listingID = $this->uri->segment(4);

        $crud = new grocery_CRUD();
        $state = $crud->getState();

        if (isset($listingID) && $state == "edit") {
            $this->db->select('IdCategoria, IdSubcategoria')
                    ->from('producto')
                    ->where('IdProducto', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $idCategoria = $row->IdCategoria;
            $idSubcategoria = $row->IdSubcategoria;

            $this->db->select('*')
                    ->from('subcategoriaproducto')
                    ->where('IdCategoria', $idCategoria)
                    ->order_by('Nombre');
            $db = $this->db->get();

            foreach ($db->result() as $row):
                if ($row->IdSubcategoria == $idSubcategoria) {
                    $empty_select .= '<option value="' . $row->IdSubcategoria . '" selected="selected">' . $row->Nombre . '</option>';
                } else {
                    $empty_select .= '<option value="' . $row->IdSubcategoria . '">' . $row->Nombre . '</option>';
                }
            endforeach;
            return $empty_select . $empty_select_closed;
        } else {
            return $empty_select . $empty_select_closed;
        }
    }

    function get_categorias() {
        $IdTipo = $this->uri->segment(3);
        $this->db->select("*")
                ->from('categoriaproducto')
                ->where('IdTipo', $IdTipo)
                ->order_by('Nombre');
        $db = $this->db->get();
        $array = array();
        foreach ($db->result() as $row):
            $array[] = array("value" => $row->IdCategoria, "property" => $row->Nombre);
        endforeach;
        echo json_encode($array);
        exit;
    }

    function get_subcategorias() {
        $stateID = $this->uri->segment(3);
        $this->db->select("*")
                ->from('subcategoriaproducto')
                ->where('IdCategoria', $stateID)
                ->order_by('Nombre');
        $db = $this->db->get();
        $array = array();
        foreach ($db->result() as $row):
            $array[] = array("value" => $row->IdSubcategoria, "property" => $row->Nombre);
        endforeach;
        echo json_encode($array);
        exit;
    }

    private function obtener_array_log_producto($primary_key, $prod, $accion) {
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
