<?php
//$key = file_get_contents('the_key.txt');
//$key = json_decode(file_get_contents('the_key.txt'), true);
$token = array('access_token'=>$key['refresh_token']);
include dirname(__FILE__).'/config.php';  
//set_include_path($_SERVER['DOCUMENT_ROOT'] . '/Google/');
//require_once $_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php';
// 
//$application_name = 'tttt'; 
//$client_secret = 'WoUA1athZYfezzfabqKAiD7v';
//$client_id = '532148557766-o37janmnf21ii9ht3ekvfe94bt0am05j.apps.googleusercontent.com';
$scope = array('https://www.googleapis.com/auth/youtube.upload', 'https://www.googleapis.com/auth/youtube', 'https://www.googleapis.com/auth/youtubepartner');
         
//$videoPath = "tutorial1.mp4";
$videoPath = $_FILES['youfile']['tmp_name'];
$videoTitle = $_FILES['youfile']['name'];
$videoDescription = " ";
$videoCategory = "22";
//$videoTags = array("youtube", "tutorial");
 
 
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
 
    if ($client->getAccessToken()) {
 
        /**
         * Check to see if our access token has expired. If so, get a new one and save it to file for future use.
         */
//        if($client->isAccessTokenExpired()) {
//            $newToken = json_decode($client->getAccessToken());
//            $client->refreshToken($newToken->refresh_token);
//            file_put_contents('the_key.txt', $client->getAccessToken());
//        }
 
        $youtube = new Google_Service_YouTube($client);
 
 
 
        // Create a snipet with title, description, tags and category id
        $snippet = new Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle($videoTitle);
        $snippet->setDescription($videoDescription);
        $snippet->setCategoryId($videoCategory);
//        $snippet->setTags($videoTags);
 
        // Create a video status with privacy status. Options are "public", "private" and "unlisted".
        $status = new Google_Service_YouTube_VideoStatus();
        $status->setPrivacyStatus('public');
 
        // Create a YouTube video with snippet and status
        $video = new Google_Service_YouTube_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);
 
        // Size of each chunk of data in bytes. Setting it higher leads faster upload (less chunks,
        // for reliable connections). Setting it lower leads better recovery (fine-grained chunks)
        $chunkSizeBytes = 1 * 1024 * 1024;
 
        // Setting the defer flag to true tells the client to return a request which can be called
        // with ->execute(); instead of making the API call immediately.
        $client->setDefer(true);
 
        // Create a request for the API's videos.insert method to create and upload the video.
        $insertRequest = $youtube->videos->insert("status,snippet", $video);
 
        // Create a MediaFileUpload object for resumable uploads.
        $media = new Google_Http_MediaFileUpload(
            $client,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );
        $media->setFileSize(filesize($videoPath));
 
 
        // Read the media file and upload it chunk by chunk.
        $status = false;
        $handle = fopen($videoPath, "rb");
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
 
        fclose($handle);
 
        /**
         * Video has successfully been upload, now lets perform some cleanup functions for this video
         */
        if ($status->status['uploadStatus'] == 'uploaded') {
            // Actions to perform for a successful upload
            $uploaded_video_id = $status['id'];
            echo 'https://www.youtube.com/watch?v='.$uploaded_video_id;
        }
 
        // If you want to make other calls after the file upload, set setDefer back to false
        $client->setDefer(true);
 
    } else{
        // @TODO Log error
        echo 'Problems creating the client';
    }
 
} catch(Google_Service_Exception $e) {
    print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage();
}catch (Exception $e) {
    print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage();
}