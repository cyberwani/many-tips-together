<?php
/**
 * @package Many Tips Together
 * @author Rodolfo Buaiz
 */
 
/*
Plugin Name: Many Tips Together
Plugin URI: http://wordpress.org/extend/plugins/many-tips-together
Text Domain: many-tips-together
Domain Path: /languages
Description: This plugin compiles many administrative customization tips in one simple interface.
Author: Rodolfo Buaiz
Author URI: http://rodbuaiz.com/
Version: 0.9.4
Stable Tag: 0.9.4
License: GPL
*/

define('MTT_LOGO_HEIGHT', 300);
define('MTT_LOGIN_BACKGROUND', 'repeat');
define('MTT_VERSION', '0.9.4');

if (!class_exists("ManyTips")) {
	class ManyTips {
		// REFERENCE VALUE TO DATABASE
		var $adminOptionsName = "ManyTipsTogether";
		
		function ManyTips() { 
			//constructor
			/* Set constant path to the members plugin directory. */
			define( 'MTT_DIR', plugin_dir_path( __FILE__ ) );

			/* Set constant path to the members plugin directory. */
			define( 'MTT_URL', plugin_dir_url( __FILE__ ) );
			
			$this->logo = MTT_URL."images/mtt-logo.png";
			load_plugin_textdomain( 'mtt', null, 'many-tips-together/languages');
		}
		
		// ACTIVATION OF PLUGIN
		function init() { 
			$this->getAdminOptions();			
		}
		
		function printAdminPage() { 
			require_once ('mtt-admin-page.php');
		}
		
		function validateUrl($url) {
			if ($url=="") return true;
			// SCHEME
			$urlregex = "^(https?|ftp)\:\/\/";

			// USER AND PASS (optional)
			$urlregex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";

			// HOSTNAME OR IP
			$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*"; // http://x = allowed (ex. http://localhost, http://routerlogin)
			//$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)+"; // http://x.x = minimum
			//$urlregex .= "([a-z0-9+\$_-]+\.)*[a-z0-9+\$_-]{2,3}"; // http://x.xx(x) = minimum
			//use only one of the above

			// PORT (optional)
			$urlregex .= "(\:[0-9]{2,5})?";
			// PATH (optional)
			$urlregex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
			// GET Query (optional)
			//$urlregex .= "(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?";
			// ANCHOR (optional)
			//$urlregex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

			// check
			if (eregi($urlregex, $url)) {return true;} else {return false;}
			
		}
		
		function getAdminOptions() {
			
			$mttAdminOptions = array(
				'maintenance_mode' => 0,
				'maintenance_mode_title' => '',
				'maintenance_mode_line1' => '',
				'maintenance_mode_line2' => '',
				'maintenance_mode_level' => 'a',
				'update_wp' => 0,
				'update_plg' => 0,
				'post_revision' => '',
				'post_autosave' => '',
				'admin_bar' => 0,
				'contato_social' => 0,
				'contato_none' => 0,
				'contato_slim' => 0,
				'contato_hidden' => 0,
				'contato_bio' => 0,
				'logout' => 0,
				'logout_url' => '',
				'loginpage_tooltip' => '',
				'loginpage' => 0,
				'loginpage_body' => '',
				'loginpage_color' => '',
				'loginpage_logo' => '',
				'loginpage_logo_url' => '',
				'loginpage_height' => '',
				'loginpage_backsite' => 0, 
				'loginpage_errors' => 0,
				'loginpage_error_msg' => '',
				'disable_smartquotes' => 0,
				'disable_capitalp' => 0,
				'disable_autop' => 0,
				'disable_selfping' => 0,
				'disable_version_full' => 0,
				'disable_version_number' => 0,
				'disable_nourl' => 0,
				'remove_dashboard_quick_press' => 0,
				'remove_dashboard_incoming_links' => 0,
				'remove_dashboard_right_now' => 0,
				'remove_dashboard_plugins' => 0,
				'remove_dashboard_recent_drafts' => 0,
				'remove_dashboard_recent_comments' => 0,
				'remove_dashboard_primary' => 0, // other news
				'remove_dashboard_secondary' => 0, // official blog
				'enable_dashboard1_mtt' => 0,
				'enable_dashboard1_mtt_title' => '',
				'enable_dashboard1_mtt_content' => '',
				'enable_dashboard2_mtt' => 0,
				'enable_dashboard2_mtt_title' => '',
				'enable_dashboard2_mtt_content' => '',
				'enable_dashboard3_mtt' => 0,
				'enable_dashboard3_mtt_title' => '',
				'enable_dashboard3_mtt_content' => '',
				'small_plugin' => 0,
				'verbose_plugin' => 0
				);
			$devOptions = get_option($this->adminOptionsName);
			
			// If options have been previously stored, it overwrites the default values
			if (!empty($devOptions)) {
				foreach ($devOptions as $key => $option) {
					$mttAdminOptions[$key] = $option;
				}
			 }      
			// The options are stored in the WordPress database
			update_option($this->adminOptionsName, $mttAdminOptions);
			
			// options are returned for your use
			return $mttAdminOptions;
		 }
		
		function resetAdminOptions() {
			delete_option($this->adminOptionsName);
		}
			
		
		// OPTIMIZE DATABASE CRON JOB, ONLY USED IF MANUALLY ACTIVATED AT THE END OF THIS FILE
		function optimize_database(){  
		    global $wpdb;  
		    $all_tables = $wpdb->get_results('SHOW TABLES',ARRAY_A);  
		    foreach ($all_tables as $tables){  
		        $table = array_values($tables);  
		        $wpdb->query("OPTIMIZE TABLE ".$table[0]);  
		    }  
		}
		function simple_optimization_cron_on(){  // add it to the cron jobs
		    wp_schedule_event(time(), 'weekly', $this->optimize_database);  
		}
		function simple_optimization_cron_off(){  // remove from the cron
		    wp_clear_scheduled_hook($this->optimize_database);  
		}  
		
		
		/*
		 * ADD JS and CSS into PLUGIN ADMIN AREA
		 */
		function admin_register_head() {
			echo '<link type="text/css" rel="stylesheet" href="' . MTT_URL.'mtt.css" />' . "\n";		
			echo '<script src="' . MTT_URL.'mtt.js"></script>';
			//wp_enqueue_script('farbtastic');
			//wp_enqueue_style('farbtastic');
			
		}
			
		function mtt_farbtastic_script() {
			wp_enqueue_script('farbtastic');
			return;
		}
		function mtt_farbtastic_style() {
			wp_enqueue_style('farbtastic');
			return;
		}


		/*
		 * ADD JS into ALL AREAS
		 */
		function global_register_head() {
			$devOptions = $this->getAdminOptions();
			if($devOptions['admin_bar']) { // print only if option set
				echo <<<JS
<script type="text/javascript">
  jQuery(document).ready(function(){
 	jQuery("#your-profile .show-admin-bar").remove();
  });
</script>\r\n
JS;
			}
		}


		/*
		 * ADD link to settings in Plugins list page
		 */
		function mtt_plugin_action_links( $links, $file ) {
			if ( $file == plugin_basename( dirname(__FILE__).'/many-tips-together.php' ) ) {
				$links[] = '<a href="options-general.php?page=many-tips-together">'.__('Settings').'</a>';
			}
			return $links;
		}
	
		
		/* MAINTENANCE MODE */
		function maintenance_mode() {
			$devOptions = $this->getAdminOptions();
			$level = 'delete_plugins';
			if($devOptions['maintenance_mode_level']=='e') $level = 'delete_pages';
			elseif($devOptions['maintenance_mode_level']=='t') $level = 'publish_posts';
			elseif($devOptions['maintenance_mode_level']=='c') $level = 'delete_posts';
			elseif($devOptions['maintenance_mode_level']=='s') $level = 'read';
		    if ( !current_user_can( $level ) ){ 
				$title = ($devOptions['maintenance_mode_title']!='') ? $devOptions['maintenance_mode_title'] : get_bloginfo('name').__(' | Maintenance Mode', 'mtt');
				if(!defined('MTT_CUSTOM_MAINTENANCE')) $message = file_get_contents( MTT_URL . "maintenance/index.php");
				else $message = file_get_contents( content_url() . "/maintenance/index.php");
				
				wp_die( $message, $title, array('response' => 503));
		    }
		}
		

		/* WORDPRESS BEHAVIOR */
		function hide_update_notice() {
			remove_action( 'admin_notices', 'update_nag', 3 );
			remove_filter( 'update_footer', 'core_update_footer' );
		}
		
		function disable_remove_url($default) {
	  		global $wp_version;
	  		return 'WordPress/'.$wp_version;
		}
		
		function no_self_ping( &$links ) {
			$home = home_url();
			foreach ( $links as $l => $link )
				if ( 0 === strpos( $link, $home ) )
	               unset($links[$l]);
		}

		function remove_version() {
			$devOptions = $this->getAdminOptions();
			if($devOptions['disable_version_full']) return '';
			elseif($devOptions['disable_version_number']) return '<meta name="generator" content="WordPress" />';
			else return '';
		}


		/* REMOVE FROM DASHBOARD */
		function remove_dashboard_widgets() {
			$devOptions = $this->getAdminOptions();
			
			if($devOptions['remove_dashboard_quick_press'])
				remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
			
			if($devOptions['remove_dashboard_incoming_links'])
				remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
			
			if($devOptions['remove_dashboard_right_now'])
				remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
			
			if($devOptions['remove_dashboard_plugins'])
				remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
			
			if($devOptions['remove_dashboard_recent_drafts'])
				remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
			
			if($devOptions['remove_dashboard_recent_comments'])
				remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
			
			if($devOptions['remove_dashboard_primary'])
				remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // other news
			
			if($devOptions['remove_dashboard_secondary'])
				remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' ); // official blog
			
		}


		/* ADD DASHBOARDS */
		function add_dashboard() {
			function add_dashboard_content1() {
				global $devOptions;
				echo stripslashes($devOptions['enable_dashboard1_mtt_content']);
			} 
			function add_dashboard_content2() {
				global $devOptions;
				echo stripslashes($devOptions['enable_dashboard2_mtt_content']);
			} 
			function add_dashboard_content3() {
				global $devOptions;
				echo stripslashes($devOptions['enable_dashboard3_mtt_content']);
			} 
			$devOptions = $this->getAdminOptions();
			if($devOptions['enable_dashboard1_mtt']) {
				$title = ($devOptions['enable_dashboard1_mtt_title']=='') ? '&nbsp;&nbsp;' : stripslashes($devOptions['enable_dashboard1_mtt_title']);
				wp_add_dashboard_widget('dashboard1_mtt_title', $title, 'add_dashboard_content1');	
				
			}
			if($devOptions['enable_dashboard2_mtt']) {
				$title = ($devOptions['enable_dashboard2_mtt_title']=='') ? '&nbsp;&nbsp;' : $devOptions['enable_dashboard2_mtt_title'];
				wp_add_dashboard_widget('dashboard2_mtt_title', $title, 'add_dashboard_content2');	
				
			}
			if($devOptions['enable_dashboard3_mtt']) {
				$title = ($devOptions['enable_dashboard3_mtt_title']=='') ? '&nbsp;&nbsp;' : $devOptions['enable_dashboard3_mtt_title'];
				wp_add_dashboard_widget('dashboard3_mtt_title', $title, 'add_dashboard_content3');	
				
			}
		} 
		

		/* REVISIONS AND AUTOSAVE */


		/* LOG IN */
		function loginpage_custom_link() { 
			$devOptions = $this->getAdminOptions();
			return $devOptions['loginpage_logo_url']; 
		} 
		
		function my_custom_login() {
			$devOptions = $this->getAdminOptions();
			
			$loginpage_body = ($devOptions['loginpage_body'] != '') ? "background:url(".$devOptions['loginpage_body'].") ".MTT_LOGIN_BACKGROUND.";" : "";
			
			$loginpage_height = ($devOptions['loginpage_height'] != '') ? " height:".$devOptions['loginpage_height']."px;" : "";
			
			$loginpage_logo = ($devOptions['loginpage_logo'] != '') ? "background-image:url(".$devOptions['loginpage_logo'].") !important;" : "";
			
			$loginpage_backsite = ($devOptions['loginpage_backsite'] != '') ? "p#backtoblog {display:none;}" : "";
			
			$loginpage_color = ($devOptions['loginpage_color'] != '') ? "background:#".$devOptions['loginpage_color']." !important;" : "";
			$loginpage_text_shadow = ($devOptions['loginpage_color'] != '') ? "#nav, #backtoblog { text-shadow: none; }" : "";
			
		   echo '
		      <style type="text/css">
				body {'.$loginpage_body.'height:100%}
				html {height:100%;overflow:hidden;'.$loginpage_color.'}
		         #login h1 a { margin:0px;'.$loginpage_height.$loginpage_logo.'}
				 '.$loginpage_backsite.'
				 '.$loginpage_text_shadow.'
				
		      </style>
		   ';
		}
		
		function change_title_on_logo() { 
			$devOptions = $this->getAdminOptions();
			return $devOptions['loginpage_tooltip']; 
		} 


		/* LOG OUT */
		function redirect_logout_front_page() {
			$devOptions = $this->getAdminOptions();
			wp_redirect($devOptions['logout_url']);
			die();
		}
		

		/* USER PROFILE */
		function extra_contact_info($contactmethods) {
		    unset($contactmethods['aim']);
		    unset($contactmethods['yim']);
		    unset($contactmethods['jabber']);
		    $contactmethods['facebook'] = 'Facebook';
		    $contactmethods['twitter'] = 'Twitter';
		    $contactmethods['linkedin'] = 'LinkedIn';
		    return $contactmethods;
		}
		
		function no_contact_info($contactmethods) {
		    unset($contactmethods['aim']);
		    unset($contactmethods['yim']);
		    unset($contactmethods['jabber']);
		    return $contactmethods;
		}
		
		function mtt_personal_options() {
			$devOptions = $this->getAdminOptions();
		?>
<script type="text/javascript">
  jQuery(document).ready(function(){ <?php
	if($devOptions['contato_bio']) { ?>
	jQuery("#your-profile .form-table:eq(3) tr:eq(0), #your-profile h3:eq(3)").remove(); <?php
	} 
	if($devOptions['contato_slim']) { ?>
    jQuery("#your-profile .form-table:first tr:lt(2)").remove(); <?php
	} elseif($devOptions['contato_hidden']) { ?>
	jQuery("#your-profile h3:first").remove();
    jQuery("#your-profile .form-table:first").remove(); <?php
	} ?>
  });
</script>
		<?php
		}
		
		function mtt_remove_adminbar() {
			return false;
		}

		
	}
} //End Class ManyTips

/*
checks for is if the class ManyTips has been created. 
If it has, a variable called $dl_pluginSeries is created with an instance of the 
ManyTips class.
*/
if (class_exists("ManyTips")) {
	$dl_pluginSeries = new ManyTips();
}


//Initialize the admin panel
if (!function_exists("ManyTips_ap")) { 
	function ManyTips_ap() {
		global $dl_pluginSeries; 
		if (!isset($dl_pluginSeries)) {
			return;
		}
		if (function_exists('add_options_page')) { 
			add_options_page('Many Tips Together', 'Many Tips Together', 9,
basename(__FILE__), array(&$dl_pluginSeries, 'printAdminPage')); 
			
		}
	}
}


//Actions and Filters
if (isset($dl_pluginSeries)) {	
	
	$devOptions = $dl_pluginSeries->getAdminOptions();
	//wp_enqueue_script('jquery');
	
	/* PLUGIN CONFIGURATION */
	add_action('activate_many-tips-together/many-tips-together.php', array(&$dl_pluginSeries, 'init'));
	add_action('admin_menu', 'ManyTips_ap');
	add_filter( 'plugin_action_links', array(&$dl_pluginSeries, 'mtt_plugin_action_links'), 10, 2 );
	
	add_action('admin_head', array(&$dl_pluginSeries, 'global_register_head'));
	add_action("admin_head-settings_page_many-tips-together", array(&$dl_pluginSeries, 'admin_register_head'));
	
	// Farbtastic
	add_action("admin_print_scripts-settings_page_many-tips-together",  array(&$dl_pluginSeries,'mtt_farbtastic_script'));
	add_action("admin_print_styles-settings_page_many-tips-together",  array(&$dl_pluginSeries,'mtt_farbtastic_style'));




	/* MAINTENANCE MODE */
	if ($devOptions['maintenance_mode']) 
		add_action('get_header', array(&$dl_pluginSeries, 'maintenance_mode'), 1 );


	/* WORDPRESS BEHAVIOR */
	if ($devOptions['update_wp']) 
		add_action( 'admin_notices', array(&$dl_pluginSeries, 'hide_update_notice'), 1 );
		
	if($devOptions['update_plg'])
		add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

	// Remove WordPress version from header 
	if($devOptions['disable_version_full'])
		remove_action('wp_head', 'wp_generator');
	// Hide blog URL from WordPress 'phone home' 
	if($devOptions['disable_nourl'])
		add_filter('http_headers_useragent', array(&$dl_pluginSeries, 'disable_remove_url'));
			
	if($devOptions['disable_smartquotes']) {
		remove_filter('comment_text', 'wptexturize');
		remove_filter('the_content', 'wptexturize');
		remove_filter('the_excerpt', 'wptexturize');
		remove_filter('the_title', 'wptexturize');
		remove_filter('the_content_feed', 'wptexturize');
	}
	
	if($devOptions['disable_capitalp']) {
		remove_filter('the_content','capital_P_dangit');
		remove_filter('the_title','capital_P_dangit');
		remove_filter('comment_text','capital_P_dangit');
	}
	
	if($devOptions['disable_autop'])
		remove_filter('the_content', 'wpautop');
		
	if($devOptions['disable_selfping']) 
		add_action( 'pre_ping', 'no_self_ping' );

	if($devOptions['disable_version_full'] || $devOptions['disable_version_number']) 
		add_filter('the_generator', array(&$dl_pluginSeries, 'remove_version'));
		

	/* REMOVE FROM DASHBOARD */
	add_action('wp_dashboard_setup', array(&$dl_pluginSeries,'remove_dashboard_widgets') );
	

	/* ADD DASHBOARDS */
	if ( $devOptions['enable_dashboard1_mtt'] || $devOptions['enable_dashboard2_mtt'] || $devOptions['enable_dashboard3_mtt'] ) 
		add_action('wp_dashboard_setup', array(&$dl_pluginSeries,'add_dashboard') );


	/* REVISIONS AND AUTOSAVE */
	$post_revision = ($devOptions['post_revision'] != "-1" && $devOptions['post_revision'] != "") ? true : false; 
	if($post_revision)
		define('WP_POST_REVISIONS', (int)$devOptions['post_revision']);

	$post_autosave = ($devOptions['post_autosave'] != "1" && $devOptions['post_autosave'] != "") ? true : false; 	
	if($post_autosave)
		define('AUTOSAVE_INTERVAL', 60*(int)$devOptions['post_autosave']);


	/* LOG IN */
	$loginpage_tooltip = ( $devOptions['loginpage_tooltip'] != "") ? true : false; 
	if($loginpage_tooltip)
		add_filter('login_headertitle', array(&$dl_pluginSeries, 'change_title_on_logo'));
	
	// Login Screen
	$loginpage = ($devOptions['loginpage_body'] != "" || $devOptions['loginpage_logo'] != "" || $devOptions['loginpage_height'] != "" || $devOptions['loginpage_backsite'] || $devOptions['loginpage_color']) ? true : false; 	
	if($loginpage)
		add_action('login_head', array(&$dl_pluginSeries, 'my_custom_login'));
		
	// Custom message for login errors
	if ($devOptions['loginpage_errors']) {
		$errorMsg = "return '".esc_html(stripslashes($devOptions['loginpage_error_msg']))."';";
		add_filter('login_errors',create_function('$a', $errorMsg));
	}
	// Custom URL for Logo in login page
	if ($devOptions['loginpage_logo_url']) 
		add_filter('login_headerurl',array(&$dl_pluginSeries,'loginpage_custom_link'));


	/* LOG OUT */
	$logout = ($devOptions['logout'] != "0" && $devOptions['logout'] != "") ? true : false; 
	if($logout)
		add_action('wp_logout', array(&$dl_pluginSeries, 'redirect_logout_front_page'));


	/* USER PROFILE */
	if($devOptions['contato_social'])
		add_filter('user_contactmethods', array(&$dl_pluginSeries, 'extra_contact_info'));
		
	if($devOptions['contato_none'])
		add_filter('user_contactmethods', array(&$dl_pluginSeries, 'no_contact_info'));
		
	if($devOptions['contato_slim'] || $devOptions['contato_hidden'] || $devOptions['contato_bio']) 
		add_action( 'personal_options', array(&$dl_pluginSeries, 'mtt_personal_options'));
	
	if($devOptions['contato_slim'])
		remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");

	if($devOptions['admin_bar']) {
		add_filter( 'show_admin_bar' , array(&$dl_pluginSeries, 'mtt_remove_adminbar'));
	}

	

	// ************************************************************************
	// 
	// ************************************************************************


	// ************************************************************************
	// DATABASE OPTIMIZATION, MANUAL ACTIVATION
	// ************************************************************************
	
	/* 
	   Activated only once. 
	   Uncomment the "register_activation_hook" line
	   and the "register_deactivation_hook" bellow, 
	   and finally disable/enable the plugin 
	*/
	
	// register_activation_hook(__FILE__, array(&$dl_pluginSeries, 'simple_optimization_cron_on')); 
	
	/* 
	   Deactivate on plugin-off. 
	   If you actived the optimization above, 
	   uncomment the next line too 
	*/ 
	
	// register_deactivation_hook(__FILE__, array(&$dl_pluginSeries, 'simple_optimization_cron_off')); 
	

}
?>