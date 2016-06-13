<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

class PlaidConnect {
	//Generic CURL call function
	function callAPI($url, $paramArray) {
		$service_url = $url;
       $curl = curl_init($service_url);
       $curl_post_data = $paramArray;
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_POST, true);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
       $curl_response = curl_exec($curl);
       curl_close($curl);

       $xml = new SimpleXMLElement($curl_response);

       return json_encode($curl_response);
	}

	function addAuthUser($username, $password, $type) {
		$params = array(
			"client_id" => "5714fe3c66710877408cff89",
			"secret" => "9c9a67029c980420ccb5d2aff4f488",
			"username" => $username,
			"password" => $password,
			"type" => $type
			);
		$url = "https://tartan.plaid.com/auth";

		$jsonReturn = callAPI($url, $params);
		return $jsonReturn;
	}

	function addConnectUser($username, $password, $type) {
		$params = array( 
			"client_id" => "5714fe3c66710877408cff89",
			"secret" => "9c9a67029c980420ccb5d2aff4f488",
			"username" => $username,
			"password" => $password,
			"type" => $type
			);
		$url = "https://tartan.plaid.com/connect"
		$jsonReturn = callAPI($url, $params);
		return $jsonReturn;
	}

	function getInstitutions() {
		$institutions = callGET("https://tartan.plaid.com/institutions");
		return $institutions;
	}

	function callGET($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

}

?>