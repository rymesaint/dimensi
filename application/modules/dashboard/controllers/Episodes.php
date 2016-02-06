<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Episodes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('episode_model');
	}

	public function proses($opsi){
		switch($opsi):
		case'tambah';
			Episodes::tambah();
		break;
		case'hapus';
			Episodes::hapus();
		break;
		endswitch;
	}

	public function tambah(){
		if(!$this->input->method()):
			die("Sorry, you're not using the right method.");
		endif;

		$iduser 	= $this->input->post("iduser");
		$idanime 	= $this->input->post("idanime");
		$episode 	= $this->input->post("episode");
		$judul 		= $this->input->post("judul");
		$url 		= $this->input->post("url");
		$filesize 	= $this->input->post("filesize");
		$subtitle 	= $this->input->post("subtitle");
		$source 	= $this->input->post("sumbervideo");

		if(empty($filesize)):
			$filesize = 0;
		endif;

		if(empty($url)):
			die("Cannot proceed the process cause required item not inserted.");
		endif;

		$url = base64_encode($url);

		$parentid = $this->episode_model->checkEpisode($episode, $idanime);

		if(empty($judul)):
			$judul = "Belum ada judul";
		endif;


		$data['iduser'] 		= $iduser;
		$data['idanime'] 		= $idanime;
		$data['idsub'] 			= $subtitle;
		$data['episode'] 		= $episode;
		$data['judul_episode'] 	= $judul;
		$data['date_added'] 	= time();
		$data['filesize'] 		= $filesize;
		$data['hashcode'] 		= $url;
		$data['parentid'] 		= $parentid;
		$data['sourcevideo'] 	= $source;
		$data['klik'] 			= 0;

		$this->episode_model->set_episode($data);
		redirect('dashboard/animes/tambah_episode/');
	}
}