<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Modales extends BaseController {

	public function __construct() {
		parent::__construct();
	}

    public function getTipos() {
        $mensaje = "";
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
    
     public function getCategorias() {
        $mensaje = "";
        $url = "";
        $correcto = true;
        $options="";
            try{
                $this->load->model('api_model');
                $data["array_cat"]=$this->api_model->get_CategoriasxTipo();
                foreach ($data["array_cat"] as $row_tipo){
                         $options .= '<option value="' . $row_tipo->IdCategoria . '">' . $row_tipo->Nombre . '</option>';
                }
            }catch(Exception $e){
                $mensaje="ocurrió un error al cargar las categorías.";
            }
            $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje, 'Opciones' => $options);
            echo json_encode($obj);
     }
     
     function getEmpresas() {
        $empty_select = "<select name='IdEmpresa' class='chosen-select' data-placeholder='Seleccione Empresa'>";
        $empty_select_closed = '</select>';
        
        $mensaje = "";
        $url = "";
        $correcto = true;
        $options="";
            try{
                $this->load->model('api_model');
                $data["array_emp"]=$this->api_model->get_Empresas();
                foreach ($data["array_emp"] as $row_tipo){
                         $empty_select .= '<option value="' . $row_tipo->IdEmpresa . '">' . $row_tipo->Nombre . '</option>';
                }
            }catch(Exception $e){
                $mensaje="ocurrió un error al cargar las empresas.";
            }
            
            $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje, 'Opciones' => $empty_select . $empty_select_closed);
            echo json_encode($obj);
            
    }
    
    
    
}
