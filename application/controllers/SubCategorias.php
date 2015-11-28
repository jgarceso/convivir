<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class SubCategorias extends BaseController {

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "SubCategorias";
    }

    public function index() {
        $this->grocery_crud->set_table('subcategoriaproducto');
        $this->grocery_crud->set_subject('Subcategorías');

        $this->grocery_crud->columns('Nombre', 'IdCategoria');
        $this->grocery_crud->fields('Nombre', 'IdCategoria');
        $this->grocery_crud->display_as('IdCategoria', 'Nombre categoría')->display_as('Nombre', 'Nombre subcategoría');
        $this->grocery_crud->required_fields('IdCategoria', 'Nombre');
        $this->grocery_crud->set_relation('IdCategoria', 'categoriaproducto', 'Nombre');

        $output = $this->grocery_crud->render();

        $this->mostrar_pagina("subcategorias", $output);
    }

}
