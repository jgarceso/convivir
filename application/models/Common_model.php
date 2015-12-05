<?php

class Alerta_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscar_fila_sql($tabla, $idCampo, $idBusqueda) {
        $this->db->select('*')
                ->from($tabla)
                ->where($idCampo, $idBusqueda);
        $db = $this->db->get();
        $row = $db->row(0);
        return $row;
    }

    public function obtener_datos_combo($tabla, $campoTexto, $campoFiltro, $idBusqueda) {
        $this->db->select("*")
                ->from($tabla)
                ->where($campoFiltro, $idBusqueda)
                ->order_by($campoTexto);
        $db = $this->db->get();
       
        return $db->result();        
    }

}
