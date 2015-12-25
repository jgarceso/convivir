<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Producto extends REST_Controller{
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('data_model');
    }

     public function index_post(){
        echo 'index_post';
         if(! $this->post('product')){
             $this->response(array(
              'status' => FALSE,
              'message' => 'Debe enviar el producto'
          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
        $product_id = $this->api_model->save($this->post("producto"));
        
        if(! is_null($product_id)){
           $this->response($product_id, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $this->response(array(
              'status' => FALSE,
              'message' => 'Ha ocurrido un error'
          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
       public function buscar_post(){
//         if(! $this->post('product')){
//             $this->response(array(
//              'status' => FALSE,
//              'message' => 'Debe enviar el producto'
//          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
//        }
        
        $result = $this->data_model->buscar_productos($this->post("strBusqueda"),$this->post("opciones"),$this->post("limite"));
        
        $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
//        if(! is_null($product_id)){
//           $this->response($product_id, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
//        }else{
//             $this->response(array(
//              'status' => FALSE,
//              'message' => 'Ha ocurrido un error'
//          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
//        }
      
 // JSON EJEMPLO PARA POSTMAN
//        {
// "opciones":{"tipo":"1,2", "producto":"true", "categoria":"true", "empresa":"false"},
// "limite":10,
// "strBusqueda":"pan"
//}
    }
    
    
    
    public function index_get(){
      $products = $this->api_model->get_Productos();
      if(! is_null($products))
      {
            $this->response($products, REST_Controller::HTTP_OK); 
      }else{
          $this->response(array('status' => FALSE,'message' => 'No fue posible encontrar productos'
          ), REST_Controller::HTTP_NOT_FOUND); 
      } 
    }
    
    public function find_get($id){
        $products = $this->api_model->get_Productos($id);
        if(! $id){
             $this->response(array('status' => FALSE,'message' => 'Debe enviar el id'
          ), REST_Controller::HTTP_NOT_FOUND); 
        }
       
      if(! is_null($products))
      {
            $this->response($products, REST_Controller::HTTP_OK); 
    
      }else{
          $this->response(array('status' => FALSE,'message' => 'Debe enviar el id'
          ), REST_Controller::HTTP_NOT_FOUND); 
      }
    }
    
    public function index_put($id){
        echo 'index_put';
           if(! $this->post('product') || !$id){
             $this->response(array(
              'status' => FALSE,
              'message' => 'Debe enviar el producto'
          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
        $update = $this->api_model->update($id,$this->put("producto"));
        
        if(! is_null($update)){
           $this->response("Producto actualizado.", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $this->response(array(
              'status' => FALSE,
              'message' => 'Ha ocurrido un error al actualizar producto'
          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
   
    public function index_delete($id){
        echo 'metodo delete';
        if(! $id){
             $this->response(array(
              'status' => FALSE,
              'message' => 'Debe enviar el id para borrar'
          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $delete = $this->api_model->delete($id);
        
        if(! is_null($delete)){
           $this->response("Producto eliminado", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $this->response(array(
              'status' => FALSE,
              'message' => 'Ha ocurrido un error al eliminar el producto'
          ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
    }
        
}
