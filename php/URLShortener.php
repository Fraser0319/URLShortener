<?php

$request_method=$_SERVER["REQUEST_METHOD"];

$url = new URLShortener();

switch($request_method)
{
    case 'GET':
    {

        if(!empty($_GET["url"])) {
            $url->createShortendUrl($_GET["url"]);
            
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
        // Connect to database
        include("connection.php");
    }
    
    function shorten() {
        $base64String = base64_encode(rand(1,100000));
        return $res = preg_replace("/[^a-zA-Z0-9]/", "", $base64String); // only have numbers and chars from a-z
    }

   function createShortendUrl($url){

        $db = new Connection();
        $connection =  $db->getConnstring();

        $url = mysqli_real_escape_string($connection,$url);
        $shortUrlKey = $this->shorten();

        try {
            $query = $connection->prepare("INSERT INTO shortend_urls (short_url_key, original_url) VALUES (?, ?)");
            $query->bind_param("ss", $shortUrlKey, $url);

            
            if ($query->execute() === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $query . "<br>" . $this->query;
            }
            $query->close();

        } catch(Exception $e) {
            echo "Error: " . $e;
            $query->close();
        }
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
		header('Content-Type: application/json');
		echo json_encode($response);
	}

}
?>