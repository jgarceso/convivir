<?php

class api_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function get_Tipos(){
		$query = $this->db->query("SELECT * FROM tipoproducto");
 
                $result = $query->result_array();
                
                return $result;
	
	}
        
        public function get_Productos(){
		$query = $this->db->query("SELECT * FROM producto");
 
                $result = $query->result_array();
                
                return $result;
	
	}
        
        
}
