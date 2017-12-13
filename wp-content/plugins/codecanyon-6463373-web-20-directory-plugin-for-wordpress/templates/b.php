<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>YouTube API Uploads via CORS</title>
    <link rel="stylesheet" href="http://sdela.com/upload_video.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Open+Sans' type='text/css'>
  </head>
  <body>
 <style>
.w2dc-btn {
    display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	color: #FFFFFF;
background-color: #5b9d30;
background-image: none;
border-color: #47891c;
 </style>
    <span id="signinButton" class="pre-sign-in">
      <span
        class="g-signin"
        data-callback="signinCallback"
        data-clientid="532148557766-o37janmnf21ii9ht3ekvfe94bt0am05j.apps.googleusercontent.com"
        data-cookiepolicy="single_host_origin"
        data-scope="https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube">
      </span>
    </span>

    <div class="post-sign-in">
      <div style="display:none;">
        <img id="channel-thumbnail">
        <span id="channel-name"></span>
      </div>

      <div style="display:none;>
        <label for="title">Title:</label>
        <input id="title" type="text" value="Default Title">
      </div>
      <div style="display:none;>
        <label for="description">Description:</label>
        <textarea id="description">Default description</textarea>
      </div>
        <div style="display: none">
        <label for="privacy-status">Privacy Status:</label>
        <select id="privacy-status">
            <option selected="selected">public</option>
          <option>unlisted</option>
          <option>private</option>
        </select>
      </div>

      <div>
        <input input type="file" id="file" class="button" accept="video/*">
        <button class="w2dc-btn w2dc-btn-primary" id="button">Upload Video</button>
      <div class="during-upload">
        <p><span id="percent-transferred"></span>% done (<span id="bytes-transferred"></span>/<span id="total-bytes"></span> bytes)</p>
        <progress id="upload-progress" max="1" value="0"></progress>
      </div>

      <div class="post-upload">
	  <input type="text" id="video1-id"  />
        <p>Uploaded video with id 
		<!--<span id="video-id"></span>-->
		</p>
        <!--<ul id="post-upload-status"></ul>-->
        <div id="player"></div>
      </div>
      <!--<p id="disclaimer">By uploading a video, you certify that you own all rights to the content or that you are authorized by the owner to make the content publicly available on YouTube, and that it otherwise complies with the YouTube Terms of Service located at <a href="http://www.youtube.com/t/terms" target="_blank">http://www.youtube.com/t/terms</a></p>-->
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apis.google.com/js/client:plusone.js"></script>
    <script src="http://sdela.com/cors_upload.js"></script>
    <script src="http://sdela.com/upload_video.js"></script>
	<script>
	jQuery(document).ready(function(){
		jQuery('#video-id').on('change', function(){
			alert('ddd');
		});
	});
	</script>
  </body>
</html>
