<?php

class Anasayfa extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->load->view('front/anasayfa');
    }

    public function talepler(){
        echo "talepler";
    }

    public function hesabim(){
        echo "hesabim";
    }

    public function logout(){
        session_destroy();
        //$this->load->view('front/login');
        redirect(base_url(''));
    }

}