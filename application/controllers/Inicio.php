<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Inicio extends BaseController {

	public function __construct() {
		parent::__construct();
                
               $this->check_session();
               $this->controllerName = "Inicio";
	}

	public function index() {
		try {
                        $this->set_js_core_files(array("jquery-1.11.1.min.js"));
                        $this->set_js_files(array("archivos/inicio.js"));
			$this -> mostrar_pagina("inicio", null);

		} catch(Exception $e) {
			show_error($e -> getMessage() . ' --- ' . $e -> getTraceAsString());
		}
	}
}
