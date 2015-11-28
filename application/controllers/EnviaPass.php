<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class EnviaPass extends BaseController {

    private $archivos_css = array(
        "convivir.css",
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
        $this -> mostrar_pagina("enviaPass");
    }
        
    public function sendMailGmail(){

        //cargamos la libreria email de ci
        $email = $_POST["email"];
        $mensaje = "asdhsh sssjsj aaaaa";
        $url = "sss";
        $correcto = false;
        
		//$this->load->library("email");
 
		//configuracion para gmail
//		$configGmail = array(
//			'protocol' => 'smtp',
//			'smtp_host' => 'ssl://smtp.gmail.com',
//			'smtp_port' => 465,
//			'smtp_user' => 'fabiola.aviles.munoz@gmail.com',
//			'smtp_pass' => 'Paciencia2016',
//			'mailtype' => 'html',
//			'charset' => 'utf-8',
//			'newline' => "\r\n"
//		);    
// 
//		//cargamos la configuración para enviar con gmail
//		$this->email->initialize($configGmail);
//                
//                $configYahoo = array(
//			'protocol' => 'smtp',
//			'smtp_host' => 'smtp.mail.yahoo.com',
//			'smtp_port' => 587,
//			'smtp_crypto' => 'tls',
//			'smtp_user' => 'solStgo@yahoo.com',
//			'smtp_pass' => 'Paciencia2016',
//			'mailtype' => 'html',
//			'charset' => 'utf-8',
//			'newline' => "\r\n"
//		); 
 
		//cargamos la configuración para enviar con yahoo
//		$this->email->initialize($configYahoo);
// 
//		$this->email->from('Fabiola');
//		$this->email->to("fabiola.aviles.munoz@gmail.com");
//		$this->email->subject('Bienvenido/a a uno-de-piera.com');
//		$this->email->message('<h2>Email enviado con codeigniter haciendo uso del smtp de gmail</h2><hr><br> Bienvenido al blog');
//		$this->email->send();
		//con esto podemos ver el resultado
//		 $obj = (object) array('Correcto' => $correcto, 'Url' => $url, 'Mensaje' => $mensaje);
//		 echo json_encode($obj);
        
		//var_dump($this->email->print_debugger());
                
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
		'smtp_user' => 'fabiola.aviles.munoz@gmail.com',
		'smtp_pass' => 'Paciencia2016',
                'mailtype'  => 'html', 
                'charset'   => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            $this->email->from('dkumara85@gmail.com','my name');
            $this->email->to("dkumara85@gmail.com"); // email array
            $this->email->subject('email subject');   
            $this->email->message("my mail body");

            $result = $this->email->send();


            show_error($this->email->print_debugger());  // for debugging purpose :: remove this once it works...
	}
 
	public function sendMailYahoo()
	{
		//cargamos la libreria email de ci
		$this->load->library("email");
 
		//configuracion para yahoo
		$configYahoo = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.mail.yahoo.com',
			'smtp_port' => 587,
			'smtp_crypto' => 'tls',
			'smtp_user' => 'emaildeyahoo',
			'smtp_pass' => 'password',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		); 
 
		//cargamos la configuración para enviar con yahoo
		$this->email->initialize($configYahoo);
 
		$this->email->from('correo que envia los emails');//correo de yahoo o no funcionará
		$this->email->to("correo que recibe el email");
		$this->email->subject('Bienvenido/a a uno-de-piera.com');
		$this->email->message('<h2>Email enviado con codeigniter haciendo uso del smtp de yahoo</h2><hr><br> Bienvenido al blog');
		$this->email->send();
		//con esto podemos ver el resultado
		var_dump($this->email->print_debugger());
 
	}
}
