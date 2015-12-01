<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';
require_once 'Encripter.php';

class RecuperaPass extends BaseController {

    private $archivos_css = array(
        "convivir.css",
        "form-login.css"
    );
    
    private $archivos_js = array(
        "lib/jquery-1.10.2.min.js",
        "lib/jquery.validate.min.js",
        "archivos/login.js"
    );
    
    public function __construct() {
		parent::__construct();
    }
        
    public function index() {
      
            $this->set_css_files($this->archivos_css);
            $this->set_js_files($this->archivos_js);
            
            $this -> mostrar_pagina("recuperaPass");
    }
        
  
 
	public function changePass()
	{
          try{
              if(isset($_POST["username"])){
                    $username =   $_POST["username"];
              }
          
            $pass = $_POST["pass"];
            $validaPassActual = $_POST["validaPassActual"];
            $url = "";
            $correcto = false;
             $this->load->model('sesion_model');
                if(isset($_POST["passActual"])){
                    $passActual = $_POST["passActual"];
                    
                    if($validaPassActual=='true'){
                          $this->check_session();
                          $usuario = $_SESSION["usuario"];
                       
                            if($this->sesion_model->isExits(md5($passActual))) 
                            { 
                               if ($this->sesion_model->changePass($usuario, md5($pass))) {
                                  $url = "inicio";
                                  $correcto = true;
                                  $mensaje = "La contraseña fué cambiada.";
                              } else {
                                  $mensaje = "No se pudo cambiar la contraseña.";
                              }
                            }else{
                                  $mensaje = "Contraseña inválida, vuelva a intentar.";
                            } 
                      }
                }else{
                    if(isset($username)){
                        $passActual = false;
                        $mensaje = "";
                        $this->load->model('sesion_model');
                        $userDesencriptado = Encrypter::decrypt($username);

                        if($validaPassActual=='false'){
                             if ($this->sesion_model->changePass($userDesencriptado, md5($pass))) {
                                      $url = "inicio";
                                      $correcto = true;
                                      $mensaje = "La contraseña fué cambiada. Ahora debe iniciar sesión con su nueva contraseña.";
                            } else {
                                $mensaje = "No se pudo cambiar la contraseña...";
                            }
                        }
                    }else{
                        $mensaje = "No fué posible obtener el nombre de usuario";
                    }
              }
            
          }catch(Exception $e){
              $mensaje = 'Ocurrio un error su contraseña no fué cambiada.';
          }  

           $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
           echo json_encode($obj);
	}
        
        
}
