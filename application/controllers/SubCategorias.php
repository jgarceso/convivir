<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class SubCategorias extends BaseController {


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
			   $this->controllerName = "SubCategorias";
	}

	public function index() {
			$this->grocery_crud -> set_table('subcategoriaproducto');
			$this->grocery_crud -> set_subject('Subcategorías');

			$this->grocery_crud -> columns('Nombre', 'IdCategoria');
			$this->grocery_crud-> fields('Nombre', 'IdCategoria');
			$this->grocery_crud -> display_as('IdCategoria', 'Nombre categoría') -> display_as('Nombre', 'Nombre subcategoría');
			$this->grocery_crud -> required_fields('IdCategoria', 'Nombre');
			$this->grocery_crud -> set_relation('IdCategoria', 'categoriaproducto', 'Nombre');
                        
			$this->set_css_files($this->archivos_css);
			$this->set_js_files($this->archivos_js);

			$output = $this->grocery_crud -> render();
                        
			$this -> mostrar_pagina("subcategorias", $output);
	}
}
