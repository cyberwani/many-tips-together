<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_Post_Listing' ) ):

    class MTT_Hook_Post_Listing
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

            // PERSISTENT LIST VIEW
            // promissed to 3.5, but did't came
            if( !empty( $options['postpageslist_persistent_list_view'] ) )
                add_action( 
                        'load-edit.php', 
                        array( $this, 'persistent_posts_list_mode' ) 
                );



            // FILTER PAGES BY TEMPLATE
            if( !empty( $options['postpageslist_template_filter_enable'] ) )
            {
                // Class for sorting pages by template
                include_once plugin_dir_path( __FILE__ ) . 'class-filter-pages-by-template.php';
                add_action( 
                        'admin_init', 
                        array( 'Page_Template_Filter', 'init' ) 
                );
            }
            
            // MAKE DUPLICATE AND DELETE REVISIONS
            if( !empty( $options['postpageslist_duplicate_del_revisions'] ) )
            {
                // Class for removing revisions and making duplicates (posts and pages)
                include_once plugin_dir_path( __FILE__ ) . 'class-revisions-duplicate.php';

                add_action( 
                        'admin_init', 
                        array( 'MTT_Manage_Duplicates_Revisions', 'init' ) 
                );
            }

            // ADD ID COLUMN
            if( !empty( $options['postpageslist_enable_id_column'] ) )
                add_action( 
                        'admin_init', 
                        array( $this, 'init_id_column' ), 
                        999 
                );

            // ADD THUMBNAIL COLUMN
            if( !empty( $options['postpageslist_enable_thumb_column']['enabled'] ) )
                add_action( 
                        'admin_init', 
                        array( $this, 'init_thumb_column' ), 
                        999 
                );

            // CSS FOR CUSTOM COLUMNS
            add_action( 
                    'admin_head-edit.php', 
                    array( $this, 'id_width_and_status_colors' ) 
            );
        }


        /**
         * Persistent Post list mode
         * 
         * @author http://wordpress.stackexchange.com/a/47417/12615
         * @return type
         */
        public function persistent_posts_list_mode()
        {
            // take into account post types that support excerpts
            $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';

            if( $post_type && !post_type_supports( $post_type, 'excerpt' ) )
                return; // don't care

            if( isset( $_REQUEST['mode'] ) )
            {
                // save the list mode
                update_user_meta( get_current_user_id(), 'posts_list_mode' . $post_type, $_REQUEST['mode'] );
                return;
            }

            // retrieve the list mode
            $mode = get_user_meta( get_current_user_id(), 'posts_list_mode' . $post_type, true );
            if( $mode )
                $_REQUEST['mode'] = $mode;
        }


        /**
         * Dispatch ID custom column
         * 
         */
        public function init_id_column()
        {
            add_filter( 'manage_pages_columns', 
                    array( $this, 'id_column_define' ) 
            );
            add_filter( 'manage_posts_columns', 
                    array( $this, 'id_column_define' ) 
            );
            add_action( 'manage_pages_custom_column', 
                    array( $this, 'id_column_display' ), 
                    10, 2 
            );
            add_action( 'manage_posts_custom_column', 
                    array( $this, 'id_column_display' ), 
                    10, 2 
            );
        }


        /**
         * Dispatch Thumbnail custom column
         * 
         */
        public function init_thumb_column()
        {
            add_filter( 
                    'manage_posts_columns', 
                    array( $this, 'thumb_column_define' ) 
            );
            add_filter( 
                    'manage_pages_columns', 
                    array( $this, 'thumb_column_define' ) 
            );
            add_action( 
                    'manage_posts_custom_column', 
                    array( $this, 'thumb_column_display' ), 
                    10, 2 
            );
            add_action( 
                    'manage_pages_custom_column', 
                    array( $this, 'thumb_column_display' ), 
                    10, 2 
            );
        }


        /**
         * Add ID column
         * 
         * @param type $cols
         * @return type
         */
        public function id_column_define( $cols )
        {
            $in = array( "id"  => "ID" );
            $cols = MTT_Plugin_Utils::array_push_after( $cols, $in, 0 );

            return $cols;
        }


        /**
         * Add Thumbnail column
         * 
         * @param type $col_name
         * @param type $id
         */
        public function id_column_display( $col_name, $id )
        {
            if( $col_name == 'id' )
                echo $id;
        }


        /**
         * Register Thumbnail column
         * 
         * @param array $cols
         * @return type
         */
        public function thumb_column_define( $cols )
        {

            $cols['thumbnail'] = __( 'Thumbnail', 'mtt' );

            return $cols;
        }


        /**
         * Render Thumbnail column
         * 
         * @param type $column_name
         * @param type $post_id
         */
        public function thumb_column_display( $column_name, $post_id )
        {
            $width  = $height = !empty( $this->params['postpageslist_enable_thumb_column']['proportion'] )
                ? $this->params['postpageslist_enable_thumb_column']['proportion']
                : '50';

            if( 'thumbnail' == $column_name )
            {
                // FEATURED IMAGE
                $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

                // ATTACHED IMAGE
                $attachments = get_children( array(
                        'post_parent'    => $post_id,
                        'post_type'      => 'attachment',
                        'post_mime_type' => 'image',
                        'numberposts'   => 1,
                        'orderby'        => 'menu_order' )
                );

                if( $thumbnail_id )
                {
                    $thumb = __( 'Featured', 'mtt' ) . '<br>'
                            . wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true );
                }
                elseif( $attachments )
                {
                    $att_id = key($attachments);
                    $thumb = __( 'Attached', 'mtt' ) . '<br>'
                                . wp_get_attachment_image( $att_id, array( $width, $height ), true );                 
                }
                
                if( isset( $thumb ) )
                    echo $thumb;
            }
        }


        /**
         * Print CSS to Post listing screen
         * 
         */
        public function id_width_and_status_colors()
        {
            $output = '';
            if( !empty( $this->params['postpageslist_enable_id_column'] ) )
                $output .= "\t" . '.column-id{width:3em} ' . "\r\n";

            if( !empty( $this->params['postpageslist_enable_thumb_column']['enabled'] ) )
                $output .= "\t" . '.column-thumbnail{width:' . $this->params['postpageslist_enable_thumb_column']['width'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_title_column_width'] ) )
                $output .= "\t" . '.column-title {width: ' . $this->params['postpageslist_title_column_width'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_status_draft'] ) && '#' != $this->params['postpageslist_status_draft'] )
                $output .= "\t" . '.status-draft {background: ' . $this->params['postpageslist_status_draft'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_status_pending'] ) && '#' != $this->params['postpageslist_status_pending'] )
                $output .= "\t" . '.status-pending {background: ' . $this->params['postpageslist_status_pending'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_status_future'] ) && '#' != $this->params['postpageslist_status_future'] )
                $output .= "\t" . '.status-future {background: ' . $this->params['postpageslist_status_future'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_status_private'] ) && '#' != $this->params['postpageslist_status_private'] )
                $output .= "\t" . '.status-private {background: ' . $this->params['postpageslist_status_private'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_status_password'] ) && '#' != $this->params['postpageslist_status_password'] )
                $output .= "\t" . '.post-password-required {background: ' . $this->params['postpageslist_status_password'] . '} ' . "\r\n";

            if( !empty( $this->params['postpageslist_status_others'] ) && '#' != $this->params['postpageslist_status_others'] )
                $output .= "\t" . '.author-other {background: ' . $this->params['postpageslist_status_others'] . '} ' . "\r\n";

            if( '' != $output )
                echo '<style type="text/css">' . "\r\n" . $output . '<style>' . "\r\n";
        }


    }

    
endif;