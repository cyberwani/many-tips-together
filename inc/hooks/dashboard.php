<?php

!defined( 'ABSPATH' ) AND exit;

if( !class_exists( 'MTT_Hook_Dashboard' ) ):

    class MTT_Hook_Dashboard
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
            //loga( 'MTT_Hook_Dashboard' );

            $this->params = $options;

            $welcome = !empty( $this->params['dashboard_remove'] ) ? in_array( 'welcome', $this->params['dashboard_remove'] ) : false;
            if( $welcome )
                add_action( 'admin_head-index.php', array( $this, 'remove_welcome' ) );

            if( !empty( $this->params['dashboard_remove_footer_rightnow'] ) )
                add_action( 'admin_head-index.php', array( $this, 'right_now_footer' ) );

            if( !empty( $this->params['dashboard_add_cpt_enable'] ) )
                add_action( 'right_now_content_table_end', array( $this, 'right_now_cpt' ) );

            if( !empty( $this->params['dashboard_remove'] ) )
                add_action( 'wp_dashboard_setup', array( $this, 'manipulate_widgets' ), 0 );
        }


        public function remove_welcome()
        {
            ?>
            <style type="text/css">

                #welcome-panel {display:none}
            </style>
            <script type="text/javascript">
                jQuery(document).ready( function($) 
                {
                    $("label[for='wp_welcome_panel-hide']").remove();
                });     
            </script>
            <?php

        }


        public function right_now_footer()
        {
            echo '<script type="text/javascript">jQuery(document).ready( function($) { $(".versions").html("") });</script>';
            //echo '<style>.versions p, .versions span, p.akismet-right-now {display:none}</style>';
        }


        public function right_now_cpt()
        {
            $args = array(
                    'public'   => true,
                    'show_ui'  => true,
                    '_builtin' => false
            );
            $output    = 'object';
            $operator  = 'and';

            $post_types = get_post_types( $args, $output, $operator );
            foreach( $post_types as $post_type )
            {
                $num_posts = wp_count_posts( $post_type->name );
                $num       = number_format_i18n( $num_posts->publish );
                $text      = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
                if( current_user_can( 'edit_posts' ) )
                {
                    $num        = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
                    $text       = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
                }
                echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
                echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
            }
            $taxonomies = get_taxonomies( $args, $output, $operator );
            foreach( $taxonomies as $taxonomy )
            {
                $num_terms = wp_count_terms( $taxonomy->name );
                $num       = number_format_i18n( $num_terms );
                $text      = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, intval( $num_terms ) );
                if( current_user_can( 'manage_categories' ) )
                {
                    $num  = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num</a>";
                    $text = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$text</a>";
                }
                echo '<tr><td class="first b b-' . $taxonomy->name . '">' . $num . '</td>';
                echo '<td class="t ' . $taxonomy->name . '">' . $text . '</td></tr>';
            }
        }


        public function manipulate_widgets()
        {
            if( in_array( 'quick_press', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

            if( in_array( 'incoming_links', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );

            if( in_array( 'right_now', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );

            if( in_array( 'plugins', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );

            if( in_array( 'recent_drafts', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );

            if( in_array( 'recent_comments', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

            if( in_array( 'primary', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // other news

            if( in_array( 'secondary', $this->params['dashboard_remove'] ) )
                remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' ); // official blog

                
// CUSTOM WIDGET 1
            if( !empty( $this->params['dashboard_mtt1_enable']['enabled'] ) )
            {
                $title = ($this->params['dashboard_mtt1_enable']['dashboard_mtt1_title'] == '') ? '&nbsp;&nbsp;' : stripslashes( $this->params['dashboard_mtt1_enable']['dashboard_mtt1_title'] );
                wp_add_dashboard_widget( 'dashboard1_mtt_title', $title, array( $this, 'add_dashboard_content1' ) );
            }

            // CUSTOM WIDGET 2
            if( !empty( $this->params['dashboard_mtt2_enable']['enabled'] ) )
            {
                $title = ($this->params['dashboard_mtt2_enable']['dashboard_mtt2_title'] == '') ? '&nbsp;&nbsp;' : $this->params['dashboard_mtt2_enable']['dashboard_mtt2_title'];
                wp_add_dashboard_widget( 'dashboard2_mtt_title', $title, array( $this, 'add_dashboard_content2' ) );
            }

            // CUSTOM WIDGET 3
            if( !empty( $this->params['dashboard_mtt3_enable']['enabled'] ) )
            {
                $title = ($this->params['dashboard_mtt3_enable']['dashboard_mtt3_title'] == '') ? '&nbsp;&nbsp;' : $this->params['dashboard_mtt3_enable']['dashboard_mtt3_title'];
                wp_add_dashboard_widget( 'dashboard3_mtt_title', $title, array( $this, 'add_dashboard_content3' ) );
            }
        }


        public function add_dashboard_content1()
        {
            echo do_shortcode( $this->params['dashboard_mtt1_enable']['dashboard_mtt1_content'] );
        }


        public function add_dashboard_content2()
        {
            echo do_shortcode( $this->params['dashboard_mtt2_enable']['dashboard_mtt2_content'] );
        }


        public function add_dashboard_content3()
        {
            echo do_shortcode( $this->params['dashboard_mtt3_enable']['dashboard_mtt3_content'] );
        }


    }

    
endif;