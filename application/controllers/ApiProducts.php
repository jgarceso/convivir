<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require APPPATH . '/libraries/REST_Controller.php';
/**
 * Description of ApiPoducts
 *
 * @author Fabiola
 */
class ApiProducts extends REST_Controller{
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }

    public function index_get(){
      $products = $this->api_model->get_Productos();
      if(! is_null($products))
      {
            $this->response($products, REST_Controller::HTTP_OK); 
      }else{
          $this->response(['status' => FALSE,'message' => 'No fue posible encontrar productos'
          ], REST_Controller::HTTP_NOT_FOUND); 
      } 
    }
    
    public function find_get($id){
        $products = $this->api_model->get_Productos($id);
        if(! $id){
             $this->response(['status' => FALSE,'message' => 'Debe enviar el id'
          ], REST_Controller::HTTP_NOT_FOUND); 
        }
       
      if(! is_null($products))
      {
            $this->response($products, REST_Controller::HTTP_OK); 
    
      }else{
          $this->response(['status' => FALSE,'message' => 'Debe enviar el id'
          ], REST_Controller::HTTP_NOT_FOUND); 
      }
    }
    
    public function index_put($id){
        echo 'index_put';
           if(! $this->post('product') || !$id){
             $this->response([
              'status' => FALSE,
              'message' => 'Debe enviar el producto'
          ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
        $update = $this->api_model->update($id,$this->put("producto"));
        
        if(! is_null($update)){
           $this->response("Producto actualizado.", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $this->response([
              'status' => FALSE,
              'message' => 'Ha ocurrido un error al actualizar producto'
          ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function index_post(){
        echo 'index_post';
         if(! $this->post('product')){
             $this->response([
              'status' => FALSE,
              'message' => 'Debe enviar el producto'
          ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
        $product_id = $this->api_model->save($this->post("producto"));
        
        if(! is_null($product_id)){
           $this->response($product_id, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $this->response([
              'status' => FALSE,
              'message' => 'Ha ocurrido un error'
          ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function index_delete($id){
        echo 'metodo delete';
        if(! $id){
             $this->response([
              'status' => FALSE,
              'message' => 'Debe enviar el id para borrar'
          ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $delete = $this->api_model->delete($id);
        
        if(! is_null($delete)){
           $this->response("Producto eliminado", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $this->response([
              'status' => FALSE,
              'message' => 'Ha ocurrido un error al eliminar el producto'
          ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
    }
        
}
