<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class BaseController extends CI_Controller {

    public $convivir;
    public $controllerName;

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->convivir = & load_class('Convivir', 'classes');
        $this->set_crud_default_options();
    }

    protected function mostrar_pagina($view, $output = null) {

        if ($output == null) {
            $js_files = $this->grocery_crud->get_js_files();
            $css_files = $this->grocery_crud->get_css_files();
            $output = (object) array('output' => '', 'js_files' => $js_files, 'css_files' => $css_files);
        }
        $this->load->view($view, $output);
    }

    protected function set_css_files($array_css) {

        foreach ($array_css as $archivo) {
            $this->grocery_crud->set_css($this->convivir->css_path . $archivo);
        }
    }

    protected function set_js_files($array_js) {

        foreach ($array_js as $archivo) {
            $this->grocery_crud->set_js($this->convivir->js_path . $archivo);
        }
    }

    protected function set_js_core_files($array_js) {

        foreach ($array_js as $archivo) {
            $this->grocery_crud->set_js($this->convivir->core_js_path . $archivo);
        }
    }
    
    protected function set_css_core_files($array_css) {

        foreach ($array_css as $archivo) {
            $this->grocery_crud->set_css($this->convivir->core_css_path . $archivo);
        }
    }
    
    protected function check_session() {
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location:" . $this->config->site_url());
        }
    }

    protected function unique_field_name($field_name) {
        return 's' . substr(md5($field_name), 0, 8);
    }

    private function set_crud_default_options() {
        $this->grocery_crud->unset_export();
        $this->grocery_crud->unset_print();
        $this->grocery_crud->unset_back_to_list();
    }

}
