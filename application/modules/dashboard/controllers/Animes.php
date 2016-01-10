<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Animes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('hosting_model');
	}

	public function index(){
		$data['title'] = "Animes";
		$data['app_name'] = "Dimensi";

		if($this->session->login != 1 && $this->session->level != 8):
			redirect(site_url('dashboard'));
		endif;

		$data['user'] = $this->user_model->getUser($this->session->iduser)->row();
		$info['count_anime'] = $this->anime_model->count_anime()->num_rows();
		$info['count_episode'] = $this->episode_model->record_count();

		$info['animes'] = $this->anime_model->select_all($rate_filter = null)->result();
		$info['episodes'] = $this->episode_model->select_all(150, 0)->result();
		$info['hostings'] = $this->hosting_model->select_all()->result();

		$this->load->view('header', $data);
		$this->load->view('templates/animes', $info);
		$this->load->view('footer');
	}

	public function changehosting(){
		if($this->input->is_ajax_request() != true):
			die("Sorry, you're not using the right method.");
		endif;

		$idepisode = $this->input->post("idepisode");
		$namehosting = $this->input->post("hosting");

		$data['sourcevideo'] = $namehosting;
		$this->episode_model->updateEpisode($data, $idepisode);

		$hosting = $this->hosting_model->select_all("idhosting=".$namehosting)->row();

		echo $hosting->namahosting;
	}

	public function episodesearch(){

		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die("Sorry, you're not using the right method.");
		}

		$query = $this->input->get("keyword");

		$state = array(
			'column' => 'title_anime',
			'value' => $query
			);

		$animes = $this->episode_model->select_all(null, null, $state)->result();
		$hostings = $this->hosting_model->select_all()->result();
		$rating = $this->rating;
		$data = null;

		foreach ($animes as $episode) {
			$result = $rating->get($episode->idanime);
			$data .= '<tr class="edit_tr" id="'.$episode->idepisode.'">
	                      <td>'.$episode->idepisode.'</td>
	                      <td>'.$episode->title_anime.'</td>
	                      <td>'. $episode->episode.'</td>
	                      <td>
	                        <span class="text" id="label_hosting_'.$episode->idepisode.'">'.$episode->namahosting.'</span>
	                        <select class="inputhosting" id="input_hosting_'.$episode->idepisode.'">';
	                          foreach ($hostings as $hosting):
	                            if($episode->namahosting == $hosting->namahosting):
	        $data .=                    '<option value="'.$hosting->idhosting.'" selected>'.$hosting->namahosting.'</option>';
	                            else:
	        $data .=                    '<option value="'.$hosting->idhosting.'">'.$hosting->namahosting.'</option>';  
	                          	endif;
	                          endforeach;
	        $data .=         '</select>
	                      </td>
	                      <td>'.date("M, d Y",$episode->date_added).'</td>
	                    </tr>';
		}
		echo $data;

		echo '<script type="text/javascript">
            $(document).ready(function()
            {

              var idepisode,
                  hosting,
                  dataS;
              $(".edit_tr").click(function(){
                idepisode = $(this).attr("id");

                $("#label_hosting_"+idepisode).hide();
                $("#input_hosting_"+idepisode).show();
              });

              $(".inputhosting").change(function(){
                hosting = $(this).val(),
                dataS = "idepisode="+idepisode+"&hosting="+hosting;
                $.ajax({
                  type: \'POST\',
                  url: \''.site_url('dashboard/animes/changehosting/').'\',
                  data: dataS,
                  cache: false,
                  success:function(data){
                    $("#label_hosting_"+idepisode).html(data);
                  }
                });
              });

              $(".inputhosting").mouseup(function(){
                return false
              });

              $(document).mouseup(function(){
                $(".inputhosting").hide();
                $(".text").show();
              });
            });
          </script>';
	}	

	public function listepisode(){

		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die("Sorry, you're not using the right method.");
		}

		$start = filter_var($this->input->post("start"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$end = filter_var($this->input->post("end"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$page = filter_var($this->input->post("page"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

		//validate page number is really numaric
		if(!is_numeric($page) && !is_numeric($end) && !is_numeric($start)){
			die('Invalid page number!');
		}

		$end = $end - $start;
		$animes = $this->episode_model->select_all($end, $start)->result();
		$hostings = $this->hosting_model->select_all()->result();
		$rating = $this->rating;
		$data = null;

		foreach ($animes as $episode) {
			$result = $rating->get($episode->idanime);
			$data .= '<tr class="edit_tr" id="'.$episode->idepisode.'">
	                      <td>'.$episode->idepisode.'</td>
	                      <td>'.$episode->title_anime.'</td>
	                      <td>'. $episode->episode.'</td>
	                      <td>
	                        <span class="text" id="label_hosting_'.$episode->idepisode.'">'.$episode->namahosting.'</span>
	                        <select class="inputhosting" id="input_hosting_'.$episode->idepisode.'">';
	                          foreach ($hostings as $hosting):
	                            if($episode->namahosting == $hosting->namahosting):
	        $data .=                    '<option value="'.$hosting->idhosting.'" selected>'.$hosting->namahosting.'</option>';
	                            else:
	        $data .=                    '<option value="'.$hosting->idhosting.'">'.$hosting->namahosting.'</option>';  
	                          	endif;
	                          endforeach;
	        $data .=         '</select>
	                      </td>
	                      <td>'.date("M, d Y",$episode->date_added).'</td>
	                    </tr>';
		}
		echo $data;

		echo '<script type="text/javascript">
            $(document).ready(function()
            {

              var idepisode,
                  hosting,
                  dataS;
              $(".edit_tr").click(function(){
                idepisode = $(this).attr("id");

                $("#label_hosting_"+idepisode).hide();
                $("#input_hosting_"+idepisode).show();
              });

              $(".inputhosting").change(function(){
                hosting = $(this).val(),
                dataS = "idepisode="+idepisode+"&hosting="+hosting;
                $.ajax({
                  type: \'POST\',
                  url: \''.site_url('dashboard/animes/changehosting/').'\',
                  data: dataS,
                  cache: false,
                  success:function(data){
                    $("#label_hosting_"+idepisode).html(data);
                  }
                });
              });

              $(".inputhosting").mouseup(function(){
                return false
              });

              $(document).mouseup(function(){
                $(".inputhosting").hide();
                $(".text").show();
              });
            });
          </script>';
	}	
}