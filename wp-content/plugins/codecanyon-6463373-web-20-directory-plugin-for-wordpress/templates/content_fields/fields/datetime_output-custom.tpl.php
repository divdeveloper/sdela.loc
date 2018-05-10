<?php if ($start_date && $end_date): 
	$formatted_start_date = mysql2date(get_option('date_format'), date('Y-m-d', $start_date->value['date']));	
	$formatted_start_time = mysql2date(get_option('time_format'), date('H:i:s', $start_date->value['date']));	
	
	$formatted_end_date = mysql2date(get_option('date_format'), date('Y-m-d', $end_date->value['date']));	
	$formatted_end_time = mysql2date(get_option('time_format'), date('H:i:s', $end_date->value['date']));	
?>
<div class="row w2dc-content-field w2dc-field-datetime">
	<div class="field-title"><?= _e('Время', 'W2DC') ?>:</div>
	<div class="field-value">
		<span class="datetime">
			c <?= $formatted_start_date; ?> по <?= $formatted_end_date; ?>
		</span>&nbsp;&nbsp;
			c <?= $formatted_start_time; ?> до <?= $formatted_end_time; ?>
			&nbsp;&nbsp;<img src="<?= W2DC_RESOURCES_URL; ?>images/icons/clock.png">
	</div>
</div>
<?php endif; ?>