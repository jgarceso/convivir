<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
/**
 * Clase para manejo de datos de categorias
 *
 * @author Fabiola
 */
class ApiCategorias extends REST_Controller{
    
      function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }
    
    public function index_get(){
      $categorias = $this->api_model->get_CategoriasxTipo();
      if(! is_null($categorias)){
          $this->response($categorias, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No fue posible encontrar categorías'
          ], REST_Controller::HTTP_NOT_FOUND); 
      } 
    }
    
    public function find_get($id){
      $categorias = $this->api_model->get_CategoriasxTipo($id);
      if(! $id){
             $this->response(['status' => FALSE,'message' => 'Debe enviar el id'
          ], REST_Controller::HTTP_NOT_FOUND); 
        }
      if(! is_null($categorias)){
            $this->response($categorias, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No se encontraron categorias'
          ], REST_Controller::HTTP_NOT_FOUND); 
      }
    }
}
