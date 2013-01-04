<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * EMAIL
 */
$options_panel->OpenTab( 'appearance' );

$options_panel->Title( __( 'Appearance', 'mtt' ) );

$options_panel->addCheckbox( 'appearance_hide_help_tab', array(
        'name' => __('Hide Help tabs', 'mtt'),
        'desc' => __('Located at top right of most screens.','mtt'),
        'std'  => false
        )
);

$options_panel->addCheckbox( 'appearance_hide_screen_options_tab', array(
        'name' => __('Hide Screen Options tabs', 'mtt'),
        'desc' => __('Located at top right of most screens.','mtt'),
        'std'  => false
        )
);

$Disable_help_texts[] = $options_panel->addRoles( 'level', array(
        'type' => 'checkbox_list'
        ), array(
        'name' => __( 'Hide the help texts from this roles.', 'mtt' ),
        'desc' => '',
        'class'=> 'no-toggle'
        ), true
);

$options_panel->addCondition( 'appearance_help_texts_enable', array(
        'name'   => __( '"Expert Mode" : Disable WordPress help texts', 'mtt' ),
        'desc'   => __( 'No explanations about custom fields, categories description, etc. CSS file copied from <a href="http://wordpress.org/extend/plugins/admin-expert-mode/" target="_blank">Admin Expert Mode</a>, by Scott Reilly. There this is set in a user basis, here in a role basis.', 'mtt' ),
        'fields' => $Disable_help_texts,
        'std'    => false
        )
);


$options_panel->addParagraph( sprintf( '<hr /><h4>%s &diams;</h4>', __( 'PLUGIN THEME - a WPSE diamond touch', 'mtt' ) )  );



$options_panel->addCheckbox( 
    'appearance_clean_admin', 
    array(
        'name' => __('Clean Admin', 'mtt'),
        'desc' => sprintf(
                __( 'An admin interface without gradients, box-shadow and rounded corners. by: %s', 'mtt' ),
                MTT_Plugin_Utils::make_tip_credit( 
                        'toscho', 
                        'https://github.com/toscho/T5-Clean-Admin' 
                        )
                ),
        'std'  => false
        )
);


$options_panel->addCheckbox( 
    'appearance_adminbar_colors', 
    array(
        'name' => __('Admin Bar In System Colors', 'mtt'),
        'desc' => sprintf(
                __( 'Takes away all the fancy stuff and enables a readable interface. by: %s', 'mtt' ),
                MTT_Plugin_Utils::make_tip_credit( 
                        'toscho', 
                        'http://toscho.de/2011/wordpress-adminbar-in-systemfarben/' 
                        )
                ),
        'std'  => false
    )
);


/***********************************
 *          HEADER & FOOTER
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'HEADER AND FOOTER', 'mtt' ) ) );



$Admin_notice_header[] = $options_panel->addTextarea( 'text', array(
        'name' => __( 'Message to display', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

// TODO: FROM WHERE IS THIS TIP?
$options_panel->addCondition( 'admin_notice_header_settings_enable', array(
        'name'   => __( 'Header: enable notice in the Settings page', 'mtt' ),
        'desc'   => __( 'Useful for displaying a notice for clients: "<em>Change this settings at your own risk...</em>".<br />Tip via: %s', 'mtt' ),
        'fields' => $Admin_notice_header,
        'std'    => false
        )
);

$Admin_notice_header_all[] = $options_panel->addTextarea( 'text', array(
        'name' => __( 'Message to display', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Admin_notice_header_all[] = $options_panel->addRoles( 'level', array( 
        'type' => 'checkbox_list' 
        ), 
        array(
            'name' => __( 'Select roles to display the notice, leave empty to show to all roles.', 'mtt' ),
            'desc' => '',
            'class'=> 'no-toggle'
        ), true
);

$options_panel->addCondition( 'admin_notice_header_allpages_enable', array(
        'name'   => __( 'Header: Enable notice all admin pages', 'mtt' ),
        'desc'   => __( 'Useful for displaying a message to all users of the site.', 'mtt' ),
        'fields' => $Admin_notice_header_all,
        'std'    => false
        )
);


$options_panel->addCheckbox( 'admin_notice_footer_hide', array(
        'name' => __( 'Footer: hide', 'mtt' ),
        'desc' => '',
        'std'  => false
        )
);

$Admin_notice_footer[] = $options_panel->addTextarea( 'admin_notice_footer_message_left', array(
        'name' => __( 'Text to display on the left (html enabled)', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Admin_notice_footer[] = $options_panel->addTextarea( 'admin_notice_footer_message_right', array(
        'name' => __( 'Text to display on the right (html enabled)', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$options_panel->addCondition( 'admin_notice_footer_message_enable', array(
        'name'   => __( 'Footer: show only your message', 'mtt' ),
        'desc'   => __( 'Remove all WordPress and other plugins messages, so your message is the only one there...', 'mtt' ),
        'fields' => $Admin_notice_footer,
        'std'    => false
        )
);


/***********************************
 *          EMAIL 
 ***********************************/
//$options_panel->addText( 'email_notice_from_name', array(
//        'name' => __('Change "From" name', 'mtt'),
//        'desc' => __('WordPress default sender name is the Site Title defined in General Settings','mtt'),
//        'std'  => ''
//        )
//);
//
//$options_panel->addText( 'email_notice_site_email_address', array(
//        'name' => __('Change "From" address', 'mtt'),
//        'desc' => __('WordPress default sender address is the E-mail Address registered in General Settings','mtt'),
//        'std'  => ''
//        )
//);
		
$options_panel->CloseTab();