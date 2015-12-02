<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'Encripter.php';

class Security extends CI_Controller {

    public function obtenerCaptcha() {

        $string = "abcdefghijklmnpqrstuvwxyz123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
        $image = @imagecreatetruecolor(120, 40) or die("Cannot Initialize new GD image stream");

        $background = imagecolorallocate($image, 102, 102, 153);
        imagefill($image, 0, 0, $background);
        $linecolor = imagecolorallocate($image, 80, 80, 130);
        $textcolor = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

        for ($i = 0; $i < 6; $i++) {
            imagesetthickness($image, rand(1, 3));
            imageline($image, 0, rand(0, 30), 120, rand(0, 30), $linecolor);
        }
        session_start();     
         $str = '';

        for ($x = 15; $x <= 95; $x += 20) {
            $pos = rand(0, 58);
            $str .= ($char = $string{$pos});
            imagechar($image, rand(12, 16), $x, rand(6, 14), $char, $textcolor);
        }

        $_SESSION['captcha'] = $str;

        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

    public function login() {

        $name = $_POST["usuario"];
        $pass = $_POST["password"];
        $captcha = $_POST["captcha"];
        $mensaje = "";
        $url = "";
        $correcto = false;

        session_start();
        if ($captcha != $_SESSION['captcha']) {
            $mensaje = "Código de verificación incorrecto";
        } else {
            $this->load->model('sesion_model');
            if ($this->sesion_model->verificar_usuario($name, md5($pass))) {
                $_SESSION["usuario"] = $name;
                $url = "inicio";
                $correcto = true;
            } else {
                $mensaje = "Usuario o password incorrectos";
            }
        }
        $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
        echo json_encode($obj);
    }

    public function salir() {
        session_start();
        session_destroy();
        header("Location: /convivir/");
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
                      session_start();
                       $usuario = $_SESSION["usuario"];

                         if($this->sesion_model->isExits($usuario, md5($passActual))) 
                         { 
                            if ($this->sesion_model->changePass($usuario, md5($pass))) {
                               $url = "login";
                               $correcto = true;
                               $mensaje = "La contraseña fué cambiada.";
                               session_destroy();
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
     
       public function sendEmail(){

        $mensaje = "";
        $url = "";
        $correcto = false;
        
            try{
                $email = $_POST["email"];
                $this->load->model('sesion_model');
                $user = $this->sesion_model->existsEmail($email);

                if(isset($user)){
                        $configGmail = array(
                                'protocol' => 'smtp',
                                'smtp_host' => 'ssl://smtp.gmail.com',
                                'smtp_port' => 465,
                                'smtp_user' => 'fabiola.aviles.munoz@gmail.com',
                                'smtp_pass' => '**********',
                                'mailtype' => 'html',
                                'charset' => 'utf-8',
                                'newline' => "\r\n"
                        );    

                        $this->email->initialize($configGmail);
                        $this->email->from('Fabiola');
                        $this->email->to("fabiola.aviles.munoz@gmail.com");
                        $this->email->subject('Bienvenido/a a uno-de-piera.com');
                        $this->email->message('<h2>Email enviado con codeigniter haciendo uso del smtp de gmail</h2><hr><br> Bienvenido al blog');

                        if(!$this->email->send()){
                            show_error($this->email->print_debugger());
                            $correcto = true;
                            $mensaje = "El correo fué enviado.  Favor verifique y siga las instrucciones.";
                        }else{
                            $correcto = false;
                            $mensaje = "El correo electrónico no pudo ser enviado, intente más tarde.";
                            echo 'tu email ha sido enviado.';
                        }
                        $correcto = true;
                        $mensaje = "El correo fué enviado.  Favor verifique y siga las instrucciones.";
                }else{
                    $correcto = false;
                    $mensaje = "La dirección de correo electrónico no coincide con la ingresada.  Favor verifique.";
                }
            }catch(Expection $e){
                $mensaje =  'Ha ocurrido un error al tratar de enviar el email. Favor intente más tarde.';
            }
            
        $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
        echo json_encode($obj);
	}

}
