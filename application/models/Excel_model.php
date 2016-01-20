<?php

class Excel_model  extends CI_Model  {

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
                return $query->result();
            }
            return null;
	}
        
        public function get_ProductosxTipo($idTipo = null, $idEstado = null){
            if(! is_null($idTipo) && ! is_null($idEstado)){
                 //$query = $this->db->select("*")->from("producto")->where("IdTipo",$idTipo)->where("IdEstadoCertificacion",$idEstado)->group_by("IdCategoria")->group_by("IdCategoria")->get();
                $query = $this->db->query("SELECT A.Descripcion, 
                        B.Nombre as Categoria, 
                        A.IdCategoria,
                        C.Nombre as SubCategoria, 
                        A.IdSubcategoria,
                        D.Nombre as Empresa 
                        FROM `producto` A 
                        left join categoriaproducto B on (A.IdCategoria = B.IdCategoria) 
                        left join subcategoriaproducto C on (A.IdSubcategoria = C.IdSubcategoria) 
                        left join empresa D on (A.IdEmpresa = D.IdEmpresa) 
                        Where A.`IdTipo`=".$idTipo." and A.`IdEstadoCertificacion`=".$idEstado." 
                        order BY A.`IdCategoria`, A.`IdSubcategoria`");
                
                if($query->num_rows()>0){
                     return $query->result();
                }else{
                      return null;
                }
            }
            $query = $this->db->select("*")->from("producto")->order_by("Descripcion")->get();
             
            if($query->num_rows()>0){
                return $query->result();
            }
            return null;
	}
        
         public function get_CategoriasxTipo($id = null){
            if(! is_null($id)){
                $query = $this->db->select("*")->from("categoriaproducto")->where("IdTipo",$id)->get();
                if($query->num_rows()>0){
                     return $query->result();
                }else{
                      return null;
                }
            }
            $query = $this->db->select("*")->from("categoriaproducto")->order_by("Nombre")->get();
             
            if($query->num_rows()>0){
                //echo $query->num_rows();
                return $query->result();
            }
            
            return null;
	}
        
         public function get_SubCategoriasxTipo($idCat = null){
            if(! is_null($idCat)){
                $query = $this->db->select("*")->from("subcategoriaproducto")->where("IdCategoria",$idCat)->get();
                if($query->num_rows()>1){
                    return $query->result_array();
                }else{
                     return $query->row_array();
                }
            }
             $query = $this->db->select("*")->from("subcategoriaproducto")->get();
             
            if($query->num_rows()>0){
                return $query->result_array();
            }
            
            return null;
	}
        
        
        public function get_Empresas($id = null){
            if(! is_null($id)){
                $query = $this->db->select("*")->from("empresa")->where("IdEmpresa",$id)->get();
                if($query->num_rows()==1){
                    return $query->row_array();
                }
                return null;
            }
             $query = $this->db->select("*")->from("empresa")->get();
            if($query->num_rows()>0){
                return $query->result_array();
            }
            
            return null;
	}
        
}
