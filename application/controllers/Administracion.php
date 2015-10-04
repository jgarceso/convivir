<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Administracion extends CI_Controller {

	public function __construct() {
		parent::__construct();
                session_start();
                if (!isset($_SESSION["usuario"])) {
                        header("Location: /convivir/");
                }
		$this -> load -> database();
		$this -> load -> helper('url');

		$this -> load -> library('grocery_CRUD');
	}

	public function _mostrar_pagina($output = null) {
		$this -> load -> view('administracion.php', $output);
	}


	public function index() {
		try {
			$this -> load -> library('Grocery_CRUD');
			$this -> load -> library('ajax_grocery_CRUD');

			$crud = new ajax_grocery_CRUD();
			$crud -> set_table('producto');
			$crud -> set_subject('Productos');

			$crud -> columns('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$crud -> fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			$crud -> display_as('Descripcion', 'Producto') -> display_as('IdEmpresa', 'Empresa') -> display_as('IdCategoria', 'Categoría') 
			-> display_as('IdSubcategoria', 'SubCategoría') -> display_as('IdTipo', 'Tipo') -> display_as('IdEstadoCertificacion', 'Certificación');
			$crud -> required_fields('Descripcion', 'IdTipo', 'IdCategoria', 'IdSubcategoria', 'IdEmpresa', 'IdEstadoCertificacion');
			/*$crud->required_fields('city');*/
			$crud -> set_relation('IdTipo', 'tipoproducto', 'Nombre');
			$crud -> set_relation('IdCategoria', 'categoriaproducto', 'Nombre');
			//$crud->set_relation_dependency('IdCategoria','IdTipo','IdTipo');
			$crud -> set_relation('IdSubcategoria', 'subcategoriaproducto', 'Nombre');
			//$crud->set_relation_dependency('IdSubcategoria','IdCategoria','IdCategoria');
			$crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
			$crud -> set_relation('IdEstadoCertificacion', 'estadocertificacion', 'Nombre');
			/*$crud->fields('Descripcion','IdCategoria','IdEmpresa');
			 $this->load->model('categoria_model');
			 $categorias = $this->categoria_model->obtener_categorias();
			 $crud->field_type('IdCategoria','dropdown', $categorias);
			 */
			$crud -> unset_export();
			$crud -> unset_print();
			$crud->unset_back_to_list();
			$output = $crud -> render();

			$this -> _mostrar_pagina($output);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}

	public function listar_productos1() {
		try {
			$crud = new grocery_CRUD();

			$crud -> set_theme('datatables');
			$crud -> set_table('producto');
			$crud -> set_subject('Productos');
			/*$crud->required_fields('city');*/
			$crud -> fields('Descripcion', 'IdCategoria', 'IdEmpresa');
			$this -> load -> model('categoria_model');
			$categorias = $this -> categoria_model -> obtener_categorias();
			$crud -> field_type('IdCategoria', 'dropdown', $categorias);
			$crud -> set_relation('IdEmpresa', 'empresa', 'Nombre');
			$crud -> display_as('Descripcion', 'Producto') -> display_as('IdEmpresa', 'Empresa') -> display_as('IdCategoria', 'Categoria');
			$output = $crud -> render();

			$this -> _mostrar_pagina($output);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}

}
