<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Security extends CI_Controller {

    public function obtenerCaptcha() {
        $width = 120;
        $height = 30;
        $string = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $image = @imagecreatetruecolor($width, $height) or die("Cannot Initialize new GD image stream");
        // set background and allocate drawing colours
        $background = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $background);
        $linecolor = imagecolorallocate($image, 175, 238, 238);
        $textcolor = imagecolorallocate($image, 135, 206, 235);
        // draw random lines on canvas

        for ($i = 0; $i < 40; $i++) {
            $x1 = rand(0, $width);
            $x2 = rand(0, $width);
            $y1 = rand(0, $width);
            $y2 = rand(0, $width);
            imageline($image, $x1, $y1, $x2, $y2, $linecolor);
        }
        session_start();

        $str = '';

        for ($x = 15; $x <= 95; $x += 20) {
            $pos = rand(0, 61);
            $str .= ($char = $string{$pos});
            imagechar($image, rand(6, 10), $x, rand(2, 14), $char, $textcolor);
        }

        $_SESSION['captcha'] = $str;

        // display image and clean up
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
        $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje'=> $mensaje);
        echo json_encode($obj);
    }
    
    public function salir(){
        session_start();
        session_destroy();
        header("Location: /convivir/");
    }

}
