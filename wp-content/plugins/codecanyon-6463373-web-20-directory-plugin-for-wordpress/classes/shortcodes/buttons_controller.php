<?php 

class w2dc_buttons_controller extends w2dc_frontend_controller {

	public function init($args = array()) {
		parent::init($args);
		
		global $w2dc_instance;

		$shortcode_atts = array_merge(array(
				'directory' => $w2dc_instance->current_directory->id,
		), $args);

		$this->args = $shortcode_atts;

		apply_filters('w2dc_buttons_controller_construct', $this);
	}

	public function display() {
		$output =  w2dc_renderTemplate('frontend/frontpanel_buttons.tpl.php', array('frontend_controller' => $this), true);
		wp_reset_postdata();

		return $output;
	}
}

?>