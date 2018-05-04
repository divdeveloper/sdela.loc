<?php 
  if ($listing->level->videos_number && $listing->videos): 
    $count = count($listing->videos) > 1  ? 2 : 1;
    $i = 1;
?>
  <div class="row">
    <?php foreach ($listing->videos AS $video): ?>
      <?php 
      if ($i <= 6):
        if (strlen($video['id']) >= 11): 
          $gallery[] = "http://www.youtube.com/watch?v=" . $video['id'];
        ?>
          <div class="col-xs-<?= $grid[$count]['xs']?> col-sm-<?= $grid[$count]['sm']?> col-md-<?= $grid[$count]['md']?> media-col">											
            <a href="http://www.youtube.com/watch?v=<?= $video['id']; ?>" class="fresco" data-fresco-group="videos">
              <img src="<?= w2dc_getVideoThumbUrl('<iframe src="//www.youtube.com/embed/' . $video['id'] . '" frameborder="0"></iframe>'); ?>" border="0" />
            </a>
          </div>
        <?php elseif (strlen($video['id']) >= 8):
          $gallery[] = "http://vimeo.com/" . $video['id'];
        ?>
          <div class="col-xs-<?= $grid[$count]['xs']?> col-sm-<?= $grid[$count]['sm']?> col-md-<?= $grid[$count]['md']?> media-col">
            <a href="http://vimeo.com/<?= $video['id']; ?>" class="fresco" data-fresco-group="videos">
              <img src="<?= w2dc_getVideoThumbUrl ('<iframe src="https://player.vimeo.com/video/' . $video['id']. '?color=d1d1d1&title=0&byline=0&portrait=0"></iframe>'); ?>" border="0" />
            </a>
          </div>
        <?php 
        endif; 
      else:
        if (strlen($video['id']) >= 11):
          $gallery[] = "http://www.youtube.com/watch?v=" . $video['id'];
        ?>
        <a href="http://www.youtube.com/watch?v=<?= $video['id']; ?>" class="fresco hidden" data-fresco-group="videos"></a>
        <?php 
        endif;

        if (strlen($video['id']) >= 8):
          $gallery[] = "http://vimeo.com/" . $video['id']; 
        ?>
          <a href="http://vimeo.com/<?= $video['id']; ?>" class="fresco hidden" data-fresco-group="videos"></a>
        <?php
        endif;
        ?>
        <?php 
      endif;
      $i++;
    endforeach; ?>
    <div class="col-xs-12">
      <a onclick='showFrescoImages(<?= json_encode($gallery);?>)'><?= count($listing->videos); ?> <?= _e("Videos", 'W2DC'); ?></a>
    </div>
  </div>
<?php else: ?>
  <div class="row">
    <div class="col-xs-12">
      <?= _e("Video not found!", 'W2DC'); ?>
    </div>
  </div>
<?php endif;?>
<script>
  function showFrescoImages(json) {
    Fresco.show(json);
  }
</script>