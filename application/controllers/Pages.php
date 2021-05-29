<?php
class Pages extends CI_Controller{
    public function view($page = ''){  
        // Check if user has already logged in before
        if (empty($this->session->userdata['user_logged']))
        {
            $models = ucfirst('home');           
            $this->load->model($models);
            $data['datas'] = $this->$models->getValue();
            $data['title'] = ucfirst($page);
            $this->load->view('pages/home', $data);
        }
        // If user already logged in, send to requested page
        else
        {
            $models = ucfirst($page);           
            $this->load->model($models);
            $data['datas'] = $this->$models->getValue();
            $data['title'] = ucfirst($page);
            $this->load->view('pages/'.$page, $data);
        }
    }

    public function logout(){
        $models = 'MLogin';
        $this->load->model($models);
        $this->$models->Logout($this->session->userdata['user_logged']);
        $this->session->sess_destroy();
        redirect('login/view','refresh');
    }
}