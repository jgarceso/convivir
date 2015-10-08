<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Login extends BaseController {

    private $archivos_css = array(
        "demo.css",
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
            $this -> mostrar_pagina("login");
	}
}
