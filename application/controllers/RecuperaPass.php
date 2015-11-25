<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class RecuperaPass extends BaseController {

    private $archivos_css = array(
        "convivir.css",
        "form-login.css"
    );
    
    private $archivos_js = array(
        "lib/jquery-1.10.2.min.js",
        "lib/jquery.validate.min.js",
        "archivos/app.js"
    );
    
    public function __construct() {
		parent::__construct();
 
                session_start();
                session_destroy();
    }
        
    public function index() {
        $this->set_css_files($this->archivos_css);
        $this->set_js_files($this->archivos_js);
        
        $password = '12345';
        $md5 = md5($password);
        
        $password2 = '12345';
        $md5 = md5($password2);
        
//        if($password->equals()){
//            
//        }
 
       echo $md5; // Salida: 2f559f951c7b56f9a63fa70522df586d
        $this -> mostrar_pagina("recuperaPass");
    }
        
  
 
	public function changePass()
	{
           
            $pass = $_POST["password"];
            $name = $_POST["name"];
            $mensaje = "";
            $url = "";
            $correcto = false;
            $this->load->model('sesion_model');

            if ($this->sesion_model->changePass($name, $pass)) {
                $url = "inicio";
                $correcto = true;
            } else {
                $mensaje = "No se pudo cambiar la contraseña";
            }
            
            $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
            echo json_encode($obj);
              
            //$this->load->model('Sesion_model');
//            $this->db->query("UPDATE `user_pwd` SET `pass`='$pass' WHERE `name`='$name'");
//            
//            if($this->db->affected_rows()==1) 
//            { 
//                return $this->db->affected_rows(); 
//            } 
	}
        
        
}
