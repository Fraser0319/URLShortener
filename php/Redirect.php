<?php

$request_method=$_SERVER["REQUEST_METHOD"];

$redirect = new Redirect();

switch($request_method)
{
    case 'GET':
    {
        $redirect->redirectOriginalURL($_GET['c']); // get the short code from the url.
    }
    break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}



class Redirect {

    public $db = null;
    public $connection = null;

    public function __construct() 
    {
        require_once('Connection.php'); 
    }

    public function redirectOriginalURL($shortCode){

        $db = new Connection();
        $connection =  $db->getConnstring();

        $query = $connection->prepare("SELECT short_url_key, original_url FROM shortend_urls WHERE short_url_key = ?");
        
        $query->bind_param("s", $shortCode);

		$response = array();
        $query->execute();
        $result = $query->get_result();

        if($result->num_rows === 0) exit('This URL does not exist !'); 
        while($row = $result->fetch_assoc()) {
            $response[]=$row;
        }
        
        $query->close();
        $escapedUrl = str_replace('\\"',"",json_encode($response[0]['original_url']));
        header('Location: ' . str_replace('"',"", $escapedUrl));
    }

}


?>