<?php

class Dashboard extends CI_Controller
{
    public $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = new stdClass();
    }

    public function index()
    {

        if ($this->session->userdata('id')) {
            redirect(base_url('anasayfa'));
        }

        $this->load->model('users');
        $this->load->library('session');

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $pass = md5($this->input->post('password'));

            $user = $this->Users->get(array('userEmail' => $email));
            if ($user) {

                if ($user[0]->userPass == $pass) {

                    $this->session->set_userdata(array(
                        'id' => $user[0]->id,
                        'username' => $user[0]->userEmail
                    ));

                    redirect(base_url('anasayfa'));

                } else {
                    $this->viewData->message = "Şifrenizi Yanlış Girdiniz.";
                }

            } else {
                $this->viewData->message = "Böyle bir kullanıcı bulunamadı.";
            }

        }

        $this->load->view('front/login', $this->viewData);
        

    }

}