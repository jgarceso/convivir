<?php

class Data_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function get_Tipos($id = null){
              if(! is_null($id)){
                $query = $this->db->select("*")->from("tipoproducto")->where("IdTipo",$id)->get();
                if($query->num_rows()==1){
                    return $query->row_array();
                }
                return null;
            }
             $query = $this->db->select("*")->from("tipoproducto")->get();
             
            if($query->num_rows()>0){
                return $query->result_array();
            }
            return null;
	}
        
        
          public function get_CategoriasxTipo($id = null){
            if(! is_null($id)){
                $query = $this->db->select("*")->from("categoriaproducto")->where("IdTipo",$id)->get();
                if($query->num_rows()>0){
                    return $query->result_array();
                }else{
                      return null;
                }
            }
             $query = $this->db->select("*")->from("categoriaproducto")->order_by("Nombre")->get();
             
            if($query->num_rows()>0){
                return $query->result_array();
            }
            
            return null;
	}
}
