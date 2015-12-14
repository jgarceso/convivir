<?php

class Api_model  extends CI_Model  {

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
        
        public function get_Productos($id = null){
            if(! is_null($id)){
                $query = $this->db->select("*")->from("producto")->where("IdProducto",$id)->get();
                if($query->num_rows()==1){
                    return $query->row_array();
                }
                return null;
            }
             $query = $this->db->select("*")->from("producto")->get();
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
                return $query->result();
            }
            
            return null;
	}
        
         public function get_SubCategoriasxTipo($idCat = null){
            if(! is_null($idCat)){
                $query = $this->db->select("*")->from("subcategoriaproducto")->where("IdCategoria",$idCat)->get();
                if($query->num_rows()>0){
                    return $query->result_array();
                }else{
                      return null;
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
             $query = $this->db->select("*")->from("empresa")->order_by("Nombre")->get();
            if($query->num_rows()>0){
                return $query->result();
            }
            
            return null;
	}
        
         public function save($product){
            
           $this->db->set($this->_setProduct($product))->insert("products");
           
           if($this->db->affected_rows()==1){
               return $this->db->insert_id();
           }
           return null;          
	}
        
         public function update($product){
              $this->db->set($this->_setProduct($product))->where("id",$id)->update("products");
           
           if($this->db->affected_rows()==1){
               return true;
           }
           return null;     
         }
         
         private function _setProduct($product){
             return array(
                 "categoria"    =>  $product["categoria"],
                 "subcategoria" =>  $product["subcategoria"],
                 "tipo"         =>  $product["tipo"],
                 "empresa"      =>  $product["empresa"],
                 "estadoCertificacion" =>  $product["estadoCertificacion"],
                 "descripcion"  =>  $product["descripcion"]);
             
         }
         
          public function delete($id){
              $this->db->where("id",$id)->delete("producto");
           
           if($this->db->affected_rows()==1){
               return true;
           }
           return null;     
         }
        
        
}
