<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_Appearance' ) ):

    class MTT_Hook_Appearance
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
            
            if( !empty( $options['appearance_hide_help_tab'] ) )
                add_filter( 'contextual_help', array( $this, 'contextual_help_remove' ), 999, 3 );

            if( !empty( $options['appearance_hide_screen_options_tab'] ) )
                add_filter( 'screen_options_show_screen', array( $this, 'remove_screen_options' ), 999, 2 );

            if( !empty( $options['appearance_help_texts_enable']['enabled'] ) && is_admin() )
            {
                $ucan = empty( $this->params['appearance_help_texts_enable']['level'] )
                    ? true
                    : MTT_Plugin_Utils::current_user_has_role_array( $this->params['appearance_help_texts_enable']['level'] );
                if( $ucan )
                {
                    add_action( 'admin_print_scripts', array( $this, 'admin_print_scripts' ), 5 );
                }
                
            }
            
            
            if( !empty( $options['appearance_clean_admin'] ) )
                add_action( 'admin_enqueue_scripts', array( $this, 't5_clean_admin' ) );


            if( !empty( $options['appearance_adminbar_colors'] ) && is_admin_bar_showing() )
            {
                add_action( 'wp_head',    array( $this, 'abse_print_style'), 40 );
                add_action( 'admin_head', array( $this, 'abse_print_style'), 40 );
            }

            
            if( 
                    !empty( $this->params['admin_notice_header_settings_enable']['enabled'] )
                    || !empty( $this->params['admin_notice_header_allpages_enable']['enabled'] )
                )
                add_action( 'admin_notices', array( $this, 'admin_notices' ), 1 );

            
            if( !empty( $options['admin_notice_footer_message_enable']['enabled'] ) )
            {
                add_filter( 'admin_footer_text', array( $this, 'footer_left' ) );
                add_filter( 'update_footer', array( $this, 'footer_right' ), 11 );
            }

            
            if( !empty( $options['admin_notice_footer_hide'] ) )
                add_filter( 'admin_print_styles', array( $this, 'footer_hide' ) );
                       
        }

        public function contextual_help_remove( $old_help, $screen_id, $screen )
        {
                $screen->remove_help_tabs();
                return $old_help;
        }
        public function remove_screen_options( $show_screen, $thiz )
        {
                return false;
        }

        public function admin_print_scripts()
        {
            wp_register_style( 'mtt-hide-help', MTT_Plugin_Init::get_url() . 'css/hide-help.css', array( ), time() );
            wp_enqueue_style( 'mtt-hide-help' );
        }
        

        public function t5_clean_admin()
        {
            wp_register_style( 'toscho-clean-admin', MTT_Plugin_Init::get_url() . 'css/toscho-clean-admin.css', array( ), time() );
            wp_enqueue_style( 'toscho-clean-admin' );
        }
        
        public function abse_print_style()
        {
            wp_register_style( 'toscho-admin-bar', MTT_Plugin_Init::get_url() . 'css/toscho-admin-bar.css', array( ), time() );
            wp_enqueue_style( 'toscho-admin-bar' );
        }
        
        public function admin_notices()
        {
            global $current_screen;

            // enable settings-page notice
            if( !empty( $this->params['admin_notice_header_settings_enable']['enabled'] ) && $current_screen->id == 'options-general' )
            {
                print '<div  class="updated">' 
                    . $this->params['admin_notice_header_settings_enable']['text'] 
                    . '</div>';
            }

            // enable general notice
            if( !empty( $this->params['admin_notice_header_allpages_enable']['enabled'] ) )
            {
//                $ucan = $this->getUserLevel( $this->params['admin_notice_header_allpages_level'] );
                $ucan = empty( $this->params['admin_notice_header_allpages_enable']['level'] )
                    ? true
                    : MTT_Plugin_Utils::current_user_has_role_array( $this->params['admin_notice_header_allpages_enable']['level'] );
                if( $ucan )
                {
                    echo '<div  class="updated">' . $this->params['admin_notice_header_allpages_enable']['text'] . '</div>';
                }
            }


            // disable WP update notices
//            if( $this->params['wpblock_update_wp'] )
//            {
//                remove_action( 'admin_notices', 'update_nag', 3 );
//                remove_filter( 'update_footer', 'core_update_footer' );
//            }
        }


        function footer_hide()
        {
            echo '<style type="text/css">#wpfooter { display: none; }</style>';
        }


        function footer_left( $default_text )
        {
            return $this->params['admin_notice_footer_message_enable']['admin_notice_footer_message_left'];
        }


        function footer_right( $default_text )
        {
            return $this->params['admin_notice_footer_message_enable']['admin_notice_footer_message_right'];
        }


    }

    

endif;
