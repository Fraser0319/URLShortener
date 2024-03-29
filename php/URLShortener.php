<?php

$request_method=$_SERVER["REQUEST_METHOD"];

$url = new URLShortener();

switch($request_method)
{
    case 'GET':
    {
        if(!empty($_GET["url"])) { // check if a url is present otherwise show all urls
            $shortUrlKey = $url->shorten();
            $url->createShortendUrl($_GET["url"], $shortUrlKey);
        } else {
            $url->getShortendUrls();
        }
    }
    break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}



class URLShortener
{
    public $db = null;
    public $connection = null;
    

    public function __construct() 
    {
        require_once('Connection.php');
    }
    
    function shorten() {
        $base64String = base64_encode(rand(1,100000)); // generate a random base64 string for the short code.
        return $res = preg_replace("/[^a-zA-Z0-9]/", "", $base64String); // only have numbers and chars from a-z and A-Z
    }

   function createShortendUrl($url, $shortUrlKey){
        
        $db = new Connection();
        $connection =  $db->getConnstring();
        $response = "";

        $url = mysqli_real_escape_string($connection,$url);
    
        $query = $connection->prepare("INSERT INTO shortend_urls (short_url_key, original_url) VALUES (?, ?)");
        $query->bind_param("ss", $shortUrlKey, $url);
        
        if ($query->execute() === TRUE) {
            $response = "http://localhost:8100/" . $shortUrlKey;
            echo $response;
        } else {
            // we check for duplicates with this error code in the response
            if($connection->errno === 1062) echo 'Duplicate entry'; 
        }
        $query->close();
            
        
    }

   function getShortendUrls()
	{
        $db = new Connection();
        $connection =  $db->getConnstring();

		$query = "SELECT * FROM shortend_urls";
		$response = array();
        $result = mysqli_query($connection, $query);
        
		while($row = mysqli_fetch_array($result)) {
			$response[]=$row;
        }

        $connection->close();
		header('Content-Type: text/plain');
		echo json_encode($response);
	}

}
?>