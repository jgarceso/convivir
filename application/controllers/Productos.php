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
			-> display_as('IdSubcategoria', 'SubCategoría') -> display_as('IdTipo', 'Tipo') -> display_as('IdEstadoCertificacion', 'Certificación');
			$this->grocery_crud -> required_fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$this->grocery_crud -> set_relation('IdTipo', 'tipoproducto', 'Nombre');
			
			$this->grocery_crud -> set_relation('IdCategoria','categoriaproducto','Nombre');
			$this->grocery_crud -> set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
			$this->grocery_crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
			$this->grocery_crud -> set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
			 
			$this->set_css_files($this->archivos_css);
			$this->set_js_files($this->archivos_js);

			$output = $this->grocery_crud -> render();
                        
			$this -> mostrar_pagina("productos", $output);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}
}
