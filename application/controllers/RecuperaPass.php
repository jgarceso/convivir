<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';
require_once 'Encripter.php';

class RecuperaPass extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->set_js_core_files(array("jquery-1.11.1.min.js"));
        $this->set_css_files(array("form-login.css"));
        $this->set_js_files(array("archivos/cambiaContrasena.js"));
        $this->mostrar_pagina("recuperaPass");
    }
    
    public function test() {
        $name = $_POST["prueba"];
        $mensaje = $name;
        $url = "";
        $correcto = true;
        $options="";
        try{
            $this->load->model('api_model');
            $data["array_tipos"]=$this->api_model->get_Tipos();

            foreach ($data["array_tipos"] as $row_tipo){
                     $options .= '<option value="' . $row_tipo->IdTipo . '">' . $row_tipo->Nombre . '</option>';
            }
        }catch(Exception $e){
            $mensaje="ocurrió un error al cargar los tipos asociados a las categorías.";
        }
        
        
        $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje, 'Opciones' => $options);
        echo json_encode($obj);

    }
    
      

}
