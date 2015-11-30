<?php

class Alerta_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener_productos_en_alerta() {

        $query = $this->db->query("SELECT p.IdProducto as recid, p.Descripcion, e.Nombre as Empresa, e.NombreContacto,e.EmailContacto,e.TelefonoContacto
                                        FROM producto p
                                        INNER JOIN empresa e
                                        ON p.IdEmpresa = e.IdEmpresa
                                        WHERE DATEDIFF(NOW(),FechaCertificacion) >= (365-20)
                                        AND YEAR(p.FechaCertificacion) > '2010'");

        $result = $query->result_array();

        return $result;
    }

}
