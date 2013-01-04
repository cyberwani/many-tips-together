<?php
!defined( 'ABSPATH' ) AND exit;

if ( !class_exists( 'MTT_Hook_Widgets' ) ):

    class MTT_Hook_Widgets
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
            global $pagenow;
            //loga($pagenow,'MTT_Hook_Widgets');
            $this->params = $options;

            // REMOVE WIDGETS
            if( isset( $options['widget_remove'] ) )
                add_action( 
                        'widgets_init', 
                        array( $this, 'remove_widgets' ), 
                        15 
                );
          
            // SIMPLE META WIDGET
            if ( !empty( $options['widget_meta_slim'] ) )
            {
                $can_do = !empty( $this->params['widget_remove'] ) 
                    ? !in_array( 'meta', $this->params['widget_remove'] ) 
                    : true; 
                if ( $can_do )
                {
                    require_once ('class-widget-meta-slim.php');
                    add_action( 
                            'widgets_init', 
                            array( $this, 'meta_slim' ) 
                    );
                }
            }

            // CHANGE RSS UPDATE TIMER
            if ( !empty( $options['widget_rss_update_timer'] ) )
                add_filter( 
                        'wp_feed_cache_transient_lifetime', 
                        array( $this, 'widgetsRss_update_timer' ) 
                );
        }


        /**
         * Remove selected widgets
         */
        function remove_widgets()
        {

            if ( in_array( 'akismet', $this->params['widget_remove'] ) )
                unregister_widget( 'Akismet_Widget' );

            if ( in_array( 'pages', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Pages' );

            if ( in_array( 'calendar', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Calendar' );

            if ( in_array( 'archives', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Archives' );

            if ( in_array( 'links', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Links' );

            if ( in_array( 'meta', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Meta' );

            if ( in_array( 'search', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Search' );

            if ( in_array( 'text', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Text' );

            if ( in_array( 'categories', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Categories' );

            if ( in_array( 'recent_posts', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Recent_Posts' );

            if ( in_array( 'recent_comments', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Recent_Comments' );

            if ( in_array( 'rss', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_RSS' );

            if ( in_array( 'tag_cloud', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Widget_Tag_Cloud' );

            if ( in_array( 'nav_menu', $this->params['widget_remove'] ) )
                unregister_widget( 'WP_Nav_Menu_Widget' );
        }


        /**
         * New meta widget, without WordPress stuff
         */
        function meta_slim()
        {     
            unregister_widget( 'WP_Widget_Meta' );
            register_widget('WP_Widget_Meta_Slim');
        }


        /**
         * Change RSS update timer
         * 
         * @return ing Timer in minutes
         */
        function rss_update_timer()
        {
            $num = (int) $this->params['widget_rss_update_timer'] * 60;
            return $num;
        }

    }

endif;

