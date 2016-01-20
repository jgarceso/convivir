<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';
require_once 'Pdf.php';

class ViewPDF extends BaseController{
    
    public function __construct() {
		parent::__construct();
	}
        
        
         public function index () {
             
             $this->load->model('Excel_model');
             $pdf = new Pdf();
             $alimentosVigentes=$this->Excel_model->get_ProductosxTipo(1,1);
             $pdf->creaPdf($alimentosVigentes);
             
             // Creación del objeto de la clase heredada


$pdf->Output();
         }
}
