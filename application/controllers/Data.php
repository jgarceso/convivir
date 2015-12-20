<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Data extends BaseController {

	public function __construct() {
		parent::__construct();
                $this->load->model('data_model');
	}

    public function getTipos() {
        $mensaje = "";
        $correcto = true;
        $options="";
            try{
                $data=$this->data_model->get_Tipos();

               // foreach ($data["array_tipos"] as $row_tipo){
                 //        $options .= '<option value="' . $row_tipo->IdTipo . '">' . $row_tipo->Nombre . '</option>';
                //}
            }catch(Exception $e){
                $correcto = false;
                $mensaje="ocurrió un error al cargar los tipos asociados a las categorías.";
            }
        $obj = (object) array('Correcto' => $correcto, 'Mensaje' => $mensaje, 'Data' => $data);
        echo json_encode($obj);
    }
    
     public function getCategorias() {
        $mensaje = "";
        $correcto = true;
        $options="";
            try{
                $data=$this->data_model->get_CategoriasxTipo();
//                foreach ($data["array_cat"] as $row_tipo){
//                         $options .= '<option value="' . $row_tipo->IdCategoria . '">' . $row_tipo->Nombre . '</option>';
//                }
            }catch(Exception $e){
                $correcto = false;
                $mensaje="ocurrió un error al cargar las categorías.";
            }
            $obj = (object) array('Correcto' => $correcto, 'Mensaje' => $mensaje, 'Data' => $data);
            echo json_encode($obj);
     }    
}
