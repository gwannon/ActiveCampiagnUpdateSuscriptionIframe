<?php

/**
 * Plugin Name: ActiveCampaignIframe
 * Plugin URI:  https://www.enutt.net/
 * Description: Shortcode para generar un iframe con el que meter páginas de Active Campaign
 * Version:     1.0
 * Author:      Enutt S.L.
 * Author URI:  https://www.enutt.net/
 * License:     GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ac-iframe
 *
 * PHP 7.3
 * WordPress 5.5.3
 */

//ini_set("display_errors", 1);

//Variables globales
define('AC_MAIN_URL', (get_option("ac_main_url") != '' ? get_option("ac_main_url") : "spri.activehosted.com")); 
define('AC_MIN_HEIGHT', (get_option("ac_min_height") > 0 ? get_option("ac_min_height")."px" : "800px")); 
define('AC_MIN_HEIGHT_2', (get_option("ac_min_height_2") > 0 ? get_option("ac_min_height_2")."px" : "800px")); 

//Cargamos las funciones que crean las páginas en el WP-ADMIN
require_once(dirname(__FILE__)."/admin.php");

//Shortcode ------------------
function activeCampignShortcode($params = array(), $content = null) {
  global $post;
  ob_start(); ?>
  <?php if(isset($_GET['ac-iframe']) && $_GET['ac-iframe'] != '' && strpos($_GET['ac-iframe'], 'https://'.AC_MAIN_URL) === 0) { ?>
    <iframe id='ac-iframe-step-2' src='<?php echo filter_input(INPUT_GET, 'ac-iframe', FILTER_SANITIZE_STRING ); ?>'></iframe>
  <?php } else { ?>
    <iframe id='ac-iframe-step-1' src='https://<?php echo AC_MAIN_URL; ?>/update_request/<?php echo $params['list_id']; ?>' style="display: none;"></iframe>
  <?php } ?>
  <style>
    #ac-iframe-step-1,
    #ac-iframe-step-2 {
      width: 100%;
      overflow: hidden;
      min-height: <?php echo ((isset($params['min_height_step_1']) && $params['min_height_step_1'] != '') ? $params['min_height_step_1']."px" : AC_MIN_HEIGHT); ?>;
      border: none;
    }
    #ac-iframe-step-2 {
      min-height: <?php echo ((isset($params['min_height_step_2']) && $params['min_height_step_2'] != '') ? $params['min_height_step_2']."px" : AC_MIN_HEIGHT_2); ?>;
    }
  </style>
  <script>
    if(window.location.hash && window.location.hash.includes('<?php echo AC_MAIN_URL; ?>')) {
      window.location.href = "<?php echo get_the_permalink(); ?>?ac-iframe="+encodeURIComponent(window.location.hash.replace("#", ""));
    } else {
      jQuery("#ac-iframe-step-1").css("display", "block");
    }
  </script>
  <?php $html = ob_get_clean(); 
  return $html;
}
add_shortcode('ac-iframe', 'activeCampignShortcode');
