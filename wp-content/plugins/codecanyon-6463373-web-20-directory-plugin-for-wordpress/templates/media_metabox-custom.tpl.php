<?php if ($listing->level->images_number): ?>
<?php
$img_width = (get_option('thumbnail_size_w')) ? get_option('thumbnail_size_w') : 120; 
$img_height = (get_option('thumbnail_size_h')) ? get_option('thumbnail_size_h') : 90; 
?>
<script>
	var images_number = <?php echo $listing->level->images_number; ?>;

	(function($) {
		"use strict";

		$(function() {
			$("#images_wrapper").on('click', '.delete_item', function() {
				$(this).parent().remove();
	
				if (images_number > $("#images_wrapper .w2dc-attached-item").length)
					$("#w2dc-upload-functions").show();
			});
		});
	})(jQuery);
</script>

<div id="w2dc-upload-wrapper">
	<div id="images_wrapper">
	<?php foreach ($listing->images AS $attachment_id=>$attachment): ?>
		<?php $src = wp_get_attachment_image_src($attachment_id, 'thumbnail'); ?>
		<?php $src_full = wp_get_attachment_image_src($attachment_id, 'full'); ?>
		<div class="w2dc-attached-item">
			<div class="w2dc-delete-attached-item delete_item" title="<?php esc_attr_e('remove image', 'W2DC'); ?>"></div>
			<input type="hidden" name="attached_image_id[]" value="<?php echo $attachment_id; ?>" />
			<div class="w2dc-img-div-border" style="width: <?php echo $img_width; ?>px; height: <?php echo $img_height; ?>px">
				<span class="w2dc-img-div-helper"></span><a href="<?php echo $src_full[0]; ?>" data-lightbox="listing_images"><img src="<?php echo $src[0]; ?>" style="max-width: <?php echo $img_width; ?>px; max-height: <?php echo $img_height; ?>px" /></a>
			</div>
			<input type="text" name="attached_image_title[]" size="37" class="w2dc-form-control" value="<?php esc_attr_e($attachment['post_title']); ?>" placeholder="<?php esc_attr_e('optional image title', 'W2DC'); ?>" />
			<?php if ($listing->level->logo_enabled): ?>
			<label><input type="radio" name="attached_image_as_logo" value="<?php echo $attachment_id; ?>" <?php checked($listing->logo_image, $attachment_id); ?>> <?php _e('set this image as logo', 'W2DC'); ?></label>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	</div>
	<div class="clear_float"></div>

	<?php if (current_user_can('upload_files')): ?>
	<script>
		(function($) {
			"use strict";
		
			$(function() {
				$('.w2dc-upload-image').click(function(event) {
					event.preventDefault();
			
					var frame = wp.media({
			            title : '<?php echo esc_js(sprintf(__('Upload image (%d maximum)', 'W2DC'), $listing->level->images_number)); ?>',
			            multiple : true,
			            library : { type : 'image'},
			            button : { text : '<?php echo esc_js(__('Insert', 'W2DC')); ?>'},
			        });
					frame.on( 'select', function() {
					    var selection = frame.state().get('selection');
					    selection.each(function(attachment) {
					    	attachment = attachment.toJSON();
					    	if (attachment.type == 'image') {
					    		if (images_number > $("#images_wrapper .w2dc-attached-item").length) {
									w2dc_ajax_loader_show();

									if (typeof attachment.sizes.thumbnail != 'undefined')
										var attachment_url = attachment.sizes.thumbnail.url;
									else
										var attachment_url = attachment.sizes.full.url;
									var attachment_url_full = attachment.sizes.full.url;
									var attachment_id = attachment.id;
									var attachment_title = attachment.title;
									$('<div class="w2dc-attached-item"><div class="w2dc-delete-attached-item delete_item" title="<?php esc_attr_e('remove image', 'W2DC'); ?>"></div><input type="hidden" name="attached_image_id[]" value="' + attachment_id + '" /><div class="w2dc-img-div-border" style="width: <?php echo $img_width; ?>px; height: <?php echo $img_height; ?>px"><span class="w2dc-img-div-helper"></span><a href="' + attachment_url_full + '" data-lightbox="listing_images"><img src="' + attachment_url + '" style="max-width: <?php echo $img_width; ?>px; max-height: <?php echo $img_height; ?>px" /></a></div><input type="text" name="attached_image_title[]" class="w2dc-form-control" value="' + attachment_title + '" size="37" placeholder="<?php esc_attr_e('optional image title', 'W2DC'); ?>" /><?php if ($listing->level->logo_enabled): ?><label><input type="radio" name="attached_image_as_logo" value="' + attachment_id + '"> <?php echo esc_js(__('set this image as logo', 'W2DC')); ?></label><?php endif; ?></div>').appendTo("#images_wrapper");
	
									$.post(
										w2dc_js_objects.ajaxurl,
										{'action': 'w2dc_upload_media_image', 'attachment_id': attachment_id, 'post_id': <?php echo $listing->post->ID; ?>, '_wpnonce': '<?php echo wp_create_nonce('upload_images'); ?>'},
										function (response_from_the_action_function){
											w2dc_ajax_loader_hide();
										}
									);
								}
								if (images_number <= $("#images_wrapper .w2dc-attached-item").length)
									jQuery("#w2dc-upload-functions").hide();
					    	}
						});
					});
					frame.open();
				});
			});
		})(jQuery);
	</script>
	<div id="w2dc-upload-functions" <?php if (count($listing->images) >= $listing->level->images_number): ?>style="display: none;"<?php endif; ?>>
        <div class="w2dc-upload-option input-group">
            <input type="text" class="w2dc-upload-image form-control" placeholder="Загрузить фотографии..." value="" readonly />
            <span class="input-group-btn">
                <button id="upload_image" class="btn w2dc-btn w2dc-upload-image">
                    <i class="fa fa-folder-open"></i>&nbsp;
	                <?php esc_attr_e('Выбрать', 'W2DC'); ?>
                </button>
            </span>
		</div>
	</div>
	<?php else: ?>
	<script>
		(function($) {
			"use strict";
	
			window.addImageDiv = function(data) {
				var attachment_url = data.uploaded_file;
				var attachment_id = data.attachment_id;
				$('<div class="w2dc-attached-item"><div class="w2dc-delete-attached-item delete_item" title="<?php esc_attr_e('remove image', 'W2DC'); ?>"></div><input type="hidden" name="attached_image_id[]" value="' + attachment_id + '" /><div class="w2dc-img-div-border" style="width: <?php echo $img_width; ?>px; height: <?php echo $img_height; ?>px"><span class="w2dc-img-div-helper"></span><img src="' + attachment_url + '" style="max-width: <?php echo $img_width; ?>px; max-height: <?php echo $img_height; ?>px" /></div><input type="text" name="attached_image_title[]" class="w2dc-form-control" size="37" /><?php if ($listing->level->logo_enabled): ?><label><input type="radio" name="attached_image_as_logo" value="' + attachment_id + '"> <?php echo esc_js(__('set this image as logo', 'W2DC')); ?></label><?php endif; ?></div>').appendTo("#images_wrapper");
		
				if (images_number <= jQuery("#images_wrapper .w2dc-attached-item").length)
					$("#w2dc-upload-functions").hide();
			};
		})(jQuery);
	</script>
	<div id="w2dc-upload-functions" class="w2dc-content" <?php if (count($listing->images) >= $listing->level->images_number): ?>style="display: none;"<?php endif; ?>>
		<div class="w2dc-upload-option">
			<input id="browse_file" name="browse_file" type="file" size="45" />
		</div>
		<div class="w2dc-upload-option">
			<label><input type="checkbox" id="crop_image" value="1" /> <?php _e('Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'W2DC'); ?></label>
		</div>
		<div class="w2dc-upload-option">
			<input
				type="button"
				class="w2dc-btn w2dc-btn-primary"
				onclick="return w2dc_ajaxImageFileUploadToGallery(
					'browse_file',
					addImageDiv,
					jQuery('#crop_image').is(':checked'),
					'<?php echo admin_url('admin-ajax.php?action=w2dc_upload_image&post_id='.$listing->post->ID.'&_wpnonce='.wp_create_nonce('upload_images')); ?>',
					'<?php echo esc_js(__('Choose image to upload first!', 'W2DC')); ?>'
				);"
				value="<?php esc_attr_e('Upload image', 'W2DC'); ?>" />
		</div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>


<?php if ($listing->level->videos_number): ?>
<script>
	var videos_number = <?php echo $listing->level->videos_number; ?>;

	(function($) {
		"use strict";

		$(function() {
			$(document).on("click", "#videos_wrapper .delete_item", function() {
				$(this).parent().remove();
	
				if (videos_number > $("#videos_wrapper .w2dc-attached-item").length)
					$("#attach_videos_functions").show();
			});
		});
	})(jQuery);
</script>
<div class="video-wrapper">
<!--<h3>Upload video (mp4)</h3>
            <p class="form-notice"></p>
            <style>
                .video-preview video{
                    max-width: 100%;
                }
            </style>
            <?php 
            $vid_id = get_post_meta( $listing->post->ID, 'vid_id', true );
            ?>
            <div class="image-form">
                <p class="image-notice"><?php echo $vid_id? '<a href="#" class="btn-change-image">Изменить?</a>':''?></p>
                <p><input type="file" name="async-upload" class="image-file" accept="video/mp4" <?php echo $vid_id? 'style="display:none;"':''?> ></p>
                <input type="hidden" name="vid_id" value ="<?php echo $vid_id? $vid_id:''?>">
                
                <div id="progressbar"><div class="progress-label"></div></div>
            </div>    
            <div class="video-preview"><video id="v_listing" <?php echo $vid_id? 'controls src="'.wp_get_attachment_url($vid_id).'"':''?>></video></div>
    
    -->
    <?php echo do_shortcode('[image_form]');?>

</div>

<!--<div class="youtube-wrapper">
    <h3>Upload video to Youtube</h3>
  <iframe style="width:100%; border: 0;min-height: 175px;"  frameborder="0" scrolling="no" src="http://sdela.com/wp-content/plugins/codecanyon-6463373-web-20-directory-plugin-for-wordpress/templates/b.php"></iframe>

</div>-->

<div id="videos_attach_wrapper">
	<div id="videos_wrapper">
	<?php foreach ($listing->videos AS $video): ?>
		<div class="w2dc-attached-item">
			<div class="w2dc-delete-attached-item delete_item" title="<?php esc_attr_e('remove video', 'W2DC'); ?>"></div>
			<input type="hidden" name="attached_video_id[]" value="<?php esc_attr_e($video['id']); ?>" />
			<div class="w2dc-img-div-border" style="width: 120px; height: 90px">
				<?php if (strlen($video['id']) == 11): ?>
				<span class="w2dc-img-div-helper"></span><img src="http://i.ytimg.com/vi/<?php echo $video['id']; ?>/default.jpg" style="max-width: 120px; max-height: 90px" />
				<?php elseif (strlen($video['id']) == 9): ?>
				<?php
					$data = file_get_contents("http://vimeo.com/api/v2/video/" . $video['id'] . ".json");
					$data = json_decode($data);
					$image_url = $data[0]->thumbnail_medium;
    			?>
				<span class="w2dc-img-div-helper"></span><img src="<?php echo $image_url; ?>" style="max-width: 120px; max-height: 90px" />
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
	<div class="clear_float"></div>

	<script>
		(function($) {
			"use strict";
		
			window.attachVideo = function() {
				if ($("#attach_video_input").val()) {
					var regExp_youtube = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
					var regExp_vimeo = /https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/;
					var matches_youtube = $("#attach_video_input").val().match(regExp_youtube);
					var matches_vimeo = $("#attach_video_input").val().match(regExp_vimeo);
					if (matches_youtube && matches_youtube[2].length == 11) {
						var video_id = matches_youtube[2];
						var image_url = 'http://i.ytimg.com/vi/'+video_id+'/0.jpg';
						$('<div class="w2dc-attached-item"><div class="w2dc-delete-attached-item delete_item" title="<?php esc_attr_e('remove video', 'W2DC'); ?>"></div><input type="hidden" name="attached_video_id[]" value="' + video_id + '" /><div class="w2dc-img-div-border" style="width: 120px; height: 90px"><span class="w2dc-img-div-helper"></span><img src="' + image_url + '" style="max-width: 120px; max-height: 90px" /></div></div>').appendTo("#videos_wrapper");

						if (videos_number <= $("#videos_wrapper .w2dc-attached-item").length)
							$("#attach_videos_functions").hide();
					} else if (matches_vimeo && (matches_vimeo[3].length == 8 || matches_vimeo[3].length == 9)) {
						var video_id = matches_vimeo[3];
						var url = "//vimeo.com/api/v2/video/" + video_id + ".json?callback=showVimeoThumb";
					    var script = document.createElement('script');
					    script.src = url;
					    $("#attach_videos_functions").before(script);
					} else
						alert("<?php esc_attr_e('Wrong URL or this video is unavailable', 'W2DC'); ?>");
				}
				return false;
			};

			window.showVimeoThumb = function(data){
				var video_id = data[0].id;
			    var image_url = data[0].thumbnail_medium;
				$('<div class="w2dc-attached-item"><div class="w2dc-delete-attached-item delete_item" title="<?php esc_attr_e('remove video', 'W2DC'); ?>"></div><input type="hidden" name="attached_video_id[]" value="' + video_id + '" /><div class="w2dc-img-div-border" style="width: 120px; height: 90px"><span class="w2dc-img-div-helper"></span><img src="' + image_url + '" style="max-width: 120px; max-height: 90px" /></div></div>').appendTo("#videos_wrapper");

				if (videos_number <= $("#videos_wrapper .w2dc-attached-item").length)
					$("#attach_videos_functions").hide();
			};
		})(jQuery);
	</script>
	<div id="attach_videos_functions" <?php if (count($listing->videos) >= $listing->level->videos_number): ?>style="display: none;"<?php endif; ?>>
		<div class="w2dc-upload-option input-group">
			<input type="text" id="attach_video_input" placeholder="Вставьте ссылку на видео" class="form-control" />
            <span class="input-group-btn">
    			<button class="btn w2dc-btn" onclick="return attachVideo(); ">
                    <?php esc_attr_e('Добавить', 'W2DC'); ?>
                </button>
            </span>
		</div>
	</div>
</div>
<?php endif; ?>