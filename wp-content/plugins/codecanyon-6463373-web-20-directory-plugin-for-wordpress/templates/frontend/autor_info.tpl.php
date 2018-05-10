<div class="autor_dateil">
<div class="row">
  <div class="col-xs-4">
    <?php 
      $user_info = get_userdata($autor_id); 
      var_dump($user_info);
    ?>
    <span><?=_e("Customer", 'W2DC'); ?>:</span> <span><?= $user_info->data->display_name;?></span>
  </div>
  <div class="col-xs-8"></div>
</div>
<?= get_avatar($autor_id, 96, '', false); ?>
</div>