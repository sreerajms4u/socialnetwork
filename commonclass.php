<?php
require('twitter/twitteroauth.php'); 
class commonclass {
	function __construct($var){
			 	
	}
}
 //twitter
class twitterclass{
	// path to twitteroauth library
	public $name="";
	public $profileImage="";
	public $followers_count="";
	public $screenName ="";
	function __construct($scnName){
		
		$consumerkey = 'Awf4UszZsT77TeevMFDS9dAYj';
		$consumersecret = 'jNUZkUSDtOUTk0MUB0OqfXjImlpMJDRGFyyh6buvxhgrN2LnN2';
		$accesstoken = '113091622-Txbnd0w1wNG3q8pp4cB5VUavedRP5fNjOQQRnfnM';
		$accesstokensecret = 'FlE55e2FyXOjs4tE00CpQMtwWvbE9wTGMAHQ1EcDDTiLE';
		$this->screenName =$scnName;
		$twitter = new TwitterOAuth($consumerkey, $consumersecret,$accesstoken, $accesstokensecret);
		$tweets =$twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='. $this->screenName.'');
		$data = json_decode($tweets, true);
		if (is_array($data)) {
			$this->name =$data[0]['user']['name'];
			$this->profileImage =  $data[0]['user']['profile_image_url'];
			$this->followers_count =  $data[0]['user']['followers_count'];
		}
	}
	function getTwitterName(){
				
		return $this->name;
	}
	function getTwitterProfileImage(){		
		return $this->profileImage;
	}
	function getTwitterFollowersCount(){		
		return $this->followers_count;
	}

}
//Facebook

class facebookclass{
	public $pageName="";
	public $likes;
	function __construct($page){
		$this->pageName = $page;
		$this->file_get_contents_curl();
	}
	public function file_get_contents_curl(){
		$url = "http://graph.facebook.com/?id=https://www.facebook.com/".$this->pageName;
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		$cont = curl_exec($ch);
		if(curl_error($ch))
		{
			die(curl_error($ch));
		}
			$json = json_decode($cont, true);
			$this->likes = $json['likes'];
			if($this->likes==null || $this->likes==''){
				$this->likes = 0;
			}			
		}
	}
	
	//Google Plus
	class googleplusclass{
		function __construct($page){
		
		}
	}
	
	//Youtube
	class youtubeclass{
		function __construct($page){
		
		}
	}
	
	//LinkedIN
	class linkedInclass{
		function __construct($page){
		
		}
	}

?>
