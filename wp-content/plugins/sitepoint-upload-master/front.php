<style>
	.progress #progressbar{
		display: none;
	}
</style>
<div class="w2dc-upload-option form-group flex">
    <div class="input-group">
        <input type="text" class="form-control upload-video" placeholder="Загрузить видео с компьютера..." value="" readonly />
        <span class="input-group-btn">
                <button class="btn w2dc-btn upload-video">
                    <i class="fa fa-folder-open"></i>&nbsp;
	                <?php esc_attr_e('Выбрать', 'W2DC'); ?>
                </button>
            </span>
    </div>
    <input class="unstyleable" type="file" id="youfile" />
    <button id="you_btn" class="btn w2dc-btn"><?php echo _PLG_YOUTUBE_UPLOAD?></button>
</div>
<div class="form-group">
	<div class="progress">
		<div id="progressbar"></div>
		<!--<div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>-->
	</div>
</div>
<div class="msg"></div>



