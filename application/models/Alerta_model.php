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
    
    /*public function guardar_alertas($alerta){
        var_dump($idsProductos);
        $query; $resultado;        
        if($opcionSeleccionada == '4'){//Recordar siempre. Eliminar alertas guardadas.
            $strIN = implode(",",$idsProductos);
            $query = sprintf("DELETE a FROM alertaproducto a 
                        WHERE IdProducto IN (%s)",$strIN );

            $resultado = $this->db->query($query);
        }else{
            $strFechaRecordatorio;
            $query = "INSERT INTO alertaproducto
                        VALUES (%s,%s,NOW()) ON DUPLICATE KEY UPDATE 
                        FechaRecordatorio = %s,
                        FechaModificacion = NOW()";
            
            if($opcionSeleccionada == '5'){//No recordar. Fecha recordatorio NULL
                $strFechaRecordatorio = "NULL";
                
            }else{
                $strFechaRecordatorio = sprintf("DATE_ADD(NOW(),INTERVAL %s DAY)",$opcionSeleccionada);
            }          
             foreach ($idsProductos as $idProducto) {
                 $query = sprintf($query,$idProducto,$strFechaRecordatorio,$strFechaRecordatorio);
                 $resultado = $this->db->query($query);
             }
        }
        return $resultado;
    }*/
}
