(function($) {
    $(document).ready(function() {    
        
        var $formNotice = $('.form-notice');
        var $imgForm    = $('.image-form');
        var $imgNotice  = $imgForm.find('.image-notice');
        var $imgPreview = $imgForm.find('.video-preview');
        var $imgFile    = $imgForm.find('.image-file');
        var $imgId      = $imgForm.find('[name="vid_id"]');
        var v_list = document.getElementById("v_listing");
        $('#progressbar').hide();
        

        $( "#progressbar" ).progressbar({
            value: 0
          });
                  

        if ( $imgForm.length ) {
            $imgFile.on('click', function() {
                $(this).val('');
                $imgId.val('');
            });

            $imgForm.on( 'click', '.btn-change-image', function(e) {
                e.preventDefault();
                $imgNotice.empty().hide();
                $imgFile.val('').show();
                $imgId.val('');
                $imgPreview.empty().hide();
            });

            $imgFile.on('change', function(e) {
                e.preventDefault();

                var formData = new FormData();

                formData.append('action', 'upload-attachment');
                formData.append('async-upload', $imgFile[0].files[0]);
                formData.append('name', $imgFile[0].files[0].name);
                formData.append('_wpnonce', su_config.nonce);

                $.ajax({
                    
                    url: su_config.upload_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        $('#progressbar').show();
                        if ( myXhr.upload ) {
                            myXhr.upload.addEventListener( 'progress', function(e) {
                                if ( e.lengthComputable ) {
                                    var perc = ( e.loaded / e.total ) * 100;
                                    perc = perc.toFixed(2);
                                    $imgNotice.html('Uploading&hellip;(' + perc + '%)');
                                    //progressbar.progressbar( "value", perc + 2 );
                                    //progressb(perc);
                                    var ii = Math.ceil(perc);
                                    $( "#progressbar" ).progressbar( 'value', ii  );
                                }
                            }, false );
                        }

                        return myXhr;
                    },
                    type: 'POST',
                    beforeSend: function() {
                        $imgFile.hide();
                        $imgNotice.html('Uploading&hellip;').show();
                    },
                    success: function(resp) {
                        if ( resp.success ) {
                            $('#progressbar').hide();
                            $imgNotice.html('<a href="#" class="btn-change-image">Изменить?</a>');

                            v_list.src = resp.data.url;
                            v_list.type = "video/mp4";
                            //var vid = '<video controls><source src="'+resp.data.url+'" type="video/mp4"></video>';
							
setTimeout(
 function() 
  {
    $('video,audio').mediaelementplayer();
 }, 5000);							
							
                            //$('video,audio').mediaelementplayer();
                            //$( window.wp.mediaelement.initialize );
							//$imgPreview.html(vid);
                            $imgId.val( resp.data.id );
                            $imgPreview.show();

                        }
                    }
                });
            });

        }
        
        
    });
})(jQuery);
