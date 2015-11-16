<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Description of ApiTipos
 *
 * @author Fabiola
 */
class ApiTipos extends REST_Controller{
    
     function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }
    public function index_get(){
      $tipos = $this->api_model->get_Tipos();
      if(! is_null($tipos))
      {
            $this->response($tipos, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No fue posible encontrar tipos'
          ], REST_Controller::HTTP_NOT_FOUND); 
      } 
    }
    
    public function find_get($id){
        $tipos = $this->api_model->get_Tipos($id);
        
        if(! $id){
             $this->response(['status' => FALSE,'message' => 'Debe enviar el id'
          ], REST_Controller::HTTP_NOT_FOUND); 
        }
       
      if(! is_null($tipos)){
            $this->response($tipos, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'Debe enviar el id'
          ], REST_Controller::HTTP_NOT_FOUND); 
      }
    }
    
}
