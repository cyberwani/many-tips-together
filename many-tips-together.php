<?php

/**
 * Plugin Name: Many Tips Together **2013**
 * Plugin URI: http://wordpress.org/extend/plugins/many-tips-together
 * Description: This plugin compiles many administrative customization tips in one simple interface.
 * Version: 2.0 beta RC1
 * Stable Tag: 1.0.3
 * Author: Rodolfo Buaiz
 * Author URI: http://rodbuaiz.com/
 * Text Domain: mtt
 * Domain Path: /languages
 * License: GPLv2 or later
 *
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * ADMIN PAGE CLASS
 * 
 * 


 */
/**
 * Prevent loading this file directly
 * Busted!
 */
!defined( 'ABSPATH' ) AND exit(
                "<pre>Hi there! I'm just part of a plugin, <h1>&iquest;what exactly are you looking for?"
);


if( !class_exists( 'MTT_Plugin_Init' ) ):
    /**
     * SETUP & INIT PLUGIN
     * 
     */
    if( function_exists( 'add_action' ) )
    {
        // Initial plugin hooks
        // register_activation_hook( __FILE__, array( 'MTT_Plugin_Init', 'on_activation' ) );
        // register_deactivation_hook( __FILE__, array( 'MTT_Plugin_Init', 'on_deactivate' ) );
        // register_uninstall_hook ( __FILE__, array( 'MTT_Plugin_Init', 'on_uninstall' ) );
        // Init All
        add_action( 'plugins_loaded', array( 'MTT_Plugin_Init', 'init' ) );
    }

    /**
     * In depth customization of WordPress administrative interface, plus some other goodies.
     * 
     * @author Rodolfo Buaiz
     * @since 2.0
     * @version 2.0
     * @package Many Tips Together
     * @subpackage 
     */
    class MTT_Plugin_Init
    {
        /**
         * Container for Plugin Settings
         * TODO: not used, check this logic
         * 
         * @since 2.0
         * @var
         */
        public $options;
        

        /**
         * Options name
         *
         * @since 2.0
         * @type string
         */
        public static $opt_name = 'ManyTipsTogether';
        public static $version      = '2.0 beta';
        public static $mtt_tb_title = ' 2.0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :o[)';

        /**
         * Handler for the action 'init'. Instantiates this class.
         * @return void
         */
        public static function init()
        {
            $class = __CLASS__;
            new $class;
            
        }


        public function __construct()
        {
            $this->load_language( 'mtt' );

            // Utilities
            include_once plugin_dir_path( __FILE__ ) . 'inc/class-plugin-utils.php';

            // Plugin Metabox
            include_once plugin_dir_path( __FILE__ ) . 'inc/class-plugin-metabox.php';

            // Admin-Page-Class library
            require_once plugin_dir_path( __FILE__ ) . 'inc/admin-page-class/admin-page-class.php';

            // Admin interface class
            require_once plugin_dir_path( __FILE__ ) . 'inc/class-admin.php';

            // Validation
            include_once plugin_dir_path( __FILE__ ) . 'inc/class-admin-validate.php';

            add_filter( 'plugin_action_links', array( $this, 'settings_plugin_link' ), 10, 2 );

            $this->setup_options();

            new BL_Many_Tips_Together_Admin( $this->options );
        }


        /**
         * 
         * @return string Plugin URL
         */
        public static function get_url()
        {
            return plugins_url( '/', __FILE__ );
        }


        /**
         * 
         * @return string Plugin system path
         */
        public static function get_path()
        {
            return plugin_dir_path( __FILE__ );
        }


        /**
         * TODO: CHECK THIS LOGIC
         */
        public function setup_options()
        {
            $mtt = get_option( self::$opt_name );
//loga($mtt);
            if( !$mtt )
            {
                $mtt = MTT_Plugin_Utils::$default_options;
                update_option( self::$opt_name, $mtt );
                $this->options	= $mtt;
            }
            else
                $this->options	= $mtt;
        }


        /**
         * Activation hook.
         * TODO: not used, just a sample
         */
        public function on_activation()
        {
            $params = get_option( BL_All_Favorites_Ordered::$opt_name );
            if( empty( $params ) )
            {
                update_option(
                        BL_All_Favorites_Ordered::$opt_name, BL_All_Favorites_Ordered::$opt_defaults
                );
            }
        }


        /**
         * TODO: remove prior to LAUNCHING
         * TODO: also search for all "//loga(" and REMOVE
         * Just for testing
         */
        public function on_deactivate()
        {
            delete_option( BL_All_Favorites_Ordered::$opt_name );
        }


        /**
         * Add link to settings in Plugins list page
         * 
         * @return Plugin link
         */
        public function settings_plugin_link( $links, $file )
        {
            if( $file == plugin_basename( dirname( __FILE__ ) . '/many-tips-together.php' ) )
            {
                $in = '<a href="'
                        . admin_url( 'options-general.php?page=options-general.php_many_tips_together' )
                        . '">'
                        . __( 'Settings' )
                        . '</a>';
                array_unshift( $links, $in );
            }
            return $links;
        }


        /**
         * Loads translation file.
         *
         * Accessible to other classes to load different language files (admin and
         * front-end for example).
         * 
         * References:
         * http://core.trac.wordpress.org/ticket/18960
         * http://www.geertdedeckere.be/article/loading-wordpress-language-files-the-right-way
         *
         * @wp-hook admin_init
         * @param   string $domain
         * @since   2012.12.22
         * @return  void
         */
        public function load_language( $domain )
        {
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

            load_textdomain(
                    $domain, WP_LANG_DIR . '/plugins/many-tips-together/' . $domain . '-' . $locale . '.mo'
            );
            load_plugin_textdomain(
                    $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages'
            );
        }


    }

endif;

include_once('github-updater.php');
add_action( 'admin_init', 'mtt_github_update_checker' );
function mtt_github_update_checker() {
    $config = array(
        'slug' => plugin_basename(__FILE__), 
        'proper_folder_name' => 'many-tips-together',
        'description' => 'version 2, release candidate 1',
        'api_url' => 'https://api.github.com/repos/brasofilo/many-tips-together',
        'raw_url' => 'https://raw.github.com/brasofilo/many-tips-together', 
        'github_url' => 'https://github.com/brasofilo/many-tips-together',
        'zip_url' => 'https://github.com/brasofilo/many-tips-together/zipball/master', 
        'sslverify' => true, 
        'requires' => '3.0', 
        'tested' => '3.5', 
);
    new wp_github_updater($config);
}