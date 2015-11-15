<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class PuntosVenta extends BaseController {

    private $archivos_css = array(
        "convivir.css"
    );
    private $archivos_js = array(
    );

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "PuntosVenta";
    }

    public function index() {
        $this->grocery_crud->set_table('puntoventa');
        $this->grocery_crud->set_subject('Punto de Venta');

        $this->grocery_crud->columns('Nombre', 'Direccion');
        $this->grocery_crud->fields('Nombre', 'Direccion', 'IdRegion','IdProvincia','IdComuna');
        //$this->grocery_crud->display_as('IdCategoria', 'IdCategoria')->display_as('Nombre', 'Nombre categoría')->display_as('IdTipo', 'Tipo');
        $this->grocery_crud->required_fields('Nombre', 'Direccion', 'IdRegion','IdProvincia','IdComuna');
        $this->grocery_crud->set_relation('IdComuna', 'comuna', 'Nombre');
        $this->grocery_crud->set_relation('IdRegion', 'region', 'Nombre');
        $this->grocery_crud->set_relation('IdProvincia', 'provincia', 'Nombre');

        $this->set_css_files($this->archivos_css);
        $this->set_js_files($this->archivos_js);

        $output = $this->grocery_crud->render();

        $this->mostrar_pagina("puntosventa", $output);
    }

}
