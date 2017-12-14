<?php
/**
 * @wordpress-plugin
 * Plugin Name:       MAXX Languege Constants Loader
 * Version:           1.0
 * Author:            A.Bodnarashek
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
add_action('init', 'loadlang');

function loadlang(){
	$lang = get_locale();
	if (is_file(__DIR__.'/lang/'.$lang.'.php')){
		require_once(__DIR__.'/lang/'.$lang.'.php');
	} else {
		require_once(__DIR__.'/lang/ru_RU.php');
	} 	
}