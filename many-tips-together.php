<?php
/**
 * @package Many Tips Together
 * @author  Rodolfo Buaiz
 */

/*
Plugin Name: Many Tips Together
Plugin URI: http://wordpress.org/extend/plugins/many-tips-together
Text Domain: many-tips-together
Domain Path: /languages
Description: This plugin compiles many administrative customization tips in one simple interface.
Author: Rodolfo Buaiz
Author URI: http://rodbuaiz.com/
Version: 1.0
Stable Tag: 1.0
License: GPL
*/

add_action('init', 'github_plugin_updater_test_init');
function github_plugin_updater_test_init() {

	include_once('updater.php');

	define('WP_GITHUB_FORCE_UPDATE', true);

	if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin

		$config = array(
			'slug' => plugin_basename(__FILE__),
			'proper_folder_name' => 'many-tips-together',
			'api_url' => 'https://api.github.com/repos/brasofilo/many-tips-together',
			'raw_url' => 'https://raw.github.com/brasofilo/master/many-tips-together',
			'github_url' => 'https://github.com/brasofilo/many-tips-together',
			'zip_url' => 'https://github.com/brasofilo/many-tips-together/zipball/master',
			'sslverify' => true,
			'requires' => '3.0',
			'tested' => '3.3',
		);

		new WPGitHubUpdater($config);

	}

}

/* CLASS FOR SORTING PAGES BY TEMPLATE */
include_once('inc/columns.php');

/* START MTT */
if (!class_exists("ManyTips")) {
    class ManyTips
    {
        // REFERENCE VALUE TO DATABASE
        var $adminOptionsName = "ManyTipsTogether";

        function ManyTips() {
            //constructor
            /* Set constant path to the members plugin directory. */
            define('MTT_DIR', plugin_dir_path(__FILE__));

            /* Set constant path to the members plugin directory. */
            define('MTT_URL', plugin_dir_url(__FILE__));

	        $this->version      = '1.0';
            $this->logo         = MTT_URL . "images/mtt-logo.png";
            $this->mtt_tb_title = ' ' . $this->version . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :o[)";
            load_plugin_textdomain('mtt', null, 'many-tips-together/languages');
        }

        // ACTIVATION OF PLUGIN
        function init() {
            $this->getAdminOptions();
        }

	    // UPDATING OLD VERSIONS
	    function iNeedUpdate() {
		    require_once ('inc/update.php');
	    }

        /***************************************************************************
         *
         * @Title      : ADMIN - set, get and print
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        var $mttBooleanOptions = array(
            'adminbar_custom_enable',
            'adminbar_disable',
            'adminbar_remove_comments',
            'adminbar_remove_my_account',
            'adminbar_remove_new_content',
            'adminbar_remove_site_name',
            'adminbar_remove_theme_options',
            'adminbar_remove_updates',
            'adminbar_remove_wp_logo',
	        'adminbar_remove_seo_by_yoast',
            'adminbar_sitename_enable',
            'admin_menus_remove_posts',
            'admin_menus_remove_media',
            'admin_menus_remove_links',
            'admin_menus_remove_pages',
            'admin_menus_remove_comments',
            'admin_menus_remove_appearence',
            'admin_menus_remove_plugins',
            'admin_menus_remove_users',
            'admin_menus_remove_tools',
            'admin_notice_footer_hide',
            'admin_notice_footer_message_enable',
            'admin_notice_header_allpages_enable',
            'admin_notice_header_settings_enable',
            'dashboard_add_cpt_enable',
            'dashboard_mtt1_enable',
            'dashboard_mtt2_enable',
            'dashboard_mtt3_enable',
            'dashboard_remove_incoming_links',
            'dashboard_remove_plugins',
            'dashboard_remove_primary',
            'dashboard_remove_quick_press',
            'dashboard_remove_recent_comments',
            'dashboard_remove_recent_drafts',
            'dashboard_remove_right_now',
            'dashboard_remove_secondary',
            'dashboard_remove_footer_rightnow',
            'email_notice_plain_html',
            'email_notice_author_comment_warn',
            'loginpage_backsite_hide',
            'loginpage_errors',
            'loginpage_form_noshadow',
            'loginpage_text_shadow',
            'logout_redirect_enable',
            'maintenance_mode_admin',
            'maintenance_mode_enable',
            'media_better_attachment',
	        'media_image_id_column_enable',
            'media_image_size_column_enable',
            'media_sanitize_filename',
            'media_jpg_sharpen',
            'media_adjust_youtube_oembed_enable',
            'mtt_small_plugin',
            'mtt_verbose_plugin',
	        'plugins_remove_plugin_notice',
	        'plugins_acf_hide_options',
            'postpageslist_enable_id_column',
            'postpageslist_template_filter_enable',
            'postpageslist_enable_thumb_column',
            'postpageslist_persistent_list_view',
	        'postpages_disable_mbox_attributes',
	        'postpages_disable_mbox_category',
	        'postpages_disable_mbox_excerpt',
	        'postpages_disable_mbox_tags',
	        'postpages_disable_mbox_trackbacks',
            'postpages_enable_page_excerpts',
            'postpages_move_author_metabox',
	        'postpages_move_comments_metabox',
            'posts_rename_enable',
            'profile_bio',
            'profile_descriptions',
            'profile_display_name',
            'profile_h3_titles',
            'profile_hidden',
            'profile_nickname',
            'profile_none',
            'profile_slim',
            'profile_social',
            'profile_website',
            'shortcodes_gdocs',
            'shortcodes_scloud',
            'shortcodes_tube',
            'widget_meta_enable',
            'widget_meta_link1',
            'widget_meta_link2',
	        'widget_remove_akismet',
            'widget_remove_archives',
            'widget_remove_calendar',
            'widget_remove_categories',
            'widget_remove_links',
            'widget_remove_meta',
            'widget_remove_nav_menu',
            'widget_remove_pages',
            'widget_remove_recent_comments',
            'widget_remove_recent_posts',
            'widget_remove_rss',
            'widget_remove_search',
            'widget_remove_tag_cloud',
            'widget_remove_text',
            'widget_text_enable_shortcodes',
            'wpblock_update_plugins',
            'wpblock_update_wp',
            'wpenable_custom_gravatars_enable',
            'wpdisable_autop',
            'wpdisable_capitalp',
            'wpdisable_nourl',
            'wpdisable_selfping',
            'wpdisable_smartquotes',
            'wpdisable_version_full',
            'wpdisable_version_number',
	        'wpdisable_help_texts_enable',
	        'wpdisable_howdy_enable',
            'wpenable_google_jquery',
            'wprss_delay_publish_enable'
        );

        var $mttStringOptions = array(
            'adminbar_custom_0_title',
            'adminbar_custom_0_url',
            'adminbar_custom_1_title',
            'adminbar_custom_1_url',
            'adminbar_custom_2_title',
            'adminbar_custom_2_url',
            'adminbar_custom_3_title',
            'adminbar_custom_3_url',
            'adminbar_custom_4_title',
            'adminbar_custom_4_url',
            'adminbar_custom_5_title',
            'adminbar_custom_5_url',
            'adminbar_sitename_icon',
            'adminbar_sitename_title',
            'admin_notice_footer_message_left',
            'admin_notice_footer_message_right',
            'admin_notice_header_allpages_level',
            'admin_notice_header_allpages_text',
            'admin_notice_header_settings_text',
            'dashboard_mtt1_content',
            'dashboard_mtt1_title',
            'dashboard_mtt2_content',
            'dashboard_mtt2_title',
            'dashboard_mtt3_content',
            'dashboard_mtt3_title',
            'email_notice_from_name',
            'email_notice_site_email_address',
            'loginpage_body_color',
            'loginpage_body_img',
            'loginpage_error_msg',
            'loginpage_logo_height',
            'loginpage_logo_img',
            'loginpage_logo_tooltip',
            'loginpage_body_position',
            'loginpage_body_repeat',
            'loginpage_body_attachment',
            'loginpage_extra_css',
            'loginpage_form_width',
            'loginpage_form_height',
            'loginpage_form_rounded',
            'loginpage_form_border',
            'loginpage_form_bg_img',
	        'loginpage_form_bg_color',
            'loginpage_button_position',
            'loginpage_links_position',
            'loginpage_logo_padding',
            'maintenance_mode_level',
            'maintenance_mode_line0',
            'maintenance_mode_line1',
            'maintenance_mode_line2',
            'maintenance_mode_title',
            'maintenance_mode_glow_img',
            'maintenance_mode_body_img',
            'maintenance_mode_html_img',
	        'maintenance_mode_extra_css',
            'media_jpg_quality',
	        'mtt_version',
	        'plugins_inactive_bg_color',
            'postpageslist_status_draft',
            'postpageslist_status_future',
            'postpageslist_status_others',
            'postpageslist_status_password',
            'postpageslist_status_pending',
            'postpageslist_status_private',
            'postpageslist_title_column_width',
            'postpages_post_autosave',
            'postpages_post_revision',
	        'postpages_disable_mbox_author',
	        'postpages_disable_mbox_comment_status',
	        'postpages_disable_mbox_comment',
	        'postpages_disable_mbox_custom_fields',
	        'postpages_disable_mbox_featured_image',
	        'postpages_disable_mbox_revisions',
	        'postpages_disable_mbox_slug',
            'posts_rename_add_new',
            'posts_rename_edit_item',
            'posts_rename_name',
            'posts_rename_not_found',
            'posts_rename_not_found_in_trash',
            'posts_rename_search_items',
            'posts_rename_singular_name',
            'posts_rename_view_item',
            'profile_css',
            'widget_meta_link1_text',
            'widget_meta_link1_title',
            'widget_meta_link2_text',
            'widget_meta_link2_title',
            'widget_meta_title',
            'widget_rss_update_timer',
	        'wpdisable_help_texts_level',
	        'wpdisable_howdy_search',
	        'wpdisable_howdy_replace',
            'wpenable_custom_gravatars_img',
            'wprss_delay_publish_period',
            'wprss_delay_publish_time'
        );

        function getAdminOptions() {
            $mttAdminOptions = array(
                'adminbar_custom_enable'               => 0,
                'adminbar_custom_0_title'              => '',
                'adminbar_custom_0_url'                => '',
                'adminbar_custom_1_title'              => '',
                'adminbar_custom_1_url'                => '',
                'adminbar_custom_2_title'              => '',
                'adminbar_custom_2_url'                => '',
                'adminbar_custom_3_title'              => '',
                'adminbar_custom_3_url'                => '',
                'adminbar_custom_4_title'              => '',
                'adminbar_custom_4_url'                => '',
                'adminbar_custom_5_title'              => '',
                'adminbar_custom_5_url'                => '',
                'adminbar_disable'                     => 0,
                'adminbar_remove_comments'             => 0,
                'adminbar_remove_my_account'           => 0,
                'adminbar_remove_new_content'          => 0,
                'adminbar_remove_site_name'            => 0,
                'adminbar_remove_theme_options'        => 0,
                'adminbar_remove_updates'              => 0,
                'adminbar_remove_wp_logo'              => 0,
	            'adminbar_remove_seo_by_yoast'         => 0,
                'adminbar_sitename_enable'             => 0,
                'adminbar_sitename_icon'               => '',
                'adminbar_sitename_title'              => '',
                'adminbar_sitename_url'                => '', //URL
                'admin_menus_remove_posts'             => 0,
                'admin_menus_remove_media'             => 0,
                'admin_menus_remove_links'             => 0,
                'admin_menus_remove_pages'             => 0,
                'admin_menus_remove_comments'          => 0,
                'admin_menus_remove_appearence'        => 0,
                'admin_menus_remove_plugins'           => 0,
                'admin_menus_remove_users'             => 0,
                'admin_menus_remove_tools'             => 0,
                'admin_notice_footer_hide'             => 0,
                'admin_notice_footer_message_enable'   => 0,
                'admin_notice_footer_message_left'     => '',
                'admin_notice_footer_message_right'    => '',
                'admin_notice_header_allpages_enable'  => 0,
                'admin_notice_header_allpages_level'   => 's',
                'admin_notice_header_allpages_text'    => '',
                'admin_notice_header_settings_enable'  => 0,
                'admin_notice_header_settings_text'    => '',
                'dashboard_add_cpt_enable'             => 0,
                'dashboard_mtt1_content'               => '',
                'dashboard_mtt1_enable'                => 0,
                'dashboard_mtt1_title'                 => '',
                'dashboard_mtt2_content'               => '',
                'dashboard_mtt2_enable'                => 0,
                'dashboard_mtt2_title'                 => '',
                'dashboard_mtt3_content'               => '',
                'dashboard_mtt3_enable'                => 0,
                'dashboard_mtt3_title'                 => '',
                'dashboard_remove_incoming_links'      => 0,
                'dashboard_remove_plugins'             => 0,
                'dashboard_remove_primary'             => 0,
                'dashboard_remove_quick_press'         => 0,
                'dashboard_remove_recent_comments'     => 0,
                'dashboard_remove_recent_drafts'       => 0,
                'dashboard_remove_right_now'           => 0,
                'dashboard_remove_secondary'           => 0,
                'dashboard_remove_footer_rightnow'     => 0,
                'dev_show_all_options'                 => 0,
                'email_notice_plain_html'              => 0,
                'email_notice_author_comment_warn'     => 0,
                'email_notice_from_name'               => '',
                'email_notice_site_email_address'      => '',
                'loginpage_backsite_hide'              => 0,
                'loginpage_body_attachment'            => '',
                'loginpage_body_color'                 => '',
                'loginpage_body_img'                   => '',
                'loginpage_body_position'              => '',
                'loginpage_body_repeat'                => '',
                'loginpage_button_position'            => '',
                'loginpage_errors'                     => 0,
                'loginpage_error_msg'                  => '',
                'loginpage_extra_css'                  => '',
	            'loginpage_form_bg_color'              => '',
                'loginpage_form_bg_img'                => '',
                'loginpage_form_border'                => '1px solid #E5E5E5',
                'loginpage_form_height'                => '',
                'loginpage_form_noshadow'              => 0,
                'loginpage_form_rounded'               => '',
                'loginpage_form_width'                 => '',
                'loginpage_links_position'             => '',
                'loginpage_logo_height'                => '', //num
                'loginpage_logo_img'                   => '',
                'loginpage_logo_padding'               => '',
                'loginpage_logo_tooltip'               => '',
                'loginpage_logo_url'                   => '',
                'loginpage_text_shadow'                => 0,
                'logout_redirect_enable'               => 0,
                'logout_redirect_url'                  => '', //URL
                'maintenance_mode_admin'               => 0,
                'maintenance_mode_enable'              => 0,
                'maintenance_mode_level'               => 'a',
                'maintenance_mode_line0'               => '',
                'maintenance_mode_line1'               => '',
                'maintenance_mode_line2'               => '',
                'maintenance_mode_title'               => '',
                'maintenance_mode_glow_img'            => '',
                'maintenance_mode_body_img'            => '',
                'maintenance_mode_html_img'            => '',
	            'maintenance_mode_extra_css'           => '',
                'media_better_attachment'              => 0,
	            'media_image_id_column_enable'         => 0,
                'media_image_size_column_enable'       => 0,
                'media_sanitize_filename'              => 0,
                'media_jpg_quality'                    => '',
                'media_jpg_sharpen'                    => 0,
                'media_adjust_youtube_oembed_enable'   => 0,
                'mtt_small_plugin'                     => 1,
                'mtt_verbose_plugin'                   => 0,
	            'mtt_version'                          => $this->version,
	            'plugins_remove_plugin_notice'         => 0,
	            'plugins_inactive_bg_color'            => '',
	            'plugins_acf_hide_options'             => 0,
                'postpageslist_enable_id_column'       => 0,
                'postpageslist_template_filter_enable' => 0,
                'postpageslist_enable_thumb_column'    => 0,
                'postpageslist_title_column_width'     => '', //num
                'postpageslist_persistent_list_view'   => 0,
                'postpageslist_status_draft'           => '',
                'postpageslist_status_future'          => '',
                'postpageslist_status_others'          => '',
                'postpageslist_status_password'        => '',
                'postpageslist_status_pending'         => '',
                'postpageslist_status_private'         => '',
	            'postpages_disable_mbox_author'        => 'none',
	            'postpages_disable_mbox_comment_status'=> 'none',
	            'postpages_disable_mbox_comment'       => 'none',
	            'postpages_disable_mbox_custom_fields' => 'none',
	            'postpages_disable_mbox_featured_image'=> 'none',
	            'postpages_disable_mbox_revisions'     => 'none',
	            'postpages_disable_mbox_slug'          => 'none',
	            'postpages_disable_mbox_attributes'    => 0,
	            'postpages_disable_mbox_category'      => 0,
		        'postpages_disable_mbox_excerpt'       => 0,
				'postpages_disable_mbox_tags'          => 0,
				'postpages_disable_mbox_trackbacks'    => 0,
                'postpages_enable_page_excerpts'       => 0,
                'postpages_move_author_metabox'        => 0,
	            'postpages_move_comments_metabox'      => 0,
                'postpages_post_autosave'              => '', //num
                'postpages_post_revision'              => '', //num
                'posts_rename_add_new'                 => '',
                'posts_rename_edit_item'               => '',
                'posts_rename_enable'                  => 0,
                'posts_rename_name'                    => '',
                'posts_rename_not_found'               => '',
                'posts_rename_not_found_in_trash'      => '',
                'posts_rename_search_items'            => '',
                'posts_rename_singular_name'           => '',
                'posts_rename_view_item'               => '',
                'profile_bio'                          => 0,
                'profile_css'                          => '',
                'profile_descriptions'                 => 0,
                'profile_display_name'                 => 0,
                'profile_h3_titles'                    => 0,
                'profile_hidden'                       => 0,
                'profile_nickname'                     => 0,
                'profile_none'                         => 0,
                'profile_slim'                         => 0,
                'profile_social'                       => 0,
                'profile_website'                      => 0,
                'shortcodes_gdocs'                     => 0,
                'shortcodes_scloud'                    => 0,
                'shortcodes_tube'                      => 0,
                'widget_meta_enable'                   => 0,
                'widget_meta_link1'                    => 0,
                'widget_meta_link1_text'               => '',
                'widget_meta_link1_title'              => '',
                'widget_meta_link1_url'                => '', //URL
                'widget_meta_link2'                    => 0,
                'widget_meta_link2_text'               => '',
                'widget_meta_link2_title'              => '',
                'widget_meta_link2_url'                => '', //URL
                'widget_meta_title'                    => '',
                'widget_remove_archives'               => 0,
                'widget_remove_calendar'               => 0,
                'widget_remove_categories'             => 0,
                'widget_remove_links'                  => 0,
                'widget_remove_meta'                   => 0,
                'widget_remove_nav_menu'               => 0,
                'widget_remove_pages'                  => 0,
                'widget_remove_recent_comments'        => 0,
                'widget_remove_recent_posts'           => 0,
                'widget_remove_rss'                    => 0,
                'widget_remove_search'                 => 0,
                'widget_remove_tag_cloud'              => 0,
                'widget_remove_text'                   => 0,
	            'widget_remove_akismet'                => 0,
                'widget_rss_update_timer'              => '', //num
                'widget_text_enable_shortcodes'        => 0,
                'wpblock_update_plugins'               => 0,
                'wpblock_update_wp'                    => 0,
                'wpdisable_autop'                      => 0,
                'wpdisable_capitalp'                   => 0,
                'wpdisable_nourl'                      => 0,
                'wpdisable_selfping'                   => 0,
                'wpdisable_smartquotes'                => 0,
                'wpdisable_version_full'               => 0,
                'wpdisable_version_number'             => 0,
	            'wpdisable_help_texts_enable'          => 0,
	            'wpdisable_help_texts_level'           => 'a',
	            'wpdisable_howdy_enable'               => 0,
	            'wpdisable_howdy_search'               => '',
	            'wpdisable_howdy_replace'              => '',
                'wpenable_custom_gravatars_enable'     => 0,
                'wpenable_custom_gravatars_img'        => '', //url
                'wpenable_google_jquery'               => 0,
                'wprss_delay_publish_enable'           => 0,
                'wprss_delay_publish_time'             => '',
                'wprss_delay_publish_period'           => ''
            );
            $devOptions      = get_option($this->adminOptionsName);

	        // Check if plugin options need update
	        if( !isset($devOptions['mtt_version']) && !empty($devOptions) ) require_once ('inc/update.php');


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

        function printAdminPage() {
            require_once ('mtt-admin-page.php');
        }


        /***************************************************************************
         *
         * @Title      : AUX FUNCTIONS
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function validateUrl($url) {
            if ($url == "" || $url == "#") return true;
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
            if (eregi($urlregex, $url)) {
                return true;
            } else {
                return false;
            }

        }

        function arrayPushAfter($src, $in, $pos) {
            if (is_int($pos)) $R = array_merge(array_slice($src, 0, $pos + 1), $in, array_slice($src, $pos + 1));
            else {
                foreach ($src as $k => $v) {
                    $R[$k] = $v;
                    if ($k == $pos) $R = array_merge($R, $in);
                }
            }
            return $R;
        }

        function getUserLevel($opt) {
            $level = 'delete_plugins';
            if ($opt == 'e') $level = 'delete_pages';
            elseif ($opt == 't') $level = 'publish_posts';
            elseif ($opt == 'c') $level = 'delete_posts';
            elseif ($opt == 's') $level = 'read';
            return $level;
        }


	    // USED BY shortCode_soundcloud SHORTCODE
	    function myUrlEncode($string) {
		    $entities     = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
		    return str_replace($entities, $replacements, urlencode($string));
	    }

		/* Used by mttGetRepositoryData */
		function formatRating($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
			if (is_numeric($number)) {
				if (!$number) {
					$rating = ($cents == 2) ? '0.00' : '0';
				} else {
					if (floor($number) == $number) {
						$rating = number_format($number, ($cents == 2 ? 2 : 0));
					} else {
						$rating = number_format(round($number, 2), ($cents == 0 ? 0 : 2));
					}
				}
				return $rating;
			}
		}

	    function checkAcfOptionsPage() {
		    global $menu;
		    foreach( $menu as $k => $item ){
			    if($item[2]=='acf-options') return true;
		    }
		    return false;
	    }

        /***************************************************************************
         *
         * @Title      : CREATE OPTIONS FIELDS IN ADMIN PAGE
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        // OPEN AND CLOSE OPTIONS BLOCKS
        function makeOpenCloseMetabox($open, $class = '', $tit = '') {
            if ($open) {
                $html = <<<HTML

				<div class="postbox {$class}">
					<div class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>{$tit}</span></h3>
					<div class="inside closenow">
						<ul>
HTML;

            } else {
                $html = <<<HTML

						</ul>
					</div>
				</div><!--postbox-->
HTML;

            }
            echo $html;
        }

        // CHECKBOX
        function makeCheckbox($opt, $txt, $desc = false, $li = false, $left = true) {
            $devOptions = $this->getAdminOptions();
            $txt        = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);

            if ($desc && preg_match("/<div/i", $desc)) {

            } elseif ($desc) {
                $desc = '<p class="desc">' . $desc . '</p> ';
            } else {
                $desc = '';
            }
            //	$desc = ($desc) ? '<p class="desc">'.$desc.'</p> ' : ' ';
            $li      = ($li) ? $li : ' class="mtt-checkboxes"';
            $checked = ($devOptions[$opt]) ? ' checked="yes"' : '';

            // FORCING ALL TO BE RIGHT SIDED
            $left = false;
            if ($left) {
                $out = <<<EOM
				<li{$li}>
					<label><input name="{$opt}" id="{$opt}" type="checkbox" {$checked}> {$txt}</label>{$desc}
				</li>
EOM;

            } else {
                $out = <<<EOM
				<li{$li}>
					<label class="textinput" for="{$opt}">{$txt}</label><input name="{$opt}" id="{$opt}" type="checkbox" {$checked}>{$desc}
				</li>
EOM;

            }
            echo $out;
        }

        // GENERIC LIST
        function makeGenericList($opt, $txt, $desc = false, $arr, $li = false) {
            $devOptions    = $this->getAdminOptions();
            $li            = ($li) ? $li : '';
            $select        = ' selected="selected"';
            $whichselected = array();
            foreach ($arr as $itm) {
                $whichselected[$itm] = ($devOptions[$opt] == $itm) ? $select : '';
            }
            $desc = ($desc) ? '<p class="desc">' . $desc . '</p> ' : ' ';
            $txt  = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);

            $out = <<<EOM

				<li{$li}>
					<label class="textinput">{$txt}</label>
					<select name="{$opt}" id="{$opt}">
EOM;
            foreach ($arr as $itm) {
                $out .= '<option value="' . $itm . '"' . $whichselected[$itm] . '>' . $itm . '</option>';
            }
            $out .= <<<EOM
					</select>
					{$desc}
				</li>

EOM;


            echo $out;
        }

        // ROLES LIST
        function makeRolesList($opt, $txt, $li = false) {
            $devOptions = $this->getAdminOptions();
            $li         = ($li) ? $li : '';
            $select     = ' selected="selected"';
            $admin_code = ($devOptions[$opt] == "a") ? $select : '';
            $edito_code = ($devOptions[$opt] == "e") ? $select : '';
            $autho_code = ($devOptions[$opt] == "t") ? $select : '';
            $contr_code = ($devOptions[$opt] == "c") ? $select : '';
            $subsc_code = ($devOptions[$opt] == "s") ? $select : '';
            $admin_text = __('Administrator');
            $edito_text = __('Editor');
            $autho_text = __('Author');
            $contr_text = __('Contributor');
            $subsc_text = __('Subscriber');
            $txt        = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);

            $out = <<<EOM
				<li{$li}">
					<label class="textinput">{$txt}</label>
					<select name="{$opt}" id="{$opt}">
					<option value="a"{$admin_code}>$admin_text</option>
					<option value="e"{$edito_code}>$edito_text</option>
					<option value="t"{$autho_code}>$autho_text</option>
					<option value="c"{$contr_code}>$contr_text</option>
					<option value="s"{$subsc_code}>$subsc_text</option>
					</select>
				</li>
EOM;


            echo $out;
        }

        // TEXT BOX
        function makeTextbox($id, $opt, $txt, $desc = false, $warn = false, $div = false, $size, $max = false, $strip = false) {
            $devOptions = $this->getAdminOptions();
            $div        = ($div) ? $div : '';
            $warn       = ($warn) ? $warn : '';
            $desc       = ($desc) ? '<p class="desc">' . $desc . '</p> ' : ' ';
            $opts       = ($strip) ? esc_html(stripslashes($devOptions[$opt])) : $devOptions[$opt];
            $max        = ($max) ? 'maxlength="' . $max . '"' : '';
            $size       = ($size == '50') ? 'style="width:56%"' : 'size="' . $size . '"';
            $txt        = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);
            $out        = <<<EOM

			 <li{$div}>
				<label class="textinput" for="{$id}">{$txt}</label> <input type="text" {$size} {$max} name="{$id}" id="{$id}" value="{$opts}">{$desc}{$warn}
			</li>
EOM;

            echo $out;
        }

        // TEXT AREA
        function makeTextArea($id, $opt, $txt, $desc = false, $li = false, $css = false, $strip = false) {
            $devOptions = $this->getAdminOptions();
            $li         = ($li) ? $li : '';
            $css        = ($css) ? $css : '';
            $desc       = ($desc) ? '<p class="desc">' . $desc . '</p> ' : ' ';
            $opts       = ($strip) ? esc_html(stripslashes($devOptions[$opt])) : $devOptions[$opt];
            $txt        = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);
            $out        = <<<EOM

			 <li{$li}>
				<label class="textinput">{$txt}</label><textarea name="{$id}" style="{$css}">{$opts}</textarea>{$desc}
			</li>
EOM;

            echo $out;
        }

        // COLOR PICKER
        function makeColorPicker($opt, $txt, $desc = false, $picker, $li = false) {
            $devOptions = $this->getAdminOptions();
            $li         = ($li) ? ' class="' . $li . '"' : '';
            $desc       = ($desc) ? '<p class="desc">' . $desc . '</p> ' : ' ';
            $id         = $opt;
            $opt        = ($devOptions[$opt] != '') ? $devOptions[$opt] : ' ';
            $txt        = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);
            $html       = <<<HTML
			<li{$li}>
			<label for="{$id}" class="textinput">{$txt}</label><input type="text" class="regular-text mtt-color-box" id="{$id}" name="{$id}" value="{$opt}" size="7" />{$desc}
			    <div id="{$picker}" class="regular-text mtt-color-picker"></div>
			</li>
HTML;
            echo $html;
        }

        // TIP CREDIT
        function makeTipCredit($name, $url) {
            $html = '<a href="' . $url . '" target="_blank">' . $name . '</a>';
            return $html;
        }

        // IMAGE UPLOADER
        function makeImageUploader($buttonId, $optId, $txt, $desc = false, $li = false) {
            $devOptions = $this->getAdminOptions();
            $li         = ($li) ? $li : '';
            $desc       = ($desc) ? '<p class="desc">' . $desc . '</p> ' : ' ';
            $opts       = ($devOptions[$optId] && $devOptions[$optId] != '') ? $devOptions[$optId] : ' ';

            //$img        = ($opts != ' ') ? '<span class="mtt-img-span"><img class="mtt-img" src="' . $opts . '"></span>' : '';
            //if($opts == '0') $img = '<span class="mtt-img-span">'.__('no image...', 'mtt') .'</span>';

	        $img =  ($opts != ' ') ? '<img class="mtt-img" src="' . $opts . '">' : '';
	        if ($opts == '0') $img = __('no image...', 'mtt');
	        $spanimg    = sprintf('<span id="img-%s" class="mtt-img-span">%s</span>',$optId, $img);

            $txt        = preg_replace('/^(\S+(\s+)?)/', '<strong>$1</strong>', $txt);
            $buttxt     = __('Select/Upload', 'mtt');
            $mtt_title  = "Many Tips Together " . __('version','mtt') . $this->mtt_tb_title;
            $out        = <<<EOM

			 <li{$li}>
				<label class="textinput" for="{$optId}">{$txt}</label><input id="{$buttonId}" value="{$buttxt}" type="button" class="button-secondary" /><input id="{$optId}" name="{$optId}" type="text" value="{$opts}" style="width: 56%;margin-left: 42%" />{$spanimg}{$desc}
				</li>
				<script>
				jQuery(document).ready( function($) {
				$('#{$buttonId}').click(function() {
					window.send_to_editor = function(html) {
					 imgurl = $('img',html).attr('src');
					 $('#{$optId}').val(imgurl);
					 imgsrc = '<img class="mtt-img" src="'+imgurl+'">';
					 $('#img-{$optId}').html(imgsrc);
					 tb_remove();
					}
				 formfield = $('#{$optId}').attr('name');
				 tb_show('{$mtt_title}', 'media-upload.php?type=image&amp;mtt_type=image&amp;TB_iframe=true');
				 return false;
				});

				});</script>
			</li>
EOM;
            echo $out;
        }

        // AUX <ul/> PRINTER (for not bugging in PhpStorm)
        function makeFakeUl($open) {
            if ($open) echo '<ul>';
            else echo '</ul>';
        }

        /***************************************************************************
         *
         * @Title      : OPTIMIZE DATABASE CRON JOB,
         * @Description: ONLY USED IF MANUALLY ACTIVATED AT THE END OF THIS FILE
         * @Returns    :
         *
         ****************************************************************************/
        function optimizeDatabase_do_it() {
            global $wpdb;
            $all_tables = $wpdb->get_results('SHOW TABLES', ARRAY_A);
            foreach ($all_tables as $tables) {
                $table = array_values($tables);
                $wpdb->query("OPTIMIZE TABLE " . $table[0]);
            }
        }

        function optimizeDatabase_cron_on() { // add it to the cron jobs
            wp_schedule_event(time(), 'weekly', $this->optimizeDatabase_do_it);
        }

        function optimizeDatabase_cron_off() { // remove from the cron
            wp_clear_scheduled_hook($this->optimizeDatabase_do_it);
        }


        /***************************************************************************
         *
         * @Title      : ADD JS and CSS into PLUGIN ADMIN AREA
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function wpAdminHead_local($hook) {
            if('settings_page_many-tips-together' != $hook) return;
            //global $firephp;$firephp->log($hook);
            wp_enqueue_script( array('jquery', 'media-upload', 'thickbox') );
            wp_register_script('mtt-js', MTT_URL . 'mtt.js');
            wp_register_style('mtt-css', MTT_URL . 'mtt.css');
            wp_enqueue_script('farbtastic');
            wp_enqueue_style('farbtastic');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox', null, array('jquery'));
            wp_enqueue_style('thickbox.css', '/' . WPINC . '/js/thickbox/thickbox.css', null, '1.0');
            wp_enqueue_script('mtt-js');
            wp_enqueue_style('mtt-css');
        }


        /***************************************************************************
         *
         * @Title      : ADD JS into ALL AREAS
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function wpAdminHead_global() {
            global $current_screen, $devOptions;

	        /* HIDE WORDPRESS HELP TEXTS */
	        if ($devOptions['wpdisable_help_texts_enable']) {
		        $ucan = $this->getUserLevel($devOptions['wpdisable_help_texts_level']);
		        if (false !== current_user_can($ucan)) {
			        wp_register_style('mtt-hide-help', MTT_URL . 'inc/hide-help.css');
			        wp_enqueue_style('mtt-hide-help');
		        }
	        }
            // CUSTOMIMZE UPLOAD WINDOW
            if ($current_screen->id == 'media-upload' && isset($_GET['mtt_type'])) {
                // HIDE MANY ELEMENTS
                echo '<style type="text/css">#media-upload-header #sidemenu li#tab-type_url,tr.post_excerpt,tr.post_content,tr.url,tr.align,tr.image_alt, tr.post_title.form-required{							display: none !important;}</style>';

                // REFRESH UPLOAD SCREEN EVERY HALF SECOND, TO CHANGE THE BUTTON NAMES
                $tab     = isset($_GET['tab']) ? $_GET['tab'] : "type";
                $refresh = ($tab == 'type') ? 'var mtt_t = setInterval(function(){$("#media-items").each(setButtonNames); $("p.savebutton").css("display", "none");}, 500);' : '';

                // BUTTON NAME
                $select = __("Select Image", 'mtt');

                //CHANGE BUTTON NAMES
                $js = <<<EOM
					<script type="text/javascript">
					function setButtonNames() {
						jQuery(this).find('.savesend .button').val('{$select}');
					}
					jQuery(document).ready(function($){
						$('#media-items').each(setButtonNames);
						{$refresh}
						//$('#media-items').each(function(){
						//	jQuery(this).find('.savesend .button').val('{$select}');
						//});
					});
					</script>
EOM;
                echo $js;
            }

            // JQUERY FOR DISABLE ADMIN BAR & ENABLE FOOTER MESSAGE
            if ($devOptions['adminbar_disable'] || $devOptions['admin_notice_footer_message_enable']) {
                $js_open  = '<script type="text/javascript">
			  		jQuery(document).ready(function($){';
                $js_cont  = '';
                $js_close = '});
					</script>';

                if ($devOptions['adminbar_disable']) $js_cont .= '$("#your-profile .show-admin-bar").remove();';
                if ($devOptions['admin_notice_footer_message_enable']) $js_cont .= '$("#footer").contents(":not(#footer-left,#footer-upgrade,#mtt-footer-codex)").remove();'; //'$("#footer p:not(#footer-left)").hide();';

                echo $js_open . $js_cont . $js_close;
            }

//	        global $firephp;$firephp->log($current_screen->id);

            switch ($current_screen->id) {
                case 'dashboard':
                    $uptmsg = ($devOptions['wpblock_update_wp']) ? '#wp-version-message {display:none}' : '';
                    $rnfoot = ($devOptions['dashboard_remove_footer_rightnow']) ? '.versions p, .versions span, p.akismet-right-now {display:none}' : '';
                    if ($devOptions['wpblock_update_wp'] || $devOptions['dashboard_remove_footer_rightnow']) {
                        echo '<style type="text/css">' . $uptmsg . $rnfoot . '</style>';
                    }
                    break;
                case 'edit-post':
                case 'edit-page':
                    $css = '<style type="text/css">';
                    if (strlen($devOptions['postpageslist_status_draft']) == 7)
                        $css .= '.status-draft {background: ' . $devOptions['postpageslist_status_draft'] . ' !important}';
                    if (strlen($devOptions['postpageslist_status_pending']) == 7)
                        $css .= '.status-pending {background: ' . $devOptions['postpageslist_status_pending'] . ' !important}';
                    if (strlen($devOptions['postpageslist_status_future']) == 7)
                        $css .= '.status-future {background: ' . $devOptions['postpageslist_status_future'] . ' !important}';
                    if (strlen($devOptions['postpageslist_status_private']) == 7)
                        $css .= '.status-private {background: ' . $devOptions['postpageslist_status_private'] . ' !important}';
                    if (strlen($devOptions['postpageslist_status_password']) == 7)
                        $css .= '.post-password-required {background: ' . $devOptions['postpageslist_status_password'] . ' !important}';
                    if (strlen($devOptions['postpageslist_status_others']) == 7)
                        $css .= '.author-other {background: ' . $devOptions['postpageslist_status_others'] . ' !important}';
                    if ($devOptions['postpageslist_title_column_width'] != '')
                        $css .= '.column-title {width: ' . $devOptions['postpageslist_title_column_width'] . 'px !important}';
                    if ($devOptions['postpageslist_enable_id_column'] != '')
                        $css .= '.column-id {width:57px}';

                    if ($devOptions['postpageslist_enable_thumb_column'] != '')
                        $css .= '.column-thumbnail {width:110px}';

                    $css .= '</style>';

                    if (strlen($css) > 31) echo $css;
                    break;
                case 'profile':
                    if ($devOptions['profile_slim'] || $devOptions['profile_hidden'] || $devOptions['profile_bio'] || $devOptions['profile_h3_titles'] || $devOptions['profile_display_name'] || $devOptions['profile_nickname'] || $devOptions['profile_website'] || $devOptions['profile_css'] || $devOptions['profile_descriptions']) {
                        $print = '';
                        if ($devOptions['profile_css'] != '')
                            $print .= '<style type="text/css">' . $devOptions['profile_css'] . '</style>';

                        $print .= '<script type="text/javascript">
						  jQuery(document).ready(function($){';

                        if ($devOptions['profile_bio'])
                            $print .= '$("#your-profile .form-table:eq(3) tr:eq(0), #your-profile h3:eq(3)").remove();';
                        if ($devOptions['profile_slim'])
                            $print .= '$("#your-profile .form-table:first tr:lt(2)").remove();';
                        elseif ($devOptions['profile_hidden'])
                            $print .= '$("#your-profile h3:first").remove();
						    $("#your-profile .form-table:first").remove();';
                        if ($devOptions['profile_display_name'])
                            $print .= '$("#display_name").parents("tr").hide();';
                        if ($devOptions['profile_nickname'])
                            $print .= '$("#nickname").parents("tr").hide();';
                        if ($devOptions['profile_website'])
                            $print .= '$("#url").parents("tr").hide();';
                        if ($devOptions['profile_descriptions'])
                            $print .= '$(".description").css("display","none");';
                        if ($devOptions['profile_h3_titles'])
                            $print .= '$("#your-profile h3").each(function(name,value) { $(this).remove(); });';
                        $print .= '});
							</script>';
                        echo $print;
                    }
                    break;
                case 'upload':
	                $idcol = ($devOptions['media_image_id_column_enable']) ? '.column-id {width:50px!important} ' : '';
	                $sizecol = ($devOptions['media_image_size_column_enable']) ? '#dimensions{width:100px!important}' : '';
	                if ($idcol!='' || $sizecol!='') {
		                echo '<style type="text/css">' . $idcol . $sizecol . '</style>';
	                }
		        break;
	            case 'plugins':
		            $inactivecolor = ($devOptions['plugins_inactive_bg_color']!=''&&$devOptions['plugins_inactive_bg_color']!=' '&&$devOptions['plugins_inactive_bg_color']) ? '.plugins .inactive, .plugins .inactive th, .plugins .inactive td, tr.inactive + tr.plugin-update-tr .plugin-update {background-color:'.$devOptions['plugins_inactive_bg_color'].'!important;} ' : false;
		            $hidepnotice = ($devOptions['plugins_remove_plugin_notice']) ? '.update-message{display:none;}' : false;
		            if ($inactivecolor || $hidepnotice) {
			            echo '<style type="text/css">' . $inactivecolor . $hidepnotice . '</style>';
		            }
		            break;
            }

        }


        /***************************************************************************
         *
         * @Title      : ADD link to settings in Plugins list page
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function mttSettings_plugin_link($links, $file) {
            if ($file == plugin_basename(dirname(__FILE__) . '/many-tips-together.php')) {
                $in = '<a href="options-general.php?page=many-tips-together">' . __('Settings') . '</a>';
                array_unshift($links, $in);
                //$links[] = '<a href="options-general.php?page=many-tips-together">'.__('Settings').'</a>';
            }
            return $links;
        }

	    function mttGetRepositoryData() {

		    $plugin_url = 'http://wpapi.org/api/plugin/many-tips-together.json';

		    $cache = get_transient('mttdlcounter2');
		    if ( false !== $cache ) return $cache;

		    // Fetch the data
		    if ( $response = wp_remote_retrieve_body( wp_remote_get( $plugin_url ) ) ) {
			    // Decode the json response
			    if ( $response = json_decode( $response, true ) ) {
				    // Double check we have all our data
				    if ( !empty($response['added']) ) {
					    set_transient( 'mttdlcounter2', $response, 720 );
					    return $response;
				    }
			    }
		    }
		    return false;
	    }

	    function mttPrintRepositoryData() {
		    $mttotal = $this->mttGetRepositoryData();
		    if(false === $mttotal) return;
		    $total_downloads = number_format_i18n($mttotal['total_downloads']);
		    $rating = $this->formatRating($mttotal['rating']/20);
		    $updated = date_i18n(get_option('date_format') ,strtotime($mttotal['updated']));
		    $num_rating = number_format_i18n($mttotal['num_ratings']);
		    $tot = __('Downloads','mtt');
		    $totr = sprintf(__('%s votes','mtt'), $num_rating);
		    $upd = __('Updated','mtt');
		    $img1 = MTT_URL .'/images/star_x_grey.gif';
		    $img2 = MTT_URL .'/images/star_x_orange.gif';
		    $rat = $mttotal['rating'].'%';
		    $print = <<<HTML
		    <div style="float:right;text-align:right"><div style="width:55px;background:url($img1) 0 0 repeat-x;">
<div style="height: 12px; background: url($img2) repeat-x scroll 0px 0px transparent; width: $rat "></div>$totr</div>
</div>
			<span style="color:#b0b0b0">$tot:</span> <em style="color:#ccbb8d;">$total_downloads</em><br>
		    <span style="color:#b0b0b0">$upd:</span> <em style="color:#ccbb8d;">$updated</em>
HTML;
			echo $print;
	    }
        /***************************************************************************
         *
         * @Title      : MAINTENANCE MODE
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function maintenanceMode_activate() {
            $devOptions = $this->getAdminOptions();
            $level      = $this->getUserLevel($devOptions['maintenance_mode_level']);
            if (!current_user_can($level)) {
                $title = ($devOptions['maintenance_mode_title'] != '') ? $devOptions['maintenance_mode_title'] : get_bloginfo('name') . __(' | Maintenance Mode', 'mtt');

                /*$opts    = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
                $context = stream_context_create($opts);

                if (!defined('MTT_CUSTOM_MAINTENANCE')) $message = @file_get_contents(MTT_URL . "maintenance/index.php", false, $context);
                else $message = @file_get_contents(content_url() . "/maintenance/index.php", false, $context);
                if ($message === false) $message = $title.' : ' . $devOptions['maintenance_mode_line1'];//"Your server does not accept this method of maintenance, still looking for a solution, sorry for that...";
                wp_die($message, $title, array('response' => 503));*/
	            if (!defined('MTT_CUSTOM_MAINTENANCE')) $message = wp_remote_get(MTT_URL . "maintenance/index.php");
	            else $message = wp_remote_get(content_url() . "/maintenance/index.php");
	            if (is_wp_error($message)) $display = $title.' : ' . $devOptions['maintenance_mode_line1'];
	            else $display = $message['body'];
                wp_die($display, $title, array('response' => 503));
            }
        }


        /***************************************************************************
         *
         * @Title      : WORDPRESS BEHAVIOR
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function wpBehavior_hide_update_bubble() {
            global $submenu; //$menu,
            //$menu[65][0] = 'Plugins';
            $submenu['index.php'][10][0] = 'Updates';
        }

        function wpBehavior_phone_home_disable($default) {
            global $wp_version;
            return 'WordPress/' . $wp_version;
        }

        function wpBehavior_no_self_ping(&$links) {
            $home = home_url();
            foreach ($links as $l => $link)
                if (0 === strpos($link, $home))
                    unset($links[$l]);
        }

        function wpBehavior_remove_version() {
            global $devOptions; // = $this->getAdminOptions();
            if ($devOptions['wpdisable_version_full']) return '';
            elseif ($devOptions['wpdisable_version_number']) return '<meta name="generator" content="WordPress" />';
            else return '';
        }

	    function wpBehavior_gravatars_custom() {
		    global $devOptions;

		    $fasticon = ' <small><em>(icon by: <a href="http://www.fasticon.com/" target="_blank">fasticon.com</a>)</em></small>';
		    $useravat = ($devOptions['wpenable_custom_gravatars_img'] != '' && $devOptions['wpenable_custom_gravatars_img'] != ' ' && $devOptions['wpenable_custom_gravatars_img']) ? $devOptions['wpenable_custom_gravatars_img'] : false;
		    unset($avatar_defaults);
		    $avat1 = MTT_URL . "images/avatar1.png";
		    $avat2 = MTT_URL . "images/avatar2.png";
		    $avat3 = MTT_URL . "images/avatar3.png";
		    if ($useravat) $avat4 = $useravat;
		    $bavat[$avat1] = 'Glasses Creature' . $fasticon;
		    $bavat[$avat2] = 'Red Creature' . $fasticon;
		    $bavat[$avat3] = 'Black Power' . $fasticon;
		    if ($useravat) $bavat[$avat4] = get_option('blogname');

		    $avatar_defaults = $bavat;

		    // best way i found to get rid of the 'mystery' default
		    $default     = get_option('avatar_default');
		    $new_default = ($devOptions['wpenable_custom_gravatars_img'] != '') ? $avat4 : $avat1;
		    if (empty($default) || $default == 'mystery') update_option('avatar_default', $new_default);

		    return $avatar_defaults;
	    }


	    function wpBehavior_jquery_cdn() {
		    if (!is_admin()) {
			    wp_deregister_script('jquery');
			    wp_register_script('jquery', ('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'), false, null, true);
			    wp_enqueue_script('jquery');
		    }
	    }

	    function wpBehavior_rss_delay_publish($where) {
		    global $wpdb, $devOptions;

		    if (is_feed()) {
			    $now  = gmdate('Y-m-d H:i:s');
			    $wait = $devOptions['wprss_delay_publish_time']; // integer
			    // http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
			    $device = $devOptions['wprss_delay_publish_period']; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR
			    // add SQL-sytax to default $where
			    $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
		    }
		    return $where;
	    }

	    function wpBehavior_goodbye_howdy_33 ( $wp_admin_bar ) {
		    global $devOptions;
		    $avatar = get_avatar( get_current_user_id(), 16 );
		    if ( ! $wp_admin_bar->get_node( 'my-account' ) )
			    return;
		    $wp_admin_bar->add_node( array(
			    'id' => 'my-account',
			    'title' => $devOptions['wpdisable_howdy_replace'] . wp_get_current_user()->display_name . $avatar,
		    ) );
	    }

	    function wpBehavior_goodbye_howdy_32($links) {
		    global $devOptions;
		    $links = str_replace( $devOptions['wpdisable_howdy_search'], $devOptions['wpdisable_howdy_replace'], $links );
		    return $links;
	    }


        function dashboardAdd_right_now_cpt() {
            $args     = array(
                'public'   => true,
                'show_ui'  => true,
                '_builtin' => false
            );
            $output   = 'object';
            $operator = 'and';

            $post_types = get_post_types($args, $output, $operator);
            foreach ($post_types as $post_type) {
                $num_posts = wp_count_posts($post_type->name);
                $num       = number_format_i18n($num_posts->publish);
                $text      = _n($post_type->labels->singular_name, $post_type->labels->name, intval($num_posts->publish));
                if (current_user_can('edit_posts')) {
                    $num  = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
                    $text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
                }
                echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
                echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
            }
            $taxonomies = get_taxonomies($args, $output, $operator);
            foreach ($taxonomies as $taxonomy) {
                $num_terms = wp_count_terms($taxonomy->name);
                $num       = number_format_i18n($num_terms);
                $text      = _n($taxonomy->labels->singular_name, $taxonomy->labels->name, intval($num_terms));
                if (current_user_can('manage_categories')) {
                    $num  = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num</a>";
                    $text = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$text</a>";
                }
                echo '<tr><td class="first b b-' . $taxonomy->name . '">' . $num . '</td>';
                echo '<td class="t ' . $taxonomy->name . '">' . $text . '</td></tr>';
            }
        }

        /***************************************************************************
         *
         * @Title      : REMOVE MENUS
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function adminMenus_remove() {
            global $devOptions;
            if ($devOptions['admin_menus_remove_posts']) remove_menu_page('edit.php');
            if ($devOptions['admin_menus_remove_media']) remove_menu_page('upload.php');
            if ($devOptions['admin_menus_remove_links']) remove_menu_page('link-manager.php');
            if ($devOptions['admin_menus_remove_pages']) remove_menu_page('edit.php?post_type=page');
            if ($devOptions['admin_menus_remove_comments']) remove_menu_page('edit-comments.php');
            if ($devOptions['admin_menus_remove_appearence']) remove_menu_page('themes.php');
            if ($devOptions['admin_menus_remove_plugins']) remove_menu_page('plugins.php');
            if ($devOptions['admin_menus_remove_users']) remove_menu_page('users.php');
            if ($devOptions['admin_menus_remove_tools']) remove_menu_page('tools.php');
        }


        /***************************************************************************
         *
         * @Title      : CHANGE POSTS NAME FOR WHATEVER
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function changePost_menu_label() {
            global $devOptions, $menu;
            global $submenu;
            if ($devOptions['posts_rename_name'] != '') $menu[5][0] = $devOptions['posts_rename_name'];
            if ($devOptions['posts_rename_name'] != '') $submenu['edit.php'][5][0] = $devOptions['posts_rename_name'];
            if ($devOptions['posts_rename_add_new'] != '') $submenu['edit.php'][10][0] = $devOptions['posts_rename_add_new'];
            //$submenu['edit.php'][16][0] = 'Tags';
            echo '';
        }

        function changePost_object_label() {
            global $wp_post_types, $devOptions;

            $labels = &$wp_post_types['post']->labels;
            if ($devOptions['posts_rename_name'] != '')
                $labels->name = $devOptions['posts_rename_name'];
            else $labels->name = $labels->name;

            if ($devOptions['posts_rename_singular_name'] != '')
                $labels->singular_name = $devOptions['posts_rename_singular_name'];
            else $labels->singular_name = $labels->singular_name;

            if ($devOptions['posts_rename_add_new'] != '') {
                $labels->add_new      = $devOptions['posts_rename_add_new'];
                $labels->add_new_item = $devOptions['posts_rename_add_new'];
            } else {
                $labels->add_new      = $labels->add_new;
                $labels->add_new_item = $labels->add_new_item;
            }

            if ($devOptions['posts_rename_edit_item'] != '')
                $labels->edit_item = $devOptions['posts_rename_edit_item'];
            else $labels->edit_item = $labels->edit_item;

            if ($devOptions['posts_rename_name'] != '')
                $labels->new_item = $devOptions['posts_rename_name'];
            else $labels->new_item = $labels->new_item;

            if ($devOptions['posts_rename_view_item'] != '')
                $labels->view_item = $devOptions['posts_rename_view_item'];
            else $labels->view_item = $labels->view_item;

            if ($devOptions['posts_rename_search_items'] != '')
                $labels->search_items = $devOptions['posts_rename_search_items'];
            else $labels->search_items = $labels->search_items;

            if ($devOptions['posts_rename_not_found'] != '')
                $labels->not_found = $devOptions['posts_rename_not_found'];
            else $labels->not_found = $labels->not_found;

            if ($devOptions['posts_rename_not_found_in_trash'] != '')
                $labels->not_found_in_trash = $devOptions['posts_rename_not_found_in_trash'];
            else $labels->not_found_in_trash = $labels->not_found_in_trash;

        }


        /***************************************************************************
         *
         * @Title      : HEADER AND FOOTER
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function adminNotices_enable_disable() {
            global $devOptions, $current_screen;

            // enable settings-page notice
            if ($devOptions['admin_notice_header_settings_enable']&&$current_screen->id!='settings_page_many-tips-together') {
                if ($current_screen->parent_base == 'options-general') {
                    echo '<div  class="updated">' . $devOptions['admin_notice_header_settings_text'] . '</div>';
                }
            }

            // enable general notice
            if ($devOptions['admin_notice_header_allpages_enable']&&$current_screen->id!='settings_page_many-tips-together') {
                $ucan = $this->getUserLevel($devOptions['admin_notice_header_allpages_level']);
                if (false !== current_user_can($ucan)) {
                    echo '<div  class="updated">' . $devOptions['admin_notice_header_allpages_text'] . '</div>';
                }
            }


            // disable WP update notices
            if ($devOptions['wpblock_update_wp']) {
                remove_action('admin_notices', 'update_nag', 3);
                remove_filter('update_footer', 'core_update_footer');
            }
        }

        function adminNotices_footer_hide() {
            echo '<style type="text/css">#footer { display: none; }</style>';
        }

        function adminNotices_footer_left($default_text) {
            global $devOptions;
            return $devOptions['admin_notice_footer_message_left'];
        }

        function adminNotices_footer_right($default_text) {
            global $devOptions;
            return $devOptions['admin_notice_footer_message_right'];
        }


        /***************************************************************************
         *
         * @Title      : REMOVE FROM DASHBOARD
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function dashboardAddRemove_widgets() {
            global $devOptions;

            /* REMOVE */
            if ($devOptions['dashboard_remove_quick_press'])
                remove_meta_box('dashboard_quick_press', 'dashboard', 'side');

            if ($devOptions['dashboard_remove_incoming_links'])
                remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');

            if ($devOptions['dashboard_remove_right_now'])
                remove_meta_box('dashboard_right_now', 'dashboard', 'normal');

            if ($devOptions['dashboard_remove_plugins'])
                remove_meta_box('dashboard_plugins', 'dashboard', 'normal');

            if ($devOptions['dashboard_remove_recent_drafts'])
                remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');

            if ($devOptions['dashboard_remove_recent_comments'])
                remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

            if ($devOptions['dashboard_remove_primary'])
                remove_meta_box('dashboard_primary', 'dashboard', 'side'); // other news

            if ($devOptions['dashboard_remove_secondary'])
                remove_meta_box('dashboard_secondary', 'dashboard', 'side'); // official blog

            /* ADD */
            function add_dashboard_content1() {
                global $devOptions;
                echo stripslashes(do_shortcode($devOptions['dashboard_mtt1_content']));
            }

            function add_dashboard_content2() {
                global $devOptions;
                echo stripslashes(do_shortcode($devOptions['dashboard_mtt2_content']));
            }

            function add_dashboard_content3() {
                global $devOptions;
                echo stripslashes(do_shortcode($devOptions['dashboard_mtt3_content']));
            }

            if ($devOptions['dashboard_mtt1_enable']) {
                $title = ($devOptions['dashboard_mtt1_title'] == '') ? '&nbsp;&nbsp;' : stripslashes($devOptions['dashboard_mtt1_title']);
                wp_add_dashboard_widget('dashboard1_mtt_title', $title, 'add_dashboard_content1');
            }
            if ($devOptions['dashboard_mtt2_enable']) {
                $title = ($devOptions['dashboard_mtt2_title'] == '') ? '&nbsp;&nbsp;' : $devOptions['dashboard_mtt2_title'];
                wp_add_dashboard_widget('dashboard2_mtt_title', $title, 'add_dashboard_content2');
            }
            if ($devOptions['dashboard_mtt3_enable']) {
                $title = ($devOptions['dashboard_mtt3_title'] == '') ? '&nbsp;&nbsp;' : $devOptions['dashboard_mtt3_title'];
                wp_add_dashboard_widget('dashboard3_mtt_title', $title, 'add_dashboard_content3');
            }
        }


        /***************************************************************************
         *
         * @Title      : WIDGETS INIT
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function widgetsEnable_and_disable() {
            global $devOptions;
            if ($devOptions['widget_meta_enable']) {
                function replace_widget_meta_do_widget($args) {
                    global $devOptions;
                    extract($args);
                    $the_extra_link_1_meta_modified = '<li><a href="' . $devOptions['widget_meta_link1_url'] . '" title="' . $devOptions['widget_meta_link1_title'] . '">' . $devOptions['widget_meta_link1_text'] . '</a></li>';
                    $the_extra_link_2_meta_modified = '<li><a href="' . $devOptions['widget_meta_link2_url'] . '" title="' . $devOptions['widget_meta_link2_title'] . '">' . $devOptions['widget_meta_link2_text'] . '</a></li>';

                    echo $before_widget;
                    echo $before_title . $devOptions['widget_meta_title'] . $after_title; ?>
                <ul>
                    <?php wp_register();?>
                    <li><?php wp_loginout(); ?></li>
                    <?php if ($devOptions['widget_meta_link1']) echo $the_extra_link_1_meta_modified; ?>
                    <?php if ($devOptions['widget_meta_link2']) echo $the_extra_link_2_meta_modified; ?>
                    <?php wp_meta(); ?>
                </ul>
                <?php
                    echo $after_widget;
                }

                wp_unregister_sidebar_widget('meta');
                $widget_ops = array('classname'   => 'widget_meta',
                                    'description' => __("Modified Meta Widget, please go to Many Tips Together page to customize", 'mtt'));
                wp_register_sidebar_widget('meta', 'Meta Slim', 'replace_widget_meta_do_widget', $widget_ops);
            }

            if ($devOptions['widget_remove_pages'])
                unregister_widget('WP_Widget_Pages');

            if ($devOptions['widget_remove_calendar'])
                unregister_widget('WP_Widget_Calendar');

            if ($devOptions['widget_remove_archives'])
                unregister_widget('WP_Widget_Archives');

            if ($devOptions['widget_remove_links'])
                unregister_widget('WP_Widget_Links');

            if ($devOptions['widget_remove_meta'])
                unregister_widget('WP_Widget_Meta');

            if ($devOptions['widget_remove_search'])
                unregister_widget('WP_Widget_Search');

            if ($devOptions['widget_remove_text'])
                unregister_widget('WP_Widget_Text');

            if ($devOptions['widget_remove_categories'])
                unregister_widget('WP_Widget_Categories');

            if ($devOptions['widget_remove_recent_posts'])
                unregister_widget('WP_Widget_Recent_Posts');

            if ($devOptions['widget_remove_recent_comments'])
                unregister_widget('WP_Widget_Recent_Comments');

            if ($devOptions['widget_remove_rss'])
                unregister_widget('WP_Widget_RSS');

            if ($devOptions['widget_remove_tag_cloud'])
                unregister_widget('WP_Widget_Tag_Cloud');

            if ($devOptions['widget_remove_nav_menu'])
                unregister_widget('WP_Nav_Menu_Widget');


        }

		function widgetsDisable_akismet() {
			wp_unregister_sidebar_widget( 'akismet' );
		}
        /***************************************************************************
         *
         * @Title      : LOGIN AND LOGOUT
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function logIn_custom_link() {
            global $devOptions;
            return $devOptions['loginpage_logo_url'];
        }

        function logIn_css_make() {
            global $devOptions;
            include('inc/login.php');

        }

        function logIn_logo_title() {
            global $devOptions;
            return $devOptions['loginpage_logo_tooltip'];
        }

        function logOut_redirect_url() {
            global $devOptions;
            wp_redirect($devOptions['logout_redirect_url']);
            die();
        }


        /***************************************************************************
         *
         * @Title      : POST AND PAGE EDITING
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function postPageEditing_autor_metabox_remove() {
            remove_meta_box('authordiv', 'post', 'normal');
	        remove_meta_box('authordiv', 'page', 'normal');
        }

        function postPageEditing_autor_metabox_move() {
            global $post_ID;
            $post = get_post($post_ID);
            echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
            post_author_meta_box($post);
            echo '</div>';
        }

	    function postPageEditing_comments_metabox_remove() {
		    remove_meta_box('commentstatusdiv', 'post', 'normal');
		    remove_meta_box('commentstatusdiv', 'page', 'normal');
	    }

	    function postPageEditing_comments_metabox_move() {
		    global $post_ID;
		    $post = get_post($post_ID);
		    echo '<div id="commentstatusdiv" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;margin-bottom: -24px"><div style="margin-bottom:-7px;font-weight: bold;">Comments:</div>';
		    post_comment_status_meta_box($post);
		    echo '</div>';
	    }

	    function postPageEditing_all_metabox_remove() {
		    global $devOptions;

		    /* Author meta box. */
		    if($devOptions['postpages_disable_mbox_author'] != 'none') {
				switch($devOptions['postpages_disable_mbox_author']) {
					case 'post':
						remove_meta_box( 'authordiv', 'post', 'normal' );
						break;
					case 'page':
						remove_meta_box( 'authordiv', 'page', 'normal' );
						break;
					default:
						remove_meta_box( 'authordiv', 'page', 'normal' );
						remove_meta_box( 'authordiv', 'post', 'normal' );
						break;
				}
		    }

		    /* Comment status meta box. */
		    if($devOptions['postpages_disable_mbox_comment_status'] != 'none') {
			    switch($devOptions['postpages_disable_mbox_comment_status']) {
				    case 'post':
					    remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
					    break;
				    case 'page':
					    remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
					    break;
				    default:
					    remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
					    remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
					    break;
			    }
		    }

		    /* Comments meta box. */
		    if($devOptions['postpages_disable_mbox_comment'] != 'none') {
			    switch($devOptions['postpages_disable_mbox_comment']) {
				    case 'post':
					    remove_meta_box( 'commentsdiv', 'post', 'normal' );
					    break;
				    case 'page':
					    remove_meta_box( 'commentsdiv', 'page', 'normal' );
					    break;
				    default:
					    remove_meta_box( 'commentsdiv', 'page', 'normal' );
					    remove_meta_box( 'commentsdiv', 'post', 'normal' );
					    break;
			    }
		    }

		    /* Custom fields meta box. */
		    if($devOptions['postpages_disable_mbox_custom_fields'] != 'none') {
			    switch($devOptions['postpages_disable_mbox_custom_fields']) {
				    case 'post':
					    remove_meta_box( 'postcustom', 'post', 'normal' );
					    break;
				    case 'page':
					    remove_meta_box( 'postcustom', 'page', 'normal' );
					    break;
				    default:
					    remove_meta_box( 'postcustom', 'page', 'normal' );
					    remove_meta_box( 'postcustom', 'post', 'normal' );
					    break;
			    }
		    }

		    /* Featured image meta box. */
		    if($devOptions['postpages_disable_mbox_featured_image'] != 'none') {
			    switch($devOptions['postpages_disable_mbox_featured_image']) {
				    case 'post':
					    remove_meta_box( 'postimagediv', 'post', 'side' );
					    break;
				    case 'page':
					    remove_meta_box( 'postimagediv', 'page', 'side' );
					    break;
				    default:
					    remove_meta_box( 'postimagediv', 'page', 'side' );
					    remove_meta_box( 'postimagediv', 'post', 'side' );
					    break;
			    }
		    }

		    /* Revisions meta box. */
		    if($devOptions['postpages_disable_mbox_revisions'] != 'none') {
			    switch($devOptions['postpages_disable_mbox_revisions']) {
				    case 'post':
					    remove_meta_box( 'revisionsdiv', 'post', 'normal' );
					    break;
				    case 'page':
					    remove_meta_box( 'revisionsdiv', 'page', 'normal' );
					    break;
				    default:
					    remove_meta_box( 'revisionsdiv', 'page', 'normal' );
					    remove_meta_box( 'revisionsdiv', 'post', 'normal' );
					    break;
			    }
		    }

		    /* Slug meta box. */
		    if($devOptions['postpages_disable_mbox_slug'] != 'none') {
			    switch($devOptions['postpages_disable_mbox_slug']) {
				    case 'post':
					    remove_meta_box( 'slugdiv', 'post', 'normal' );
					    break;
				    case 'page':
					    remove_meta_box( 'slugdiv', 'page', 'normal' );
					    break;
				    default:
					    remove_meta_box( 'slugdiv', 'page', 'normal' );
					    remove_meta_box( 'slugdiv', 'post', 'normal' );
					    break;
			    }
		    }

		    /* Page attributes meta box. */
		    if($devOptions['postpages_disable_mbox_attributes'])
			    remove_meta_box( 'pageparentdiv', 'page', 'side' );

		    /* Category meta box. */
			if($devOptions['postpages_disable_mbox_category'])
				remove_meta_box( 'categorydiv', 'post', 'side' );

		    /* Excerpt meta box. */
		    if($devOptions['postpages_disable_mbox_excerpt'])
			    remove_meta_box( 'postexcerpt', 'post', 'normal' );

		    /* Post tags meta box. */
		    if($devOptions['postpages_disable_mbox_tags'])
			    remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );

		    /* Trackbacks meta box. */
		    if($devOptions['postpages_disable_mbox_trackbacks'])
			    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
	    }

	    // Smashing Magazine : http://goo.gl/cSCpy
	    function postPageEditing_page_excerpts() {
		    add_post_type_support('page', 'excerpt');
	    }




        /***************************************************************************
         *
         * @Title      : POST AND PAGE LISTING
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
	    function postPageListing_id_column_define($cols) {
		    //$cols['id'] = 'ID';

		    $in   = array("id" => "ID");
		    $cols = $this->arrayPushAfter($cols, $in, 0);
		    //$cols=array("id"=>"ID") + $cols;
		    //$cols=array_merge(array("id"=>"ID"),$cols);
		    return $cols;
	    }

	    function postPageListing_id_column_display($col_name, $id) {
		    if ($col_name == 'id') echo $id;
	    }

        function postPageListing_thumb_column_add_support() {
            $supportedTypes = get_theme_support('post-thumbnails');
            if ($supportedTypes === false) {
                add_theme_support('post-thumbnails');
            } elseif (!is_array($supportedTypes)) {
            } else {
                if (!in_array("post", $supportedTypes[0])) $supportedTypes[0][] = 'post';
                if (!in_array("page", $supportedTypes[0])) $supportedTypes[0][] = 'page';
                add_theme_support('post-thumbnails', $supportedTypes[0]);
            }
        }

        function postPageListing_thumb_column_define($cols) {

            $cols['thumbnail'] = __('Thumbnail', 'mtt');

            return $cols;
        }

        function postPageListing_thumb_column_display($column_name, $post_id) {

            $width  = (int)55;
            $height = (int)55;

            if ('thumbnail' == $column_name) {
                // thumbnail of WP 2.9
                $thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
                // image from gallery
                $attachments = get_children(array('post_parent'    => $post_id,
                                                  'post_type'      => 'attachment',
                                                  'post_mime_type' => 'image',
                                                  'orderby'        => 'menu_order'));
                if ($thumbnail_id)
                    $thumb = __('Featured','mtt').'<br>'.wp_get_attachment_image($thumbnail_id, array($width, $height), true);
                elseif ($attachments) {
                    foreach ($attachments as $attachment_id => $attachment) {
                        $thumb = __('Attached','mtt').'<br>'.wp_get_attachment_image($attachment_id, array($width, $height), true);
                    }
                }
                if (isset($thumb) && $thumb) {
                    echo $thumb;
                }
            }
        }

        function postPageListing_persistent_posts_list_mode() {

            // take into account post types that support excerpts
            $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
            if ($post_type && !post_type_supports($post_type, 'excerpt'))
                return; // don't care

            if (isset($_REQUEST['mode'])) {
                // save the list mode
                update_user_meta(get_current_user_id(), 'posts_list_mode' . $post_type, $_REQUEST['mode']);
                return;
            }

            // retrieve the list mode
            if ($mode = get_user_meta(get_current_user_id(), 'posts_list_mode' . $post_type, true))
                $_REQUEST['mode'] = $mode;
        }


	    //Add page template filter to page listing
	    //Adds a page template filter to the page listing, so you can view a list of pages that have a given template attached.
	    //stackexchange - http://goo.gl/Y9zDQ
	    function postPageListing_page_template_filter() {
		    $Page_Template_Filter = new Page_Template_Filter;
	    }


        /***************************************************************************
         *
         * @Title      : USER PROFILE
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function userProfile_contact_metods($contactmethods) {
            $devOptions = $this->getAdminOptions();

            if ($devOptions['profile_social']) {
                unset($contactmethods['aim']);
                unset($contactmethods['yim']);
                unset($contactmethods['jabber']);
                $contactmethods['facebook'] = 'Facebook';
                $contactmethods['twitter']  = 'Twitter';
                $contactmethods['linkedin'] = 'LinkedIn';
                return $contactmethods;
            } elseif ($devOptions['profile_none']) {
                unset($contactmethods['aim']);
                unset($contactmethods['yim']);
                unset($contactmethods['jabber']);
                return $contactmethods;
            }
        }


        /***************************************************************************
         *
         * @Title      : ADMIN BAR
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function adminBar_add_remove() {
            global $wp_admin_bar;

            $devOptions = get_option($this->adminOptionsName);

            if ($devOptions['adminbar_remove_comments']) $wp_admin_bar->remove_menu('comments');
            if ($devOptions['adminbar_remove_my_account']) $wp_admin_bar->remove_menu('my-account');
            if ($devOptions['adminbar_remove_updates']) $wp_admin_bar->remove_menu('updates');
            if ($devOptions['adminbar_remove_wp_logo']) $wp_admin_bar->remove_menu('wp-logo');
            if ($devOptions['adminbar_remove_new_content']) $wp_admin_bar->remove_menu('new-content');
            if ($devOptions['adminbar_remove_theme_options']) $wp_admin_bar->remove_menu('theme_options');
            if ($devOptions['adminbar_remove_site_name']) $wp_admin_bar->remove_menu('site-name');
            if ($devOptions['adminbar_remove_seo_by_yoast']) $wp_admin_bar->remove_menu('wpseo-menu');

            if ($devOptions['adminbar_custom_enable'] && $devOptions['adminbar_custom_0_title'] != '') {
                $href0 = ($devOptions['adminbar_custom_0_url'] != '') ? $devOptions['adminbar_custom_0_url'] : '#';
                $wp_admin_bar->add_menu(array(
                    'id'    => 'MTT',
                    'title' => $devOptions['adminbar_custom_0_title'],
                    'href'  => $href0
                ));
                if ($devOptions['adminbar_custom_1_title'] != '') {
                    $href1 = ($devOptions['adminbar_custom_1_url'] != '') ? $devOptions['adminbar_custom_1_url'] : '#';
                    $wp_admin_bar->add_menu(array(
                        'parent' => 'MTT',
                        'id'     => 'MTT1',
                        'title'  => $devOptions['adminbar_custom_1_title'],
                        'href'   => $href1
                    ));
                }
                if ($devOptions['adminbar_custom_2_title'] != '') {
                    $href2 = ($devOptions['adminbar_custom_2_url'] != '') ? $devOptions['adminbar_custom_2_url'] : '#';
                    $wp_admin_bar->add_menu(array(
                        'parent' => 'MTT',
                        'id'     => 'MTT2',
                        'title'  => $devOptions['adminbar_custom_2_title'],
                        'href'   => $href2
                    ));
                }
                if ($devOptions['adminbar_custom_3_title'] != '') {
                    $href3 = ($devOptions['adminbar_custom_3_url'] != '') ? $devOptions['adminbar_custom_3_url'] : '#';
                    $wp_admin_bar->add_menu(array(
                        'parent' => 'MTT',
                        'id'     => 'MTT3',
                        'title'  => $devOptions['adminbar_custom_3_title'],
                        'href'   => $href3
                    ));
                }
                if ($devOptions['adminbar_custom_4_title'] != '') {
                    $href4 = ($devOptions['adminbar_custom_4_url'] != '') ? $devOptions['adminbar_custom_4_url'] : '#';
                    $wp_admin_bar->add_menu(array(
                        'parent' => 'MTT',
                        'id'     => 'MTT4',
                        'title'  => $devOptions['adminbar_custom_4_title'],
                        'href'   => $href4
                    ));
                }
                if ($devOptions['adminbar_custom_5_title'] != '') {
                    $href5 = ($devOptions['adminbar_custom_5_url'] != '') ? $devOptions['adminbar_custom_5_url'] : '#';
                    $wp_admin_bar->add_menu(array(
                        'parent' => 'MTT',
                        'id'     => 'MTT5',
                        'title'  => $devOptions['adminbar_custom_5_title'],
                        'href'   => $href5
                    ));
                }
            }
        }

        function adminBar_site_name() {
            global $wp_admin_bar;
            $devOptions = get_option($this->adminOptionsName);

            $title = ($devOptions['adminbar_sitename_icon'] != '') ? '<img src="' . $devOptions['adminbar_sitename_icon'] . '" style="vertical-align:middle;margin:0 8px 0 6px;"/>' : '';
            $title .= ($devOptions['adminbar_sitename_title'] != '') ? $devOptions['adminbar_sitename_title'] : get_bloginfo('name');
            $url = ($devOptions['adminbar_sitename_url'] != '') ? $devOptions['adminbar_sitename_url'] : get_bloginfo('url');

            $wp_admin_bar->add_menu(array(
                'id'    => 'Site MTT',
                'title' => $title,
                'href'  => $url
            ));

        }


        /***************************************************************************
         *
         * @Title      : SHORTCODES
         * @Description:
         * @Returns    :
         *
         ****************************************************************************/
        function shortCode_youtube($atts, $content = null) {
            //$teste = get_page_by_path($atts['id'],'OBJECT','post');
            $img   = "http://i3.ytimg.com/vi/{$atts['id']}/default.jpg";
            $yt    = "http://www.youtube.com/watch_popup?v={$atts['id']}";
            $color = ($atts['color'] && $atts['color'] != '') ? ';color:' . $atts['color'] : '';
            $html  = <<<EOM
				<div class="mtt-poptube" style="text-align:center;">
				<h2 class="mtt-poptube" style="text-shadow:none;padding:0px{$color}">{$atts['title']}</h2>
				<a href="{$yt}" target="_blank"><img class="mtt-poptube" src="{$img}" style="margin-bottom:-19px"/></a><br />
				<a class="mtt-poptube button-secondary" href="{$yt}" target="_blank">{$atts['button']}</a></div>
EOM;
            return $html;
        }

        function shortCode_googledocs($attr, $content) {
            $class = ($attr['class']) ? $attr['class'] : 'google-docs-viewer';
            return '<a class="' . $class . '" href="http://docs.google.com/viewer?url=' . $attr['url'] . '" target="_blank">' . $content . '</a>';
        }

        function shortCode_soundcloud($atts, $content = null) {
            extract(shortcode_atts(array(
                "url"    => '',
                "params" => '',
                "width"  => '',
                "height" => ''
            ), $atts));

            $output = '<iframe width="' . $width . '" height="' . $height . '" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=' . urlencode($url) . '&amp;' . $this->myUrlEncode($params) . '"></iframe>';

            return $output;
        }


        /***************************************************************************
         *
         * EMAILS WARNINGS
         *
         ****************************************************************************/
	    function emailNotice_site_email_address() {
		    global $devOptions;
		    return $devOptions['email_notice_site_email_address'];
	    }

        /***************************************************************************
         *
         * MEDIA
         *
         ****************************************************************************/
        function mediaLibrary_upload_column_redefine($columns) {
            unset($columns['parent']);
            $columns['better_parent'] = __("Attached to", 'mtt');
            return $columns;
        }

        function mediaLibrary_upload_column_display($column_name, $id) {
            $post = get_post($id);
            if ($column_name != 'better_parent') return;
            if ($post->post_parent > 0) {
                if (get_post($post->post_parent)) {
                    $title = _draft_or_post_title($post->post_parent);
                }
                ?>
            <strong><a
                href="<?php echo get_edit_post_link($post->post_parent); ?>"><?php echo $title ?></a></strong>, <?php echo get_the_time(__('Y/m/d')); ?>
            <br/>
            <a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Re-Attach', 'mtt'); ?></a>
            <?php
            } else {
                ?>
            <?php _e('(Unattached)', 'mtt'); ?><br/>
            <a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;"
               href="#the-list"><?php _e('Attach', 'mtt'); ?></a>
            <?php
            }
        }

        function mediaLibrary_sharpen_resized_jpgs($resized_file) {

            $image = wp_load_image($resized_file);
            if (!is_resource($image))
                return new WP_Error('error_loading_image', $image, $file);

            $size = @getimagesize($resized_file);
            if (!$size)
                return new WP_Error('invalid_image', __('Could not read image size'), $file);
            list($orig_w, $orig_h, $orig_type) = $size;

            switch ($orig_type) {
                case IMAGETYPE_JPEG:
                    $matrix = array(
                        array(-1, -1, -1),
                        array(-1, 16, -1),
                        array(-1, -1, -1),
                    );

                    $divisor = array_sum(array_map('array_sum', $matrix));
                    $offset  = 0;
                    imageconvolution($image, $matrix, $divisor, $offset);
                    imagejpeg($image, $resized_file, apply_filters('jpeg_quality', 90, 'edit_image'));
                    break;
                case IMAGETYPE_PNG:
                    return $resized_file;
                case IMAGETYPE_GIF:
                    return $resized_file;
            }

            return $resized_file;
        }

        function mediaLibrary_size_column_define($columns) {
            $columns['dimensions'] = __('Dimensions', 'mtt');
            return $columns;
        }

        function mediaLibrary_size_column_display($column_name, $post_id) {
            if ('dimensions' != $column_name || !wp_attachment_is_image($post_id))
                return;
            list($url, $width, $height) = wp_get_attachment_image_src($post_id, 'full');
            echo "{$width}<span style=\"color:#aaa\"> &times; </span>{$height}";
        }

        function mediaLibrary_jpg_quality($arg) {
            global $devOptions;
            $num = intval($devOptions['media_jpg_quality']);
            return $num;
        }

        function mediaLibrary_oembed_adjust_youtube($html, $url, $attr) {
            if ( strpos( $html, "<embed src=" ) !== false ) {
                return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html);
            } elseif ( strpos ( $html, 'feature=oembed' ) !== false ) {
                return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html );
            } else {
                return $html;
            }
        }

	    function mediaLibrary_id_column_define($cols) {
		    $in   = array("id" => "ID");
		    $cols = $this->arrayPushAfter($cols, $in, 0);
		    return $cols;
	    }

	    function mediaLibrary_id_column_display($col_name, $post_id) {
		    if ($col_name == 'id') echo $post_id;
	    }


	    // http://code.seebz.net/p/to-permalink/
	    function mediaLibrary_sanitize_filename($str) {
		    $extension = '.' . strtolower(pathinfo($str, PATHINFO_EXTENSION));
		    $str       = preg_replace("/\\.[^.\\s]{3,4}$/", "", $str);
		    if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
			    $str = mb_convert_encoding($str, 'UTF-8');
		    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
		    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
		    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
		    $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
		    $str = strtolower(trim($str, '-'));
		    return $str . $extension;
	    }



	    /***************************************************************************
         *
         * DEVELOPER
         *
         ****************************************************************************/




    }
} //End Class ManyTips


/* START-UP */
if (class_exists("ManyTips")) {
    $bsf_manyTips = new ManyTips();
}


function mtt_handle_options_import() {

    // check file extension
    $str_file_name = $_FILES['datei']['name'];
    $str_file_ext  = explode( ".", $str_file_name );

    if ( $str_file_ext[1] != 'seq' ) {
        $addreferer = 'notexist';
    } elseif ( file_exists( $_FILES['datei']['name'] ) ) {
        $addreferer = 'exist';
    } else {
        // path for file
        $str_ziel = WP_CONTENT_DIR . '/' . $_FILES['datei']['name'];
        // transfer
        move_uploaded_file( $_FILES['datei']['tmp_name'], $str_ziel );
        // access authorisation
        chmod( $str_ziel, 0644);
        // SQL import
        ini_set( 'default_socket_timeout', 120);
        $import_file = file_get_contents( $str_ziel );

        delete_option( 'ManyTipsTogether' );
        $import_file = unserialize( $import_file );

        if ( file_exists( $str_ziel ) )
            unlink( $str_ziel );
        update_option( 'ManyTipsTogether', $import_file );
        if ( file_exists( $str_ziel ) )
            unlink( $str_ziel );

        $addreferer = 'true';
    }
    /*
   $myErrors = new mtt_handle_options_message_class();
   $myErrors = '<div id="message" class="updated fade"><p>' .
       $myErrors->get_error( 'mtt_handle_options_import' ) . '</p></div>';
   echo $myErrors;*/
}
function mtt_handle_options_export() {
    global $wpdb;

    $filename = 'many_tips_together_export-' . date( 'Y-m-d_G-i-s' ) . '.seq';

    header( "Content-Description: File Transfer");
    header( "Content-Disposition: attachment; filename=" . urlencode( $filename ) );
    header( "Content-Type: application/force-download");
    header( "Content-Type: application/octet-stream");
    header( "Content-Type: application/download");
    header( 'Content-Type: text/seq; charset=' . get_option( 'blog_charset' ), TRUE );
    flush();

    $export_data = mysql_query("SELECT option_value FROM $wpdb->options WHERE option_name = 'ManyTipsTogether'");
    $export_data = mysql_result( $export_data, 0 );
    echo $export_data;
    flush();
}

/* START ADMIN MENU */
if (!function_exists("ManyTips_ap")) {
    function ManyTips_ap() {
        global $bsf_manyTips;
        if (!isset($bsf_manyTips)) {
            return;
        }
        if ( isset( $_POST['mtt_handle_options_export'] ) ) {
            mtt_handle_options_export();
            die();
        }
        if ( ( isset($_POST['mtt_handle_options_action']) && $_POST['mtt_handle_options_action'] == 'mtt_handle_options_import')  ) {

            if ( function_exists('current_user_can') && current_user_can('manage_options') ) {
                check_admin_referer('mtt_handle_options_nonce');

                mtt_handle_options_import();
            }
        }
        if (function_exists('add_options_page')) {
            add_options_page('Many Tips Together', 'Many Tips Together', 'administrator',
                basename(__FILE__), array(&$bsf_manyTips, 'printAdminPage'));

        }
    }
}


/* EXECUTE ALL ACTIONS AND FILTERS */
if (isset($bsf_manyTips)) {

    $devOptions = $bsf_manyTips->getAdminOptions();

    global $wp_version;


    /***************************************************************************
     *
     * PLUGIN CONFIGURATION
     *
     ****************************************************************************/
    add_action('activate_many-tips-together/many-tips-together.php', array(&$bsf_manyTips, 'init'));
    add_action('admin_menu', 'ManyTips_ap');
    add_filter('plugin_action_links', array(&$bsf_manyTips, 'mttSettings_plugin_link'), 10, 2);


    /***************************************************************************
     *
     * SPECIAL JS OR CSS FOR ADMIN AREAS
     *
     ****************************************************************************/
    add_action('admin_head', array(&$bsf_manyTips, 'wpAdminHead_global'));

    add_action("admin_enqueue_scripts", array(&$bsf_manyTips, 'wpAdminHead_local'));


    /***************************************************************************
     *
     * MAINTENANCE
     *
     ****************************************************************************/
    if ($devOptions['maintenance_mode_enable']) {
        if ($devOptions['maintenance_mode_admin']) {
            add_action('admin_head', array(&$bsf_manyTips, 'maintenanceMode_activate'));
        } else {
            add_action('admin_head', array(&$bsf_manyTips, 'maintenanceMode_activate'));
            add_action('get_header', array(&$bsf_manyTips, 'maintenanceMode_activate'));
        }
    }


    /***************************************************************************
     *
     * WORDPRESS BEHAVIOR
     *
     ****************************************************************************/
    // Disable plugin update notices
    if ($devOptions['wpblock_update_plugins'])
        add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));

    // Hide update buble in Dashboard menu
    if ($devOptions['wpblock_update_wp'] && $devOptions['wpblock_update_plugins'])
        add_action('admin_menu', array(&$bsf_manyTips, 'wpBehavior_hide_update_bubble'));

    // Remove WordPress version from header
    if ($devOptions['wpdisable_version_full'])
        remove_action('wp_head', 'wp_generator');

    // Hide blog URL from WordPress 'phone home'
    if ($devOptions['wpdisable_nourl'])
        add_filter('http_headers_useragent', array(&$bsf_manyTips, 'wpBehavior_phone_home_disable'));

    if ($devOptions['wpdisable_smartquotes']) {
        remove_filter('comment_text', 'wptexturize');
        remove_filter('the_content', 'wptexturize');
        remove_filter('the_excerpt', 'wptexturize');
        remove_filter('the_title', 'wptexturize');
        remove_filter('the_content_feed', 'wptexturize');
    }

    if ($devOptions['wpdisable_capitalp']) {
        remove_filter('the_content', 'capital_P_dangit');
        remove_filter('the_title', 'capital_P_dangit');
        remove_filter('comment_text', 'capital_P_dangit');
    }

    if ($devOptions['wpdisable_autop'])
        remove_filter('the_content', 'wpautop');

    if ($devOptions['wpdisable_selfping'])
        add_action('pre_ping', array(&$bsf_manyTips, 'wpBehavior_no_self_ping'));

    if ($devOptions['wpdisable_version_full'] || $devOptions['wpdisable_version_number'])
        add_filter('the_generator', array(&$bsf_manyTips, 'wpBehavior_remove_version'));

    if ($devOptions['wpenable_google_jquery'])
        add_action('init', array(&$bsf_manyTips, 'wpBehavior_jquery_cdn'));

    if ($devOptions['wprss_delay_publish_enable'] && $devOptions['wprss_delay_publish_time'] != '')
        add_filter('posts_where', array(&$bsf_manyTips, 'wpBehavior_rss_delay_publish'));

    if ($devOptions['wpenable_custom_gravatars_enable'])
        add_filter('avatar_defaults', array(&$bsf_manyTips, 'wpBehavior_gravatars_custom'));

    if ($devOptions['wpdisable_howdy_enable']) {
	    if(version_compare($wp_version, "3.3", "<")) {
		    add_filter( 'admin_user_info_links', array(&$bsf_manyTips, 'wpBehavior_goodbye_howdy_32') );
		} else {
		    add_action( 'admin_bar_menu', array(&$bsf_manyTips, 'wpBehavior_goodbye_howdy_33') );
	    }
    }
        add_filter('avatar_defaults', array(&$bsf_manyTips, 'wpBehavior_gravatars_custom'));


    /***************************************************************************
     *
     * MANAGE DASHBOARD
     *
     ****************************************************************************/
    add_action('wp_dashboard_setup', array(&$bsf_manyTips, 'dashboardAddRemove_widgets'));


	if ($devOptions['dashboard_add_cpt_enable'])
		add_action('right_now_content_table_end', array(&$bsf_manyTips, 'dashboardAdd_right_now_cpt'));

    /***************************************************************************
     *
     * CHANGE POSTS NAME FOR WHATEVER
     *
     ****************************************************************************/
    if ($devOptions['posts_rename_enable']) {
        add_action('init', array(&$bsf_manyTips, 'changePost_object_label'));
        add_action('admin_menu', array(&$bsf_manyTips, 'changePost_menu_label'));
    }


    /***************************************************************************
     *
     * REMOVE ADMIN MENUS
     *
     ****************************************************************************/
    add_action('admin_menu', array(&$bsf_manyTips, 'adminMenus_remove'), 999);

    /***************************************************************************
     *
     * HEADER AND FOOTER
     * the hide-other-plugins options is inserted directly in header js
     *
     ****************************************************************************/
    add_action('admin_notices', array(&$bsf_manyTips, 'adminNotices_enable_disable'), 1);

    if ($devOptions['admin_notice_footer_message_enable']) {
        add_filter('admin_footer_text', array(&$bsf_manyTips, 'adminNotices_footer_left'));
        add_filter('update_footer', array(&$bsf_manyTips, 'adminNotices_footer_right'), 11);
    }

	if ($devOptions['admin_notice_footer_hide'])
		add_filter('admin_print_styles', array(&$bsf_manyTips, 'adminNotices_footer_hide'));


    /***************************************************************************
     *
     * MEDIA
     *
     ****************************************************************************/
    if ($devOptions['media_better_attachment']) {
        add_filter("manage_upload_columns", array(&$bsf_manyTips, 'mediaLibrary_upload_column_redefine'));
        add_action("manage_media_custom_column", array(&$bsf_manyTips, 'mediaLibrary_upload_column_display'), 0, 2);
    }

    if ($devOptions['media_jpg_sharpen'])
        add_filter('image_make_intermediate_size', array(&$bsf_manyTips, 'mediaLibrary_sharpen_resized_jpgs'), 900);

    if ($devOptions['media_sanitize_filename'])
        add_filter('sanitize_file_name', array(&$bsf_manyTips, 'mediaLibrary_sanitize_filename'), 10);

    if ($devOptions['media_adjust_youtube_oembed_enable'])
        add_filter( 'embed_oembed_html', array(&$bsf_manyTips, 'mediaLibrary_oembed_adjust_youtube'), 10, 3);

	if ($devOptions['media_image_id_column_enable']) {
		add_filter( 'manage_upload_columns', array(&$bsf_manyTips, 'mediaLibrary_id_column_define') );
		add_action( 'manage_media_custom_column', array(&$bsf_manyTips, 'mediaLibrary_id_column_display'), 10, 2);
	}

    if ($devOptions['media_image_size_column_enable']) {
        add_filter('manage_upload_columns', array(&$bsf_manyTips, 'mediaLibrary_size_column_define'));
        add_action('manage_media_custom_column', array(&$bsf_manyTips, 'mediaLibrary_size_column_display'), 10, 2);
    }

    if ($devOptions['media_jpg_quality'] != '' && $devOptions['media_jpg_quality'] != '0')
        add_filter('jpeg_quality', array(&$bsf_manyTips, 'mediaLibrary_jpg_quality'));


    /***************************************************************************
     *
     * EMAILS WARNINGS
     *
     ****************************************************************************/
    if ($devOptions['email_notice_plain_html'])
        add_filter ('wp_mail_content_type', create_function('$changeContentType', 'return "text/html";'));

    if ($devOptions['email_notice_site_email_address'] != '')
        add_filter ('wp_mail_from', array(&$bsf_manyTips, 'emailNotice_site_email_address'), 0);

    if ($devOptions['email_notice_from_name'] != '')
        add_filter ('wp_mail_from_name', create_function('$changeFromName', 'return ' . $devOptions['email_notice_from_name'] . ';'), 0);



    /***************************************************************************
     *
     * POST AND PAGE LISTINGS
     *
     ****************************************************************************/
    if ($devOptions['postpageslist_enable_id_column']) {
        add_action('manage_pages_custom_column', array(&$bsf_manyTips, 'postPageListing_id_column_display'), 10, 2);
        add_action('manage_posts_custom_column', array(&$bsf_manyTips, 'postPageListing_id_column_display'), 10, 2);
        add_filter('manage_pages_columns', array(&$bsf_manyTips, 'postPageListing_id_column_define'));
        add_filter('manage_posts_columns', array(&$bsf_manyTips, 'postPageListing_id_column_define'));
    }

    if ($devOptions['postpageslist_enable_thumb_column']) {
        add_filter('manage_posts_columns', array(&$bsf_manyTips, 'postPageListing_thumb_column_define'));
        add_action('manage_posts_custom_column', array(&$bsf_manyTips, 'postPageListing_thumb_column_display'), 10, 2);
        add_filter('manage_pages_columns', array(&$bsf_manyTips, 'postPageListing_thumb_column_define'));
        add_action('manage_pages_custom_column', array(&$bsf_manyTips, 'postPageListing_thumb_column_display'), 10, 2);
        add_action('after_setup_theme', array(&$bsf_manyTips, 'postPageListing_thumb_column_add_support'), 11);

    }

    if (version_compare($wp_version, "3.5", "<") && $devOptions['postpageslist_persistent_list_view'])
        add_action('load-edit.php', array(&$bsf_manyTips, 'postPageListing_persistent_posts_list_mode'));

    if ($devOptions['postpageslist_template_filter_enable'])
        add_action('admin_init', array(&$bsf_manyTips, 'postPageListing_page_template_filter'));


    /***************************************************************************
     *
     * POSTS AND PAGES EDITING
     *
     ****************************************************************************/
    $postRevision = ($devOptions['postpages_post_revision'] != "-1" && $devOptions['postpages_post_revision'] != "") ? true : false;
    if ($postRevision)
        define('WP_POST_REVISIONS', (int)$devOptions['postpages_post_revision']);

    $postAutosave = ($devOptions['postpages_post_autosave'] != "1" && $devOptions['postpages_post_autosave'] != "") ? true : false;
    if ($postAutosave)
        define('AUTOSAVE_INTERVAL', 60 * (int)$devOptions['postpages_post_autosave']);

    if ($devOptions['postpages_enable_page_excerpts'])
        add_action('init', array(&$bsf_manyTips, 'postPageEditing_page_excerpts'));

    if ($devOptions['postpages_move_author_metabox']) {
        add_action('admin_menu', array(&$bsf_manyTips, 'postPageEditing_autor_metabox_remove'));
        add_action('post_submitbox_misc_actions', array(&$bsf_manyTips, 'postPageEditing_autor_metabox_move'));
    }

	if ($devOptions['postpages_move_comments_metabox']) {
		add_action('add_meta_boxes', array(&$bsf_manyTips, 'postPageEditing_comments_metabox_remove'));
		add_action('post_submitbox_misc_actions', array(&$bsf_manyTips, 'postPageEditing_comments_metabox_move'));
	}

	add_action( 'add_meta_boxes', array(&$bsf_manyTips, 'postPageEditing_all_metabox_remove') );



    /***************************************************************************
     *
     * LOGOUT AND LOGIN
     *
     ****************************************************************************/
    $logout = ($devOptions['logout_redirect_enable'] != "0" && $devOptions['logout_redirect_enable'] != "") ? true : false;
    if ($logout)
        add_action('wp_logout', array(&$bsf_manyTips, 'logOut_redirect_url'));

    // START LOGIN
    $loginpage_logo_tooltip = ($devOptions['loginpage_logo_tooltip'] != "") ? true : false;
    if ($loginpage_logo_tooltip)
        add_filter('login_headertitle', array(&$bsf_manyTips, 'logIn_logo_title'));

    // Login Screen
    add_action('login_head', array(&$bsf_manyTips, 'logIn_css_make'));

    // Custom message for login errors
    if ($devOptions['loginpage_errors']) {
        $errorMsg = "return '" . esc_html(stripslashes($devOptions['loginpage_error_msg'])) . "';";
        add_filter('login_errors', create_function('$a', $errorMsg));
    }
    // Custom URL for Logo in login page
    if ($devOptions['loginpage_logo_url'])
        add_filter('login_headerurl', array(&$bsf_manyTips, 'logIn_custom_link'));


    /***************************************************************************
     *
     * PLUGINS
     *
     ****************************************************************************/
	if ($devOptions['plugins_acf_hide_options'])
		add_action( 'admin_menu', function() {
			if (! current_user_can('delete_plugins')) {
				remove_menu_page('acf-options');
			}
		});


    /***************************************************************************
     *
     * USER PROFILE
     *
     ****************************************************************************/
    if ($devOptions['profile_social'] || $devOptions['profile_none'])
        add_filter('user_contactmethods', array(&$bsf_manyTips, 'userProfile_contact_metods'));

    if ($devOptions['profile_slim'])
        remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");

    if ($devOptions['adminbar_disable'])
        add_filter('show_admin_bar', '__return_false');


    /***************************************************************************
     *
     * ADMIN BAR
     *
     ****************************************************************************/
    if ($devOptions['adminbar_remove_comments'] || $devOptions['adminbar_remove_my_account'] || $devOptions['adminbar_remove_updates'] || $devOptions['adminbar_remove_wp_logo'] || $devOptions['adminbar_remove_new_content'] || $devOptions['adminbar_remove_theme_options'] || $devOptions['adminbar_remove_site_name'] || $devOptions['adminbar_custom_enable'])
        add_action('wp_before_admin_bar_render', array(&$bsf_manyTips, 'adminBar_add_remove'), 0);

    if ($devOptions['adminbar_sitename_enable'])
        add_action('admin_bar_menu', array(&$bsf_manyTips, 'adminBar_site_name'), 10);


    /***************************************************************************
     *
     * WIDGETS
     *
     ****************************************************************************/
    add_action('widgets_init', array(&$bsf_manyTips, 'widgetsEnable_and_disable'), 1);

	if ($devOptions['widget_remove_akismet'])
		add_action( 'init', array(&$bsf_manyTips, 'widgetsDisable_akismet'));

    if (!is_admin() && $devOptions['widget_text_enable_shortcodes']) {
        add_filter('widget_text', 'do_shortcode', 11);
    }

    if ($devOptions['widget_rss_update_timer'] != '') {
        $num = (int)$devOptions['widget_rss_update_timer'] * 60;
        add_filter('wp_feed_cache_transient_lifetime', create_function('$fixrss', 'return ' . $num . ';'));
    }


    /***************************************************************************
     *
     * SHORTCODES
     *
     ****************************************************************************/
    if ($devOptions['shortcodes_tube'])
        add_shortcode('poptube', array(&$bsf_manyTips, 'shortCode_youtube'));

    if ($devOptions['shortcodes_scloud'])
        add_shortcode('soundcloud', array(&$bsf_manyTips, 'shortCode_soundcloud'));

    if ($devOptions['shortcodes_gdocs'])
        add_shortcode('gdocs', array(&$bsf_manyTips, 'shortCode_googledocs'));


    /***************************************************************************
     *
     * DEVELOPER
     *
     ****************************************************************************/


    // ************************************************************************
    // DATABASE OPTIMIZATION, MANUAL ACTIVATION
    // ************************************************************************

    /*
        Activated only once.
        Uncomment the "register_activation_hook" line
        and the "register_deactivation_hook" bellow,
        and finally disable/enable the plugin
     */

    // register_activation_hook(__FILE__, array(&$bsf_manyTips, 'optimizeDatabase_cron_on'));

    /*
        Deactivate on plugin-off.
        If you actived the optimization above,
        uncomment the next line too
     */

    // register_deactivation_hook(__FILE__, array(&$bsf_manyTips, 'optimizeDatabase_cron_off'));


}
?>