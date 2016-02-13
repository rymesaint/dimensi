<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Load related model
	 * Load library form_validation for validating input form
	 *
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
	}

	/**
	 * Function login()
	 *
	 * Show form login
	 *
	 */
	public function login(){

		/**
		 * Get title website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		/**
		 * Condition to check is session login is already true or null
		 * if true then
		 * turn of the script and redirect to profil page
		 *
		 */
		if($this->session->login == true):
			die(redirect('user/profil/'));
		endif;

		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$data['website'] = $title->content;
		$data['title'] = 'Masuk | '.$title->content;
		$data['description'] = 'Masuk ke situs Dimensi Anime';
		$data['keywords'] = null;

		/**
		 * Create validation for input form
		 *
		 */
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

	/**
	 * Function auth()
	 *
	 * Authentication login user
	 *
	 */
	public function auth(){

		/**
		 * Get value input from method POST
		 *
		 */
		$user = $this->input->post("username");
		$pass = $this->input->post("password");

		/**
		 * Fetch 1 row data login with matching username
		 *
		 */
		$check = $this->user_model->getID($user)->row();

		/**
		 * Condition when user login data is match
		 *
		 */
		if(!empty($check)):

			/**
			 * Condition for verify password with password from database
			 *
			 */
			if(password_verify($pass, $check->password)):

				/**
				 * Define variable and store data key login
				 * Then redirect to profil page.
				 */
				$userdata = array(
					'login' => true,
					'level' => $user->groupid,
					'iduser' => $user->iduser
					);
				$this->session->set_userdata($userdata);
				redirect('user/profil/');
			else:

				/**
				 * When password not match set message form validation
				 *
				 * return false
				 */
				$this->form_validation->set_message('password', 'The {field} field is not match with password in our database.');
            	redirect('user/login/');
				return false;
            endif;
        else:

        	/**
        	 * When user login data not match within database
        	 * set message error to form
        	 *
        	 * return false
        	 */
        	$this->form_validation->set_message('username', 'The {field} field is not match with username in our database.');
            redirect('user/login/');
            return false;
        endif;
	}

	/**
	 * Function logout()
	 *
	 * Destroy session login from members system
	 */
	public function logout(){
		/**
		 * When the user have a session login = true
		 * Destroy all session login
		 */
		if($this->session->login == true):
			$this->session->sess_destroy();
			redirect('user/login/');
		else:
			redirect('user/login/');
		endif;
	}
}