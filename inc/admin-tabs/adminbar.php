<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * ADMIN BAR
 */
$options_panel->OpenTab( 'admin_bar' );

$options_panel->Title( __( 'Admin Bar', 'mtt' ) );
//$options_panel->addParagraph( __( '', 'mtt' ) );

// TODO: tip via @bueltge
$options_panel->addCheckbox( 'adminbar_completely_disable', array(
    'name' => __( 'Completely remove the Admin Bar', 'mtt' ),
    'desc' => __( 'LOREM IPSUM LOREM', 'mtt' ),
    'std'  => false
        )
);

$options_panel->addCheckbox( 'adminbar_disable', array(
    'name' => __( 'Disable Admin Bar for all users in Frontend', 'mtt' ),
    'desc' => __( 'This works for the admin area too in WordPress 3.2.<br />In 3.3, instead of fighting it, I decided to customize as follows:', 'mtt' ),
    'std'  => false
        )
);

$yoast = array();
if( defined('WPSEO_URL') )
    $yoast = array( 'seo_by_yoast' => __( 'SEO by Yoast', 'mtt' ) );


$adminbar_remove_defaults = array(
    'wp_logo'       => __( 'WP logo', 'mtt' ),
    'site_name'     => __( 'Site name', 'mtt' ),
    'updates'       => __( 'Updates', 'mtt' ),
    'comments'      => __( 'Comments', 'mtt' ),
    'new_content'   => __( 'New content', 'mtt' ),
    'theme_options' => __( 'Theme options', 'mtt' ),
    'my_account'    => __( 'My account', 'mtt' ),
);

$adminbar_remove_array = array_merge( $adminbar_remove_defaults, $yoast );

$options_panel->addCheckboxList( 'adminbar_remove', $adminbar_remove_array, 
        array(
            'name' => __( 'Remove default items', 'mtt' ),
            'desc' => '',
            'class' => 'no-toggle',
            'std'  => false
        )
);


$Howdy_change[] = $options_panel->addText( 'howdy', array(
        'name' => __( 'Replace with', 'mtt' ),
        'desc' => __( 'Leave empty for complete removal', 'mtt' ),
        'std'  => ''
        ), true
);

// TODO: PUT NOTICE: ONLY 3.4 UP 
$options_panel->addCondition( 'adminbar_howdy_enable', array(
        'name'   => __( 'Remove or change "Howdy"', 'mtt' ),
        'desc'   => '',
        'fields' => $Howdy_change,
        'std'    => false
        )
);

$Adminbar_sitename_fields[] = $options_panel->addText( 'adminbar_sitename_title', array(
    'name'                      => __( 'Title', 'mtt' ),
    'desc'                      => '',
    'std'                       => ''
        ), true
);
$Adminbar_sitename_fields[] = $options_panel->addImage( 'adminbar_sitename_icon', array(
    'name'                      => __( 'Icon (between 16x16 and 22x22 pixels)', 'mtt' ),
    'std'                       => '',
    'desc'                      => '',
    'preview_height'            => 'auto',
    'preview_width'             => '140px'
        ), true
);
$Adminbar_sitename_fields[] = $options_panel->addText( 'adminbar_sitename_url', array(
    'name' => __( 'URL', 'mtt' ),
    'desc' => '',
    'std'  => ''
        ), true
);
$options_panel->addCondition( 'adminbar_sitename_enable', array(
    'name'   => __( 'Add Site Name with Icon', 'mtt' ),
    'desc'   => __( 'Add a custom link with title and icon', 'mtt' ),
    'fields' => $Adminbar_sitename_fields,
    'validate_func' => 'validate_adminbar_sitename',
    'std'    => false
        )
);

$Adminbar_custom_menu_fields[] = $options_panel->addText( 'adminbar_custom_0_title', array(
    'name'                         => __( 'Menu name', 'mtt' ),
    'desc'                         => __( '*Required', 'mtt' ),
    'std'                          => ''
        ), true
);
$Adminbar_custom_menu_fields[] = $options_panel->addText( 'adminbar_custom_0_url', array(
    'name' => __( 'Menu link', 'mtt' ),
    'desc' => __( 'If empty, makes a null link', 'mtt' ),
    'std'  => ''
        ), true
);
for ( $i = 1; $i < 6; $i++ )
{
    $Adminbar_custom_menu_fields[] = $options_panel->addText( 'adminbar_custom_' . $i . '_title', array(
        'name'                         => sprintf( __( 'Submenu %s name', 'mtt' ), "$i" ),
        'desc'                         => __( '*Required', 'mtt' ),
        'std'                          => ''
            ), true
    );
    $Adminbar_custom_menu_fields[] = $options_panel->addText( 'adminbar_custom_' . $i . '_url', array(
        'name' => sprintf( __( 'Submenu %s link', 'mtt' ), "$i" ),
        'desc' => __( 'If empty, makes a null link', 'mtt' ),
        'std'  => ''
            ), true
    );
}
$options_panel->addCondition( 'adminbar_custom_enable', array(
    'name'   => __( 'Enable Custom Menu', 'mtt' ),
    'desc'   => '',
    'fields' => $Adminbar_custom_menu_fields,
    'validate_func' => 'validate_adminbar_custom',
    'std'    => false
        )
);

$options_panel->CloseTab();