<?php

class Data_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_Tipos($id = null) {
        if (!is_null($id)) {
            $query = $this->db->select("*")->from("tipoproducto")->where("IdTipo", $id)->get();
            if ($query->num_rows() == 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select("*")->from("tipoproducto")->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    public function get_CategoriasxTipo($id = null) {
        if (!is_null($id)) {
            $query = $this->db->select("*")->from("categoriaproducto")->where("IdTipo", $id)->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return null;
            }
        }
        $query = $this->db->select("*")->from("categoriaproducto")->order_by("Nombre")->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function buscar_productos($strBusqueda, $camposBusqueda, $inicio, $largoPagina, $incluirTotal) {
        $likeInicio = "LIKE '" . $strBusqueda . "%'";
        $likeNormal = "LIKE '%" . $strBusqueda . "%'";
        $numFilas = null;
        
        $sqlComun = "SELECT p.Descripcion AS Producto, t.Nombre AS Tipo, c.Nombre AS Categoria, sc.Nombre AS SubCategoria, e.Nombre as Empresa, p.IdEstadoCertificacion
                                FROM producto p
                                  INNER JOIN tipoproducto t ON p.IdTipo = t.IdTipo
                                  INNER JOIN categoriaproducto c ON c.IdCategoria = p.IdCategoria
                                  INNER JOIN subcategoriaproducto sc ON sc.IdSubcategoria = p.IdSubcategoria
                                  INNER JOIN empresa e ON e.IdEmpresa = p.IdEmpresa
                                WHERE t.IdTipo IN(" . $camposBusqueda['tipo'] . ")";


        $sql = "SELECT  * FROM (
                               ".$sqlComun;
        $sql = $sql." ".$this->obtener_condiciones_sql_productos($camposBusqueda,$likeInicio);
        $sql = $sql."\n UNION ";
        $sql = $sql."\n ".$sqlComun;
        $sql = $sql." ".$this->obtener_condiciones_sql_productos($camposBusqueda,$likeNormal);
        $sql = $sql . "\n          ) a
                ORDER BY a.IdEstadoCertificacion";
        if($incluirTotal === 'true'){
            $numFilas = $this->db->query($sql)->num_rows();
        }
        $sql = $sql ." LIMIT " . $inicio . ",".$largoPagina;

        $datos = $this->db->query($sql)->result_array();
        $resultado = (object) array('Total' => $numFilas, 'Datos' => $datos);
        return $resultado;
    }

    private function obtener_condiciones_sql_productos($camposBusqueda, $likeStr) {
        $sql = "";
        $operadorLogico = "AND";
        if ($camposBusqueda['producto'] === 'true') {
            $sql = $sql . "\n " . $operadorLogico . " p.Descripcion ".$likeStr;
            $operadorLogico = "OR";
        }

        if ($camposBusqueda['categoria'] === 'true') {
            $sql = $sql . "\n " . $operadorLogico . " c.Nombre ".$likeStr;
            $operadorLogico = "OR";
        }

        if ($camposBusqueda['subcategoria'] === 'true') {
            $sql = $sql . "\n " . $operadorLogico . " sc.Nombre ".$likeStr;
            $operadorLogico = "OR";
        }

        if ($camposBusqueda['empresa'] === 'true') {
            $sql = $sql . "\n " . $operadorLogico . " e.Nombre ".$likeStr;
        }
        return $sql;
    }
}
