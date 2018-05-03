(function($) {
	$('#progressbar').progressbar();
	$('#you_btn').click(function (e) {
		e.preventDefault();
//		$('.myprogress').css('width', '0');
		$('.msg').text('');
		//var filename = $('#filename').val();
		var myfile = $('#youfile').val();
		if (myfile == '') {
			alert('Please select file');
			return;
		}
		$( "#progressbar" ).show();
		var formData = new FormData();
		formData.append('youfile', $('#youfile')[0].files[0]);
		formData.append('action', 'maxx_youtube_upload');
		$('#youfile, .upload-video').attr('disabled', 'disabled');
		 $('.msg').text('Uploading in progress...');
		$.ajax({
			url: su_config.upload_url,
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			// this part is progress bar
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						$( "#progressbar" ).progressbar( 'value', percentComplete  );
//						$('.myprogress').text(percentComplete + '%');
//						$('.myprogress').css('width', percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			success: function (data) {
				/////
				$('#attach_video_input').val(data);
				attachVideo();
				/////
				$('.msg').text(data);
				$('.msg').text('');
				$('#btn').removeAttr('disabled');
				$('#youfile, .upload-video').removeAttr('disabled');
				$('#youfile').val('');
				$( "#progressbar" ).hide();
			}
		});
	});
})(jQuery);