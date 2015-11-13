<?php

class Sesion_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function verificar_usuario($name, $pass){
		$query = $this->db->query("SELECT * FROM user_pwd WHERE name='$name' AND pass='$pass'");
 
                $result = $query->result_array();
                
                return count($result) > 0;
	
	}
}
