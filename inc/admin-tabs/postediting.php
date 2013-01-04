<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * POST EDITING
 */
$options_panel->OpenTab( 'post_editing' );

$options_panel->Title( __( 'Post and Page Editing', 'mtt' ) );


$options_panel->addCheckbox( 
    'postpages_enable_page_excerpts', 
    array(
        'name' => __( 'Pages: enable Excerpt', 'mtt' ),
        'desc' => sprintf( __( 'Tip via: %s', 'mtt' ), MTT_Plugin_Utils::make_tip_credit( 'Smashing Magazine', 'http://goo.gl/cSCpy' ) ),
        'std'  => false
    )
);


$options_panel->addText( 
    'postpages_post_revision', 
    array(
        'name' => __( 'Posts-Pages: number of revisions to maintain', 'mtt' ),
        'desc' => __( '-1 (unlimited) | 0 (none) | 1 or more (custom)', 'mtt' ),
        'validate_func' => 'validate_number',
        'std'  => ''
    )
);


$options_panel->addText( 
    'postpages_post_autosave', 
    array(
        'name' => __( 'Posts-Pages: auto-save interval <em>in minutes</em>', 'mtt' ),
        'desc' => '',
        'validate_func' => 'validate_number',
        'std'  => ''
    )
);


$options_panel->addParagraph( 
    sprintf( 
        '<hr /><h4>%s</h4>', 
        __( 'MOVE METABOXES', 'mtt' ) 
    ) 
);


$options_panel->addCheckbox( 
    'postpages_move_author_metabox', 
    array(
        'name' => __( 'Posts-Pages: move the Author metabox into the Publish metabox', 'mtt' ),
        'desc' => sprintf( __( 'Tip via: %s', 'mtt' ), MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/Y9zDQ' ) ),
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpages_move_comments_metabox', 
    array(
        'name' => __( 'Posts-Pages: move the Discussion metabox into the Publish metabox', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addParagraph( 
    sprintf( 
        '<hr /><h4>%s</h4><p class="desc-field">%s</p>', 
        __( 'HIDE FROM PUBLISH METABOX', 'mtt' ), 
        __('also easy with Adminimize, but as I use this normally, it\'s faster by here.', 'mtt' ) 
    ) 
);


$options_panel->addCheckboxList( 
    'postpages_hide_from_publish', 
    array(
        'status'      => __( 'Status' ),
        'visibility'  => __( 'Visibility' ),
        'published'   => __( 'Published On' ),
     ), 
     array(
        'name' => __( 'Affects ALL post types. Select items to hide:', 'mtt' ),
        'desc' => '',
        'class' => 'no-toggle',
        'std'  => false
     )
);


$options_panel->addParagraph( 
    sprintf( 
        '<hr /><h4>%s</h4><small>%s</small>', 
        __( 'REMOVE METABOXES<br />', 'mtt' ), 
        __('<p class="desc-field"><i>although Adminimize can handle this filtering by roles, it only hides the meta box and it doen\'t removes it from the Screen Options</i></p>', 'mtt') 
    ) 
);


$options_panel->addSelect( 
    'postpages_disable_mbox_author', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'AUTHOR', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addSelect( 
    'postpages_disable_mbox_comment_status', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'DISCUSSION', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addSelect( 
    'postpages_disable_mbox_comment', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'COMMENTS', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addSelect( 
    'postpages_disable_mbox_custom_fields', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'CUSTOM FIELDS', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addSelect( 
    'postpages_disable_mbox_featured_image', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'FEATURED IMAGE', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addSelect( 
    'postpages_disable_mbox_revisions', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'REVISIONS', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addSelect( 
    'postpages_disable_mbox_slug', 
    array(
        'none'          => 'none',
        'post'          => 'post',
        'page'          => 'page',
        'post_and_page' => 'post and page'
    ), 
    array(
        'name' => __( 'SLUG', 'mtt' ),
        'desc' => '',
        'class' => 'no-fancy',
        'std'  => null
    )
);


$options_panel->addParagraph( 
    sprintf(
        '<h4>%s</h4>',
        __( 'PAGES ONLY', 'mtt' ) 
    ) 
);


$options_panel->addCheckbox( 
        'postpages_disable_mbox_attributes', 
        array(
        'name' => __( 'ATTRIBUTES', 'mtt' ),
        'desc' => '',
        'std'  => false
        )
);


$options_panel->addParagraph( sprintf('<h4>%s</h4>', __( 'POSTS ONLY', 'mtt' ) ) );


$options_panel->addCheckbox( 
    'postpages_disable_mbox_format', 
    array(
        'name' => __( 'FORMAT', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpages_disable_mbox_category', 
    array(
        'name' => __( 'CATEGORY', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpages_disable_mbox_excerpt', 
    array(
        'name' => __( 'EXCERPT', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpages_disable_mbox_tags', 
    array(
        'name' => __( 'TAGS', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'postpages_disable_mbox_trackbacks', 
    array(
        'name' => __( 'TRACKBACKS', 'mtt' ),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->CloseTab();