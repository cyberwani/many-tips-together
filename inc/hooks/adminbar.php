<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_Adminbar' ) ):

    class MTT_Hook_Adminbar
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

            // DISABLE COMPLETELY
            if( !empty( $options['adminbar_completely_disable'] ) )
            {
                add_action( 
                        'init', 
                        array( $this, 'fb_remove_admin_bar' ), 
                        0 
                );
                add_action( 
                        'admin_menu', 
                        array( $this, 'menu_visit_site' ) 
                );

                // No other action needed, bail out
                return;
            }

            // DISABLE IN FRONT END
            if( !empty( $options['adminbar_disable'] ) )
                add_filter( 
                        'show_admin_bar', 
                        '__return_false' 
                );

            // MODIFY HOWDY
            if( !empty( $options['adminbar_howdy_enable']['enabled'] ) )
                add_action( 
                        'admin_bar_menu', 
                        array( $this, 'goodbye_howdy' ) 
                );

            // REMOVE ITEMS
            if( !empty( $options['adminbar_remove'] ) )
                add_action( 
                        'wp_before_admin_bar_render', 
                        array( $this, 'remove_items' ) 
                );

            // NEW SITE NAME
            if( !empty( $options['adminbar_sitename_enable']['enabled'] ) )
                add_action( 
                        'admin_bar_menu', 
                        array( $this, 'site_name' ), 
                        10 
                );

            // ADD CUSTOM ITEMS
            if( !empty( $options['adminbar_custom_enable']['enabled'] ) )
                add_action( 
                        'admin_bar_menu', 
                        array( $this, 'custom_menu' ), 
                        10 
                );
        }


        /**
         * Completely remove the Admin Bar
         * 
         * by Frank Bueltge
         * http://wordpress.stackexchange.com/a/77648/12615
         */
        function fb_remove_admin_bar()
        {
            wp_deregister_script( 'admin-bar' );
            wp_deregister_style( 'admin-bar' );
            remove_action( 'init', '_wp_admin_bar_init' );
            remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
            remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
            // maybe also: 'wp_head'
            foreach( array( 'admin_head', 'wp_head' ) as $hook )
                add_action( $hook, array( $this, 'hide_admin_bar_css' ) );
        }


        /**
         * Extra link if Admin Bar removed
         * 
         * @global type $submenu
         */
        public function menu_visit_site()
        {
            global $submenu;
            $submenu['index.php'][500] = array(
                    'Visit site'
                    , 'read'
                    , site_url()
            );
        }


        /**
         * Adjust CSS if Admin Bar completely removed
         * 
         */
        public function hide_admin_bar_css()
        {
            echo '<style>body.admin-bar #wpwrap
{padding-top: 0px !important; position:absolute; top: 0px;}</style>';
        }


        /**
         * Remove or modify Howdy
         * 
         * @param type $wp_admin_bar
         * @return type
         */
        public function goodbye_howdy( $wp_admin_bar )
        {
            $avatar = get_avatar( get_current_user_id(), 16 );
            if( !$wp_admin_bar->get_node( 'my-account' ) )
                return;

            $howdy = !empty( $this->params['wpdisable_howdy_enable']['howdy'] ) 
                ?  $this->params['wpdisable_howdy_enable']['howdy']
                : '';
            $wp_admin_bar->add_node( array(
                    'id'    => 'my-account',
                    'title' => $howdy . ' ' . wp_get_current_user()->display_name . $avatar,
            ) );
        }


        /**
         * Remove items from Admin Bar
         * 
         * @global type $wp_admin_bar
         */
        public function remove_items()
        {
            global $wp_admin_bar;

            if( in_array( 'comments', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'comments' );

            if( in_array( 'my_account', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'my-account' );

            if( in_array( 'updates', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'updates' );

            if( in_array( 'wp_logo', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'wp-logo' );

            if( in_array( 'new_content', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'new-content' );

            if( in_array( 'theme_options', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'theme_options' );

            if( in_array( 'site_name', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'site-name' );

            if( in_array( 'seo_by_yoast', $this->params['adminbar_remove'] ) )
                $wp_admin_bar->remove_menu( 'wpseo-menu' );
        }


        /**
         * Add Site Name to Admin Bar
         * 
         * @global type $wp_admin_bar
         */
        public function site_name()
        {
            global $wp_admin_bar;

            $title = $this->params['adminbar_sitename_enable']['adminbar_sitename_title'];
            $icon  = isset( $this->params['adminbar_sitename_enable']['adminbar_sitename_icon']['src'] ) ? $this->params['adminbar_sitename_enable']['adminbar_sitename_icon']['src'] : '';
            $url   = $this->params['adminbar_sitename_enable']['adminbar_sitename_url'];


            $do_title = ( $icon != '' ) ? '<img src="' . $icon . '" style="vertical-align:middle;margin:0 8px 0 6px;"/>' : '';
            $do_title .= ( $title != '') ? $title : get_bloginfo( 'name' );
            $do_url   = ( $url != '') ? $url : ( is_admin() ? site_url() : admin_url() );

            $wp_admin_bar->add_menu( array(
                    'id'    => 'Site MTT',
                    'title' => $do_title,
                    'href'  => $do_url
            ) );
        }


        /**
         * Add custom menu to Admin Bar
         * 
         * @global type $wp_admin_bar
         * @return type
         */
        public function custom_menu()
        {
            global $wp_admin_bar;

            // ERROR, NO PARENT
            if( $this->params['adminbar_custom_enable']['adminbar_custom_0_title'] == '' )
                return;

            // PARENT
            if( $this->params['adminbar_custom_enable']['adminbar_custom_0_title'] != '' )
            {
                $href0 = ($this->params['adminbar_custom_enable']['adminbar_custom_0_url'] != '') ? $this->params['adminbar_custom_enable']['adminbar_custom_0_url'] : '#';
                $wp_admin_bar->add_menu( array(
                        'id'    => 'MTT',
                        'title' => $this->params['adminbar_custom_enable']['adminbar_custom_0_title'],
                        'href'  => $href0
                ) );
            }

            // CHILDREN
            for( $i = 1; $i <= 5; $i++ )
            {
                if( $this->params['adminbar_custom_enable']["adminbar_custom_{$i}_title"] != '' )
                {
                    $href = ( $this->params['adminbar_custom_enable']["adminbar_custom_{$i}_url"] != '' ) ? $this->params['adminbar_custom_enable']["adminbar_custom_{$i}_url"] : '#';
                    $wp_admin_bar->add_menu( array(
                            'parent' => 'MTT',
                            'id'     => 'MTT' . $i,
                            'title'  => $this->params['adminbar_custom_enable']["adminbar_custom_{$i}_title"],
                            'href'   => $href
                    ) );
                }
            }
        }


    }

    
endif;