<?php

class AjaxController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $this->load->model('Users');

        $email = $this->input->post('username');
        $pass = md5($this->input->post('password'));

        $data = $this->Users->get(array(
            'userEmail' => $email
        ));

        if (!empty($data)){

            if($data[0]->userEmail == $email){
                if ($data[0]->userPass == $pass){

                    $this->session->set_userdata(array(
                        'id' => $data[0]->id
                    ));

                    $status = [
                        'code' => 1,
                        'msg' => 'Giriş yapılıyor.'
                    ];
                    header('Content-type: application/json');
                    $this->output->set_output(json_encode($status));

                }else{
                    $status = [
                        'code' => 0,
                        'msg' => 'Şifreniz yanlış.'
                    ];
                    header('Content-type: application/json');
                    $this->output->set_output(json_encode($status));
                }

            }else{
                $status = [
                    'code' => 0,
                    'msg' => 'Böyle bir kullanıcı bulunamadı.'
                ];
                header('Content-type: application/json');
                $this->output->set_output(json_encode($status));
            }

        }else{
            $status = [
                'code' => 0,
                'msg' => 'Böyle bir kullanıcı bulunamadı.'
            ];
            header('Content-type: application/json');
            $this->output->set_output(json_encode($status));
        }



    }

}