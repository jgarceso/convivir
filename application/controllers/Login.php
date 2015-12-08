<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Login extends BaseController {
   
    public function __construct() {
		parent::__construct();
    }
        
	public function index() {
             session_start();
             session_destroy();
            $this->set_js_core_files(array("jquery-1.11.1.min.js"));
            $this->set_css_files(array("form-login.css"));
            $this->set_js_files(array("archivos/login.js"));
            $this -> mostrar_pagina("login");
	}
        
}
