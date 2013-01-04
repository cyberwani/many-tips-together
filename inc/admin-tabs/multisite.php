<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * MULTISITE
 */
$options_panel->OpenTab( 'multisite' );

$options_panel->Title( __( 'Multisite', 'mtt' ) );


$options_panel->addParagraph( 
    __( 'This section only appears in the main site and for super-admins.', 'mtt').'<hr />' 
);


$options_panel->addCheckbox( 
    'multisite_active_plugins_widget', 
    array(
        'name' => __('Enable Active Plugins widget', 'mtt'),
        'desc' => __('Lists all network activated plugins, and all sites with their plugins.','mtt'),
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'multisite_site_id_column', 
    array(
        'name' => __('Enable Site ID column in sites list', 'mtt'),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'multisite_blogname_column', 
    array(
        'name' => __('Enable Site Name column in sites list', 'mtt'),
        'desc' => '',
        'std'  => false
    )
);


$options_panel->addCheckbox( 'multisite_redirect_new_site', 
        array(
        'name' => __('Redirect to site details after new site creation.', 'mtt'),
        'desc' => __( 'The default behavior is to stay in the same screen', 'mtt'),
        'std'  => false
        )
);


// TODO: Tip via http://wordpress.stackexchange.com/a/77812/12615
$options_panel->addCheckbox( 
    'multisite_sort_sites_names', 
    array(
        'name' => __( 'Sort sites by name and domain.', 'mtt' ),
        'desc' => __( 'Sorted by name in the Admin Bar, and by domain in Sites of User. This is a hook into get_blogs_of_user, and I\'m not sure if it has adverse effects elsewhere. Feedback is welcome, use the WPSE post.', 'mtt' ),
        'std'  => false
    )
);


// TODO: Tip via: http://helen.wordpress.com/2011/08/01/customizing-the-special-multisite-dashboards/
$options_panel->addCheckboxList( 
    'multisite_dashboard_remove', 
    array(
        'right_now'       => __( 'Right now', 'mtt' ),
        'plugins'         => __( 'Plugins', 'mtt' ),
        'primary'         => __( 'WordPress Blog', 'mtt' ),
        'secondary'       => __( 'Other WordPress News', 'mtt' ),
    ), 
    array(
        'name' => __( 'Remove default items', 'mtt' ),
        'desc' => 'WordPress Blog and Other WP News titles and feed addresses can be configured.',
        'class' => 'no-toggle',                
        'std'  => false
    )
);


$options_panel->addParagraph( 
    sprintf( 
        '<hr /><p><i>%s:</i> %s</p>',
        __( 'PLUGINS', 'mtt' ), 
        __( 'all setting applied in the Plugins section are also applied in the network screen.', 'mtt') 
    ) 
);


$options_panel->CloseTab();