<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require APPPATH . '/libraries/REST_Controller.php';
/**
 * Description of ApiSubCategorias
 *
 * @author Fabiola
 */
class ApiSubCategorias extends REST_Controller{
   
    function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }
    
    public function index_get(){
      $subcategorias = $this->api_model->get_SubCategoriasxTipo();
      if(! is_null($subcategorias))
      {
            $this->response($subcategorias, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No fue posible encontrar tipos'
          ], REST_Controller::HTTP_NOT_FOUND); 
      } 
    }
    
    public function find_get($idCat){
        $subcategorias = $this->api_model->get_SubCategoriasxTipo($idCat);
        if(! $idCat){
             $this->response(['status' => FALSE,'message' => 'Debe enviar los ids'
          ], REST_Controller::HTTP_NOT_FOUND); 
        }
       
      if(! is_null($subcategorias)){
            $this->response($subcategorias, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No se encontraron subcategorias'
          ], REST_Controller::HTTP_NOT_FOUND); 
      }
    }
    
}
