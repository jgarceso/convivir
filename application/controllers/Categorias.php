<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Categorias extends BaseController {

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "Categorias";
    }

    public function index() {
        $this->grocery_crud->set_table('categoriaproducto');
        $this->grocery_crud->set_subject('Categorías');

        $this->grocery_crud->columns('Nombre', 'IdTipo');
        $this->grocery_crud->fields('Nombre', 'IdTipo');
        $this->grocery_crud->display_as('IdCategoria', 'IdCategoria')->display_as('Nombre', 'Nombre categoría')->display_as('IdTipo', 'Tipo');
        $this->grocery_crud->required_fields('IdCategoria', 'Nombre', 'IdTipo');
        $this->grocery_crud->set_relation('IdTipo', 'tipoproducto', 'Nombre');
        
        $this->grocery_crud->callback_before_delete(array($this, 'valida_categoria'));
        $this->grocery_crud->set_lang_string('delete_error_message', 'Si desea eliminar la categor&iacute;a primero debe eliminar los productos y subcategorías asociadas.');

        $output = $this->grocery_crud->render();
        $this->mostrar_pagina("categorias", $output);
    }
    
   function valida_categoria($primary_key) {
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
