<?php

class Setting_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function obtener_settings(){
		$query = $this->db->query("SELECT * FROM setting");
 
                $result = $query->result_array();
                
                return $result;
	
	}
}
