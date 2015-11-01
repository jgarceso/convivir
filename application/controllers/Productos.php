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
                        
			$this->grocery_crud -> set_table('producto');
			$this->grocery_crud -> set_subject('Productos');
			$this->grocery_crud -> columns('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$this->grocery_crud-> fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$this->grocery_crud -> display_as('Descripcion', 'Producto') -> display_as('IdEmpresa', 'Empresa') -> display_as('IdCategoria', 'Categoría') 
			-> display_as('IdSubcategoria', 'SubCategoría') -> display_as('IdTipo', 'Tipo') -> display_as('IdEstadoCertificacion', 'Estado');
			$this->grocery_crud -> required_fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$this->grocery_crud -> set_relation('IdTipo', 'tipoproducto', 'Nombre');
			$this->grocery_crud -> set_relation('IdCategoria','categoriaproducto','Nombre');
			$this->grocery_crud -> set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
			$this->grocery_crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
		 
			$this->set_css_files($this->archivos_css);
			$this->set_js_files($this->archivos_js);
                        
                        $this->grocery_crud -> callback_column($this->unique_field_name('IdEstadoCertificacion'),array($this,'showImage'));
			$this->grocery_crud -> set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
                        
                        $this->grocery_crud ->callback_add_field('IdCategoria', array($this, 'empty_categoria_dropdown_select'));
			$this->grocery_crud ->callback_edit_field('IdCategoria', array($this, 'empty_categoria_dropdown_select'));
			$this->grocery_crud ->callback_add_field('IdSubcategoria', array($this, 'empty_subcategoria_select'));
			$this->grocery_crud ->callback_edit_field('IdSubcategoria', array($this, 'empty_subcategoria_select'));
                        $this->grocery_crud ->order_by('Descripcion','asc');
                        
			$output = $this->grocery_crud -> render();
			$dd_data = array(				
				'dd_state' =>  $this->grocery_crud ->getState(),
				'dd_dropdowns' => array('IdTipo','IdCategoria','IdSubcategoria'),
				'dd_url' => array('', site_url().'/productos/get_categorias/', site_url().'/productos/get_subcategorias/'),
				'dd_ajax_loader' => $this->config->site_url().$this->convivir->imagenes_path.'ajax-loader.gif'
			);
			$output->dropdown_setup = $dd_data;
			$this -> mostrar_pagina("productos", $output);
		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}
    function showImage($value) {  
      if($value=='Vigente'){
            return '<div class="circulo-estado-verde" title="'.$value.'"></div>';
      }else if($value=='Caducada'){
             return '<div class="circulo-estado-rojo" title="'.$value.'"></div>';
      }else if($value=='En Renovación'){
             return '<div class="circulo-estado-amarillo" title="'.$value.'"></div>';
      }
    }    
  
    function unique_field_name($field_name) {
             return 's'.substr(md5($field_name),0,8); 
    }
    //CALLBACK FUNCTIONS
    function empty_categoria_dropdown_select()
    {
            $empty_select = '<select name="IdCategoria" class="chosen-select" data-placeholder="Seleccione Categor&iacute;a">';
            $empty_select_closed = '</select>';
            $listingID = $this->uri->segment(4);
            $crud = new grocery_CRUD();
            $state = $crud->getState();

            if(isset($listingID) && $state == "edit") {
                    $this->db->select('IdTipo, IdCategoria')
                                     ->from('producto')
                                     ->where('IdProducto', $listingID);
                    $db = $this->db->get();
                    $row = $db->row(0);
                    $IdTipo = $row->IdTipo;
                    $stateID = $row->IdCategoria;

                    $this->db->select('*')
                                     ->from('categoriaproducto')
                                     ->where('IdCategoria', $IdTipo);
                    $db = $this->db->get();
                    
                    foreach($db->result() as $row):
                            if($row->IdCategoria == $stateID) {
                                    $empty_select .= '<option value="'.$row->IdCategoria.'" selected="selected">'.$row->Nombre.'</option>';
                            } else {
                                    $empty_select .= '<option value="'.$row->IdCategoria.'">'.$row->Nombre.'</option>';
                            }
                    endforeach;
                    return $empty_select.$empty_select_closed;
            } else {
                    return $empty_select.$empty_select_closed;	
            }
        }
            
    function empty_subcategoria_select(){
            $empty_select = '<select name="IdSubcategoria" class="chosen-select" data-placeholder="Seleccione SubCategor&iacute;a">';
            $empty_select_closed = '</select>';
            $listingID = $this->uri->segment(4);

            $crud = new grocery_CRUD();
            $state = $crud->getState();

            if(isset($listingID) && $state == "edit") {
                    $this->db->select('IdCategoria, IdSubcategoria')
                                     ->from('producto')
                                     ->where('IdProducto', $listingID);
                    $db = $this->db->get();
                    $row = $db->row(0);
                    $stateID = $row->IdCategoria;
                    $cityID = $row->IdSubcategoria;

                    $this->db->select('*')
                                     ->from('subcategoriaproducto')
                                     ->where('IdCategoria', $stateID);
                    $db = $this->db->get();

                    foreach($db->result() as $row):
                            if($row->IdSubcategoria == $cityID) {
                                    $empty_select .= '<option value="'.$row->IdSubcategoria.'" selected="selected">'.$row->Nombre.'</option>';
                            } else {
                                    $empty_select .= '<option value="'.$row->IdSubcategoria.'">'.$row->Nombre.'</option>';
                            }
                    endforeach;
                    return $empty_select.$empty_select_closed;
            } else {
                    return $empty_select.$empty_select_closed;	
            }
    }
				
    function get_categorias()
    {
            $IdTipo = $this->uri->segment(3);
            $this->db->select("*")
                             ->from('categoriaproducto')
                             ->where('IdTipo', $IdTipo);
            $db = $this->db->get();

            $array = array();
            foreach($db->result() as $row):
                    $array[] = array("value" => $row->IdCategoria, "property" => $row->Nombre);
            endforeach;
            echo json_encode($array);
            exit;
    }
	
    function get_subcategorias()
    {
            $stateID = $this->uri->segment(3);
            $this->db->select("*")
                             ->from('subcategoriaproducto')
                             ->where('IdCategoria', $stateID);
            $db = $this->db->get();
            $array = array();
            foreach($db->result() as $row):
                    $array[] = array("value" => $row->IdSubcategoria, "property" => $row->Nombre);
            endforeach;
            echo json_encode($array);
            exit;
    }
}
