<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_Multisite' ) ):

    class MTT_Hook_Multisite
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

            // ACTIVE PLUGINS WIDGET
            if( !empty( $options['multisite_active_plugins_widget'] ) )
            {
                add_action(
                        'admin_head-index.php', 
                        array( $this, 'print_scripts' )
                );
                add_action(
                        'wp_network_dashboard_setup', 
                        array( $this, 'network_dashboard_setup' )
                );
            }

            // SITES COLUMNS - ID AND BLOGNAME
            if(
                    !empty( $options['multisite_site_id_column'] )
                    or !empty( $options['multisite_blogname_column'] )
            )
            {
                // ID
                if( !empty( $options['multisite_site_id_column'] ) )
                {
                    add_filter( 
                        'wpmu_blogs_columns', 
                        array( $this, 'add_id_column' )
                    );
                    add_action(
                        'admin_head-sites.php', 
                        array( $this, 'print_id_column_style' )
                    );
                }

                // BLOGNAME
                if( !empty( $options['multisite_blogname_column'] ) )
                    add_filter(
                        'wpmu_blogs_columns', 
                        array( $this, 'add_blogname_column' )
                    );

                // BOTH
                add_action(
                        'manage_sites_custom_column', 
                        array( $this, 'render_columns' ), 
                        10, 2
                );
            }

            // REDIRECT TO SITE SETTINGS AFTER CREATING A NEW SITE
            if( !empty( $options['multisite_redirect_new_site'] ) )
                add_filter(
                        'admin_head-site-new.php', 
                        array( $this, 'redirect_after_site_creation' )
                );
            
            // REMOVE DASHBOARD WIDGETS
            if( !empty( $options['multisite_dashboard_remove'] ) )
                add_action(
                        'wp_network_dashboard_setup', 
                        array( $this, 'dashboard_widgets' )
                );

            // SORT SITES NAMES IN ADMIN MENU AND USERS SITES
            if( !empty( $options['multisite_sort_sites_names'] ) )
                add_filter(
                    'get_blogs_of_user',
                    array( $this, 'reorder_users_sites' ),
                    0
                );
        }

        /**
         * Active plugins widget scripts
         * @global type $current_screen
         * @return type
         */
        public function print_scripts()
        {
            global $current_screen;
            if( !$current_screen->is_network )
                return;

            echo '<style type="text/css">

        table.widefat {
                font: 11px/24px Verdana, Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                }

        .widefat thead tr th {
                padding: 0.2em 0.5em;
                text-align: left;
                background: linear-gradient(to top, #CEEBE9, #DFEBEB) repeat scroll 0 0 #739E9E !important;
                 /*  background-color: #1a82f7; 
                background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#2F2727), to(#1a82f7)) !important;
                background-image: -webkit-linear-gradient(top, #2F2727, #1a82f7) !important; 
                background-image:    -moz-linear-gradient(top, #2F2727, #1a82f7) !important;
                background-image:     -ms-linear-gradient(top, #2F2727, #1a82f7) !important;
                background-image:      -o-linear-gradient(top, #2F2727, #1a82f7) !important;*/

                }

        .widefat tr.yellow td {
                border-top: 1px solid #FB7A31;
                border-bottom: 1px solid #FB7A31;
                background: #FFC;
                }

        .widefat td {
                border-top: 1px solid #CCC;
                border-bottom: 1px solid #CCC;
                padding: 0.2em 0.5em;
                vertical-align:middle;
                text-align: center;
                }


        .widefat td+td {
                border-left: 1px solid #CCC;
                text-align: center;
                }
        .aright {text-align:right !important;}

    </style>';
        }


        /**
         * Active plugins widget add
         */
        public function network_dashboard_setup()
        {
            wp_add_dashboard_widget(
                    'active_network_plugins', 
                    'Network active plugins', 
                    array( $this, 'active_network_plugins' )
            );
            wp_add_dashboard_widget(
                    'all_network_plugins', 
                    'Sites active plugins', 
                    array( $this, 'all_network_plugins' )
            );
        }


        /**
         *  Network active plugins widget render
         */
        public function active_network_plugins()
        {

            $the_plugs = get_site_option( 'active_sitewide_plugins' );
            echo '
                    <table class="widefat">
                        <tbody>
                ';
            $count     = 0;
            foreach( $the_plugs as $key => $value )
            {
                if( $count % 4 == 0 )
                    echo '<tr>' . "\r\n";
                $string = explode( '/', $key ); // Folder name will be displayed
                echo "<td>{$string[0]}</td>" . "\r\n";
                $count++;
                if( $count % 4 == 0 )
                    echo '</tr>' . "\r\n";
            }
            $rest   = 4 - $count % 4;
            for( $i = 0; $i < $rest; $i++ )
                echo '<td></td>';
            echo '</tr></tbody></table>';
        }


        /**
         *  All sites active plugins widget render
         */
        public function all_network_plugins()
        {

            global $wpdb;
            $blogs = $wpdb->get_results( "
                SELECT blog_id
                FROM {$wpdb->blogs}
                WHERE site_id = '{$wpdb->siteid}'
                AND spam = '0'
                AND deleted = '0'
                AND archived = '0'
            " );


            foreach( $blogs as $blog )
            {
                $the_plugs    = get_blog_option( $blog->blog_id, 'active_plugins' );
                $the_theme    = get_blog_option( $blog->blog_id, 'current_theme' );
                $the_template = get_blog_option( $blog->blog_id, 'template' );
                $blogname     = get_blog_option( $blog->blog_id, 'blogname' );

                echo "
<table class='widefat'>
            <thead>
                     <tr>
            <th colspan='2'><b>Site</b>: {$blogname}</th>
                            <th colspan='2' class='aright'><b>Theme</b>: {$the_theme}</th>
        </tr>
    </thead>
    <tbody>";
                $count = 0;
                foreach( $the_plugs as $value )
                {
                    if( $count % 4 == 0 )
                        echo '<tr>' . "\r\n";
                    $string = explode( '/', $value ); // Folder name will be displayed
                    echo "<td>{$string[0]}</td>" . "\r\n";
                    $count++;
                    if( $count % 4 == 0 )
                        echo '</tr>' . "\r\n";
                }
                $rest   = 4 - $count % 4;
                for( $i = 0; $i < $rest; $i++ )
                    echo '<td></td>';
                echo '</tr></tbody></table><br class="clear">';
            }
        }


        /**
         * Render columns in sites listing (id and blogname)
         * 
         * @param type $column_name
         * @param type $blog_id
         * @return type
         */
        public function render_columns( $column_name, $blog_id )
        {
            if( 'blogid' === $column_name )
                echo $blog_id;
            elseif( 'blog_name' === $column_name )
                echo get_blog_option( $blog_id, 'blogname' );
            return $column_name;
        }


        /**
         * Add id column header
         * 
         * @param type $columns
         * @return type 
         */
        public function add_id_column( $columns )
        {
            $in = array( "blogid" => "ID" );
            $columns  = MTT_Plugin_Utils::array_push_after( $columns, $in, 0 );
            return $columns;
        }


        /** 
         * Add blogname column header
         * 
         * @param type $columns
         * @return type
         */
        public function add_blogname_column( $columns )
        {
            $in = array( "blog_name" => "Name" );
            $columns    = MTT_Plugin_Utils::array_push_after( $columns, $in, 2 );
            return $columns;
        }


        /**
         * Print id column style
         * 
         * @global type $current_screen
         */
        public function print_id_column_style()
        {
            global $current_screen;
            echo '<style type="text/css">#blogid { width:3%; }</style>';
        }


        /**
         * Redirect after site creation
         * 
         */
        public function redirect_after_site_creation()
        {
            if( !isset( $_GET['update'] ) || 'added' != $_GET['update'] )
                return;

            wp_redirect( admin_url( 'network/site-info.php?id=' . $_GET['id'] ) );
            exit;
        }


        /**
         * Remove dashboar widgets
         * 
         * http://helen.wordpress.com/2011/08/01/customizing-the-special-multisite-dashboards/
         */
        public function dashboard_widgets()
        {
            if( in_array( 'right_now', $this->params['multisite_dashboard_remove'] ) )
                remove_meta_box( 'network_dashboard_right_now', 'dashboard-network', 'normal' );

            if( in_array( 'plugins', $this->params['multisite_dashboard_remove'] ) )
                remove_meta_box( 'dashboard_plugins', 'dashboard-network', 'normal' ); 

            if( in_array( 'primary', $this->params['multisite_dashboard_remove'] ) )
                remove_meta_box( 'dashboard_primary', 'dashboard-network', 'side' ); 
            
            if( in_array( 'secondary', $this->params['multisite_dashboard_remove'] ) )
                remove_meta_box( 'dashboard_secondary', 'dashboard-network', 'side' ); 
        }


        /**
         * Reorder sites listing in menu and sites of user
         * 
         * @param type $blogs
         * @return type
         */
        function reorder_users_sites( $blogs )
        {
            if( !did_action( 'wp_before_admin_bar_render' ) )
                uasort( $blogs, array( $this, 'bf_uasort_by_blogname' ) );
            else
                uasort( $blogs, array( $this, 'bf_uasort_by_domain' ) );

            return $blogs;
        }


        /**
         * Sort by domain
         * 
         * @param type $a
         * @param type $b
         * @return type
         */
        private function bf_uasort_by_domain( $a, $b )
        {
            return strcasecmp( $a->domain, $b->domain );
        }


        /**
         * Sort by blogname
         * @param type $a
         * @param type $b
         * @return type
         */
        private function bf_uasort_by_blogname( $a, $b )
        {
            return strcasecmp( $a->blogname, $b->blogname );
        }


    }
    
endif;