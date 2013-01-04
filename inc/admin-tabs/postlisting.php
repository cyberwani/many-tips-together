<?php

!defined( 'ABSPATH' ) AND exit;


/**
 * POST LISTING
 */
$options_panel->OpenTab( 'post_listing' );

$options_panel->Title( __( 'Post, Page and Custom Post Types listing', 'mtt' ) );

$options_panel->addCheckbox( 
    'postpageslist_persistent_list_view', 
    array(
        'name' => __( 'Posts: persistent Post listing view', 'mtt' ),
        'desc' => sprintf(
                __( 'If you change the viewing mode (list or excerpt view), it doesn\'t stick. Follow this %s.<br /><img src="%s" alt="persistent listing"><br />Tip via: %s', 'mtt' ),
                MTT_Plugin_Utils::make_tip_credit( 'track ticket', 'http://core.trac.wordpress.org/ticket/20335' ),
                $this->plugin_url . "images/persistent-listing.jpg",
                MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/ijfb3' )
        ),
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpageslist_template_filter_enable', 
    array(
        'name' => __( 'Pages: enable filtering by Template', 'mtt' ),
        'desc' => sprintf(
                __( 'Tip via: %s', 'mtt' )
                , MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/BqGUl' )
        ),
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpageslist_duplicate_del_revisions', 
    array(
        'name' => __( 'All types: enable Duplicate and Delete Revisions', 'mtt' ),
        'desc' => __('Based on GD Press Tools', 'mtt'),
        'std'  => false
    )
);


$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'CUSTOM COLUMNS', 'mtt' ) ) );


$options_panel->addCheckbox( 
    'postpageslist_enable_id_column', 
    array(
        'name' => __( 'All types:: add ID column', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addText( 
    'postpageslist_title_column_width', 
    array(
        'name' => __( 'All types: width of the Title column', 'mtt' ),
        'desc' => __( 'Sometimes the Title column gets shrinked by other columns, you may change this here. Use px or %, i.e. 200px, 50%', 'mtt' ),
        'std'  => ''
    )
);


$Thumbnail_column_fields[] = $options_panel->addText( 
    'proportion', 
    array(
        'name' => __( 'Proportion of the thumbnails', 'mtt' ),
        'desc' => __( 'Used for width and height. The scale is proportional, this value is used for the bigger side.', 'mtt' ),
        'std'  => ''
    ), 
    true
);

$Thumbnail_column_fields[] = $options_panel->addText( 
    'width', 
    array(
        'name' => __( 'Width of the column', 'mtt' ),
        'desc' => __( 'Depending on the proportion you may need this. Use px or %, i.e. 200px, 50%', 'mtt' ),
        'std'  => ''
    ), 
    true
);

$options_panel->addCondition( 
    'postpageslist_enable_thumb_column', 
    array(
        'name' => __( 'All types: add Thumbnail column', 'mtt' ),
        'desc' => sprintf(
                __( 'Shows the featured image or, if not set, the first attached.<br />Tip via: %s', 'mtt' )
                , MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/Y9zDQ' )
            ),
        'validate_func' => 'validate_thumb_column',
        'fields' => $Thumbnail_column_fields,
        'std'    => false
    )
);


$options_panel->addParagraph( 
    sprintf( 
        '<hr /><h4>%s</h4>', 
        __( 'CUSTOM COLORS FOR DIFFENT TYPES OF CONTENT', 'mtt' ) 
    ) 
);


$options_panel->addColor( 
    'postpageslist_status_draft', 
    array(
        'name' => __('Posts-Pages Draft color', 'mtt'),
        'desc' => ''
    )
);


$options_panel->addColor( 
    'postpageslist_status_pending', 
    array(
        'name' => __('Posts-Pages Pending color', 'mtt'),
        'desc' => ''
    )
);


$options_panel->addColor( 
    'postpageslist_status_future', 
    array(
        'name' => __('Posts-Pages Future color', 'mtt'),
        'desc' => ''
    )
);


$options_panel->addColor( 
    'postpageslist_status_private', 
    array(
        'name' => __('Posts-Pages Private color', 'mtt'),
        'desc' => ''
    )
);


$options_panel->addColor( 
    'postpageslist_status_password', 
    array(
        'name' => __('Posts-Pages Password Protected color', 'mtt'),
        'desc' => ''
    )
);


$options_panel->addColor( 
    'postpageslist_status_others', 
    array(
        'name' => __('Posts-Pages Other Author\'s color', 'mtt'),
        'desc' => ''
    )
);


$options_panel->CloseTab();