<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
	}

	public function login(){

		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		if($this->session->login == true):
			die(redirect('user/profil/'));
		endif;

		$data['website'] = $title->content;
		$data['title'] = 'Masuk | '.$title->content;
		$data['description'] = 'Masuk ke situs Dimensi Anime';
		$data['keywords'] = null;

		$this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim',
                array('required' => 'You must provide a %s.')
        );


		$this->load->view('header', $data);
		if ($this->form_validation->run() == FALSE):
            $this->load->view('templates/login');
        else:
            $this->load->view('templates/profil');
        endif;
		$this->load->view('footer', $data);
	}

	public function auth(){

		$user = $this->input->post("username");
		$pass = $this->input->post("password");

		$check = $this->user_model->getID($user)->row();
		if(!empty($check)):
			if(password_verify($pass, $check->password)):
				$userdata = array(
					'login' => true,
					'level' => $user->groupid,
					'iduser' => $user->iduser
					);
				$this->session->set_userdata($userdata);
				redirect('user/profil/');
			else:
				$this->form_validation->set_message('password', 'The {field} field is not match with password in our database.');
            	redirect('user/login/');
				return false;
            endif;
        else:
        	$this->form_validation->set_message('username', 'The {field} field is not match with username in our database.');
            redirect('user/login/');
            return false;
        endif;
	}

	public function logout(){
		if($this->session->login == true):
			$this->session->sess_destroy();
			redirect('user/login/');
		else:
			redirect('user/login/');
		endif;
	}
}