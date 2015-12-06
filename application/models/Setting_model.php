<?php

class Setting_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function obtener_settings(){
		$query = $this->db->query("SELECT IdSetting as recid, Nombre, Descripcion, Valor FROM setting");
 
                $result = $query->result_array();
                
                return $result;
	
	}
        
        public function guardar_settings($setting){
            $query = sprintf("UPDATE setting
                      SET Valor = %s
                      WHERE IdSetting = %s",$setting->Valor, $setting->recid);
            $resultado = $this->db->query($query);
           return $resultado;         
        }
        
        public function obtener_setting_por_nombre($nombreSetting){
            $query = $this->db->query(sprintf("SELECT Nombre, Valor 
                                                FROM setting
                                                WHERE Nombre = '%s'",$nombreSetting));
 
                $result = $query->result_array();
                return $result[0]["Valor"];
        }
}
