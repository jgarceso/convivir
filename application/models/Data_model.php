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
        
        public function buscar_productos ($strBusqueda, $camposBusqueda, $limite){
        
        $sql = "SELECT * FROM (
                                SELECT p.Descripcion AS Producto, t.Nombre AS Tipo, c.Nombre AS Categoría, sc.Nombre AS SubCategoría, e.Nombre as Empresa
                                FROM producto p
                                  INNER JOIN tipoproducto t ON p.IdTipo = t.IdTipo
                                  INNER JOIN categoriaproducto c ON c.IdCategoria = p.IdCategoria
                                  INNER JOIN subcategoriaproducto sc ON sc.IdSubcategoria = p.IdSubcategoria
                                  INNER JOIN empresa e ON e.IdEmpresa = p.IdEmpresa
                                WHERE t.IdTipo IN(".$camposBusqueda['tipo'].")
                                AND ";
        
        if($camposBusqueda['producto'] == true){
                                $sql = $sql."p.Descripcion LIKE '".$strBusqueda."%'" ;
        }
        $sql = $sql."          ) a
                LIMIT ".$limite."";
        
//       $sql = "SELECT * FROM (
//                                SELECT p.Descripcion AS Producto, t.Nombre AS Tipo, c.Nombre AS Categoría, sc.Nombre AS SubCategoría, e.Nombre as Empresa
//                                FROM producto p
//                                  INNER JOIN tipoproducto t ON p.IdTipo = t.IdTipo
//                                  INNER JOIN categoriaproducto c ON c.IdCategoria = p.IdCategoria
//                                  INNER JOIN subcategoriaproducto sc ON sc.IdSubcategoria = p.IdSubcategoria
//                                  INNER JOIN empresa e ON e.IdEmpresa = p.IdEmpresa
//                                WHERE t.IdTipo IN(".$camposBusqueda['tipo'].")
//                                  AND p.Descripcion LIKE '".$strBusqueda."%' 
//                                  OR c.Nombre LIKE 'pan%'
//                                  OR sc.Nombre LIKE 'pan%'
//                                  OR e.Nombre LIKE 'pan%'
//
//                                UNION
//
//                                SELECT p.Descripcion AS Producto, t.Nombre AS Tipo, c.Nombre AS Categoría, sc.Nombre AS SubCategoría, e.Nombre as Empresa
//                                FROM producto p
//                                  INNER JOIN tipoproducto t ON p.IdTipo = t.IdTipo
//                                  INNER JOIN categoriaproducto c ON c.IdCategoria = p.IdCategoria
//                                  INNER JOIN subcategoriaproducto sc ON sc.IdSubcategoria = p.IdSubcategoria
//                                  INNER JOIN empresa e ON e.IdEmpresa = p.IdEmpresa
//                                WHERE 1 = 1 
//                                  AND p.Descripcion LIKE '%pan%'
//                                  OR c.Nombre LIKE '%pan%'
//                                  OR sc.Nombre LIKE '%pan%'
//                                  OR e.Nombre LIKE 'pan%'
//                            ) a
//            LIMIT ".$limite."";
        
        var_dump($sql);
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
