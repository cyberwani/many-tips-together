<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * WIDGETS
 */
$options_panel->OpenTab( 'widgets' );

$options_panel->Title( __( 'Widgets', 'mtt' ) );


$options_panel->addText( 
    'widget_rss_update_timer', 
    array(
        'name' => __( 'RSS Widget: update timer (in minutes)', 'mtt' ),
        'desc' => sprintf( 
            __( 'Default is 12 hours, leave blank for not activating<br />Tip via: %s', 'mtt' ), 
            MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/Y9zDQ' ) 
        ),
        'std'  => ''
    )
);


$options_panel->addCheckbox( 
    'widget_meta_slim', 
    array(
        'name'   => __( 'New Meta widget', 'mtt' ),
        'desc'   => __( 'Based on the original, removes WordPress links and adds a custom link'),
        'std'    => false
    )
);


$options_panel->addParagraph( 
    sprintf( 
        '<hr /><h4>%s</h4>', 
        __( 'REMOVE WIDGETS', 'mtt' ) 
    ) 
);


$akismet = array();
if( defined('AKISMET_VERSION') )
    $akismet = array( 'widget_remove_akismet' => __( 'Akismet', 'mtt' ) );

$widgets_defaults = array(
        'pages'           => __( 'Pages', 'mtt' ),
        'calendar'        => __( 'Calendar', 'mtt' ),
        'archives'        => __( 'Archives', 'mtt' ),
        'links'           => __( 'Links', 'mtt' ),
        'meta'            => __( 'Meta', 'mtt' ),
        'search'          => __( 'Search', 'mtt' ),
        'text'            => __( 'Text', 'mtt' ),
        'categories'      => __( 'Categories', 'mtt' ),
        'recent_posts'    => __( 'Recent Posts', 'mtt' ),
        'recent_comments' => __( 'Recent Comments', 'mtt' ),
        'rss'             => __( 'RSS', 'mtt' ),
        'tag_cloud'       => __( 'Tag Cloud', 'mtt' ),
        'nav_menu'        => __( 'Custom Menu', 'mtt' )
        );
$widgets_array = array_merge($akismet, $widgets_defaults);
$options_panel->addCheckboxList( 
    'widget_remove', 
    $widgets_array, 
    array(
        'name' => __( 'Remove default items', 'mtt' ),
        'desc' => '',
        'class' => 'no-toggle',
        'std'  => false
    )
);


$options_panel->CloseTab();
