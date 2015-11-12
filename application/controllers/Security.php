<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

            if ($this->sesion_model->verificar_usuario($name, $pass)) {
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

}
