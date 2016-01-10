<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}

	public function login(){
		$data['title'] = "Login Administration";
		$data['app_name'] = "Portal Dimensi";

		if($this->session->login == 1 && $this->session->level == 8):
			redirect(site_url('dashboard'));
		endif;

		$this->load->view('login', $data);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(site_url('dashboard/users/login/'));
	}

	public function auth(){

		if($this->input->is_ajax_request() != true):
			die("Sorry, you're not using the right method.");
		endif;

		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$ip_address = $this->input->ip_address();

		if(empty($username) || empty($password)):
			echo '<div class="alert alert-danger">Maaf, username dan password tidak boleh kosong.</div>';
			exit();
		endif;

		$user = $this->user_model->getUser($username)->row();
		if(empty($user)):
			echo '<div class="alert alert-danger">Maaf, username yang anda masukan tidak ditemukan di database.</div>';
		else:
			if(password_verify($password, $user->password)):
				$userdata = array(
					'login' => true,
					'level' => $user->groupid,
					'iduser' => $user->iduser
					);
				$this->session->set_userdata($userdata);
				echo "<script>window.location=".site_url('dashboard')."</script>";
			else:
				echo '<div class="alert alert-danger">Maaf, password yang anda masukan salah.</div>';
			endif;
		endif;
	}
}