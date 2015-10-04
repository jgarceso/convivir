<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class CerrarSesion extends CI_Controller {
        
    public function index() {
        session_start();
        session_destroy();
        header("Location: /convivir/");
    }
}
