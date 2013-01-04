<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * DASHBOARD
 */
$options_panel->OpenTab( 'dashboard' );

$options_panel->Title( __( 'Dashboard', 'mtt' ) );

$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'REMOVE DASHBOARD WIDGETS', 'mtt' ) ) );

$options_panel->addCheckboxList( 'dashboard_remove', array(
    'quick_press'     => __( 'QuickPress', 'mtt' ),
    'incoming_links'  => __( 'Incoming Links', 'mtt' ),
    'right_now'       => __( 'Right now', 'mtt' ),
    'plugins'         => __( 'Plugins', 'mtt' ),
    'recent_drafts'   => __( 'Recent Drafts', 'mtt' ),
    'recent_comments' => __( 'Recent Comments', 'mtt' ),
    'primary'         => __( 'WordPress Blog', 'mtt' ),
    'secondary'       => __( 'Other WordPress News', 'mtt' ),
    'welcome'         => __( 'Welcome Panel', 'mtt' ),
        ), array(
    'name' => __( 'Remove default items', 'mtt' ),
    'desc' => 'WordPress Blog and Other WP News titles and feed addresses can be configured.',
    'class' => 'no-toggle',                
    'std'  => false
        )
);


$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'CUSTOMIZE RIGHT NOW WIDGET', 'mtt' ) ) );

$options_panel->addCheckbox( 'dashboard_add_cpt_enable', array(
    'name' => __( 'Add Custom Post Types to Right Now Widget', 'mtt' ),
    'desc' => sprintf( __( 'Tip via: %s', 'mtt' ), MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/Y9zDQ' ) ),
    'std'  => false
        )
);

$options_panel->addCheckbox( 'dashboard_remove_footer_rightnow', array(
    'name' => __( 'Hide the footer of Right Now widget', 'mtt' ),
    'desc' => '',
    'std'  => false
        )
);

// TODO: CHECK IF OPTIONS ARE THE SAME
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'ADD CUSTOM WIDGETS', 'mtt' ) ) );



$Dashboard_widget_1_fields[] = $options_panel->addText( 'dashboard_mtt1_title', array(
    'name' => __( 'Title', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);

$Dashboard_widget_1_fields[] = $options_panel->addTextarea( 'dashboard_mtt1_content', array(
    'name' => __( 'Content', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);

$options_panel->addCondition( 'dashboard_mtt1_enable', array(
    'name'   => __( 'Enable Widget 1', 'mtt' ),
    'desc'   => __( 'Use this dashboards to put your own messages or iframes or embeds.', 'mtt' ),
    'fields' => $Dashboard_widget_1_fields,
    'validate_func' => 'validate_html',
    'std'    => false
        )
);



$Dashboard_widget_2_fields[] = $options_panel->addText( 'dashboard_mtt2_title', array(
    'name' => __( 'Title', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);

$Dashboard_widget_2_fields[] = $options_panel->addTextarea( 'dashboard_mtt2_content', array(
    'name' => __( 'Content', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);

$options_panel->addCondition( 'dashboard_mtt2_enable', array(
    'name'   => __( 'Enable Widget 2', 'mtt' ),
    'desc'   => __( 'Use this dashboards to put your own messages or iframes or embeds.', 'mtt' ),
    'fields' => $Dashboard_widget_2_fields,
    'validate_func' => 'validate_html',
    'std'    => false
        )
);



$Dashboard_widget_3_fields[] = $options_panel->addText( 'dashboard_mtt3_title', array(
    'name' => __( 'Title', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);

$Dashboard_widget_3_fields[] = $options_panel->addTextarea( 'dashboard_mtt3_content', array(
    'name' => __( 'Content', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);

$options_panel->addCondition( 'dashboard_mtt3_enable', array(
    'name'   => __( 'Enable Widget 3', 'mtt' ),
    'desc'   => __( 'Use this dashboards to put your own messages or iframes or embeds.', 'mtt' ),
    'fields' => $Dashboard_widget_3_fields,
    'validate_func' => 'validate_html',
    'std'    => false
        )
);




$options_panel->CloseTab();