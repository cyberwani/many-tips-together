<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_Adminmenus' ) ):

    class MTT_Hook_Adminmenus
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
            
            // DISABLE HOVER INTENT
            if( !empty( $options['admin_menus_hover'] ) )
                add_action( 
                        'admin_head', 
                        array( $this, 'hoverintent' ) 
                );

            // REMOVE ITEMS
            if( !empty( $options['admin_menus_remove'] ) )
                add_action( 
                        'admin_menu', 
                        array( $this, 'remove_items' ), 
                        0 
                );

            // RENAME POSTS
            if( !empty( $options['posts_rename_enable']['enabled'] ) )
            {
                add_action( 
                        'init', 
                        array( $this, 'object_label' ), 
                        0 
                );
                add_action( 
                        'admin_menu', 
                        array( $this, 'menu_label' ), 
                        0 
                );
            }
            
            // HIDE ADVANCED CUSTOM FIELDS OPTIONS PAGE
//            if ( !empty( $options['plugins_acf_hide_options'] ) )
//                add_action( 
//                        'admin_menu', 
//                        array( $this, 'hide_acf_options' ) 
//                );
            
        }


        /**
         * Block menu hover intent, speeds up the menu
         */
        public function hoverintent()
        {
            wp_enqueue_script(
                    'disable-admin-hoverintent', MTT_Plugin_Init::get_url() . 'js/disableadminhi.js', array( ), time()
            );
        }


        /**
         * Remove menu items
         */
        public function remove_items()
        {
            if( in_array( 'posts', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'edit.php' );

            if( in_array( 'media', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'upload.php' );

            if( in_array( 'links', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'link-manager.php' );

            if( in_array( 'pages', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'edit.php?post_type=page' );

            if( in_array( 'comments', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'edit-comments.php' );

            if( in_array( 'appearence', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'themes.php' );

            if( in_array( 'plugins', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'plugins.php' );

            if( in_array( 'users', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'users.php' );

            if( in_array( 'tools', $this->params['admin_menus_remove'] ) )
                remove_menu_page( 'tools.php' );
        }


        /**
         * Rename "Posts" in the global scope
         * 
         * @global type $wp_post_types
         */
        public function object_label()
        {
            global $wp_post_types;

            $labels = &$wp_post_types['post']->labels;

            if ( !empty( $this->params['posts_rename_enable']['name'] ) )
                $labels->name = $this->params['posts_rename_enable']['name'];

            if ( !empty( $this->params['posts_rename_enable']['singular_name'] ) )
                $labels->singular_name = $this->params['posts_rename_enable']['singular_name'];

            if ( !empty( $this->params['posts_rename_enable']['add_new'] ) )
            {
                $labels->add_new      = $this->params['posts_rename_enable']['add_new'];
                $labels->add_new_item = $this->params['posts_rename_enable']['add_new'];
            }

            if ( !empty( $this->params['posts_rename_enable']['edit_item'] ) )
                $labels->edit_item = $this->params['posts_rename_enable']['edit_item'];

            if ( !empty( $this->params['posts_rename_enable']['name'] ) )
                $labels->new_item = $this->params['posts_rename_enable']['name'];

            if ( !empty( $this->params['posts_rename_enable']['view_item'] ) )
                $labels->view_item = $this->params['posts_rename_enable']['view_item'];

            if ( !empty( $this->params['posts_rename_enable']['search_items'] ) )
                $labels->search_items = $this->params['posts_rename_enable']['search_items'];

            if ( !empty( $this->params['posts_rename_enable']['not_found'] ) )
                $labels->not_found = $this->params['posts_rename_enable']['not_found'];

            if ( !empty( $this->params['posts_rename_enable']['not_found_in_trash'] ) )
                $labels->not_found_in_trash = $this->params['posts_rename_enable']['not_found_in_trash'];
        }


        /**
         * Rename "Posts" in the Admin Menu
         * 
         * @global type $menu
         * @global type $submenu
         */
        public function menu_label()
        {
            global $menu, $submenu;

            if ( !empty( $this->params['posts_rename_enable']['name'] ) )
                $menu[5][0]                 = $this->params['posts_rename_enable']['name'];

            if ( !empty( $this->params['posts_rename_enable']['name'] ) )
                $submenu['edit.php'][5][0]  = $this->params['posts_rename_enable']['name'];

            if ( !empty( $this->params['posts_rename_enable']['add_new'] ) )
                $submenu['edit.php'][10][0] = $this->params['posts_rename_enable']['add_new'];       
        }


    }

    
endif;