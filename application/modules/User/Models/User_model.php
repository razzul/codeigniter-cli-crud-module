<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends MY_Model {

    public $_table = 'tbl_user';
    public $primary_key = 'id';
    
    
    
    public $belongs_to = array(
    "contact" => array(
        "model" => "user_contact_model",
        "primary_key" => "id"
      ), //->with("contact")
    );
    
    public $has_many = array(
    );
}
