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
    private $latitud;
    private $longitud;

    public function __construct() {
        parent::__construct();

        $this->check_session();
        $this->controllerName = "PuntosVenta";
        $this->load->model('common_model');
    }

    public function index() {
        $this->grocery_crud->set_table('puntoventa');
        $this->grocery_crud->set_subject('Punto de Venta');
        $this->grocery_crud->columns('Nombre', 'Direccion');
        $this->grocery_crud->fields('Nombre', 'Direccion', 'IdRegion', 'IdProvincia', 'IdComuna', 'Latitud', 'Longitud');
        $this->grocery_crud->change_field_type('Latitud', 'invisible');
        $this->grocery_crud->change_field_type('Longitud', 'invisible');
        $this->grocery_crud->display_as('Direccion', 'Dirección')->display_as('IdRegion', 'Región')->display_as('IdProvincia', 'Provincia')->display_as('IdComuna', 'Comuna');
        $this->grocery_crud->required_fields('Nombre', 'Direccion', 'IdRegion', 'IdProvincia', 'IdComuna');
        $this->grocery_crud->set_rules('Direccion', 'Dirección', 'required|callback_validar_direccion');
        $this->grocery_crud->form_validation()->set_message('validar_direccion', 'Dirección no válida');
        $this->grocery_crud->set_relation('IdComuna', 'comuna', 'Nombre');
        $this->grocery_crud->set_relation('IdRegion', 'region', 'Nombre');
        $this->grocery_crud->set_relation('IdProvincia', 'provincia', 'Nombre');
        $this->grocery_crud->callback_insert(array($this, 'insertar_punto_venta'));
        $this->grocery_crud->callback_update(array($this, 'actualizar_punto_venta'));
        $this->grocery_crud->callback_field('IdProvincia', array($this, 'provincia_select'));
        $this->grocery_crud->callback_field('IdComuna', array($this, 'comuna_select'));
        $this->set_css_files($this->archivos_css);
        $this->set_js_files($this->archivos_js);

        $output = $this->grocery_crud->render();
         $dd_data = array(
                'dd_state' => $this->grocery_crud->getState(),
                'dd_dropdowns' => array('IdRegion', 'IdProvincia', 'IdComuna'),
                'dd_url' => array('', site_url() . $this->controllerName.'/get_provincias/', site_url() . $this->controllerName.'/get_comunas/'),
                'dd_ajax_loader' => $this->config->site_url() . $this->convivir->imagenes_path . 'ajax-loader.gif'
            );
            $output->dropdown_setup = $dd_data;

        $this->mostrar_pagina("puntosventa", $output);
    }

    function validar_direccion($direccion) {
        //Nos conectamnos a la Api de ggogle maps para validar la dirección. Si es válida, obtendremos las coordenadas y
        // podremos mostrar el punto de venta en un mapa.
        $base_url = "https://maps.googleapis.com/maps/api/geocode/json?";
        $idcomuna = $this->input->post('IdComuna');
        $idregion = $this->input->post('IdRegion');
        $idprovincia = $this->input->post('IdProvincia');

        if ($idcomuna != "" && $idregion != "" && $idprovincia != "") {
            $region = $this->common_model->buscar_fila_sql('region', 'IdRegion', $idregion)->Nombre;
            $provincia = $this->common_model->buscar_fila_sql('provincia', 'IdProvincia', $idprovincia)->Nombre;
            $comuna = $this->common_model->buscar_fila_sql('comuna', 'IdComuna', $idcomuna)->Nombre;
            //Buscar coordenadas de la dirección
            $address = utf8_decode($direccion . ',' . $comuna . ',' . $provincia . ', Chile');
            $request_url = $base_url . "address=" . urlencode($address);
            $result = file_get_contents($request_url) or die("url not loading");
            $arr = json_decode($result, true); //resultados en un arreglo.

            if ($arr['status'] == "OK") {
                $this->latitud = $arr['results'][0]['geometry']['location']['lat'];
                $this->longitud = $arr['results'][0]['geometry']['location']['lng'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function insertar_punto_venta($post_array) {
        $post_array['Latitud'] = $this->latitud;
        $post_array['Longitud'] = $this->longitud;
        return $this->db->insert('puntoventa', $post_array);
    }

    function actualizar_punto_venta($post_array, $primary_key) {
        $post_array['Latitud'] = $this->latitud;
        $post_array['Longitud'] = $this->longitud;
        return $this->db->update('puntoventa', $post_array, array('IdPuntoVenta' => $primary_key));
    }

    function provincia_select() {
        $empty_select = '<select name="IdProvincia" class="chosen-select" data-placeholder="Seleccione Provincia">';
        $empty_select_closed = '</select>';
        $idPuntoVenta = $this->uri->segment(4);
        $state = $this->grocery_crud->getState();

        if (isset($idPuntoVenta) && $state == "edit") {
            $row = $this->common_model->buscar_fila_sql('puntoventa', 'IdPuntoVenta', $idPuntoVenta);
            $idRegion = $row->IdRegion;
            $idProvincia = $row->IdProvincia;
            $result = $this->common_model->obtener_datos_combo('provincia', 'Nombre', 'IdRegion', $idRegion);
            foreach ($result as $row):
                if ($row->IdProvincia == $idProvincia) {
                    $empty_select .= '<option value="' . $row->IdProvincia . '" selected="selected">' . $row->Nombre . '</option>';
                } else {
                    $empty_select .= '<option value="' . $row->IdProvincia . '">' . $row->Nombre . '</option>';
                }
            endforeach;
            return $empty_select . $empty_select_closed;
        } else {
            return $empty_select . $empty_select_closed;
        }
    }

    function comuna_select() {
        $empty_select = '<select name="IdComuna" class="chosen-select" data-placeholder="Seleccione Comuna">';
        $empty_select_closed = '</select>';
        $idPuntoVenta = $this->uri->segment(4);
         $state = $this->grocery_crud->getState();

        if (isset($idPuntoVenta) && $state == "edit") {           
            $row = $this->common_model->buscar_fila_sql('puntoventa', 'IdPuntoVenta', $idPuntoVenta);
            $idProvincia = $row->IdProvincia;
            $idComuna = $row->IdComuna;
            $result = $this->common_model->obtener_datos_combo('comuna', 'Nombre', 'IdProvincia', $idProvincia);
            foreach ($result as $row):
                if ($row->IdComuna == $idComuna) {
                    $empty_select .= '<option value="' . $row->IdComuna . '" selected="selected">' . $row->Nombre . '</option>';
                } else {
                    $empty_select .= '<option value="' . $row->IdComuna . '">' . $row->Nombre . '</option>';
                }
            endforeach;
            return $empty_select . $empty_select_closed;
        } else {
            return $empty_select . $empty_select_closed;
        }
    }

    function get_provincias() {
        $idRegion = $this->uri->segment(3);
        $result = $this->common_model->obtener_datos_combo('provincia', 'Nombre', 'IdRegion', $idRegion);
        echo json_encode($this->get_array_combo($result,'IdProvincia', 'Nombre'));
        exit;
    }

    function get_comunas() {
        $idProvincia = $this->uri->segment(3);
        $result = $this->common_model->obtener_datos_combo('comuna', 'Nombre', 'IdProvincia', $idProvincia);     
        echo json_encode($this->get_array_combo($result,'IdComuna', 'Nombre'));
        exit;
    }
    
    private function get_array_combo($result, $campoValor, $campoTexto){   
        $array = array();
          foreach($result as $row):
          $array[] = array("value" => $row->$campoValor, "property" => $row->$campoTexto);
          endforeach;
        return $array;
    }

}
