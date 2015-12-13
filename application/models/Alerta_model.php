<?php

class Alerta_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener_productos_en_alerta($diasCertificacionMenosAlerta, $diasCertificacion) {
        $query = $this->db->query("SELECT p.IdProducto as recid, p.Descripcion, ap.FechaRecordatorio, DATE_FORMAT(FechaCertificacion, '%d-%m-%Y') as FechaCertificacion, 
                                    DATE_FORMAT(DATE_ADD(FechaCertificacion,INTERVAL ".$diasCertificacion." DAY),'%d-%m-%Y') as FechaVencimiento,
                                    e.Nombre as Empresa, e.NombreContacto,e.EmailContacto,e.TelefonoContacto
                                    FROM producto p
                                    INNER JOIN empresa e
                                        ON p.IdEmpresa = e.IdEmpresa
                                    LEFT JOIN alertaproducto ap
                                        ON p.IdProducto = ap.IdProducto
                                    WHERE DATEDIFF(NOW(),FechaCertificacion) >= ".$diasCertificacionMenosAlerta."
                                        AND YEAR(p.FechaCertificacion) > '2010'
                                        AND (ap.IdOpcionAlerta <> 5 OR ap.IdOpcionAlerta IS NULL) /*DISTINTO A NO RECORDAR*/
                                        AND (CURDATE() >= ap.FechaRecordatorio OR ap.IdOpcionAlerta = 4 OR ap.IdProducto IS NULL)");

        $result = $query->result_array();
        return $result;
    }

    public function guardar_alertas($alerta){
        $opcionSeleccionada = $alerta->IdOpcionAlerta;
        $query; $resultado;        
            $strFechaRecordatorio;
            $query = "INSERT INTO alertaproducto
                        VALUES (%s,%s,%s,NOW()) ON DUPLICATE KEY UPDATE
                        IdOpcionAlerta = %s,
                        FechaRecordatorio = %s,
                        FechaModificacion = NOW()";
            
            if($opcionSeleccionada == '4' || $opcionSeleccionada == '5'){//Recordar siempre / No recordar. Fecha recordatorio NULL
                $strFechaRecordatorio = "NULL";
                
            }else{
                $strFechaRecordatorio = sprintf("DATE_ADD(NOW(),INTERVAL %s DAY)",$opcionSeleccionada);
            }          
                 $query = sprintf($query,$alerta->recid,$opcionSeleccionada,$strFechaRecordatorio,$opcionSeleccionada,$strFechaRecordatorio);
                 $resultado = $this->db->query($query);

        return $resultado;
    }
}
