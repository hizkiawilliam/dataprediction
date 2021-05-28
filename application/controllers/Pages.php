<?php
class Pages extends CI_Controller{
    public function view($page = ''){
        $models = ucfirst($page);           // Model for each page
        $this->load->model($models);    
        // Check if user has already logged in before
        if (empty($this->session->userdata['user_logged']))
        {
            $data['message'] = '';
            redirect('login/view','refresh'); 
        }
        // If user already logged in, send to requested page
        else
        {
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