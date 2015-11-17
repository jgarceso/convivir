<?php

class Common_model extends CI_Model {

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
         /*$array = array();
          foreach($db->result() as $row):
          $array[] = array("value" => $row->$campoValor, "property" => $row->$campoTexto);
          endforeach;
        
          return $array;
        
       /* foreach ($db->result_array() as $row) {
            $data[$row[$campoValor]] = $row[$campoTexto];
        }
        return $data;
        * */
        
    }

}
