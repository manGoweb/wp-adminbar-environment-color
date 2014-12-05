<?php
/**
 * Plugin Name: Adminbar environment color
 * Plugin URI: https://github.com/mangoweb/wp-adminbar-environment-color
 * Description: Plugin detects environment via Tracy\Debugger and changes background color of adminbar
 * Version: 1.1.0
 * Author: manGoweb
 * Author URI: http://mangoweb.cz/
 * License: MIT License
 */

function hook_development_wpadminbar_color() {
	$production = TRUE;

	if(class_exists('Tracy\Debugger')) {
		$production = Tracy\Debugger::$productionMode;
	} else {
		$developmentWhitelist = [];
		if (!isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$developmentWhitelist[] = '127.0.0.1';
			$developmentWhitelist[] = '::1';
		}
		$production = !in_array(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : php_uname('n'), $developmentWhitelist, TRUE);
	}

	$color = $production ? '#A22' : '#234';

?>
<style>
#wpadminbar {
	background-color: <?php echo $color ?> !important;
	opacity: .95 !important;
}
#wpadminbar *, #wpadminbar *:before {
	color: #FFF !important;
}
#wpadminbar #adminbarsearch *, #wpadminbar #adminbarsearch:before {
	color: #111 !important;
}
</style>
<?php
}

add_action('wp_head', 'hook_development_wpadminbar_color');
add_action('admin_head', 'hook_development_wpadminbar_color');
