<?php

!defined( 'ABSPATH' ) AND exit;


/**
 * MEDIA
 */
$options_panel->OpenTab( 'media' );

$options_panel->Title( __( 'Media', 'mtt' ) );


$options_panel->addParagraph( 
        sprintf( '<hr /><h4>%s</h4>', 
                __( 'MEDIA LIBRARY', 'mtt' ) 
        ) 
);


$options_panel->addCheckbox( 
        'media_image_bigger_thumbs', 
        array(
            'name' => __( 'Bigger thumbnails in the default column', 'mtt' ),
            'desc' => '',
            'std'  => false
        )
);


$options_panel->addCheckbox( 
        'media_image_id_column_enable', 
        array(
            'name' => __( 'Add ID column', 'mtt' ),
            'desc' => '',
            'std'  => false
        )
);


$options_panel->addCheckbox( 
        'media_image_size_column_enable', 
        array(
            'name' => __( 'Add image size column', 'mtt' ),
            'desc' => sprintf( 
                        __( 'Tip via: %s', 'mtt' ), 
                        MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/dfd8t' ) 
                    ),
            'std'  => false
        )
);


$options_panel->addCheckbox( 
        'media_image_thubms_list_column_enable', 
        array(
            'name' => __( 'Add a column that lists all thumbnails of the image, with direct link to it.', 'mtt' ),
            'desc' => sprintf( 
                    __( 'Tip via: %s', 'mtt' ), 
                    MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/dfd8t' ) 
                    ),
            'std'  => false
        )
);


$options_panel->addCheckbox( 
        'media_download_link', 
        array(
            'name' => __( 'Download link in row actions', 'mtt' ),
            'desc' => sprintf( 
                        __( 'Adds a download link to all items (Edit|Delete|View|Download). Tip via: %s', 'mtt' ), 
                        MTT_Plugin_Utils::make_tip_credit( 
                                'WPSE', 
                                'http://wordpress.stackexchange.com/q/30159/12615' 
                        ) 
                     ),
            'std'  => false
        )
);


$options_panel->addCheckbox( 
        'media_better_attachment', 
        array(
            'name' => __( 'Enables the re-attachemnt', 'mtt' ),
            'desc' => sprintf( 
                    __( 'Change the parent of the media file to another post/page<br />Unfortunately, this disables the capability to sort the column... Tip via: %s', 'mtt' ), 
                    MTT_Plugin_Utils::make_tip_credit( 'WPEngineer', 'http://goo.gl/wywy5' ) 
                    ),
            'std'  => false
        )
);


$options_panel->addCheckboxList( 
        'media_remove_metaboxes', 
        array(
            'discussion'    => __( 'Discussion', 'mtt' ),
            'comments'      => __( 'Comments', 'mtt' ),
            'slug'          => __( 'Slug', 'mtt' ),
            'author'        => __( 'Author', 'mtt' )
        ), 
        array(
            'name' => __( 'Remove Meta Boxes', 'mtt' ),
            'desc' => '',
            'class' => 'no-toggle',                
            'std'  => false
    )
);


$options_panel->addParagraph( 
        sprintf( '<hr /><h4>%s</h4>', 
                __( 'IMAGES UPLOAD', 'mtt' ) 
        ) 
);


$options_panel->addCheckbox( 
        'media_sanitize_filename', 
        array(
            'name' => __( 'Sanitize filename', 'mtt' ),
            'desc' => sprintf( 
                    __( 'Removes symbols, spaces, latin and other languages characters from uploaded files and gives them "permalink" structure (clean characters, only lowercase and dahes)<br />Tip via: %s', 'mtt' ), 
                    MTT_Plugin_Utils::make_tip_credit( 'CSS Tricks', 'http://goo.gl/k2yAq' ) 
                    ),
            'std'  => false
    )
);

$options_panel->addCheckbox( 
        'media_jpg_sharpen', 
        array(
            'name' => __( 'Sharpen resized images (only jpg)', 'mtt' ),
            'desc' => sprintf( 
                    __( 'Check an <a href="http://i.stack.imgur.com/hkLaX.png" target="_blank">example</a>. . . Tip via: %s', 'mtt' ), 
                    MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/Y9zDQ' ) 
                    ),
            'std'  => false
    )
);

$options_panel->addText( 
        'media_jpg_quality', 
        array(
            'name' => __( 'Quality of resized Jpegs', 'mtt' ),
            'desc' => __( 'From 1 to 100. WordPress default is 90.' ),
            'std'  => ''
        )
);


$options_panel->addCheckbox( 
        'media_add_size_to_upload_window', 
        array(
            'name' => __( 'Add image size column to the Media Upload window', 'mtt' ),
            'desc' => sprintf( 
                    __( 'ONLY WORKS for the old Thickbox window, NOT the new Media Library. Tip via: %s', 'mtt' ), 
                    MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/LDklI' ) 
                    ),
            'std'  => false
        )
);


$options_panel->CloseTab();