<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

   function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['tipo_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['tipo_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['tipo_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('api_model');
    }
    
    public function tipos_get()
    {
        // Users from a data store e.g. database

        $this->db->select('*')
                        ->from('tipoproducto');
        $db = $this->db->get();
        $tipos =null;
        $array = array();
                foreach($db->result() as $row):
                   array_push($array,[ 'IdTipo' => intval($row->IdTipo),'Nombre' => $row->Nombre]);
               //  ['IdTipo' => $row->IdTipo, 'Nombre' => $row->Nombre],
                endforeach;  
                
        $tipos=$array;
        $id = $this->get('id');
        
//         $products = [
//            ['id' => 1, 'name' => 'Fabiola', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
//            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
//            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
//        ];

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($tipos)
            {
                // Set the response and exit
                $this->response($tipos, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;
        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retreival.
        // Usually a model is to be used for this.

        $tipo = NULL;

        if (!empty($tipos))
        {
            echo 'no vaciooooo';
            foreach ($tipos as $key => $value)
            {
                
                echo $value->IdTipo ;
                echo isset($value['id']);
                if (isset($value['id']) && $value['id'] === $id)
                {
                    echo 'valueeeeeeeeee->'.$value;    
                    $tipo = $value;
                }else{
                     echo 'nones';    
                }
            }
        }else{
            echo 'arreglo vaiooooooooo';
        }

        if (!empty($tipo))
        {
            $this->set_response($tipo, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function tipos_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'IdTipo' => $this->post('IdTipo'),
            'Nombre'  => $this->post('Nombre')
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function tipos_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }
}
