<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * MAINTENANCE MODE
 */
$options_panel->OpenTab( 'maintenance' );

$options_panel->Title( __( 'Maintenance Mode', 'mtt' ) );

$Maintenance_mode_fields[] = $options_panel->addText( 'title', array(
        'name' => __( 'Browser Title &lt;title&gt;', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Maintenance_mode_fields[] = $options_panel->addText( 'line0', array(
        'name' => __( 'Text for the first line', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Maintenance_mode_fields[] = $options_panel->addText( 'line1', array(
        'name' => __( 'Text for the second line', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Maintenance_mode_fields[] = $options_panel->addText( 'line2', array(
        'name' => __( 'Link for the third line, without http://', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Maintenance_mode_fields[] = $options_panel->addImage( 'html_img', array(
        'name'           => __( 'Page background image (full URL)', 'mtt' ),
        'desc'           => __( 'Use a pattern or a big image, or enter 0 (zero) to disable', 'mtt' ),
        'preview_height' => 'auto',
        'preview_width'  => '140px'
        ), true
);

$Maintenance_mode_fields[] = $options_panel->addImage( 'body_img', array(
        'name'           => __( 'Box background image (full URL)', 'mtt' ),
        'desc'           => __( 'Use a pattern or a big image', 'mtt' ),
        'preview_height' => 'auto',
        'preview_width'  => '140px'
        ), true
);

//$Maintenance_mode_fields[] = $options_panel->addImage( 'glow_img', array(
//        'name'           => __( 'Glow image in the center (full URL)', 'mtt' ),
//        'desc'           => __( 'Transparent image, or enter 0 (zero) to disable', 'mtt' ),
//        'preview_height' => 'auto',
//        'preview_width'  => '140px'
//        ), true
//);

$Maintenance_mode_fields[] = $options_panel->addRoles( 'level', array( 
        'type' => 'select'
        ), 
        array(
        'name' => __( 'Minimum user level to access site.', 'mtt' ),
        'desc' => '',
        'class'=> 'no-fancy'
        ), true
);

//$Maintenance_mode_fields[] = $options_panel->addCheckbox( 'only_admin', array(
//        'name'                     => __( 'NOT WORKING:::WAITING ISSUE #20 ::: Block only admin area', 'mtt' ),
//        'desc'                     => __( 'Useful when doing maintenance task that don\'t require taking the site down, but block non-admins from doing any changes.', 'mtt' ),
//        'std'                      => '',
//        'class' => 'no-toggle'
//        ), true
//);

$Maintenance_mode_fields[] = $options_panel->addCheckboxList( 'other_options', array(
    'only_admin'      => __( 'Block only admin area' ),
     ), 
     array(
        'name' => __( 'Other options', 'mtt' ),
        'desc' => '',
        'class' => 'no-toggle',
        'std'  => false
     ), true
);

$Maintenance_mode_fields[] = $options_panel->addCode( 'extra_css', array(
        'name'   => __( 'Custom CSS', 'mtt' ),
        'desc'   => __( 'Add your custom css to further stylize the Maintenance page', 'mtt' ),
        'std'    => '.class-name {}',
        'theme'  => 'dark',
        'syntax' => 'css'
        ), true
);

// TODO: REVISE INSTRUCTIONS
$options_panel->addCondition( 'maintenance_mode_enable', array(
        'name'   => __( 'Enable maintenance mode', 'mtt' ),
        'desc'   => __( 'Block the site to visitors and not-admins. To display your own custom page, follow the instruction in the file <em><strong>many-tips-together/maintenance/index.php</strong></em>.', 'mtt' ),
        'fields' => $Maintenance_mode_fields,
        'std'    => false
        )
);

$options_panel->CloseTab();
