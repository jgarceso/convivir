<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
/**
 * Clase Api para manejo de datos de empresa
 * @author Fabiola
 */
class ApiEmpresas extends REST_Controller{
   
     function __construct() {
            parent::__construct();
            $this->load->model('api_model');
      }
      
     public function index_get(){
            $empresas = $this->api_model->get_Empresas();
            if(! is_null($empresas))
            {
                  $this->response($empresas, REST_Controller::HTTP_OK); 
            }else{
                $this->response(['status' => FALSE,'message' => 'No fue posible encontrar tipos'
                ], REST_Controller::HTTP_NOT_FOUND); 
            } 
    }
    
    public function find_get($id){
        $empresas = $this->api_model->get_Empresas($id);
        if(! $id){
             $this->response(['status' => FALSE,'message' => 'Debe enviar los ids'
          ], REST_Controller::HTTP_NOT_FOUND); 
        }
       
      if(! is_null($empresas)){
            $this->response($empresas, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No se encontraron subcategorias'
          ], REST_Controller::HTTP_NOT_FOUND); 
      }
    }
    function user_post()
    {
        $result = 'llalalalalal';
         
        if($result === FALSE){
            $this->response(array('status' => 'failed'));
        }
         
        else
        {
            $this->response(array('status' => 'success llegueeeeeeeee'));
        }
         
    }
}
