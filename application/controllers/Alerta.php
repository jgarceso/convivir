<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Alerta extends BaseController {

	public function __construct() {
		parent::__construct();
               $this->check_session();
               $this->load->model('alerta_model');
	}
        
    public function obtener_productos_alerta (){      
        $resultado = $this->alerta_model->obtener_productos_en_alerta();
        echo json_encode($resultado);
    }
    
    public function guardar_alertas (){
        $idsProductos = $_POST["productos"];
        $opcionSeleccionada = $_POST["opcionSeleccionada"];
        $resultado = $this->alerta_model->guardar_alertas($idsProductos,$opcionSeleccionada);
        echo json_encode($resultado);
    }
}