<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	/**
	 * Load related model that need to use via ajax and load the library
	 * to create a genre if the genre not exists in the database.
	 *
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('counter_model');

		$this->load->library('generate_genres');
	}


	/**
	 * Function listanime()
	 *
	 * Load list anime via ajax and show it via echo command.
	 * @start (int)
	 * @end (int)
	 * @page (int)
	 * return @data
	 */
	public function listanime(){

		/**
		 * Condition when requesting data via ajax is true
		 *
		 */
		if (!$this->input->is_ajax_request()){
			die("Sorry, you're not using the right method.");
		}

		/**
		 * Filtering variable and define variable
		 *
		 */
		$start 	= filter_var($this->input->post("start"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$end 	= filter_var($this->input->post("end"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$page 	= filter_var($this->input->post("page"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

		/*
		 *validate page number is really numaric
		 *
		 */
		if(!is_numeric($page) && !is_numeric($end) && !is_numeric($start)):
			die('Invalid page number!');
		endif;

		$end = $end - $start;

		/**
		 * Fetch data from database
		 *
		 * @animes (Object)
		 * Parameters :
		 * @end (int)
		 * @start (int)
		 */
		$animes = $this->episode_model->select_all($end, $start)->result();

		/**
		 * Define variable and insert value default library rating
		 *
		 */
		$rating = $this->rating;

		/* Define a variable and assume variable default value is null */
		$data = null;

		/**
		 * Loop each data from @animes as @episode
		 *
		 * @result (Object) Load rating from each episode anime
		 * @data (Object)
		 */ 
		foreach ($animes as $episode) {
			$result = $rating->get($episode->idanime);
			$data .= '<div class="wrapper-block-anime">
				<a href="'.base_url().'anime/'.$episode->permalink.'/'.$episode->episode.'/">
					<div class="block-anime-title">
					'.$episode->title_anime.' Episode <span class="episode">'.$episode->episode.'</span>
					</div>
				</a>
				<div class="block-anime-img">
					<a href="'.base_url().'anime/'.$episode->permalink.'/'.$episode->episode.'/"><img src="'.base_url().'uploads/no-image.jpg" data-src="'.base_url().'uploads/'.$episode->image.'" class="img img-responsive"></a>
				</div>
				<div class="block-anime-meta">
					<table class="table table-stripped">
						<tr>
							<td>'. $this->lang->line('release_date').'</td>
							<td>: '. date('F d Y H:i A', $episode->date_added).'</td>
						</tr>
						<tr>
							<td>Rating</td>
							<td>: '. $result->avg.'/5 dari '.$result->votes .' pengguna.</td>
						</tr>
						<tr>
							<td>Lihat semua Episode</td>
							<td>: <a href="'.base_url().'anime/'.$episode->permalink.'/">'.$episode->title_anime.'</a></td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>';
		}
		echo $data;

		echo '<script>
		  $(document).ready(function() {
			  $("img").unveil();
			});
		</script>';
	}

	/**
	 * Function searchGenre()
	 *
	 * Show genre based filtered genre via ajax and show it with echo command
	 * 
	 * @start (int)
	 * @end (int)
	 * @page (int)
	 * @permalink (String)
	 * return @data
	 */
	public function searchGenre(){

		/**
		 * Condition when requesting data via ajax is true
		 *
		 */
		if (!$this->input->is_ajax_request()){
			die("Sorry, you're not using the right method.");
		}

		/**
		 * Filtering variable and define variable
		 *
		 */
		$start 		= filter_var($this->input->post("start"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$end 		= filter_var($this->input->post("end"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$page 		= filter_var($this->input->post("page"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$permalink 	= $this->input->post("genre");

		/*
		 *validate page number is really numaric
		 *
		 */
		if(!is_numeric($page) && !is_numeric($end) && !is_numeric($start)):
			die('Invalid page number!');
		endif;

		$end = $end - $start;

		/**
		 * Fetch data from database
		 *
		 * @animes (Object)
		 * Parameters :
		 * @permalink (String)
		 * @end (int)
		 * @start (int)
		 */
		$animes = $this->anime_model->select_by_genre($permalink, $start, $end)->result();

		/**
		 * Define variable and insert value default library rating
		 *
		 */
		$rating = $this->rating;

		/* Define a variable and assume variable default value is null */
		$data = null;

		/**
		 * Loop each data from @animes as @episode
		 *
		 * @result (Object) Load rating from each episode anime
		 * @data (Object)
		 */
		foreach ($animes as $episode) {
			$result = $rating->get($episode->idanime);
			$data .= '<div class="wrapper-block-anime">
				<a href="'.base_url().'anime/'.$episode->permalink.'/">
					<div class="block-anime-title">
					'.$episode->title_anime.'
					</div>
				</a>
				<div class="block-anime-img">
					<a href="'.base_url().'anime/'.$episode->permalink.'/"><img src="'.base_url().'uploads/no-image.jpg" data-src="'.base_url().'uploads/'.$episode->image.'" class="img img-responsive"></a>
				</div>
				<div class="block-anime-meta">
					<table class="table table-stripped">
						<tr>
							<td>'. $this->lang->line('release_date').'</td>
							<td>: '. date('F d Y H:i A', $episode->created_date).'</td>
						</tr>
						<tr>
							<td>Rating</td>
							<td>: '. $result->avg.'/5 dari '.$result->votes .' pengguna.</td>
						</tr>
						<tr>
							<td>Lihat semua Episode</td>
							<td>: <a href="'.base_url().'anime/'.$episode->permalink.'/">'.$episode->title_anime.'</a></td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>';
		}
		echo $data;
		
		echo '<script>
		  $(document).ready(function() {
			  $("img").unveil();
			});
		</script>';
	}
}