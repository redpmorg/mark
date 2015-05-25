<?php

session_start();

$instance_url = $_COOKIE["instance_url"];
$access_token = $_COOKIE["access_token"];

$r = show_accounts($instance_url, $access_token);

function show_accounts($instance_url, $access_token) {

	$last_version = "v26.0/";
	$query = "sobjects/";
	// $query = "SELECT Name, Id from Account LIMIT 100";
	// $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

	$url = $instance_url."/services/data/".$last_version."/".$query;
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token"));

	$json_response = curl_exec($curl);
	curl_close($curl);

	$response = json_decode($json_response, true);

	var_dump($response);

//	return $response;

}