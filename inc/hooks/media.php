<?php
!defined( 'ABSPATH' ) AND exit;

if ( !class_exists( 'MTT_Hook_Media' ) ):

    class MTT_Hook_Media
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

            // BIGGER THUMBS
            if ( !empty( $options['media_image_bigger_thumbs'] ) )
                add_action( 
                        'admin_head-upload.php', 
                        array( $this, 'bigger_thumbs' ) 
                        );

            // SANITIZE FILENAME
            if ( !empty( $options['media_sanitize_filename'] ) )
                add_filter( 
                        'sanitize_file_name', 
                        array( $this, 'sanitize_filename' ), 
                        10 
                        );

            // COLUMN ID
            if ( !empty( $options['media_image_id_column_enable'] ) )
            {
                add_filter( 
                        'manage_upload_columns', 
                        array( $this, 'id_column_define' ) 
                        );
                add_action( 
                        'manage_media_custom_column', 
                        array( $this, 'id_column_display' ), 
                        10, 2 
                        );
            }

            // COLUMN IMAGE SIZE
            if ( !empty( $options['media_image_size_column_enable'] ) )
            {
                add_filter( 
                        'manage_upload_columns', 
                        array( $this, 'size_column_define' ) 
                        );
                add_action( 
                        'manage_media_custom_column', 
                        array( $this, 'size_column_display' ), 
                        10, 2 
                        );
            }

            // COLUMN LIST OF THUMBNAILS
            if ( !empty( $options['media_image_thubms_list_column_enable'] ) )
            {
                add_filter( 
                        'manage_upload_columns', 
                        array( $this, 'all_thumbs_column_define' ) 
                        );
                add_action( 
                        'manage_media_custom_column', 
                        array( $this, 'all_thumbs_column_display' ), 
                        10, 2 
                        );
            }

            // COLUMN SIZE IN UPLOAD THICKBOX
            if ( !empty( $options['media_add_size_to_upload_window'] ) )
                add_filter( 
                        'media_upload_library', 
                        array($this,'media_upload_library' ) 
                        );

            // COLUMNS ID AND SIZE
            if ( 
                    !empty( $this->params['media_image_id_column_enable'] ) 
                    or !empty( $this->params['media_image_size_column_enable'] ) 
                )
                add_action( 
                        'admin_head-upload.php', 
                        array( $this, 'id_and_size_columns' ) 
                        );


            //BETTER ATTACHMENT
            if ( !empty( $options['media_better_attachment'] ) )
            {
                add_action( 
                        "manage_media_custom_column", 
                        array( $this, 'reattach_column_display' ), 
                        0, 2 
                        );
                add_filter( 
                        "manage_upload_columns", 
                        array( $this, 'reattach_column_redefine' ) 
                        );
            }

            // DOWNLOAD LINK
            if ( !empty( $options['media_download_link'] ) )
            {
                add_action( 
                        'admin_footer-upload.php', 
                        array( $this, 'print_download_js' ) 
                        );
                add_filter( 
                        'media_row_actions', 
                        array( $this, 'row_download_link' ), 
                        10, 3 
                        );
                add_action( 
                        'admin_head-upload.php', 
                        array( $this, 'download_button_css' ) 
                        );
            }

            // JPEG SHARPEN
            if ( !empty( $options['media_jpg_sharpen'] ) )
                add_filter( 
                        'image_make_intermediate_size', 
                        array( $this, 'sharpen_resized_jpgs' ), 
                        900 
                        );

            // JPEG QUALITY
            if ( !empty( $options['media_jpg_quality'] ) )
                add_filter( 
                        'jpeg_quality', 
                        array( $this, 'jpg_quality' ) 
                        );

            // REMOVE META BOXES
            if ( !empty( $options['media_remove_metaboxes'] ) )
                add_action( 
                        'add_meta_boxes', 
                        array( $this, 'all_metabox_remove' ) 
                        );
        }

        
        /**
         * Manipulates thumbnails attributes and properties in wp-admin/upload.php
         */
        public function bigger_thumbs()
        {
            ?>
            <script type="text/javascript">
                jQuery(document).ready( function($) {
                    $('.wp-list-table img').each(function(){
                        $(this).removeAttr('width').css('max-width','100%');
                        $(this).removeAttr('height').css('max-height','100%');
                    });
                    $('.column-icon').css('width', '150px');
                });     
            </script>
            <?php
        }

        
        /**
         * Clean up uploaded file names
         * 
         * @author toscho
         * @url    https://github.com/toscho/Germanix-WordPress-Plugin
         */
        public function sanitize_filename( $filename )
        {

            $filename = html_entity_decode( $filename, ENT_QUOTES, 'utf-8' );
            $filename = $this->translit( $filename );
            $filename = $this->lower_ascii( $filename );
            $filename = $this->remove_doubles( $filename );
            return $filename;
        }

        
        /**
         * Add ID colum to wp-admin/upload.php
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
         * Display ID column in wp-admin/upload.php
         * 
         * @param type $col_name
         * @param type $post_id
         */
        public function id_column_display( $col_name, $post_id )
        {
            if ( $col_name == 'id' )
                echo $post_id;
        }


        /**
         * Add size column to wp-admin/upload.php
         * 
         * @param array $columns
         * @return type
         */
        public function size_column_define( $columns )
        {
            $columns['dimensions'] = __( 'Dimensions', 'mtt' );
            return $columns;
        }


        /**
         * Display size column in wp-admin/upload.php
         * 
         * @param type $column_name
         * @param type $post_id
         * @return type
         */
        public function size_column_display( $column_name, $post_id )
        {
            if ( 'dimensions' != $column_name || !wp_attachment_is_image( $post_id ) )
                return;
            list($url, $width, $height) = wp_get_attachment_image_src( $post_id, 'full' );
            echo "{$width}<span style=\"color:#aaa\"> &times; </span>{$height}";
        }


        /**
         * Print custom columns CSS
         * 
         */
        public function id_and_size_columns()
        {
            $output = '';
            if ( !empty( $this->params['media_image_id_column_enable'] ) )
                $output .= "\t" . '.column-id{width:5%} ' . "\r\n";

            if ( !empty( $this->params['media_image_size_column_enable'] ) )
                $output .= "\t" . '.column-dimensions{width:8%} ' . "\r\n";


            if ( '' != $output )
                echo '<style type="text/css">' . "\r\n" . $output . '</style>' . "\r\n";
        }


        /**
         * Add all thumbs column to wp-admin/upload.php
         * 
         * @param array $columns
         * @return string
         */
        public function all_thumbs_column_define( $columns ) 
        {
            $columns['all_thumbs'] = 'All Thumbs';

            return $columns;
        }

        
        /**
         * Display all thumbs column in wp-admin/upload.php
         * 
         * @param type $column_name
         * @param type $post_id
         * @return type
         */
        public function all_thumbs_column_display( $column_name, $post_id ) 
        {
            if( 'all_thumbs' != $column_name || !wp_attachment_is_image($post_id) )
                return;

            $full_size = wp_get_attachment_image_src( $post_id, 'full' );
            echo '<div style="clear:both">FULL SIZE : '.$full_size[1].' x '.$full_size[2].'</div>';
            
            $size_names = get_intermediate_image_sizes();

            foreach( $size_names as $name )
            {
                // CHECK THIS: http://wordpress.org/support/topic/wp_get_attachment_image_src-problem
                $the_list = wp_get_attachment_image_src( $post_id, $name );
//
                if ( $the_list[3] )
                    echo '<div style="clear:both"><a href="'.$the_list[0].'" target="_blank">'.$name.'</a> : '.$the_list[1].' x '.$the_list[2].'</div>';
            }
            
        }


        /**
         * New way to hook into the correct tab
         * -> triggered by a filter hook
         * 
         */
        public function media_upload_library()
        {
            add_action( 
                    'admin_print_styles-media-upload-popup', 
                    array( $this, 'upload_add_size' ) 
            );
        }


        /**
         * Enqueue script and print style in wp-admin/upload.php
         */
        public function upload_add_size()
        {            
            wp_enqueue_script( 'mtt_thickbox_js' );
            echo '<style>#media-upload th.order-head {width: 5%} #media-upload th.actions-head {width: 10%}</style>';
        }


        /**
         * Add better attach column to wp-admin/upload.php
         * 
         * @param array $columns
         * @return type
         */
        public function reattach_column_redefine( $columns )
        {
            unset( $columns['parent'] );
            $columns['better_parent'] = __( "Attached to", 'mtt' );
            return $columns;
        }


        /**
         * Display better attach column in wp-admin/upload.php
         * 
         * @param type $column_name
         * @param type $id
         * @return type
         */
        public function reattach_column_display( $column_name, $id )
        {
            $post = get_post( $id );
            if ( 'better_parent' != $column_name )
                return;

            if ( $post->post_parent > 0 )
            {
                if ( get_post( $post->post_parent ) )
                {
                    $title = _draft_or_post_title( $post->post_parent );
                }
                ?>
                <strong>
                    <a href="<?php echo get_edit_post_link( $post->post_parent ); ?>">
                        <?php echo $title ?>
                    </a>
                </strong>, 
                <?php echo get_the_time( __( 'Y/m/d' ) ); ?>
                <br/>
                <a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list">
                    <?php _e( 'Re-Attach', 'mtt' ); ?>
                </a>
                <?php
            }
            else
            {
                ?>
                <?php _e( '(Unattached)', 'mtt' ); ?><br/>
                <a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;"
                   href="#the-list">
                       <?php _e( 'Attach', 'mtt' ); ?>
                </a>
                <?php
            }
        }


        /**
         * Add download link to row actions in wp-admin/upload.php
         * 
         * @param array $actions
         * @param type $post
         * @param type $detached
         * @return string
         */
        public function row_download_link( $actions, $post, $detached )
        {
            $the_file = get_attached_file( $post->ID );
            $actions['Download'] = '<a href="'
                . wp_get_attachment_url( $post->ID )
                .'" class="mtt-downloader" alt="Download link" title="'
                . __('Right click as choose Save As', 'mtt')
                . '">Download</a>';
            /*$actions['Download'] = '<a href="'
                //. MTT_Plugin_Init::get_url()
                //. 'inc/force-download.php?file='
                //. $the_file
                . '#'
                . '&mtt-download=true" class="mtt-downloader" id="mtt-attach-'
                . $post->ID
                .'">Download</a>';*/
             return $actions;    
        }

        
        /**
         * Enqueue download script
         */
        public function print_download_js()
        {
            ?>
            <script>
            jQuery(document).ready( function($) 
            { 
                $('.mtt-downloader').click( function(e) 
                {        
                    e.preventDefault();
                    window.open($(this).attr('href'));
                }); 
            });
            </script>
            <?php
        }
        
        
 
        
        /**
         * Print custom columns CSS
         * 
         */
        public function download_button_css()
        {
            echo '<style type="text/css">.mtt-downloader{cursor:pointer}</style>' . "\r\n";
        }



        
        /**
         * Sharpen Jpegs
         * 
         * @param type $resized_file
         * @return \WP_Error
         */
        public function sharpen_resized_jpgs( $resized_file )
        {

            $image = $this->my_wp_load_image( $resized_file );
            if ( !is_resource( $image ) )
                return new WP_Error( 'error_loading_image', $image, $file );

            $size = @getimagesize( $resized_file );
            if ( !$size )
                return new WP_Error( 'invalid_image', __( 'Could not read image size' ), $file );
            list($orig_w, $orig_h, $orig_type) = $size;

            switch ( $orig_type )
            {
                case IMAGETYPE_JPEG:
                    $matrix = array(
                            array( -1, -1, -1 ),
                            array( -1, 16, -1 ),
                            array( -1, -1, -1 ),
                    );

                    $divisor = array_sum( array_map( 'array_sum', $matrix ) );
                    $offset  = 0;
                    imageconvolution( $image, $matrix, $divisor, $offset );
                    imagejpeg( $image, $resized_file, apply_filters( 'jpeg_quality', 90, 'edit_image' ) );
                    break;
                case IMAGETYPE_PNG:
                    return $resized_file;
                case IMAGETYPE_GIF:
                    return $resized_file;
            }

            return $resized_file;
        }

        
        /**
         * Change default Jpeg quality
         * 
         * @param type $arg
         * @return type
         */
        public function jpg_quality( $arg )
        {
            $num = intval( $this->params['media_jpg_quality'] );
            return $num;
        }


        /**
         * Remove meta boxes in wp-admin/upload.php
         * 
         * @global type $current_screen
         * @return type
         */
        public function all_metabox_remove()
        {

            global $current_screen;
            if ( 'attachment' != $current_screen->post_type )
                return;

            //loga( 'attachment screen' );
            /* Author meta box. */
            if ( in_array( 'author', $this->params['media_remove_metaboxes'] ) )
                remove_meta_box( 'authordiv', 'attachment', 'normal' );

            /* Comment status meta box. */
            if ( in_array( 'discussion', $this->params['media_remove_metaboxes'] ) )
                remove_meta_box( 'commentstatusdiv', 'attachment', 'normal' );

            /* Comments meta box. */
            if ( in_array( 'comments', $this->params['media_remove_metaboxes'] ) )
                remove_meta_box( 'commentsdiv', 'attachment', 'normal' );


            /* Slug meta box. */
            if ( in_array( 'slug', $this->params['media_remove_metaboxes'] ) )
                remove_meta_box( 'slugdiv', 'attachment', 'normal' );
        }

        /**
         * Same function without deprecated notice
         * TODO: search for correct method/ ask in [wp-hackers]
         * 
         * @param type $file
         * @return type
         */
        private function my_wp_load_image( $file ) {

            if ( is_numeric( $file ) )
                    $file = get_attached_file( $file );

            if ( ! is_file( $file ) )
                    return sprintf(__('File &#8220;%s&#8221; doesn&#8217;t exist?'), $file);

            if ( ! function_exists('imagecreatefromstring') )
                    return __('The GD image library is not installed.');

            // Set artificially high because GD uses uncompressed images in memory
            @ini_set( 'memory_limit', apply_filters( 'image_memory_limit', WP_MAX_MEMORY_LIMIT ) );
            $image = imagecreatefromstring( file_get_contents( $file ) );

            if ( !is_resource( $image ) )
                    return sprintf(__('File &#8220;%s&#8221; is not an image.'), $file);

            return $image;
        }


	/**
	 * Converts uppercase characters to lowercase and removes the rest.
         * https://github.com/toscho/Germanix-WordPress-Plugin
	 *
	 * @uses   apply_filters( 'germanix_lower_ascii_regex' )
	 * @param  string $str Input string
	 * @return string
	 */
	private function lower_ascii( $str )
	{
		$str   = strtolower( $str );
		$regex = array (
				'pattern'     => '~([^a-z\d_.-])~'
			,	'replacement' => ''
		);
		// Leave underscores, otherwise the taxonomy tag cloud in the
		// backend won’t work anymore.
		return preg_replace( $regex['pattern'], $regex['replacement'], $str );
	}
        
        /**
	 * Replaces non ASCII chars.
         * https://github.com/toscho/Germanix-WordPress-Plugin
	 *
	 * wp-includes/formatting.php#L531 is unfortunately completely inappropriate.
	 * Modified version of Heiko Rabe’s code.
	 *
	 * @author Heiko Rabe http://code-styling.de
	 * @link   http://www.code-styling.de/?p=574
	 * @param  string $str
	 * @return string
	 */
	private function translit( $str )
	{
		$utf8 = array (
				'Ä' => 'Ae'
			,	'ä' => 'ae'
			,	'Æ' => 'Ae'
			,	'æ' => 'ae'
			,	'À' => 'A'
			,	'à' => 'a'
			,	'Á' => 'A'
			,	'á' => 'a'
			,	'Â' => 'A'
			,	'â' => 'a'
			,	'Ã' => 'A'
			,	'ã' => 'a'
			,	'Å' => 'A'
			,	'å' => 'a'
			,	'ª' => 'a'
			,	'ₐ' => 'a'
			,	'ā' => 'a'
			,	'Ć' => 'C'
			,	'ć' => 'c'
			,	'Ç' => 'C'
			,	'ç' => 'c'
			,	'Ð' => 'D'
			,	'đ' => 'd'
			,	'È' => 'E'
			,	'è' => 'e'
			,	'É' => 'E'
			,	'é' => 'e'
			,	'Ê' => 'E'
			,	'ê' => 'e'
			,	'Ë' => 'E'
			,	'ë' => 'e'
			,	'ₑ' => 'e'
			,	'ƒ' => 'f'
			,	'ğ' => 'g'
			,	'Ğ' => 'G'
			,	'Ì' => 'I'
			,	'ì' => 'i'
			,	'Í' => 'I'
			,	'í' => 'i'
			,	'Î' => 'I'
			,	'î' => 'i'
			,	'Ï' => 'Ii'
			,	'ï' => 'ii'
			,	'ī' => 'i'
			,	'ı' => 'i'
			,	'I' => 'I' // turkish, correct?
			,	'Ñ' => 'N'
			,	'ñ' => 'n'
			,	'ⁿ' => 'n'
			,	'Ò' => 'O'
			,	'ò' => 'o'
			,	'Ó' => 'O'
			,	'ó' => 'o'
			,	'Ô' => 'O'
			,	'ô' => 'o'
			,	'Õ' => 'O'
			,	'õ' => 'o'
			,	'Ø' => 'O'
			,	'ø' => 'o'
			,	'ₒ' => 'o'
			,	'Ö' => 'Oe'
			,	'ö' => 'oe'
			,	'Œ' => 'Oe'
			,	'œ' => 'oe'
			,	'ß' => 'ss'
			,	'Š' => 'S'
			,	'š' => 's'
			,	'ş' => 's'
			,	'Ş' => 'S'
			,	'™' => 'TM'
			,	'Ù' => 'U'
			,	'ù' => 'u'
			,	'Ú' => 'U'
			,	'ú' => 'u'
			,	'Û' => 'U'
			,	'û' => 'u'
			,	'Ü' => 'Ue'
			,	'ü' => 'ue'
			,	'Ý' => 'Y'
			,	'ý' => 'y'
			,	'ÿ' => 'y'
			,	'Ž' => 'Z'
			,	'ž' => 'z'
			// misc
			,	'¢' => 'Cent'
			,	'€' => 'Euro'
			,	'‰' => 'promille'
			,	'№' => 'Nr'
			,	'$' => 'Dollar'
			,	'℃' => 'Grad Celsius'
			,	'°C' => 'Grad Celsius'
			,	'℉' => 'Grad Fahrenheit'
			,	'°F' => 'Grad Fahrenheit'
			// Superscripts
			,	'⁰' => '0'
			,	'¹' => '1'
			,	'²' => '2'
			,	'³' => '3'
			,	'⁴' => '4'
			,	'⁵' => '5'
			,	'⁶' => '6'
			,	'⁷' => '7'
			,	'⁸' => '8'
			,	'⁹' => '9'
			// Subscripts
			,	'₀' => '0'
			,	'₁' => '1'
			,	'₂' => '2'
			,	'₃' => '3'
			,	'₄' => '4'
			,	'₅' => '5'
			,	'₆' => '6'
			,	'₇' => '7'
			,	'₈' => '8'
			,	'₉' => '9'
			// Operators, punctuation
			,	'±' => 'plusminus'
			,	'×' => 'x'
			,	'₊' => 'plus'
			,	'₌' => '='
			,	'⁼' => '='
			,	'⁻' => '-'    // sup minus
			,	'₋' => '-'    // sub minus
			,	'–' => '-'    // ndash
			,	'—' => '-'    // mdash
			,	'‑' => '-'    // non breaking hyphen
			,	'․' => '.'    // one dot leader
			,	'‥' => '..'  // two dot leader
			,	'…' => '...'  // ellipsis
			,	'‧' => '.'    // hyphenation point
			,	' ' => '-'   // nobreak space
			,	' ' => '-'   // normal space
		);

		$str = strtr( $str, $utf8 );
		return trim( $str, '-' );
	}

        /**
	 * Reduces repeated meta characters (-=+.) to one.
         * https://github.com/toscho/Germanix-WordPress-Plugin
	 *
	 * @uses   apply_filters( 'germanix_remove_doubles_regex' )
	 * @param  string $str Input string
	 * @return string
	 */
	private function remove_doubles( $str )
	{
		$regex = apply_filters(
			'germanix_remove_doubles_regex'
		,	array (
				'pattern'     => '~([=+.-])\\1+~'
			,	'replacement' => "\\1"
			)
		);
		return preg_replace( $regex['pattern'], $regex['replacement'], $str );
	}


    }

    
endif;

