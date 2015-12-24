<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Empresas extends BaseController {

	public function __construct() {
		parent::__construct();
                
               $this->check_session();
			   $this->controllerName = "Empresas"; 
	}

	public function index() {
			$this->grocery_crud -> set_table('empresa');
			$this->grocery_crud -> set_subject('Empresa');

			$this->grocery_crud -> columns('Nombre','NombreContacto', 'EmailContacto', 'TelefonoContacto');
			$this->grocery_crud-> fields('Nombre', 'NombreContacto', 'EmailContacto', 'TelefonoContacto');
			$this->grocery_crud -> display_as('Nombre', 'Nombre de la empresa')->display_as('NombreContacto', 'Nombre Contacto')
                                ->display_as('EmailContacto', 'Email Contacto')->display_as('TelefonoContacto', 'Teléfono Contacto');
			$this->grocery_crud -> required_fields('IdEmpresa', 'Nombre');
                        $this->grocery_crud->set_rules('TelefonoContacto','Telefono Contacto','numeric');
                        $this->grocery_crud->set_rules('EmailContacto', 'Email', 'valid_email');

			$output = $this->grocery_crud -> render();
                        
			$this -> mostrar_pagina("empresas", $output);
	}
}
