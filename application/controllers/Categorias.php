<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Categorias extends BaseController {


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
	}

	public function index() {
			$this->grocery_crud -> set_table('categoriaproducto');
			$this->grocery_crud -> set_subject('Categorías');

			$this->grocery_crud -> columns('Nombre', 'IdTipo');
			$this->grocery_crud-> fields('Nombre', 'IdTipo');
			$this->grocery_crud -> display_as('IdCategoria', 'IdCategoria') -> display_as('Nombre', 'Nombre') -> display_as('IdTipo', 'Tipo');
			$this->grocery_crud -> required_fields('IdCategoria', 'Nombre', 'IdTipo');
			/*$this->grocery_crud->required_fields('city');*/
			$this->grocery_crud -> set_relation('IdTipo', 'tipoproducto', 'Nombre');
			//$this->grocery_crud -> set_relation('IdCategoria', 'categoriaproducto', 'Nombre');
			//$this->grocery_crud->set_relation_dependency('IdCategoria','IdTipo','IdTipo');
			//$this->grocery_crud -> set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
			//$this->grocery_crud->set_relation_dependency('IdSubcategoria','IdCategoria','IdCategoria');
			//$this->grocery_crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
			//$this->grocery_crud -> set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
			/*$this->grocery_crud->fields('Descripcion','IdCategoria','IdEmpresa');
			 $this->load->model('categoria_model');
			 $categorias = $this->categoria_model->obtener_categorias();
			 $this->grocery_crud->field_type('IdCategoria','dropdown', $categorias);
			 */
                        
                        $this->set_css_files($this->archivos_css);
                        $this->set_js_files($this->archivos_js);

			$output = $this->grocery_crud -> render();
                        
			$this -> mostrar_pagina("categorias", $output);
	}
}
