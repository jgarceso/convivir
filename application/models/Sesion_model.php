<?php

class Sesion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function verificar_usuario($name, $pass) {
        $query = $this->db->query("SELECT * FROM user_pwd WHERE name='$name' AND pass='$pass'");
        $result = $query->result_array();
        return count($result) > 0;
    }

    public function cambiarPassword($user, $pass) {
        $query = $this->db->query("UPDATE `user_pwd` SET `pass`='$pass' WHERE `name`='$user'");
        return true;
    }

    public function validarClaveActual($usuario, $pass) {
        $query = $this->db->query("SELECT * FROM user_pwd WHERE pass='$pass' and name='$usuario' ");
        $row = $query->row();
        return isset($row);
    }

    public function existeEmail($email) {
        $query = $this->db->query("SELECT name FROM user_pwd WHERE email='$email'");

        $aux = null;

        $result = $query->result_array();
        if (count($result) > 0) {
            foreach ($query->result() as $row):
                $aux = $row->name;
            endforeach;
        }
        return $aux;
    }

}
