<?php

!defined( 'ABSPATH' ) AND exit;
/**
 * @package Many Tips Together
 * @author  GD Press Tools (gdragon)
 * http://wordpress.org/extend/plugins/gd-press-tools/
 */
if( !class_exists( "MTT_Manage_Duplicates_Revisions" ) )
{

    class MTT_Manage_Duplicates_Revisions
    {
        static private $class = null;

        public static function init()
        {
            if( null === self::$class )
                self :: $class = new self;

            return self :: $class;
        }


        public function __construct()
        {
            if( !is_admin() )
                return;
            $this->make_duplicate();
            add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );
            add_filter( 'page_row_actions', array( $this, 'post_row_actions' ), 10, 2 );
        }


        private function duplicate_post( $old_id )
        {
            global $wpdb, $table_prefix;
            

            $sql      = sprintf( 
                    "SELECT * FROM %sposts WHERE ID = %s", 
                    $table_prefix, 
                    $old_id 
                    );
            $old_post = $wpdb->get_row( $sql );
            
            $sql      = sprintf( 
                    "SELECT * FROM %spostmeta WHERE post_id = %s", 
                    $table_prefix, 
                    $old_id 
                    );
            $old_meta = $wpdb->get_results( $sql );
            
            $sql      = sprintf( 
                    "SELECT * FROM %sterm_relationships WHERE object_id = %s", 
                    $table_prefix, 
                    $old_id 
                    );
            $old_term = $wpdb->get_results( $sql );

            $post_date     = current_time( 'mysql' );
            $post_date_gmt = get_gmt_from_date( $post_date );

            unset( $old_post->ID );
            unset( $old_post->filter );
            unset( $old_post->guid );
            unset( $old_post->post_date_gmt );

            $old_post->post_date         = $post_date;
            $old_post->post_status       = "draft";
            $old_post->post_title.= " (1)";
            $old_post->post_name.= "-1";
            $old_post->post_modified     = $post_date;
            $old_post->post_modified_gmt = $post_date_gmt;
            $old_post->comment_count     = "0";

            if( false === $wpdb->insert( $wpdb->posts, get_object_vars( $old_post ) ) )
                return 0;
            
            $post_ID = (int) $wpdb->insert_id;

            $wpdb->update( $wpdb->posts, 
                    array( 'guid' => get_permalink( $post_ID ) ), 
                    array( 'ID' => $post_ID ) 
                    );

            foreach( $old_meta as $m )
            {
                unset( $m->meta_id );
                $m->post_id = $post_ID;
                $wpdb->insert( $wpdb->postmeta, get_object_vars( $m ) );
            }
            
            foreach( $old_term as $m )
            {
                unset( $m->meta_id );
                $m->object_id = $post_ID;
                $wpdb->insert( $wpdb->term_relationships, get_object_vars( $m ) );
            }

            

            return $post_ID;
        }


        private function delete_revisions( $post_id )
        {
            global $wpdb, $table_prefix;
            
            $sql = sprintf( 
                    "DELETE %s, %s, %s FROM %sposts p 
                        LEFT JOIN %sterm_relationships t ON t.object_id = p.ID 
                        LEFT JOIN %spostmeta m ON m.post_id = p.ID 
                        WHERE p.post_type = 'revision' 
                        AND p.post_parent = %s", 
                    "p", 
                    "t", 
                    "m", 
                    $table_prefix, 
                    $table_prefix, 
                    $table_prefix, 
                    $post_id );
            $wpdb->query( $sql );
            return $wpdb->rows_affected;
        }


        private function make_duplicate()
        {
            if( !isset( $_GET["mtt-dups-revs"] ) )
                return;
            $gd_action = $_GET["mtt-dups-revs"];
            if( $gd_action != '' )
            {
                switch( $gd_action )
                {
                    case "delrev":
                        $post_id = $_GET["pid"];
                        $counter = $this->delete_revisions( $post_id );
                        wp_redirect(
                                remove_query_arg(
                                        array( 'pid', 'mtt-dups-revs' ), 
                                        stripslashes( $_SERVER['REQUEST_URI'] )
                                )
                        );
                        exit();
                        break;
                    case "duplicate":
                        $post_id = $_GET["pid"];
                        $new_id  = $this->duplicate_post( $post_id );
                        if( $new_id > 0 )
                            wp_redirect( sprintf(
                                            "post.php?action=edit&post=%s", 
                                            $new_id
                                    ) );
                        else
                            wp_redirect(
                                    remove_query_arg(
                                            array( 'pid', 'mtt-dups-revs' ), 
                                            stripslashes( $_SERVER['REQUEST_URI'] )
                                    )
                            );
                        exit();
                        break;
                }
            }
        }


        private function count_revisions( $post_id )
        {
            global $wpdb, $table_prefix;

            $sql = sprintf(
                    "SELECT count(*) AS revisions 
                        FROM %sposts WHERE post_type = 'revision' 
                        AND post_parent = %s", 
                    $table_prefix, 
                    $post_id
            );
            return $wpdb->get_var( $sql );
        }


        public function post_row_actions( $actions, $post )
        {
            $url                  = add_query_arg( "pid", $post->ID, $_SERVER['REQUEST_URI'] );
            $actions["duplicate"] = sprintf(
                    '<a style="color: #00008b" href="%s" title="%s">%s</a>', 
                    add_query_arg( "mtt-dups-revs", "duplicate", $url ), 
                    __( "Duplicate", "mtt" ), 
                    __( "Duplicate", "mtt" )
            );
            $counter              = $this->count_revisions( $post->ID );
            $sure_msg             = sprintf(
                    __( "Are you sure you want to delete the REVISIONS of the post %s?", "mtt" ), 
                    $post->post_title
            );
            if( $counter > 0 )
                $actions["revisions"] = sprintf(
                        '<a style="color: #cc0000" onclick="if (confirm(\'%s\')) { return true; } return false;" href="%s" title="%s">%s (%s)</a>', 
                        __( "Confirm delete of revisions?", "mtt" ), 
                        add_query_arg( "mtt-dups-revs", "delrev", $url ), 
                        __( "Delete Revisions", "mtt" ), 
                        __( "Delete Revisions", "mtt" ), 
                        $counter
                );
            return $actions;
        }


    }

// end class
} // end if