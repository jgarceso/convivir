<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
    require_once 'BaseController.php';

class Administracion extends BaseController {


	public function __construct() {
		parent::__construct();
                
               $this->check_session();
	}

//	public function _mostrar_pagina($output = null) {
//		$this -> load -> view('administracion.php', $output);
//	}


	public function index() {
		try {
			$this->grocery_crud -> set_table('producto');
			$this->grocery_crud -> set_subject('Productos');

			$this->grocery_crud -> columns('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$this->grocery_crud-> fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$this->grocery_crud -> display_as('Descripcion', 'Producto') -> display_as('IdEmpresa', 'Empresa') -> display_as('IdCategoria', 'Categoría') 
			-> display_as('IdSubcategoria', 'SubCategoría') -> display_as('IdTipo', 'Tipo') -> display_as('IdEstadoCertificacion', 'Certificación');
			$this->grocery_crud -> required_fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			/*$this->grocery_crud->required_fields('city');*/
			$this->grocery_crud -> set_relation('IdTipo', 'tipoproducto', 'Nombre');
			$this->grocery_crud -> set_relation('IdCategoria', 'categoriaproducto', 'Nombre');
			//$this->grocery_crud->set_relation_dependency('IdCategoria','IdTipo','IdTipo');
			$this->grocery_crud -> set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
			//$this->grocery_crud->set_relation_dependency('IdSubcategoria','IdCategoria','IdCategoria');
			$this->grocery_crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
			$this->grocery_crud -> set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
			/*$this->grocery_crud->fields('Descripcion','IdCategoria','IdEmpresa');
			 $this->load->model('categoria_model');
			 $categorias = $this->categoria_model->obtener_categorias();
			 $this->grocery_crud->field_type('IdCategoria','dropdown', $categorias);
			 */
                        
                        $this->grocery_crud ->set_css($this->convivir->css_path ."convivir.css");
                        

			$output = $this->grocery_crud -> render();
                        
			$this -> mostrar_pagina("administracion", $output);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}

	public function listar_productos1() {
		try {
			$this->grocery_crud = new grocery_CRUD();

			$this->grocery_crud -> set_theme('datatables');
			$this->grocery_crud -> set_table('producto');
			$this->grocery_crud -> set_subject('Productos');
			/*$this->grocery_crud->required_fields('city');*/
			$this->grocery_crud -> fields('Descripcion', 'IdCategoria', 'IdEmpresa');
			$this -> load -> model('categoria_model');
			$categorias = $this -> categoria_model -> obtener_categorias();
			$this->grocery_crud -> field_type('IdCategoria', 'dropdown', $categorias);
			$this->grocery_crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
			$this->grocery_crud -> display_as('Descripcion', 'Producto') -> display_as('IdEmpresa', 'Empresa') -> display_as('IdCategoria', 'Categoria');
			$output = $this->grocery_crud -> render();

			$this -> _mostrar_pagina($output);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}

}
