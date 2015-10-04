<?php

class categoria_Model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function obtener_categorias(){
		$query=$this->db->query("
		
		select c.IdCategoria, c.Nombre 
		from categoria c
		where c.IdCategoria not in (
		                             select distinct IdPadre
		                             from categoria                            
		                                      )
		and c.IdPadre > 0		
		");
 
		foreach ($query->result_array() as $row)
            {
                $data[$row['IdCategoria']] = $row['Nombre']; 
            }
			return $data;
	}
}
