<?php

class Generate_genres {

	var $contents;
	var $encoding;
	var $keywords;
	var $wordLengthMin;
	var $wordOccuredMin;
	var $word2WordPhraseLengthMin;
	var $phrase2WordLengthMinOccur;
	var $word3WordPhraseLengthMin;
	var $phrase2WordLengthMin;
	var $phrase3WordLengthMinOccur;
	var $phrase3WordLengthMin;

	private $tbl = 'genres';

	public function __construct()
    {
        $this->CI =& get_instance();
    }

	public function check_tag($str){
		$this->CI->db->select('namegenre');
		$this->CI->db->from($this->tbl);
		$this->CI->db->where('namegenre', $str);

		$count = $this->CI->db->count_all_results();
		if($count <= 0){
			return false;
		}else{
			return true;
		}
	}

	public function newTags($tags,$tagcount){

		if(!empty($tags)){
			$this->tags = explode(",",$tags);
			$this->arrTag = array();
			$this->num = 1;
			foreach ($this->tags as $this->tagname) {
				$this->arrTag[] = $this->tagname;
			}
			for($this->i = 0; $this->i<$tagcount;$this->i++){
				$this->temp = $this->arrTag[$this->i];
				$this->CI->db->select('*');
				$this->CI->db->from($this->tbl);
				$this->CI->db->where('namegenre', $this->temp);

				$this->count = $this->CI->db->count_all_results();
				if($this->count <= 0){
					$data = array(
							'namegenre' => $this->temp
						);
					$this->CI->db->insert($data);
				}
			}
		}
	}

	public function countTags($tags){
		$tags = explode(",",$tags);
		$num = 1;
		foreach($tags as $coma){
			$coma = $num++;
		}
		return $coma;
	}

	public function get_tags($class = null, $limit = 5, $start = 0, $use_count = true){
		$content 	= null;
		if($limit <= 0){
			$limit = '';
		}else{
			$limit = "LIMIT 0,".$limit;
		}

		$this->CI->db->select('namegenre');
		$this->CI->db->from($this->tbl);
		$this->CI->db->order_by('namegenre', 'asc');
		$this->CI->db->limit($limit, $start);

		$count = $this->CI->db->count_all_results();
		if($count <= 0){
			return '<div class="alert alert-warning">Sorry, there are no tags at the moment.</div>';
		}else{
			$sql = $this->CI->db->get()->result();
			foreach($sql as $genre):
				$genre = $genre->namegenre;
				$query2 	= "SELECT count(*) as num_post FROM anime where genres LIKE '%$genre%'";
				$post = mysqli_query($mysqli, $query2);
				$postcount = mysqli_fetch_assoc($post);
				if($use_count === true){
					$genre_count = '<span class="genre">'.$data['namegenre'].'</span> <span class="count">'.$postcount['num_post'].'</span>';
				}else{
					$genre_count = $data['namegenre'];
				}
				$content .= '<li><a href="'.$config->myurl.'genre/'.urlencode($data['namegenre']).'/" rel="tag" title="'.$data['namegenre'].'" '.$class.'>'.$genre_count.'</a></li>';	
			endforeach;
			}
			return $content;
		}

	function randomTags($tags,$tagcount){
		$tags = explode(",",$tags);
		$arrTag = array();
		$num = 1;
		foreach ($tags as $tagname) {
			$arrTag[] = $tagname;
		}
		$random = rand(0,($tagcount-1));
		return $arrTag[$random];
	}

	function get_tag_link($tags,$tagcount){
		$results = null;
		$tags = explode(",",$tags);
		$arrTag = array();
		$num = 1;
		foreach ($tags as $tagname):
			$arrTag[] = '<a href="'.base_url().'genre/'.urlencode(strtolower($tagname)).'/" rel="tag" target="_BLANK">'.$tagname.'</a>';
		endforeach;

		for($i = 0; $i<$tagcount;$i++):
			if(($tagcount-1) == $i):
				$results .= $arrTag[$i];
			else:
				$results .= $arrTag[$i].", ";
			endif;
		endfor;
		return $results;
	}

	function autokeyword($params, $encoding)
	{
		//get parameters
		$this->encoding = $encoding;
		mb_internal_encoding($encoding);
		$this->contents = $this->replace_chars($params['content']);

		// single word
		$this->wordLengthMin = $params['min_word_length'];
		$this->wordOccuredMin = $params['min_word_occur'];

		// 2 word phrase
		$this->word2WordPhraseLengthMin = $params['min_2words_length'];
		$this->phrase2WordLengthMin = $params['min_2words_phrase_length'];
		$this->phrase2WordLengthMinOccur = $params['min_2words_phrase_occur'];

		// 3 word phrase
		$this->word3WordPhraseLengthMin = $params['min_3words_length'];
		$this->phrase3WordLengthMin = $params['min_3words_phrase_length'];
		$this->phrase3WordLengthMinOccur = $params['min_3words_phrase_occur'];

		//parse single, two words and three words

	}

	function get_keywords()
	{
		$keywords = $this->parse_words().$this->parse_2words().$this->parse_3words();
		if($keywords){
			return substr($keywords, 0, -2);
		}else{
			return false;
		}
	}
	
	function get_keywords_head()
	{
		$keywords = $this->parse_words1().$this->parse_2words2().$this->parse_3words3();
		if($keywords){
			return substr($keywords, 0, -2);
		}else{
			return "Not found any keywords.";
		}
	}

	//turn the site contents into an array
	//then replace common html tags.
	function replace_chars($content)
	{
		//convert all characters to lower case
		$content = mb_strtolower($content);
		//$content = mb_strtolower($content, "UTF-8");
		$content = strip_tags($content);

      //updated in v0.3, 24 May 2009
		$punctuations = array(',', ')', '(', '.', "'", '"',
		'<', '>', '!', '?', '/', '-',
		'_', '[', ']', ':', '+', '=', '#',
		'$', '&quot;', '&copy;', '&gt;', '&lt;', 
		'&nbsp;', '&trade;', '&reg;', ';', 
		chr(10), chr(13), chr(9));

		$content = str_replace($punctuations, " ", $content);
		// replace multiple gaps
		$content = preg_replace('/ {2,}/si', " ", $content);

		return $content;
	}

	//single words META KEYWORDS
	function parse_words()
	{
		//list of commonly used words
		// this can be edited to suit your needs
		$common = array("able", "about", "above", "act", "add", "afraid", "after", "again", "against", "age", "ago", "agree", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "amount", "an", "and", "anger", "angry", "animal", "another", "answer", "any", "appear", "apple", "are", "arrive", "arm", "arms", "around", "arrive", "as", "ask", "at", "attempt", "aunt", "away", "back", "bad", "bag", "bay", "be", "became", "because", "become", "been", "before", "began", "begin", "behind", "being", "bell", "belong", "below", "beside", "best", "better", "between", "beyond", "big", "body", "bone", "born", "borrow", "both", "bottom", "box", "boy", "break", "bring", "brought", "bug", "built", "busy", "but", "buy", "by", "call", "came", "can", "cause", "choose", "close", "close", "consider", "come", "consider", "considerable", "contain", "continue", "could", "cry", "cut", "dare", "dark", "deal", "dear", "decide", "deep", "did", "die", "do", "does", "dog", "done", "doubt", "down", "during", "each", "ear", "early", "eat", "effort", "either", "else", "end", "enjoy", "enough", "enter", "even", "ever", "every", "except", "expect", "explain", "fail", "fall", "far", "fat", "favor", "fear", "feel", "feet", "fell", "felt", "few", "fill", "find", "fit", "fly", "follow", "for", "forever", "forget", "from", "front", "gave", "get", "gives", "goes", "gone", "good", "got", "gray", "great", "green", "grew", "grow", "guess", "had", "half", "hang", "happen", "has", "hat", "have", "he", "hear", "heard", "held", "hello", "help", "her", "here", "hers", "high", "hill", "him", "his", "hit", "hold", "hot", "how", "however", "I", "if", "ill", "in", "indeed", "instead", "into", "iron", "is", "it", "its", "just", "keep", "kept", "knew", "know", "known", "late", "least", "led", "left", "lend", "less", "let", "like", "likely", "likr", "lone", "long", "look", "lot", "make", "many", "may", "me", "mean", "met", "might", "mile", "mine", "moon", "more", "most", "move", "much", "must", "my", "near", "nearly", "necessary", "neither", "never", "next", "no", "none", "nor", "not", "note", "nothing", "now", "number", "of", "off", "often", "oh", "on", "once", "only", "or", "other", "ought", "our", "out", "please", "prepare", "probable", "pull", "pure", "push", "put", "raise", "ran", "rather", "reach", "realize", "reply", "require", "rest", "run", "said", "same", "sat", "saw", "say", "see", "seem", "seen", "self", "sell", "sent", "separate", "set", "shall", "she", "should", "side", "sign", "since", "so", "sold", "some", "soon", "sorry", "stay", "step", "stick", "still", "stood", "such", "sudden", "suppose", "take", "taken", "talk", "tall", "tell", "ten", "than", "thank", "that", "the", "their", "them", "then", "there", "therefore", "these", "they", "this", "those", "though", "through", "till", "to", "today", "told", "tomorrow", "too", "took", "tore", "tought", "toward", "tried", "tries", "trust", "try", "turn", "two", "under", "until", "up", "upon", "us", "use", "usual", "various", "verb", "very", "visit", "want", "was", "we", "well", "went", "were", "what", "when", "where", "whether", "which", "while", "white", "who", "whom", "whose", "why", "will", "with", "within", "without", "would", "yes", "yet", "you", "young", "your", "br", "img", "p","lt", "gt", "quot", "copy");
		//create an array out of the site contents
		$s = explode(" ", $this->contents);
		//initialize array
		$k = array();
		//iterate inside the array
		foreach( $s as $key=>$val ) {
			//delete single or two letter words and
			//Add it to the list if the word is not
			//contained in the common words list.
			if(mb_strlen(trim($val)) >= $this->wordLengthMin  && !in_array(trim($val), $common)  && !is_numeric(trim($val))) {
				$k[] = trim($val);
			}
		}
		//count the words
		$k = array_count_values($k);
		//sort the words from
		//highest count to the
		//lowest.
		$occur_filtered = $this->occure_filter($k, $this->wordOccuredMin);
		@arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		
		//release unused variables
		unset($k);
		unset($s);

		return $imploded;
	}
	
	function parse_words1()
	{
		//list of commonly used words
		// this can be edited to suit your needs
		$common = array("able", "about", "above", "act", "add", "afraid", "after", "again", "against", "age", "ago", "agree", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "amount", "an", "and", "anger", "angry", "animal", "another", "answer", "any", "appear", "apple", "are", "arrive", "arm", "arms", "around", "arrive", "as", "ask", "at", "attempt", "aunt", "away", "back", "bad", "bag", "bay", "be", "became", "because", "become", "been", "before", "began", "begin", "behind", "being", "bell", "belong", "below", "beside", "best", "better", "between", "beyond", "big", "body", "bone", "born", "borrow", "both", "bottom", "box", "boy", "break", "bring", "brought", "bug", "built", "busy", "but", "buy", "by", "call", "came", "can", "cause", "choose", "close", "close", "consider", "come", "consider", "considerable", "contain", "continue", "could", "cry", "cut", "dare", "dark", "deal", "dear", "decide", "deep", "did", "die", "do", "does", "dog", "done", "doubt", "down", "during", "each", "ear", "early", "eat", "effort", "either", "else", "end", "enjoy", "enough", "enter", "even", "ever", "every", "except", "expect", "explain", "fail", "fall", "far", "fat", "favor", "fear", "feel", "feet", "fell", "felt", "few", "fill", "find", "fit", "fly", "follow", "for", "forever", "forget", "from", "front", "gave", "get", "gives", "goes", "gone", "good", "got", "gray", "great", "green", "grew", "grow", "guess", "had", "half", "hang", "happen", "has", "hat", "have", "he", "hear", "heard", "held", "hello", "help", "her", "here", "hers", "high", "hill", "him", "his", "hit", "hold", "hot", "how", "however", "I", "if", "ill", "in", "indeed", "instead", "into", "iron", "is", "it", "its", "just", "keep", "kept", "knew", "know", "known", "late", "least", "led", "left", "lend", "less", "let", "like", "likely", "likr", "lone", "long", "look", "lot", "make", "many", "may", "me", "mean", "met", "might", "mile", "mine", "moon", "more", "most", "move", "much", "must", "my", "near", "nearly", "necessary", "neither", "never", "next", "no", "none", "nor", "not", "note", "nothing", "now", "number", "of", "off", "often", "oh", "on", "once", "only", "or", "other", "ought", "our", "out", "please", "prepare", "probable", "pull", "pure", "push", "put", "raise", "ran", "rather", "reach", "realize", "reply", "require", "rest", "run", "said", "same", "sat", "saw", "say", "see", "seem", "seen", "self", "sell", "sent", "separate", "set", "shall", "she", "should", "side", "sign", "since", "so", "sold", "some", "soon", "sorry", "stay", "step", "stick", "still", "stood", "such", "sudden", "suppose", "take", "taken", "talk", "tall", "tell", "ten", "than", "thank", "that", "the", "their", "them", "then", "there", "therefore", "these", "they", "this", "those", "though", "through", "till", "to", "today", "told", "tomorrow", "too", "took", "tore", "tought", "toward", "tried", "tries", "trust", "try", "turn", "two", "under", "until", "up", "upon", "us", "use", "usual", "various", "verb", "very", "visit", "want", "was", "we", "well", "went", "were", "what", "when", "where", "whether", "which", "while", "white", "who", "whom", "whose", "why", "will", "with", "within", "without", "would", "yes", "yet", "you", "young", "your", "br", "img", "p","lt", "gt", "quot", "copy");
		//create an array out of the site contents
		$s = explode(" ", $this->contents);
		//initialize array
		$k = array();
		//iterate inside the array
		foreach( $s as $key=>$val ) {
			//delete single or two letter words and
			//Add it to the list if the word is not
			//contained in the common words list.
			if(mb_strlen(trim($val)) >= $this->wordLengthMin  && !in_array(trim($val), $common)  && !is_numeric(trim($val))) {
				$k[] = trim($val);
			}
		}
		//count the words
		$k = array_count_values($k);
		//sort the words from
		//highest count to the
		//lowest.
		$occur_filtered = $this->occure_filter($k, $this->wordOccuredMin);
		arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		
		//release unused variables
		unset($k);
		unset($s);

		return $imploded;
	}

	function parse_2words()
	{
		//create an array out of the site contents
		$x = explode(" ", $this->contents);
		//initilize array

		//$y = array();
		for ($i=0; $i < count($x)-1; $i++) {
			//delete phrases lesser than 5 characters
			if( (mb_strlen(trim($x[$i])) >= $this->word2WordPhraseLengthMin ) && (mb_strlen(trim($x[$i+1])) >= $this->word2WordPhraseLengthMin) )
			{
				$y[] = trim($x[$i])." ".trim($x[$i+1]);
			}
		}

		//count the 2 word phrases
		$y = @array_count_values($y);

		$occur_filtered = $this->occure_filter($y, $this->phrase2WordLengthMinOccur);
		//sort the words from highest count to the lowest.
		@arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		//release unused variables
		unset($y);
		unset($x);

		return $imploded;
	}
	
	function parse_2words2()
	{
		//create an array out of the site contents
		$x = explode(" ", $this->contents);
		//initilize array

		//$y = array();
		for ($i=0; $i < count($x)-1; $i++) {
			//delete phrases lesser than 5 characters
			if( (mb_strlen(trim($x[$i])) >= $this->word2WordPhraseLengthMin ) && (mb_strlen(trim($x[$i+1])) >= $this->word2WordPhraseLengthMin) )
			{
				$y[] = trim($x[$i])." ".trim($x[$i+1]);
			}
		}

		//count the 2 word phrases
		$y = array_count_values($y);

		$occur_filtered = $this->occure_filter($y, $this->phrase2WordLengthMinOccur);
		//sort the words from highest count to the lowest.
		arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		//release unused variables
		unset($y);
		unset($x);

		return $imploded;
	}

	function parse_3words()
	{
		//create an array out of the site contents
		$a = explode(" ", $this->contents);
		//initilize array
		$b = array();

		for ($i=0; $i < count($a)-2; $i++) {
			//delete phrases lesser than 5 characters
			if( (mb_strlen(trim($a[$i])) >= $this->word3WordPhraseLengthMin) && (mb_strlen(trim($a[$i+1])) > $this->word3WordPhraseLengthMin) && (mb_strlen(trim($a[$i+2])) > $this->word3WordPhraseLengthMin) && (mb_strlen(trim($a[$i]).trim($a[$i+1]).trim($a[$i+2])) > $this->phrase3WordLengthMin) )
			{
				$b[] = trim($a[$i])." ".trim($a[$i+1])." ".trim($a[$i+2]);
			}
		}

		//count the 3 word phrases
		$b = array_count_values($b);
		//sort the words from
		//highest count to the
		//lowest.
		$occur_filtered = $this->occure_filter($b, $this->phrase3WordLengthMinOccur);
		@arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		//release unused variables
		unset($a);
		unset($b);

		return $imploded;
	}
	
	function parse_3words3()
	{
		//create an array out of the site contents
		$a = explode(" ", $this->contents);
		//initilize array
		$b = array();

		for ($i=0; $i < count($a)-2; $i++) {
			//delete phrases lesser than 5 characters
			if( (mb_strlen(trim($a[$i])) >= $this->word3WordPhraseLengthMin) && (mb_strlen(trim($a[$i+1])) > $this->word3WordPhraseLengthMin) && (mb_strlen(trim($a[$i+2])) > $this->word3WordPhraseLengthMin) && (mb_strlen(trim($a[$i]).trim($a[$i+1]).trim($a[$i+2])) > $this->phrase3WordLengthMin) )
			{
				$b[] = trim($a[$i])." ".trim($a[$i+1])." ".trim($a[$i+2]);
			}
		}

		//count the 3 word phrases
		$b = array_count_values($b);
		//sort the words from
		//highest count to the
		//lowest.
		$occur_filtered = $this->occure_filter($b, $this->phrase3WordLengthMinOccur);
		arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		//release unused variables
		unset($a);
		unset($b);

		return $imploded;
	}

	function occure_filter($array_count_values, $min_occur)
	{
		$occur_filtered = array();
		if(!empty($array_count_values)){
		foreach ($array_count_values as $word => $occured) {
			if ($occured >= $min_occur) {
				$occur_filtered[$word] = $occured;
			}
		}

		return $occur_filtered;
		}
	}

	// function implode($gule, $array)
	// {
	// 	$c = "";
	// 	if(!empty($array)){
	// 	foreach($array as $key=>$val) {
	// 		@$c .= $key.$gule;
	// 	}
	// 	return $c;
	// 	}
	// }
}