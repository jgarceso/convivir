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
    
     function valida_subcategoria($primary_key) {
     $integridad = false;
       try{
            $this->db->select("*")
                    ->from('subcategoriaproducto')
                    ->where('IdCategoria', $primary_key);
            $resultCat = $this->db->get();
            echo '111';
            $this->db->select("*")
                    ->from('producto')
                    ->where('IdCategoria', $primary_key);
            $resultSub = $this->db->get();
            echo '222';
            if(count($resultCat)>0){
                $integridad = false;
            }
            if(count($resultSub)>0){
                $integridad = false;
            }
            echo $integridad;
            return $integridad;

       }catch(Exception $e){
           echo 'error';
           return false;
       }
    }

}
