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
                $this->load->model('setting_model');
	}
        
    public function obtener_productos_alerta (){ 
        $diasCertificacion = $this->setting_model->obtener_setting_por_nombre('CantDiasCertificacion');
        $diasAlerta = $this->setting_model->obtener_setting_por_nombre('CantDiasAlertaVencimiento');
        $diasCertificacionMenosAlerta = $diasCertificacion - $diasAlerta;
        $resultado = $this->alerta_model->obtener_productos_en_alerta($diasCertificacionMenosAlerta, $diasCertificacion);
        echo json_encode($resultado);
    }
    
    public function guardar_alertas (){
        $mensaje = 'Ha ocurrido un error al guardar la alerta';
        $alerta = json_decode($_POST["alerta"]);
        $resultado = $this->alerta_model->guardar_alertas($alerta);
        if($resultado){
            $mensaje = 'Alerta guardada exitosamente.';
        }
        $obj = (object) array('Correcto' => $resultado, 'Mensaje' => $mensaje);
        echo json_encode($obj);
    }
}
