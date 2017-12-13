<script>
//jQuery(document).ready(function(){
//  jQuery('#video-id').on('change', function(){
//      alert('https://www.youtube.com/watch?v='+jQuery('#video-id').val());
//});

</script>
<div class="youtube-wrapper">
    <h3>Upload video to Youtube</h3>
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
        <div style="display: none">
        <img id="channel-thumbnail">
        <span id="channel-name"></span>
      </div>

        <div style="display: none">
        <label for="title">Title:</label>
        <input id="title" type="text" value=" ">
      </div>
      <div style="display: none">
        <label for="description">Description:</label>
        <textarea id="description"> </textarea>
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
        <button id="button">Upload Video</button>
      <div class="during-upload">
        <p><span id="percent-transferred"></span>%  (<span id="bytes-transferred"></span>/<span id="total-bytes"></span> bytes)</p>
        <progress id="upload-progress" max="1" value="0"></progress>
      </div>

      <div class="post-upload">
        <p>Uploaded video with id <span id="video-id"></span></p>
        <div id="player"></div>
      </div>
    </div>    
</div>