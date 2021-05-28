<?php
class Login extends CI_Controller{
    public function view($page = 'login'){
        if (!empty($this->session->userdata['user_logged']))
        {
            redirect('pages/view/home','refresh');   
        }
        else
        {
            $data['message'] = '';
            $this->load->view('pages/login',$data); 
        }
    }

    public function auth(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $modelLogin = 'Mlogin';
        $this->load->model($modelLogin);
        $check = $this->$modelLogin->getValue($username,$password);
        if($check == true)
        {
            $this->session->set_userdata(['user_logged' => $username]);
            $this->session->set_userdata(['name_logged' => $this->$modelLogin->getName($username)]);
            $this->session->set_userdata(['user_role' => $this->$modelLogin->getRole($username)]);
            redirect('pages/view/home','refresh');
        }
        else
        {
            $data['message'] = "Invalid login. Check username and password";
            $this->load->view('pages/login',$data);
        }
    }
}