<?php
$key = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/the_key.txt'), true);
//$key = json_decode(file_get_contents('the_key.txt'), true);
$token = array('access_token'=>$key['access_token']);
 
//set_include_path($_SERVER['DOCUMENT_ROOT'] . '/Google/');
//require_once $_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php';
include dirname(__FILE__).'/config.php';

//$application_name = 'tttt'; 
//$client_secret = 'WoUA1athZYfezzfabqKAiD7v';
//$client_id = '532148557766-o37janmnf21ii9ht3ekvfe94bt0am05j.apps.googleusercontent.com';
$scope = array('https://www.googleapis.com/auth/youtube.upload', 'https://www.googleapis.com/auth/youtube', 'https://www.googleapis.com/auth/youtubepartner');
try{
    // Client init
    $client = new Google_Client();
    $client->setApplicationName($APPNAME);
    $client->setClientId($OAUTH2_CLIENT_ID);
    $client->setAccessType('offline');
	$client->setApprovalPrompt('force');
    $client->setAccessToken($token);
    $client->setScopes($scope);
    $client->setClientSecret($OAUTH2_CLIENT_SECRET);
	//if($client->isAccessTokenExpired()) {
		if ($client->getAccessToken()) {
				$newToken = $client->getAccessToken();
				$client->refreshToken($newToken);
				$temp = $client->getAccessToken();
				if($temp['access_token']){
					$tmp = $temp['access_token'];
					$temp['access_token'] = $temp['refresh_token']['access_token'];
					$temp['refresh_token']['access_token'] = $tmp;
					$temp['refresh_token'] = $tmp;
				}
				file_put_contents($_SERVER['DOCUMENT_ROOT'].'/the_key.txt', json_encode($temp));
				//file_put_contents('the_key.txt', json_encode($temp));
				echo 'success';
		}		
	//}
}catch(Google_Service_Exception $e) {
    print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage();
    print "Stack trace is ".$e->getTraceAsString();
}catch (Exception $e) {
    print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage();
    print "Stack trace is ".$e->getTraceAsString();
}