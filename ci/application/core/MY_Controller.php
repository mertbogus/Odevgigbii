<?php

class MY_Controller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        if (!$this->session->userdata('id')){
            redirect(base_url('dashboard'));
        }

    }

}