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
 
                session_start();
                session_destroy();
    }
        
    public function index() {
        try{
            $this->set_css_files($this->archivos_css);
            $this->set_js_files($this->archivos_js);
            if(isset($_GET["email"])){
                $email= $_GET["email"];
                 $texto_original = Encrypter::decrypt($email);
                // session_start();
                 $_SESSION['email'] = $texto_original;
                 //echo $_SESSION['usuario'];
            }
        }catch(Exception $e){
            
        }
        $this -> mostrar_pagina("recuperaPass");
    }
        
  
 
	public function changePass()
	{
          try{
              
            $pass = $_POST["pass"];
            $validaPassActual = $_POST["validaPassActual"];
            $url = "";
            $correcto = false;
             $this->load->model('sesion_model');
            
                if(isset($_POST["passActual"])){
                    $passActual = $_POST["passActual"];
                    //$username = $_SESSION["usuario"];
                    
                    if($validaPassActual=='true'){
                            if($this->sesion_model->isExits(md5($passActual))) 
                            { 
                                   //echo '222';
                               if ($this->sesion_model->changePass(md5($pass))) {
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
                    //echo $_SESSION['email'];
//                    if(isset($_SESSION['email'])){
//                    }else{
//                        $mensaje = "problemas con la sesion, no se puede obtener el email. ";
//                    }
                     //$email = $_SESSION['email'] ;
                        $passActual = false;
                        $mensaje = "";
                        $this->load->model('sesion_model');

                        if($validaPassActual=='false'){
                             if ($this->sesion_model->changePass(md5($pass))) {
                                      $url = "inicio";
                                      $correcto = true;
                                      $mensaje = "La contraseña fué cambiada. Ahora debe iniciar sesión con su nueva contraseña.";
                            } else {
                                $mensaje = "No se pudo cambiar la contraseña...";
                            }
                        }
                    
                }
            
          }catch(Exception $e){
              $mensaje = 'Ocurrio un error su contraseña no fué cambiada.';
          }  

           $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
           echo json_encode($obj);
	}
        
        
}
