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
       echo 'laaaaaala';
       
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
//$this->grocery_crud->set_lang_string('delete_error_message', 'Existeoría.');
            echo $integridad;
            return $integridad;

       }catch(Exception $e){
           echo 'error';
           return false;
       }

        
       
       
//        $IdTipo = $this->uri->segment(3);
//        $this->db->select("*")
//                ->from('categoriaproducto')
//                ->where('IdTipo', $IdTipo)
//                ->order_by('Nombre');
//        $db = $this->db->get();
//        $array = array();
//        foreach ($db->result() as $row):
//            $array[] = array("value" => $row->IdCategoria, "property" => $row->Nombre);
//        endforeach;
//        echo json_encode($array);
//        exit;
        
//        $mensaje = "";
//        $url = "";
//        $correcto = true;
//        $options="";
//        
//            try{
//                $this->load->model('api_model');
//                $data["array_cat"]=$this->api_model->get_CategoriasxTipo();
//                foreach ($data["array_cat"] as $row_tipo){
//                         $options .= '<option value="' . $row_tipo->IdCategoria . '">' . $row_tipo->Nombre . '</option>';
//                }
//            }catch(Exception $e){
//                $mensaje="ocurrió un error al cargar las categorías.";
//            }
//        $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje, 'Opciones' => $options);
//        echo json_encode($obj);
    }
    
    

}
