<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';


class Setting extends BaseController {
    private $settings;

	public function __construct() {
		parent::__construct();
               $this->check_session();
               $this->load->model('setting_model');
	}
        
    public function obtener_settings (){        
        echo json_encode($this->get_settings());
    }
    
    public function guardar_settings (){
        $setting = json_decode($_POST["setting"]);
        $resultado = $this->setting_model->guardar_settings($setting);
        if($resultado){
            $this->get_settings(true);
        }
        echo json_encode($resultado);
    }
    
    private function get_settings($recargar = null){
        if($this->settings == null || $recargar){
            $this->settings = $this->setting_model->obtener_settings();
        }
        return $this->settings;
    }
}
