<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class {module_name} extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('{module_name}_model');
    }

    function index() {
        $data['{module_name}'] = $this->{module_name}_model->get_all();
        $data['main_content'] = '{module_name}_index';
        $this->load->view('page', $data);
    }

    function details($id){
        if(!isset($id))
            redirect('/{module_name}');

        $data['{module_name}'] = $this->{module_name}_model->get($id);
        $data['main_content'] = '{module_name}_details';
        $this->load->view('page', $data);
    }

    function success(){
        $data['{module_name}'] = 'success';
        $data['main_content'] = '{module_name}_success';
        $this->load->view('page', $data);   
    }

    function add(){
        $data['{module_name}'] = 'add';
        if($_POST):
            $data = $this->_post_data();
            $create = $this->{module_name}_model->insert($data['{module_name}']);
            if($create):
                redirect('/{module_name}/success');
            else:
                print_r(validation_errors());
            endif;
        endif;

        $data['main_content'] = '{module_name}_add';
        $this->load->view('page', $data);
    }

    

    function _post_data(){
        
        $data['{module_name}'] = array();
        return $data;
    }
}
