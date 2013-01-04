<?php

!defined( 'ABSPATH' ) AND exit;


if ( !class_exists( 'BL_Many_Tips_Together_Admin' ) ):
class BL_Many_Tips_Together_Admin
{

    
    /**
     * Options default
     * Configuration of Admin Class
     * 
     * @type array 
     */
    protected $config = array(
            'menu'           => 'settings'
       ,    'page_title'     => 'Many Tips Together'
       ,    'capability'     => 'import'
       ,    'option_group'   => 'ManyTipsTogether'
       ,    'id'             => 'mtt_page'
       ,    'fields'         => array( )
       ,    'local_images'   => true
       ,    'use_with_theme' => false
    );
    
    
    
    private $plugin_sections = array( 
            'adminbar'
        ,   'adminmenus'
        ,   'appearance'
        ,   'dashboard'
        ,   'general'
        ,   'login'
        ,   'maintenance' 
        ,   'media'
        ,   'plugins'
        ,   'postediting'
        ,   'postlisting'
        ,   'profile'
        ,   'shortcodes'
        ,   'widgets'
    );
    
    private $plugin_multisite = array( 'multisite' );
    
    public $options_class;

    
    /**
     * URL to this plugin's directory.
     *
     * @type string
     */
    public $plugin_url;

    
    /**
     * Path to this plugin's directory.
     *
     * @type string
     */
    public $plugin_path;
    /**
     * Options internal holder
     * 
     * @type array 
     */
    public $params = array( );

    public $multisite = false;

    /**
     * Constructor
     *
     * @wp-hook plugins_loaded
     * @since   2012.12.21
     * @return  void
     */
    public function __construct( $options )//array  )
    {
        // Basic parameters
        $this->params      = $options;
        $this->plugin_url  = MTT_Plugin_Init::get_url();
        $this->plugin_path = MTT_Plugin_Init::get_path();
        $this->multisite   = is_multisite() 
                ? ( is_super_admin() && get_current_blog_id() == 1 ) 
                : false;
        
        // Modify config if in Multisite
        if( $this->multisite ) {
           $this->plugin_sections = array_merge($this->plugin_sections, array('multisite') );
           $this->config['capability'] = 'manage_network';
        }
        
        // Load all classes
        foreach ( $this->plugin_sections as $section )
            require_once ('hooks/' . $section . '.php');

        // Plugin script and style
        add_action( 'admin_init', array( $this, 'mtt_admin_init' ) );

        // Build bases
        $this->build_admin();
        $this->build_hooks();
        
       // MTT custom sidebar
        add_action( 'admin_page_class_before_page', array( 'MTT_Plugin_Meta_Box', 'mtt_meta_box' ) );
    }


    /**
     * Build admin page
     *
     * @wp-hook plugins_loaded
     * @since   2012.12.21
     * @return  void
     */
    public function build_admin()
    {
        // Initiate the admin page
        $options_panel = new BF_Admin_Page_Class( $this->config );
        $options_panel->OpenTabs_container( '' );

        
        // Define tabs listing
        $tabs_links = array(
                        'appearance'    => __( 'Appearance', 'mtt' ),
                        'admin_bar'     => __( 'Admin Bar', 'mtt' ),
                        'admin_menus'   => __( 'Admin Menus' ),
                        'dashboard'     => __( 'Dashboard', 'mtt' ),
                        'post_listing'  => __( 'Post and Page Listing', 'mtt' ),
                        'post_editing'  => __( 'Post and Page Editing', 'mtt' ),
                        'media'         => __( 'Media', 'mtt' ),
                        'widgets'       => __( 'Widgets', 'mtt' ),
                        'plugins'       => __( 'Plugins', 'mtt' ),
                        'user_profile'  => __( 'Users and Profile', 'mtt' ),
                        'shortcodes'    => __( 'Shortcodes', 'mtt' ),
                        'general'       => __( 'General Settings', 'mtt' ),
                        'login_logout'  => __( 'Login and Logout', 'mtt' ),
                        'maintenance'   => __( 'Maintenance Mode', 'mtt' ),
                );
        
        // MS support
        if( $this->multisite )
            $tabs_links['multisite'] =  __( 'Multisite', 'mtt' );
        
        // Finish tabs listing
        $tabs_links['import_export'] =  __( 'Import Export', 'mtt' );

        // Declare tabs listing
        $options_panel->TabsListing( array( 'links' => $tabs_links ) );
       
        // Include Admin Tabs
        foreach ( $this->plugin_sections as $section )
            require_once ('admin-tabs/' . $section . '.php');

        // Import Export Admin Tabs
        $options_panel->OpenTab( 'import_export' );
        $options_panel->Title( __( 'Import Export', 'mtt' ) );
        $options_panel->addImportExport();
        $options_panel->addCheckboxList( 'mtt_verbose_plugin', 
			array( 
				'visible' => 'Select Value1',
			), 
			array( 
				'name'=> 'Hide help texts', 
				'desc'=> 'THIS FIELD IS INVISIBLE, manipulated by MTT meta box', 
				'std' => false
			));
        $options_panel->CloseTab();

        // End Admin Tabs Container
        $options_panel->CloseTab();

        
        // Help Tabs
       $options_panel->HelpTab( array(
                'id'      => 'tab_id1',
                'title'   => 'Dump Plugin Options',
                'callback' => array( $this, 'help_tab_callback_one' )
        ) );
        $options_panel->HelpTab( array(
                'id'       => 'tab_id2',
                'title'    => 'Dump Repository Data',
                'callback' => array( $this, 'help_tab_callback_two' )
       ) );


        // Create Admin Interface
        $this->options_class = $options_panel; 
    }


    /**
     * Instantiates all hook classes
     * 
     * @wp-hook plugins_loaded
     * @since   2012.12.21
     * @return  void
     */
    public function build_hooks()
    {
        // Shortcircuit the instantiation of specific classes
        global $pagenow;
        
        // ADMIN BAR
        new MTT_Hook_Adminbar( $this->params );
        
        // ADMIN MENUS
        if( is_admin() )
            new MTT_Hook_Adminmenus( $this->params );
        
        // DASHBOARD
        if( 'index.php' == $pagenow && is_admin() )
            new MTT_Hook_Dashboard( $this->params );

        // APPEARENCE
        if( is_admin() )
            new MTT_Hook_Appearance( $this->params );
        
        // GENERAL
        new MTT_Hook_General( $this->params );
                
        // LOGIN
        if( 'wp-login.php' == $pagenow )
            new MTT_Hook_Login( $this->params );

        // MAINTENANCE
        new MTT_Hook_Maintenance( $this->params );
        
        // MEDIA
        new MTT_Hook_Media( $this->params );
        
        // PLUGINS
        if( 'plugins.php' == $pagenow && is_admin() )
            new MTT_Hook_Plugins( $this->params, $this->multisite );
        
        // POST EDITING
        if( ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) && is_admin() )
            new MTT_Hook_Post_Editing( $this->params );
        
        // POST LISTING
        if( 
            ( 'edit.php' == $pagenow && is_admin() )
            or
            ( 'admin-ajax.php' == $pagenow && isset($POST) && '_inline-save' == $_POST['action'] && 'list' == $_POST['post_view'] )
        )
            new MTT_Hook_Post_Listing( $this->params );
    
       // PROFILE
        if( ( 'profile.php' == $pagenow || 'user-edit.php' == $pagenow ) && is_admin() )
            new MTT_Hook_Profile( $this->params );
        
        // SHORTCODES
        new MTT_Hook_Shortcodes( $this->params );

        // WIDGETS
        new MTT_Hook_Widgets( $this->params );
        
        // MULTISITE
        if( $this->multisite ) 
            new MTT_Hook_Multisite( $this->params );
    }
    
    
    /**
     * Admin Init Hooks
     * 
     * TODO: remove cache -> time()
     */
    public function mtt_admin_init()
    {
        $page = $this->options_class->_Slug; //$mtt_class_admin_instance->options_class->_Slug;
        
        // Basic stuff
        wp_register_style( 
                'mtt_admin_css', 
                $this->plugin_url . 'css/admin.css', 
                array( ), 
                time() 
        );
        wp_register_script( 
                'mtt_admin_js', 
                $this->plugin_url . 'js/mtt.js', 
                array( ), 
                time(), 
                true 
        );
        
        // Used in upload window
        wp_register_script( 
                'mtt_thickbox_js', 
                $this->plugin_url . 'js/thickbox-column.js', 
                array( 'jquery' ), 
                time(), 
                true 
        );
       

        add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_print_scripts' ), 5 );
        
        add_filter( 'media_upload_default_tab', array( $this, 'upload_default_tab' ) );
        add_action( 'admin_print_styles-media-upload-popup', array( $this, 'upload_popup_style' ) );
    }

    
   /**
     * Print plugin style and script
     */
    public function admin_print_scripts( )
    {
        wp_enqueue_style( 'mtt_admin_css' );
        wp_enqueue_script( 'mtt_admin_js' );
        
        $network = $this->multisite ? 'network/' : '';
         wp_localize_script( 
		 'mtt_admin_js' 
		, 'mtt' 
		, array( 
			 'title' 	=> "Many Tips Together " . __( 'version', 'mtt' ) .MTT_Plugin_Init::$mtt_tb_title,
			'network'   => $network
		) 
	);
    }
    
    /**<?php echo "Many Tips Together " . __( 'version', 'mtt' ) . $mtt_tb_title; ?>
     * Default tab for Thickbox
     * 
     * TODO: confirm that this is working only in our page
     * 
     * @param type $tab
     * @return string
     */
    public function upload_default_tab( $tab )
    {
        if( !isset( $_GET['apc'] ) )
            return $tab;
        
       return 'library';
    }
    
    /**
     * Hide items in Thickbox
     * 
     * TODO: confirm that this is working only in our page
     */
    public function upload_popup_style()
    {
        if( !isset( $_GET['apc'] ) )
            return;
        ?>
        <style> tr.post_title, tr.image_alt, tr.post_excerpt, tr.post_content, tr.url, tr.align {display:none;} </style>
        <?php
    }

    /**
     * Help Tab Callback
     */
    public function help_tab_callback_zero()
    {
        echo '<p>';
        MTT_Plugin_Utils::print_repository_info();
        echo '</p>';
    }

    /**
     * Help Tab Callback
     */
    public function help_tab_callback_one()
    {
        $section = $this->filter( $this->params, 'login' );
        echo '<p><pre>';
        echo print_r( $section );
        echo '</pre></p>';
    }

    /**
     * Used to get the Options values that startWith
     * 
     * @param type $val
     * @param type $needle
     * @return type
     */
    private function filter( $val, $needle )
    {
        $arr = array();
        foreach( $val as $key => $value ){
            if( $this->startsWith( $needle, $key) )
                    $arr[$key] = $val[$key];
        }
        return $arr;
    }

    /**
     * Search for needle at first position of haystack
     * 
     * @param type $needle
     * @param type $haystack
     * @return type
     */
    private function startsWith( $needle, $haystack )
    {
        return !strncmp( $haystack, $needle, strlen( $needle ) );
    }
   
    
    /**
     * Help Tab Callback
     */
    public function help_tab_callback_two()
    {
        echo '<p><pre>';
        $getty = MTT_Plugin_Utils::print_repository_info(false);
        unset( $getty['changelog'], $getty['sections'], $getty['stats'] );
        print_r($getty);
        echo '</pre></p>';
    }


 
}
endif;

