<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * GENERAL SETTINGS
 */
$options_panel->OpenTab( 'general' );

$options_panel->Title( __( 'General Settings', 'mtt' ) );


/***********************************
 *          FRONTEND
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'FRONTEND', 'mtt' ) ) );


$options_panel->addCheckbox( 'wpdisable_version_full', array(
        'name' => __( 'Completely eliminate WordPress version in &lt;head&gt;', 'mtt' ),
        'desc' => '',
        'std'  => false
        )
);

$options_panel->addCheckbox( 'wpdisable_version_number', array(
        'name' => __( 'Eliminate only the WordPress version number in &lt;head&gt;', 'mtt' ),
        'desc' => '',
        'std'  => false
        )
);


/***********************************
 *          UPDATE NOTICES
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'UPDATES', 'mtt' ) ) );

$options_panel->addCheckbox( 'wpblock_update_wp', array(
        'name' => __( 'Block WordPress upgrade notice', 'mtt' ),
        'desc' => __( 'Yes, I know that, but cannot do it right now...', 'mtt' ),
        'std'  => false
        )
);

$options_panel->addCheckbox( 'wpblock_update_screen', array(
        'name' => __( 'Block update screen and redirect to Dashboard.', 'mtt' ),
        'desc' => '',
        'std'  => false
        )
);


/***********************************
 *    PRIVACY and RESTRICTIONS
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'PRIVACY and RESTRICTIONS', 'mtt' ) ) );

$options_panel->addCheckbox( 'wpdisable_nourl', array(
        'name' => __( 'Hide blog URL from WordPress "phone home"', 'mtt' ),
        'desc' => __( 'Filter out the blog URL from the data that is sent to wordpress.org - Check this <a href="http://lynnepope.net/wordpress-privacy">article</a> to learn more.', 'mtt' ),
        'std'  => false
        )
);

// TODO: is this "privacy"?
$options_panel->addCheckbox( 'wpdisable_selfping', array(
        'name' => __( 'Disable Self Ping', 'mtt' ),
        'desc' => __( 'Prevents WordPress from sending pings to your own site.', 'mtt' ),
        'std'  => false
        )
);

// TODO: tip via wpse 57206
$options_panel->addCheckbox( 'wpdisable_redirect_disallow', array(
        'name' => __( 'Redirect unauthorized attempts.', 'mtt' ),
        'desc' => __( 'If the user tries to access an admin page directly via URL, e.g.: /wp-admin/plugins.php, it goes stright to the frontend', 'mtt' ),
        'std'  => false
        )
);


/***********************************
 *          TAXONOMY COLUMNS
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'TAXONOMY ID AND POST COUNT', 'mtt' ) ) );

// TODO: tip via @toscho
$options_panel->addCheckbox( 'wptaxonomy_columns', array(
        'name' => __( 'Enable', 'mtt' ),
        'desc' => __( 'LOREM IPSUM LOREM', 'mtt' ),
        'std'  => false
        )
);


/***********************************
 *          RSS
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'RSS', 'mtt' ) ) );


$Enable_rss_delay[] = $options_panel->addText( 'time', array(
        'name' => __( 'Number of delay', 'mtt' ),
        'desc' => '',
        'std'  => ''
        ), true
);

$Enable_rss_delay[] = $options_panel->addSelect( 'period', array(
        'MINUTE' => __( 'MINUTE', 'mtt' ),
        'HOUR'   => __( 'HOUR', 'mtt' ),
        'DAY'    => __( 'DAY', 'mtt' ),
        'WEEK'   => __( 'WEEK', 'mtt' ),
        'MONTH'  => __( 'MONTH', 'mtt' ),
        'YEAR'   => __( 'YEAR', 'mtt' )
        ), array(
        'name' => __( 'Period of delay', 'mtt' ),
        'desc' => '',
        'class'=> 'no-fancy',
        'std'  => array( 'MINUTE' )
        ), true
);

$options_panel->addCondition( 'wprss_delay_publish_enable', array(
        'name'   => __( 'Delay RSS feed update', 'mtt' ),
        'desc'   => sprintf( __( 'This can give you time to make corrections after publishing a post, delaying the update in your RSS feed. Or you can make your content web exclusive for a larger period. Tip via: %s', 'mtt' ), MTT_Plugin_Utils::make_tip_credit( 'StackExchange', 'http://goo.gl/Y9zDQ' ) ),
        'fields' => $Enable_rss_delay,
        'std'    => false
        )
);


/***********************************
 *          AVATARS
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'AVATARS', 'mtt' ) ) );


$Custom_gravatar_field[] = $options_panel->addImage( 'img', array(
        'name'           => sprintf( __( 'Bellow are your new gravatars, and you can also upload your own image :)  <br /> <br /><img src="%s" width="36" height="36" alt="gravatar 1"> <img src="%s" width="36" height="36" alt="gravatar 2"> <img src="%s" width="36" height="36" alt="gravatar 3"><br /><a href="http://www.fasticon.com/" target="_blank">Icons by: FastIcon.com</a>', 'mtt' ), $this->plugin_url . 'images/avatar1.png', $this->plugin_url . 'images/avatar2.png', $this->plugin_url . 'images/avatar3.png' ),
        'desc'           => '',
        'preview_height' => 'auto',
        'preview_width'  => '140px'
        ), true
);

$options_panel->addCondition( 'wpenable_custom_gravatars_enable', array(
        'name'   => __( 'Custom gravatars', 'mtt' ),
        'desc'   => '',
        'fields' => $Custom_gravatar_field,
        'std'    => false
        )
);



/***********************************
 *          AUTOCOWERKS
 ***********************************/
$options_panel->addParagraph( sprintf( '<hr /><h4>%s</h4>', __( 'AUTOCOWERKS', 'mtt' ) ) );

$options_panel->addCheckbox( 'wpdisable_smartquotes', array(
        'name' => __( 'Disable SmartQuotes', 'mtt' ),
        'desc' => __( 'Prevent the conversion of straight quotes into directional quotes.', 'mtt' ),
        'std'  => false
        )
);

$options_panel->addCheckbox( 'wpdisable_capitalp', array(
        'name' => __( 'Disable Capital P', 'mtt' ),
        'desc' => __( 'Prevents WordPress of auto-correcting mispellings of its name. Check this <a href="http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit">article</a>', 'mtt' ),
        'std'  => false
        )
);

$options_panel->addCheckbox( 'wpdisable_autop', array(
        'name' => __( 'Disable Auto P', 'mtt' ),
        'desc' => __( 'Prevents WordPress from inserting automatic &lt;p&gt; tags in your code.', 'mtt' ),
        'std'  => false
        )
);


/**
 * END
 */
$options_panel->CloseTab();