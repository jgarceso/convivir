<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Inicio extends BaseController {


    private $archivos_css = array(
        "convivir.css"
    );
    
    private $archivos_js = array(

    );
	public function __construct() {
		parent::__construct();
                
               $this->check_session();
               $this->controllerName = "Inicio";
	}

	public function index() {
		try {
                        $this->set_css_files($this->archivos_css);
                        $this->set_js_files($this->archivos_js);
			$this -> mostrar_pagina("inicio", null);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}
}
