<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_General' ) ):

    class MTT_Hook_General
    {
        // store the options
        protected $params;

        /**
         * Check options and dispatch hooks
         * 
         * @param  array $options
         * @return void
         */
        public function __construct( $options )
        {

            $this->params = $options;
            
            // REMOVE/MODIFY WP VERSION
            if( 
                    !empty( $options['wpdisable_version_full'] ) 
                    or !empty( $options['wpdisable_version_number'] ) 
                )
                add_filter( 
                        'the_generator', 
                        array( $this, 'remove_version' ) 
                );

            // HIDE UPDATE BUBLE IN DASHBOARD MENU
            if( !empty( $options['wpblock_update_wp'] ) && !empty( $options['wpblock_update_plugins'] ) )
                add_action( 
                        'admin_menu', 
                        array( $this, 'hide_update_bubble' ) 
                );

            // HIDE WP UPDATE NOTICE
            if( !empty( $options['wpblock_update_wp'] ) )
                add_action( 
                        'admin_footer', 
                        array( $this, 'hide_wp_update_nag' ) 
                );

            // REDIRECT FROM UPDATED SCREEN
            if( !empty( $this->params['wpblock_update_screen'] ) )
                add_action( 
                        'admin_head-about.php', 
                        array( $this, 'redirect_update_screen') 
                );

            // HIDE BLOG URL FROM WORDPRESS 'PHONE HOME'
            if( !empty( $options['wpdisable_nourl'] ) )
            {
                add_filter( 
                        'http_headers_useragent', 
                        array( $this, 'phone_home_disable' ) 
                );
                add_filter( 
                        'http_request_args', 
                        array( $this, 't5_anonymize_ua_string' ) 
                );
            }

            // ADD ID AND POST COUNT TO TAXONOMIES
            if( !empty( $options['wptaxonomy_columns'] ) )
                add_action( 
                        'admin_init', 
                        array( $this, 'tax_ids_make' ) 
                );

            // REMOVE SMART QUOTES
            if( !empty( $options['wpdisable_smartquotes'] ) )
            {
                remove_filter( 'comment_text', 'wptexturize' );
                remove_filter( 'the_content', 'wptexturize' );
                remove_filter( 'the_excerpt', 'wptexturize' );
                remove_filter( 'the_title', 'wptexturize' );
                remove_filter( 'the_content_feed', 'wptexturize' );
            }

            // REMOVE CAPITAL P
            if( !empty( $options['wpdisable_capitalp'] ) )
            {
                remove_filter( 'the_content', 'capital_P_dangit' );
                remove_filter( 'the_title', 'capital_P_dangit' );
                remove_filter( 'comment_text', 'capital_P_dangit' );
            }

            // REMOVE AUTO P
            if( !empty( $options['wpdisable_autop'] ) )
                remove_filter( 'the_content', 'wpautop' );

            // DISABLE SELF PING
            if( !empty( $options['wpdisable_selfping'] ) )
                add_action( 
                        'pre_ping', 
                        array( $this, 'no_self_ping' ) 
                );

            // REDIRET HOME ON ACCESS DENIED
            if( !empty( $options['wpdisable_redirect_disallow'] ) )
                add_action( 
                        'admin_page_access_denied', 
                        array( $this, 'access_denied' ) 
                );

            // DELAY RSS PUBLISH UPDATE
            if( !empty( $this->params['wprss_delay_publish_enable']['enabled'] ) )
                add_filter( 
                        'posts_where', 
                        array( $this, 'rss_delay_publish' ) 
                );

            // ENABLE CUSTOM GRAVATARS
            if( !empty( $this->params['wpenable_custom_gravatars_enable']['enabled'] ) )
                add_filter( 
                        'avatar_defaults', 
                        array( $this, 'gravatars_custom' ) 
                );
        }
        

        /**
         * Modify site generator
         * 
         * @return string
         */
        public function remove_version()
        {
            // = $this->getAdminOptions();
            if( !empty( $this->params['wpdisable_version_full'] ) )
                return;
            elseif( !empty( $this->params['wpdisable_version_number'] ) )
                return '<meta name="generator" content="WordPress" />';

            return;
        }

        
        /**
         * Hide update bubble
         * 
         * @global string $submenu
         */
        public function hide_update_bubble()
        {
            global $submenu; //$menu,

            if( isset( $submenu['index.php'][10] ) )
                $submenu['index.php'][10][0] = 'Updates';
        }


        /**
         * Forcefull hide WordPress update notice
         * 
         * TODO: seems that normal techniques are not working (?)
         */
        public function hide_wp_update_nag()
        {
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    jQuery("div.update-nag:has(a:contains('WordPress'))").hide();
                });
            </script>  
            <?php

        }


        /**
         * Redirect from update screen
         * 
         * @return type
         */
        public function redirect_update_screen()
        {
            if( !isset( $_GET['updated'] ) )
                return;

            wp_redirect( admin_url() );
            exit;
        }
        
        
        /**
         * Disable phone home
         * 
         * @global type $wp_version
         * @param type $default
         * @return type
         */
        public function phone_home_disable( $default )
        {
            global $wp_version;
            return 'WordPress/' . $wp_version;
        }


        /**
         * Replace the UA string.
         * http://wordpress.stackexchange.com/a/64053/12615
         *
         * @param  array $args Request arguments
         * @return array
         */
        function t5_anonymize_ua_string( $args )
        {
           global $wp_version;
           $args['user-agent'] = 'WordPress/' . $wp_version;

           // catch data set by wp_version_check()
           if ( isset ( $args['headers']['wp_install'] ) )
           {
               $args['headers']['wp_install'] = 'http://example.com';
               $args['headers']['wp_blog']    = 'http://example.com';
           }
           return $args;
        }
        
        
        /**
         * No self-ping
         * 
         * @param type $links
         */
        public function no_self_ping( &$links )
        {
            $home = home_url();
            foreach( $links as $l => $link )
                if( 0 === strpos( $link, $home ) )
                    unset( $links[$l] );
        }


        /**
         * Modify RSS update period
         * 
         * TODO: validate number and use default if empty
         * 
         * @global type $wpdb
         * @param type $where
         * @return type
         */
        public function rss_delay_publish( $where )
        {
            global $wpdb;

            if( is_feed() )
            {
                $now    = gmdate( 'Y-m-d H:i:s' );
                $wait   = $this->params['wprss_delay_publish_enable']['time']; // integer
                // http://dev.mysql.com/doc/refman/5.0/en/date-and-time-public functions.html#public function_timestampdiff
                $device = $this->params['wprss_delay_publish_enable']['period']; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR
                // add SQL-sytax to default $where
                $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
            }
            return $where;
        } 

        
        /**
         * Redirect unauthorized access attempts
         */
        public function access_denied()
        {
            wp_redirect( home_url() );
            exit();
        }


        /**
         * Change default avatars
         * 
         * TODO: not working
         * ----- http://wordpress.stackexchange.com/questions/72578/set-default-avatar-network-wide
         * -----
         * 
         * @param type $avatar_defaults
         * @return type
         */
        public function gravatars_custom( $avatar_defaults )
        {
            $fasticon      = ' <small><em>(icon by: <a href="http://www.fasticon.com/" target="_blank">fasticon.com</a>)</em></small>';
            $useravat      = !empty( $this->params['wpenable_custom_gravatars_enable']['img']['src'] ) 
                    ? $this->params['wpenable_custom_gravatars_enable']['img']['src'] 
                    : false;
            
            unset( $avatar_defaults );
            
            $avat1         = MTT_Plugin_Init::get_url() . "images/avatar1.png";
            $avat2         = MTT_Plugin_Init::get_url() . "images/avatar2.png";
            $avat3         = MTT_Plugin_Init::get_url() . "images/avatar3.png";
            //loga($avat1);
            if( $useravat )
                $avat4         = $useravat;
            
            $bavat[$avat1] = 'Glasses Creature' . $fasticon;
            $bavat[$avat2] = 'Red Creature' . $fasticon;
            $bavat[$avat3] = 'Black Power' . $fasticon;
            
            if( $useravat )
                $bavat[$avat4] = get_option( 'blogname' );

            $avatar_defaults = $bavat;

            // best way i found to get rid of the 'mystery' default
            $default     = get_option( 'avatar_default' );
            $new_default = !empty( $this->params['wpenable_custom_gravatars_enable']['img']['src'] ) ? $avat4 : $avat1;
            
            if( empty( $default ) || $default == 'mystery' )
                update_option( 'avatar_default', $new_default );

            return $avatar_defaults;
        }


        /**
         * Add hook for taxonomy ID columns
         */
        public function tax_ids_make()
        {
            foreach( get_taxonomies() as $taxonomy )
            {
                add_action( "manage_edit-${taxonomy}_columns", array( $this, 't5_add_col' ) );
                add_filter( "manage_edit-${taxonomy}_sortable_columns", array( $this, 't5_add_col' ) );
                add_filter( "manage_${taxonomy}_custom_column", array( $this, 't5_show_id'), 10, 3 );
            }
            add_action( 'admin_print_styles-edit-tags.php', array( $this, 't5_tax_id_style' ) );
        }


        /**
         * Register custom ID column
         * @param type $columns
         * @return type
         */
        public function t5_add_col( $columns )
        {
            $in = array( "tax_id" => "ID" );
            $columns = MTT_Plugin_Utils::array_push_after( $columns, $in, 0 );
            return $columns;
        }


        /**
         * Display custom ID/Post column
         * 
         * @global type $wp_list_table
         * @param type $v
         * @param type $name
         * @param type $id
         * @return type
         */
        public function t5_show_id( $v, $name, $id )
        {
            global $wp_list_table;
            return 'tax_id' === $name ? $id : $v;
        }


        /**
         * Print taxonomy columns style
         */
        public function t5_tax_id_style()
        {
            print '<style>#tax_id{width:4em}</style>';
        }

    }

    

    
endif;
