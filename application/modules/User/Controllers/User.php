<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class user extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $data['user'] = $this->user_model->get_all();
        $data['main_content'] = 'user_index';
        $this->load->view('page', $data);
    }

    function details($id){
        if(!isset($id))
            redirect('/user');

        $data['user'] = $this->user_model->get($id);
        $data['main_content'] = 'user_details';
        $this->load->view('page', $data);
    }

    function success(){
        $data['user'] = 'success';
        $data['main_content'] = 'user_success';
        $this->load->view('page', $data);   
    }

    function add(){
        $data['user'] = 'add';
        if($_POST):
            $data = $this->_post_data();
            $create = $this->user_model->insert($data['user']);
            if($create):
                redirect('/user/success');
            else:
                print_r(validation_errors());
            endif;
        endif;

        $data['main_content'] = 'user_add';
        $this->load->view('page', $data);
    }

    

    function _post_data(){
        
        $data['user'] = array();
        return $data;
    }
}
