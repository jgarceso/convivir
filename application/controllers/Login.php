<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Login extends BaseController {

    private $archivos_css = array(
        "form-login.css"
    );
    
    private $archivos_js = array(
        "lib/jquery.validate.min.js",
        "archivos/login.js"
    );
    
    public function __construct() {
		parent::__construct();
    }
        
	public function index() {
             session_start();
             session_destroy();
            $this->set_js_core_files(array("jquery-1.11.1.min.js"));
            $this->set_css_files($this->archivos_css);
            $this->set_js_files($this->archivos_js);
            $this -> mostrar_pagina("login");
	}
        
}
