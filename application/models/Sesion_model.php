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
        
        public function changePass($user, $pass){
		$query = $this->db->query("UPDATE `user_pwd` SET `pass`='$pass' WHERE `name`='$user'");
                 return true;
               // echo 'filas->'.$this->db->affected_rows();
//                if ($this->db->affected_rows()==1){
//                     return true;
//                }else{
//                     return false;
//                } 
	}
        
        public function isExits($pass){
		$query = $this->db->query("SELECT * FROM user_pwd WHERE pass='$pass' ");
                $row = $query->row();
                if (isset($row)){
                     return true;
                }else{
                     return false;
                } 
        }
        
        public function getUser($name, $pass){
		$query = $this->db->query("SELECT email FROM user_pwd WHERE name='$name' AND pass='$pass'");
                return $query->result_array();
//                foreach ($this->db->result() as $row):
//                    $email = $row->email;
//                echo $email;
//                endforeach;
//                
//                return email;
	}
         
}
