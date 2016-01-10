<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('episode_model');
	}

	public function index(){
		$data['title'] = "Dashboard";
		$data['app_name'] = "Dimensi";

		if($this->session->login != 1 && $this->session->level != 8):
			redirect(site_url('dashboard/users/login/'));
		endif;

		$data['user'] = $this->user_model->getUser($this->session->iduser)->row();
		$info['count_user'] = $this->user_model->countUsers();
		$info['count_episodes'] = $this->episode_model->record_count();

		$this->load->view('header', $data);
		$this->load->view('templates/dashboard', $info);
		$this->load->view('footer');
	}
}