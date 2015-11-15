<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class PuntosVenta extends BaseController {

    private $archivos_css = array(
        "convivir.css"
    );
    private $archivos_js = array(
    );

    public $latitud;
    public $longitud;
    
    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "PuntosVenta";
    }

    public function index() {
        $this->grocery_crud->set_table('puntoventa');
        $this->grocery_crud->set_subject('Punto de Venta');

        $this->grocery_crud->columns('Nombre', 'Direccion');
        $this->grocery_crud->fields('Nombre', 'Direccion', 'IdRegion', 'IdProvincia', 'IdComuna','Latitud','Longitud');
        $this->grocery_crud->change_field_type('Latitud', 'invisible');
        $this->grocery_crud->change_field_type('Longitud', 'invisible');
        //$this->grocery_crud->display_as('IdCategoria', 'IdCategoria')->display_as('Nombre', 'Nombre categoría')->display_as('IdTipo', 'Tipo');
        $this->grocery_crud->required_fields('Nombre', 'Dirección','IdRegion', 'IdProvincia', 'IdComuna');
        //$this->grocery_crud->set_rules('Direccion', 'Dirección', 'required|callback_obtener_coordenadas['.$this->input->post('IdRegion').','.$this->input->post('IdProvincia').','.$this->input->post('IdComuna').']');
        $this->grocery_crud->set_rules('Direccion', 'Dirección', 'required|callback_obtener_coordenadas');
        $this->grocery_crud->form_validation()->set_message('obtener_coordenadas', 'Dirección no válida');
        $this->grocery_crud->set_relation('IdComuna', 'comuna', 'Nombre');
        $this->grocery_crud->set_relation('IdRegion', 'region', 'Nombre');
        $this->grocery_crud->set_relation('IdProvincia', 'provincia', 'Nombre');

        $this->set_css_files($this->archivos_css);
        $this->set_js_files($this->archivos_js);

        $output = $this->grocery_crud->render();

        $this->mostrar_pagina("puntosventa", $output);
    }

    function obtener_coordenadas($direccion) {
        //Nos conectamnos a la Api de ggogle maps para validar la dirección. Si es válida
        // podremos mostrar el punto de venta en un mapa.
        
        $base_url = "https://maps.googleapis.com/maps/api/geocode/json?";
        //$region = "hdfskjkjgfds";
        //$region = $post_array['IdRegion'];
        //$arrDatos = explode(",",$datos);
        $idcomuna = $this->input->post('IdComuna');
        $idregion = $this->input->post('IdRegion');
        $idprovincia = $this->input->post('IdProvincia');
       
        if ($idcomuna != "" && $idregion != "" && $idprovincia != "") {
            $this->load->model('common_model');

            $region = $this->common_model->buscar_datos_sql('region', 'IdRegion', $idregion)->Nombre;
            $provincia = $this->common_model->buscar_datos_sql('provincia', 'IdProvincia', $idprovincia)->Nombre;
            $comuna = $this->common_model->buscar_datos_sql('comuna', 'IdComuna', $idcomuna)->Nombre;
            //Buscar coordenadas de la dirección
            $address = utf8_decode($direccion.','.$comuna.','.$provincia.', Chile');
            $request_url = $base_url . "address=" . urlencode($address);
            $result = file_get_contents($request_url) or die("url not loading");
            $arr = json_decode($result, true);//resultados en un arreglo.
            
                    //var_dump($arr);
                    //die();
            
             if($arr['status'] == "OK"){
              $this->latitud = $arr['results'][0]['geometry']['location']['lat'];
              $this->longitud = $arr['results'][0]['geometry']['location']['lng'];
              return true;
             }
             else{
              return false;   
             }
             
        } else {
            return false;
        }
    }

}
