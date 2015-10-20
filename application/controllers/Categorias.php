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
		       $this->controllerName = "Categorias";
	}

	public function index() {
			$this->grocery_crud -> set_table('categoriaproducto');
			$this->grocery_crud -> set_subject('Categorías');

			$this->grocery_crud -> columns('Nombre', 'IdTipo');
			$this->grocery_crud-> fields('Nombre', 'IdTipo');
			$this->grocery_crud -> display_as('IdCategoria', 'IdCategoria') -> display_as('Nombre', 'Nombre categoría') -> display_as('IdTipo', 'Tipo');
			$this->grocery_crud -> required_fields('IdCategoria', 'Nombre', 'IdTipo');
			$this->grocery_crud -> set_relation('IdTipo', 'tipoproducto', 'Nombre');
	                        
			$this->set_css_files($this->archivos_css);
			$this->set_js_files($this->archivos_js);

			$output = $this->grocery_crud -> render();
                        
			$this -> mostrar_pagina("categorias", $output);
	}
}
