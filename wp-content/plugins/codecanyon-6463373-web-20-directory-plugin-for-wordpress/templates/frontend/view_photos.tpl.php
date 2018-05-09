<?php
  if ($listing->level->images_number && $listing->images):
    $count = count($listing->images)  > 1 ? 2 : 1;
    $i = 1;
?>
  <div class="row">
    <?php if ($listing->images && get_option('w2dc_enable_fresco_gallery')): ?>
      <?php foreach ($listing->images as $attachment_id=>$image): 
        $image_src = wp_get_attachment_image_src($attachment_id, 'full')[0];
        $gallery[] = $image_src;
        $image_thumbnail = wp_get_attachment_image_src($attachment_id, 'large')[0];
        if ($i <= 6) { ?>
          <div class="col-xs-<?= $grid[$count]['xs']?> col-sm-<?= $grid[$count]['sm']?> col-md-<?= $grid[$count]['md']?> media-col">
            <a href="<?= $image_src; ?>" class="fresco" data-fresco-group="images">
              <img src="<?= $image_thumbnail; ?>" alt="image <?= $attachment_id; ?>">
            </a>
          </div>
        <?php }else{ ?>
        <a href="<?= $image_src; ?>" class="fresco hidden" data-fresco-group="images"></a>
        <?php } 
        $i ++;
      endforeach; ?>
    <?php endif; ?>
    <div class="col-xs-12 more-media">
      <a onclick='showFrescoImages(<?= json_encode($gallery);?>)'><?= count($listing->images); ?> <?= _e("фото", 'W2DC'); ?></a>
    </div>
  </div>
<? endif; ?>
<script>
  function showFrescoImages(json) {
    Fresco.show(json);
  }
</script>