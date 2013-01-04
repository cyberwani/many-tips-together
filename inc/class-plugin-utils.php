<?php
!defined( 'ABSPATH' ) AND exit;

/**
 * MTT utilities
 * version 2012.12.24
 */
if( !class_exists( 'MTT_Plugin_Utils' ) ):

    class MTT_Plugin_Utils
    {
    
        public static $default_options = array (
            'adminbar_completely_disable' => false,
            'adminbar_disable' => false,
            'adminbar_howdy_enable' => 
            array (
              'howdy' => '',
            ),
            'adminbar_sitename_enable' => 
            array (
              'adminbar_sitename_title' => '',
              'adminbar_sitename_icon' => 
              array (
                'id' => '',
                'src' => '',
              ),
              'adminbar_sitename_url' => '',
            ),
            'adminbar_custom_enable' => 
            array (
              'adminbar_custom_0_title' => '',
              'adminbar_custom_0_url' => '',
              'adminbar_custom_1_title' => '',
              'adminbar_custom_1_url' => '',
              'adminbar_custom_2_title' => '',
              'adminbar_custom_2_url' => '',
              'adminbar_custom_3_title' => '',
              'adminbar_custom_3_url' => '',
              'adminbar_custom_4_title' => '',
              'adminbar_custom_4_url' => '',
              'adminbar_custom_5_title' => '',
              'adminbar_custom_5_url' => '',
            ),
            'admin_menus_hover' => true,
            'posts_rename_enable' => 
            array (
              'name' => '',
              'singular_name' => '',
              'add_new' => '',
              'edit_item' => '',
              'view_item' => '',
              'search_items' => '',
              'not_found' => '',
              'not_found_in_trash' => '',
            ),
            'appearance_clean_admin' => false,
            'appearance_adminbar_colors' => false,
            'admin_notice_header_settings_enable' => 
            array (
              'text' => '',
            ),
            'admin_notice_header_allpages_enable' => 
            array (
              'text' => '',
            ),
            'admin_notice_footer_hide' => false,
            'admin_notice_footer_message_enable' => 
            array (
              'admin_notice_footer_message_left' => '',
              'admin_notice_footer_message_right' => '',
            ),
            'dashboard_add_cpt_enable' => false,
            'dashboard_remove_footer_rightnow' => false,
            'dashboard_mtt1_enable' => 
            array (
              'dashboard_mtt1_title' => '',
              'dashboard_mtt1_content' => '',
            ),
            'dashboard_mtt2_enable' => 
            array (
              'dashboard_mtt2_title' => '',
              'dashboard_mtt2_content' => '',
            ),
            'dashboard_mtt3_enable' => 
            array (
              'dashboard_mtt3_title' => '',
              'dashboard_mtt3_content' => '',
            ),
            'wpdisable_version_full' => false,
            'wpdisable_version_number' => false,
            'wpblock_update_wp' => false,
            'wpblock_update_screen' => false,
            'wpdisable_nourl' => false,
            'wpdisable_selfping' => false,
            'wpdisable_redirect_disallow' => false,
            'wptaxonomy_columns' => false,
            'wprss_delay_publish_enable' => 
            array (
              'time' => '',
              'period' => 'MINUTE',
            ),
            'wpenable_custom_gravatars_enable' => 
            array (
              'img' => 
              array (
                'id' => '',
                'src' => '',
              ),
            ),
            'wpdisable_smartquotes' => false,
            'wpdisable_capitalp' => false,
            'wpdisable_autop' => false,
            'login_redirect_enable' => 
            array (
              'url' => '',
            ),
            'logout_redirect_enable' => 
            array (
              'url' => '',
            ),
            'loginpage_errors' => 
            array (
              'msg' => '',
            ),
            'loginpage_disable_shaking' => false,
            'loginpage_form_noshadow' => false,
            'loginpage_form_border' => false,
            'loginpage_form_bg_color' => '#',
            'loginpage_body_color' => '#',
            'loginpage_body_position' => 'empty',
            'loginpage_body_repeat' => 'empty',
            'loginpage_body_attachment' => 'empty',
            'loginpage_backsite_hide' => false,
            'loginpage_text_shadow' => false,
            'loginpage_extra_css' => '.class-name {}',
            'maintenance_mode_enable' => 
            array (
              'title' => '',
              'line0' => '',
              'line1' => '',
              'line2' => '',
              'html_img' => 
              array (
                'id' => '',
                'src' => '',
              ),
              'body_img' => 
              array (
                'id' => '',
                'src' => '',
              ),
              'level' => 'Administrator',
              'extra_css' => '.class-name {}',
            ),
            'media_sanitize_filename' => false,
            'media_image_id_column_enable' => false,
            'media_image_size_column_enable' => false,
            'media_image_thubms_list_column_enable' => false,
            'media_add_size_to_upload_window' => false,
            'media_better_attachment' => false,
            'media_jpg_sharpen' => false,
            'plugins_block_update_notice' => false,
            'plugins_block_update_inactive_plugins' => false,
            'plugins_remove_plugin_edit' => false,
            'plugins_remove_description' => false,
            'plugins_remove_plugin_notice' => false,
            'plugins_add_last_updated' => false,
            'plugins_inactive_bg_color' => '#',
            'plugins_my_plugins_bg_color' => 
            array (
              'names' => '',
              'color' => '#',
            ),
            'postpages_enable_page_excerpts' => false,
            'postpages_move_author_metabox' => false,
            'postpages_move_comments_metabox' => false,
            'postpages_disable_mbox_author' => 'none',
            'postpages_disable_mbox_comment_status' => 'none',
            'postpages_disable_mbox_comment' => 'none',
            'postpages_disable_mbox_custom_fields' => 'none',
            'postpages_disable_mbox_featured_image' => 'none',
            'postpages_disable_mbox_revisions' => 'none',
            'postpages_disable_mbox_slug' => 'none',
            'postpages_disable_mbox_attributes' => false,
            'postpages_disable_mbox_format' => false,
            'postpages_disable_mbox_category' => false,
            'postpages_disable_mbox_excerpt' => false,
            'postpages_disable_mbox_tags' => false,
            'postpages_disable_mbox_trackbacks' => false,
            'postpageslist_persistent_list_view' => false,
            'postpageslist_template_filter_enable' => false,
            'postpageslist_duplicate_del_revisions' => false,
            'postpageslist_enable_id_column' => false,
            'postpageslist_enable_thumb_column' => 
            array (
              'proportion' => '',
              'width' => '',
            ),
            'postpageslist_status_draft' => '#',
            'postpageslist_status_pending' => '#',
            'postpageslist_status_future' => '#',
            'postpageslist_status_private' => '#',
            'postpageslist_status_password' => '#',
            'postpageslist_status_others' => '#',
            'profile_h3_titles' => false,
            'profile_descriptions' => false,
            'profile_slim' => false,
            'profile_hidden' => false,
            'profile_display_name' => false,
            'profile_nickname' => false,
            'profile_website' => false,
            'profile_social' => false,
            'profile_none' => false,
            'profile_bio' => false,
            'profile_css' => '.class-name {}',
            'shortcodes_everywhere' => false,
            'shortcodes_tube' => false,
            'shortcodes_scloud' => false,
            'shortcodes_gdocs' => false,
            'widget_meta_slim' => false,
            'multisite_active_plugins_widget' => false,
            'multisite_site_id_column' => false,
            'multisite_blogname_column' => false,
            'multisite_redirect_new_site' => false,
            'multisite_sort_sites_names' => false,
          );

        /**
         * Get all users by user_login=>display_name
         * 
         * @param  many $field Value of the custom field
         * @param  str  $name  Name of property
         * @param  str  $type  Type of custom field
         * @return prints Html/JS code
         */
        public static function get_users_array()
        {
            $default = array( 'none'    => 'None' );
            $user_arr = array( );
            $users = get_users();
            if( count( $users ) > 1 )
            {
                foreach( $users as $user )
                {
                    $user_arr[$user->data->user_login] = ucwords( $user->data->display_name );
                }
            }
            else
            {
                return false;
            }

            return array_merge( $default, $user_arr );
        }


        public static function check_url( $url, $allow_dash = false )
        {
            if( $allow_dash && $url == "#" )
                return true;

            return filter_var( $url, FILTER_VALIDATE_URL );
        }


        public static function array_push_after( $src, $in, $pos )
        {
            if( is_int( $pos ) )
                $R = array_merge( array_slice( $src, 0, $pos + 1 ), $in, array_slice( $src, $pos + 1 ) );
            else
            {
                foreach( $src as $k => $v )
                {
                    $R[$k] = $v;
                    if( $k == $pos )
                        $R     = array_merge( $R, $in );
                }
            }
            return $R;
        }


        public static function maintenance_user_level( $opt=null )
        {
            $level = 'delete_plugins';
            if( $opt == 'Editor' )
                $level = 'delete_pages';
            elseif( $opt == 'Author' )
                $level = 'publish_posts';
            elseif( $opt == 'Contributor' )
                $level = 'delete_posts';
            elseif( $opt == 'Subscriber' )
                $level = 'read';
            return $level;
        }


// USED BY shortCode_soundcloud SHORTCODE
        public static function url_encode( $string )
        {
            $entities = array( '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D' );
            $replacements = array( '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]" );
            return str_replace( $entities, $replacements, urlencode( $string ) );
        }


        /* Used by get_repository_info */

        public static function formatRating( $number, $cents = 1 )
        {
// cents: 0=never, 1=if needed, 2=always
            if( is_numeric( $number ) )
            {
                if( !$number )
                {
                    $rating = ($cents == 2) ? '0.00' : '0';
                }
                else
                {
                    if( floor( $number ) == $number )
                    {
                        $rating = number_format( $number, ($cents == 2 ? 2 : 0 ) );
                    }
                    else
                    {
                        $rating = number_format( round( $number, 2 ), ($cents == 0 ? 0 : 2 ) );
                    }
                }
                return $rating;
            }
        }


        /**
         * Function name grabbed from: http://core.trac.wordpress.org/ticket/22624
         * 2 lines of code from TutPlus: http://goo.gl/X4lmf
         * 
         * Usage: current_user_has_role( 'editor' );
         */
        public static function current_user_has_role( $role )
        {
            $current_user = new WP_User( wp_get_current_user()->ID );
            $user_roles   = $current_user->roles;
            $is_or_not    = in_array( $role, $user_roles );
            return $is_or_not;
        }


        /**
         * Modified to work with Array
         */
        public static function current_user_has_role_array( $role )
        {
            $current_user = new WP_User( wp_get_current_user()->ID );
            $user_roles   = $current_user->roles;
            $arrtolower = array_map( 'strtolower', $role );
            $search     = array_intersect( $user_roles, $arrtolower );
            if( count( $search ) > 0 )
                return true;
            return false;
        }


        /**
         * Helper for making external links
         *
         * @param str  $name  Name of the link
         * @param str  $url   Address of the link
         * @param bool $blank Open in new window
         * @return str Html content
         */
        public static function make_tip_credit( $name, $url, $blank = true )
        {
            $target = $blank ? 'target="_blank"' : '';
            $html   = '<a href="' . $url . '" ' . $target . '>' . $name . '</a>';
            return $html;
        }


        public static function get_repository_info()
        {

            $plugin_url = 'http://wpapi.org/api/plugin/many-tips-together.json';

            $cache = get_transient( 'mttdlcounter2' );
            if( false !== $cache )
                return $cache;

            // Fetch the data
            if( $response = wp_remote_retrieve_body( wp_remote_get( $plugin_url ) ) )
            {
                // Decode the json response
                if( $response = json_decode( $response, true ) )
                {
                    // Double check we have all our data
                    if( !empty( $response['added'] ) )
                    {
                        set_transient( 'mttdlcounter2', $response, 720 );
                        return $response;
                    }
                }
            }
            return false;
        }


        public static function print_repository_info( $echo = true )
        {
            $mttotal = self::get_repository_info();
            if( false === $mttotal )
                return;

            $total_downloads = number_format_i18n( $mttotal['total_downloads'] );
            //$rating          = self::formatRating( $mttotal['rating'] / 20 );
            $updated         = date_i18n( get_option( 'date_format' ), strtotime( $mttotal['updated'] ) );
            $num_rating      = number_format_i18n( $mttotal['num_ratings'] );
            $tot             = __( 'Downloads', 'mtt' );
            $totr            = sprintf( __( '%s votes', 'mtt' ), $num_rating );
            $upd             = __( 'Updated', 'mtt' );
            $img1            = plugins_url( 'many-tips-together' ) . '/images/star_x_grey.gif';
            $img2            = plugins_url( 'many-tips-together' ) . '/images/star_x_orange.gif';

            $rat = $mttotal['rating'] . '%';
            if( !$echo )
                return $mttotal;

            $print = <<<HTML
		    <div style="float:right;text-align:right"><div style="width:55px;background:url($img1) 0 0 repeat-x;">
<div style="height: 12px; background: url($img2) repeat-x scroll 0px 0px transparent; width: $rat "></div>$totr</div>
</div>
			<span style="color:#b0b0b0">$tot:</span> <em style="color:#ccbb8d;">$total_downloads</em><br>
		    <span style="color:#b0b0b0">$upd:</span> <em style="color:#ccbb8d;">$updated</em>
HTML;
            echo $print;
        }


        /**
         * Validate CSS numbers, strips 'px' from string
         * 
         * @param string $val
         * @return int/boolean False or Integer without decimals
         */
        public static function validate_css_number( $val )
        {
            $num    = str_replace( 'px', '', $val );
            $number = str_replace( '%', '', $num );

            if( is_numeric( $number ) )
                return (int) $number;

            return false;
        }


        /**
         * Validate CSS numbers, keeps 'px' and '%' in the string
         * 
         * @param string $val
         * @return int/boolean False or Integer without decimals and sign
         */
        public static function validate_css_px_percent( $val )
        {

            if( self::endswith( $val, '%' ) )
            {
                $num = str_replace( '%', '', $val );
                if( is_numeric( $num ) )
                    return (int) $num . '%';
                else
                    return false;
            }
            elseif( self::endswith( $val, 'px' ) )
            {
                $num = str_replace( 'px', '', $val );
                if( is_numeric( $num ) )
                    return (int) $num . 'px';
                else
                    return false;
            }
            else
            {
                return false;
            }
        }


        private static function endswith( $string, $test )
        {
            $strlen  = strlen( $string );
            $testlen = strlen( $test );
            if( $testlen > $strlen )
                return false;
            return substr_compare( $string, $test, -$testlen ) === 0;
        }


    }

    endif;
