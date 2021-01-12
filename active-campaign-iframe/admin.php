<?php

//ADMIN -----------------------------------------
add_action( 'admin_menu', 'ac_plugin_menu' );
function ac_plugin_menu() {
	add_options_page( __('Administración ActiveCampaign', 'ac-iframe'), __('Administración  AC', 'ac-iframe'), 'manage_options', 'ac-iframe', 'ac_page_settings');
}

function ac_page_settings() { 
	//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
	if(isset($_REQUEST['send']) && $_REQUEST['send'] != '') { 
		update_option('ac_main_url', $_POST['ac_main_url']);
		update_option('ac_min_height', $_POST['ac_min_height']);
		update_option('ac_min_height_2', $_POST['ac_min_height_2']);
		?><p style="border: 1px solid green; color: green; text-align: center;"><?php _e("Datos guardados correctamente.", 'ac-iframe'); ?></p><?php
	} ?>
	<form method="post">
		<h2><?php _e("Dominio principal de ActiveCampaign", 'ac-iframe'); ?>:</h2>
		<input type="text" name="ac_main_url" value="<?php echo get_option("ac_main_url"); ?>" /><br/><br/>
		<h2><?php _e("Altura mínima del iframe del primer paso en px (800px por defecto)", 'ac-iframe'); ?>:</h2>
		<input type="number" name="ac_min_height" value="<?php echo get_option("ac_min_height"); ?>" /><br/><br/>
		<h2><?php _e("Altura mínima del iframe del segundo paso en px (800px por defecto)", 'ac-iframe'); ?>:</h2>
		<input type="number" name="ac_min_height_2" value="<?php echo get_option("ac_min_height_2"); ?>" /><br/><br/>
		<input type="submit" name="send" class="button button-primary" value="<?php _e("Guardar"); ?>" />
	</form>
	<?php
}
