<?php

class Common_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
        
        public function buscar_datos_sql($tabla, $idCampo,$idBusqueda){
            $this->db->select('*')
                                     ->from($tabla)
                                     ->where($idCampo, $idBusqueda);
                    $db = $this->db->get();
                    $row = $db->row(0);
                    return $row;
        }
}
