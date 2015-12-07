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

    public function cambiarPassword() {
        try {
            if (isset($_POST["username"])) {
                $username = $_POST["username"];
            }
            $pass = $_POST["pass"];
            $validaPassActual = $_POST["validaPassActual"];
            $url = "";
            $correcto = false;
            $this->load->model('sesion_model');
            if (isset($_POST["passActual"])) {
                $passActual = $_POST["passActual"];

                if ($validaPassActual == 'true') {
                    session_start();
                    $usuario = $_SESSION["usuario"];

                    if ($this->sesion_model->validarClaveActual($usuario, md5($passActual))) {
                        if ($this->sesion_model->cambiarPassword($usuario, md5($pass))) {
                            $url = "login";
                            $correcto = true;
                            $mensaje = "La contraseña fué cambiada. Ahora deberá iniciar sesión con su nueva contraseña.";
                            session_destroy();
                        } else {
                            $mensaje = "No se pudo cambiar la contraseña.";
                        }
                    } else {
                        $mensaje = "Contraseña inválida, vuelva a intentar.";
                    }
                }
            } else {
                if (isset($username)) {
                    $mensaje = "";
                    $userDesencriptado = Encrypter::decrypt($username);

                        if ($this->sesion_model->cambiarPassword($userDesencriptado, md5($pass))) {
                            $url = "login";
                            $correcto = true;
                            $mensaje = "La contraseña fué cambiada. Ahora debe iniciar sesión con su nueva contraseña.";
                        } else {
                            $mensaje = "No se pudo cambiar la contraseña...";
                        }
                } else {
                    $mensaje = "Error al cambiar la contraseña. No fué posible obtener el nombre de usuario";
                }
            }
        } catch (Exception $e) {
            $mensaje = 'Ocurrio un error su contraseña no fué cambiada.';
        }
        $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
        echo json_encode($obj);
    }

    public function sendEmailRecuperaPassword() {
        $mensaje = "";
        $correcto = false;

        try {
            $email = $_POST["email"];
            $this->load->model('sesion_model');
            $user = $this->sesion_model->existeEmail($email);

            if (isset($user)) {
                $this->load->library("email");
                //ejemplo 
                $enlace = $this->config->site_url().'RecuperaPass?name=' . Encrypter::encrypt($user);
                $config = array(
                    'protocol' => $this->config->item('protocol_email'),
                    'smtp_host' => $this->config->item('smtp_host_email'),
                    'smtp_port' => $this->config->item('smtp_port_email'),
                    'smtp_user' => $this->config->item('smtp_user_email'),
                    'smtp_pass' => $this->config->item('smtp_pass_email'),
                    'mailtype' => $this->config->item('mailtype'),
                    'charset' => $this->config->item('charset_email'),
                    'newline' => $this->config->item('newline_email')
                );

                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from('Administrador');
                $this->email->to($email);
                $this->email->subject('Instrucciones de recuperaci&oacute;n de contrase&ntilde;a Convivir');
                $this->email->subject('Instrucciones de recuperación de contraseña, Convivir');
                $this->email->message('<p>Hemos recibido su solicitud de recuperaci&oacute;n de contrase&ntilde;a. '.
                                                'Si hace click en el enlace, le enviaremos a una p&aacute;gina en donde '. 
                                                'podr&aacute; cambiar o recuperar su contrase&ntilde;a.</p> '.
                                                '<p>Si el enlace no funciona, copie y pegue el enlace en la barra '.
                                                'de direcciones de su navegador.</p> '.
                                                '<p>Enlace: <a href="'.$enlace.'">'.$enlace.'</a></p><br><br>');

                if ($this->email->send()) {
                    $correcto = true;
                    $mensaje = "El correo fué enviado.  Favor verifique y siga las instrucciones.";
                } else {
                    $correcto = false;
                    $mensaje = "El correo electrónico no pudo ser enviado, intente más tarde.";
                    //show_error($this->email->print_debugger()); DEJAR PARA DEBUG EN CASO DE FALLA
                }
                $correcto = true;
                $mensaje = "El correo fué enviado.  Favor verifique y siga las instrucciones.";
            } else {
                $correcto = false;
                $mensaje = "Email no registrado.  Favor verifique.";
            }

            $obj = (object) array('Correcto' => $correcto, 'Mensaje' => $mensaje);
        } catch (Expection $e) {
            $obj = (object) array('Correcto' => $correcto, 'Mensaje' => $mensaje);
            $mensaje = 'Ha ocurrido un error al tratar de enviar el email. Favor intente más tarde.';
        }

        echo json_encode($obj);
    }

}
