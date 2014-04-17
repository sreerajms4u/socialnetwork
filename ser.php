<?php


require './util.php';

interface SearchFormatStrategy {

	function getData(Google_Search $search);
}

class JSONStrategy implements SearchFormatStrategy {

	// Request JSON formatted search response
	public	function  getData(Google_Search $searchRes) {

		$params = array('key' => $searchRes::API_KEY,
						'cx' => $searchRes::CX,
						'q' => $searchRes->getQuery(),
						'alt'=>'json'
						);

		$url = $searchRes::BASE_URL . '?' . http_build_query($params, '', '&');
		$response = getSearchResult($url);
		if ($response['errno'] == 0) {

			$responseArr =  json_decode($response['content']);

		}
		else {

			echo 'Error! Trouble somewehre. <br>' . $response['errmsg'];
		}
		foreach ($responseArr->items as $item) {

			// $item->htmlTitle, $item->snippet
			$outputArr[] =  array($item->title, $item->link, $item->htmlSnippet);
		}
	
		return $outputArr;

	}
}

class ATOMStrategy implements SearchFormatStrategy {

	// Request ATOM formatted search response
	public	function  getData(Google_Search $searchRes) {

		$params = array('key' => $searchRes::API_KEY,
						'cx' => $searchRes::CX,
						'q' => $searchRes->getQuery(),
						'alt'=>'atom'
						);

		$url = $searchRes::BASE_URL . '?' . http_build_query($params, '', '&');
		

		$response = getSearchResult($url);

		if ($response['errno'] == 0) { // no error

			return $this->_blogFeed($response['content']);

		}
		else {

			echo 'Error! Trouble somewehre. <br>' . $response['errmsg'];
		}

	}

    private function _blogFeed($rssXML)
    {
	libxml_use_internal_errors(true);

        $doc = simplexml_load_string($rssXML);
		$xml = explode("\n", $rssXML);

		if (!$doc) {
			$errors = libxml_get_errors();

			foreach ($errors as $error) {
				echo $this->display_xml_error($error, $xml);
			}

			libxml_clear_errors();
		}

        if(count($doc) == 0) return;

		$docArr = json_decode(json_encode($doc),true);
		$entries = $docArr['entry'];

        foreach($entries as $item)
        {

		   $this->title		=	$item['title'];
		   $this->link		=	$item['link']['@attributes']['href'];
		   $this->summary	=	$item['summary'];

            $post = array(
				'title'=>		$this->title,
				'link' =>		$this->link,
				'summary' =>	$this->summary

			);

            $this->posts[] = $post;

        }

		return $this->posts;

    }

       // This I copied from somewhere
	public function display_xml_error($error, $xml)
	{
		$return  = $xml[$error->line - 1] . "\n";
		$return .= str_repeat('-', $error->column) . "^\n";

		switch ($error->level) {
			case LIBXML_ERR_WARNING:
				$return .= "Warning $error->code: ";
				break;
			 case LIBXML_ERR_ERROR:
				$return .= "Error $error->code: ";
				break;
			case LIBXML_ERR_FATAL:
				$return .= "Fatal Error $error->code: ";
				break;
		}

		$return .= trim($error->message) .
				   "\n  Line: $error->line" .
				   "\n  Column: $error->column";

		if ($error->file) {
			$return .= "\n  File: $error->file";
		}

		return "$return\n\n--------------------------------------------\n\n";
	}

}

class Google_Search {

	CONST BASE_URL	= 'https://www.googleapis.com/customsearch/v1';
	CONST API_KEY	= 'AIzaSyA13qMqAdQnuQVfvTi6Kli3JfPt0312DlY';
	CONST CX		= '003027148717437402488:fmxuegbhrmg';

	private $query = ''; 

	public function __construct ($queryTerm_) {

		$this->setQuery($queryTerm_);

	}

	public function getData(SearchFormatStrategy $strategyObject) {

		return $strategyObject->getData($this);

	}

	public function setQuery ($queryTerm_) {

		$this->query = $queryTerm_;

	}

	public function getQuery () {

		return $this->query;

	}

}
class socialNetworkIds{
	public $twitterID='';
	public $facebookID='';
	public $youtubeID='';
	public $twitterURL='twitter.com';
	public $faceBookURL='www.facebook.com';
	public $youtubeURL='www.youtube.com';
	public function __construct () {
		

	}
}
$google = new Google_Search('Sachin Tendulkar');
$objSNids=  new socialNetworkIds();
echo '<pre>';
// each array value should be encoded in production env.
$result = $google->getData(new JSONStrategy);
foreach($result as $item){
	getSNIds($item[1],$objSNids);
}
var_dump($objSNids);

function getSNIds($url,$objSNids){
	echo $url;	
	$strDomain = explode('/',$url);
	switch($strDomain[2]){
		case $objSNids->twitterURL:
			if($objSNids->twitterID==''){
				
				$objSNids->twitterID= $strDomain[3];
			}
			break;
		case $objSNids->faceBookURL:
			if($objSNids->facebookID==''){
				$objSNids->facebookID= $strDomain[3];
			}
			break;
		case $objSNids->youtubeURL:
			if($objSNids->youtubeID==''){
				$objSNids->youtubeID= $strDomain[4];
			}
			break;
		default:
			break;
	}
	
}
/*function parseURLforID($url,$strPreURL){
	echo $strPreURL;
	$position = strlen( $strPreURL);
	$endindex = 0;
	$name = substr($url, $position, strlen($url));	
	//echo $name."</br>" ;
	return $name;
}*/

?>
