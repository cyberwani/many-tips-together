<?php

!defined( 'ABSPATH' ) AND exit;

/**
 * ADMIN MENUS
 */
$options_panel->OpenTab( 'admin_menus' );

$options_panel->Title( __( 'Admin Menus', 'mtt' ) );

// TODO : credit to @t31os
// http://wordpress.stackexchange.com/a/36360/12615
$options_panel->addCheckbox( 'admin_menus_hover', array(
        'name' => __('Disable Hover Intent', 'mtt'),
        'desc' => __('LOREM IPSUM','mtt'),
        'std'  => false
        )
);


$options_panel->addParagraph( sprintf( 
        '<hr /><h4 class="h3-mtt">%s</h4><p style="font-weight:normal;font-style:italic">%s</p>', 
        __( 'REMOVE MENU ITEMS', 'mtt' ),
        __( 'The following simply removes the menus for all users.<br>Note that this doesn\'t prevent the access using the actual url address of the item.<br/>For a better fine tuning use <a target="_blank" href="http://wordpress.org/extend/plugins/adminimize/">Adminimize</a>. And to really block the access use <a target="_blank" href="http://wordpress.org/extend/plugins/members/">Members</a> or <a target="_blank" href="http://wordpress.org/extend/plugins/user-role-editor/">User-Role-Editor</a>', 'mtt' )
        ) 
);

$options_panel->addCheckboxList( 'admin_menus_remove', array(
    'posts'      => __( 'Posts' ),
    'media'      => __( 'Media' ),
    'links'      => __( 'Links' ),
    'pages'      => __( 'Pages' ),
    'comments'   => __( 'Comments' ),
    'appearence' => __( 'Appearence' ),
    'plugins'    => __( 'Plugins' ),
    'users'      => __( 'Users' ),
    'tools'      => __( 'Tools' ),
     ), 
     array(
        'name' => __( 'Select items to remove:', 'mtt' ),
        'desc' => '',
        'class' => 'no-toggle',
        'std'  => false
     )
);


if ( function_exists( 'get_fields' )  ):

    $options_panel->addParagraph( 
        sprintf( '<hr /><h4 class="h3-mtt">%s</h4>',
            __( 'ADVANCED CUSTOM FIELDS', 'mtt' )
        )
    );


    $users_arr = MTT_Plugin_Utils::get_users_array();
    if( $users_arr )
    {
        $ACF_hide_from_users[] = $options_panel->addSelect( 
            'for_user', 
            $users_arr, 
            array(
                'name' => __( 'Select authorized user.', 'mtt' ),
                'desc' => '',
                'std'  => array( 'none' )
            ),
            true
        );        
        $options_panel->addCondition( 
            'plugins_acf_show_only', 
            array(
                'name' => __( 'Advanced Custom Fields: show ACF menu only for one user.', 'mtt' ),
                'desc' => '',
                'fields' 	=> $ACF_hide_from_users,
                'std' 	=> false
            )
        );
    }        

    // OPTIONS PAGE
    if( get_option( 'acf_options_page_ac' ) )
    {
        $options_panel->addCheckbox( 
            'plugins_acf_hide_options', 
            array(
                'name' => __( 'Advanced Custom Fields: hide "Options" from non-administrators', 'mtt' ),
                'desc' => '',
                'std'  => false
            )
        );

        //$users_arr = MTT_Plugin_Utils::get_users_array();
        if( $users_arr )
        {
            $options_panel->addSelect( 
                'plugins_acf_hide_options_user', 
                $users_arr, 
                array(
                    'name' => __( 'If you want to show only for one user, select bellow.', 'mtt' ),
                    'desc' => __( 'If none is selected, the administrator rule applies. Otherwise, this overrides the previous.', 'mtt' ),
                    'std'  => array( 'none' )
                )
            );        
        }        
    }
endif;


$options_panel->addParagraph( 
        sprintf( '<hr /><h4 class="h3-mtt">%s</h4><p>%s</p>',
            __( 'RENAME POSTS', 'mtt' ), 
            __( 'to whatever you want (i.e. news, articles)', 'mtt' ) 
        )
);


$Post_rename_fields[] = $options_panel->addText( 'name', 
    array( 
        'name'=> __('Name', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 'singular_name', 
    array( 
        'name'=> __('Singular Name', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 'add_new', 
    array( 
        'name'=> __('Add New', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 'edit_item', 
    array( 
        'name'=> __('Edit Posts', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 'view_item', 
    array( 
        'name'=> __('View Posts', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 'search_items', 
    array( 
        'name'=> __('Search Posts', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 'not_found', 
    array( 
        'name'=> __('No Posts found', 'mtt'), 
        'std'=> ''
    ),
    true
);
$Post_rename_fields[] = $options_panel->addText( 
    'not_found_in_trash', 
    array( 
        'name'=> __('No Posts found in trash', 'mtt'), 
        'std'=> ''
    ),
    true
);
$options_panel->addCondition( 
    'posts_rename_enable',
    array(
        'name'	=> __('Enable renaming the word "Posts"', 'mtt'),
        'desc' 	=> sprintf(
              __( 'Maybe you prefer it to be called News or Articles and don\'t want to create a Custom Post Type for that.<br />Tip via: %s', 'mtt' ), 
              MTT_Plugin_Utils::make_tip_credit( 'new2wp', 'http://goo.gl/Gvkle' )
              ),
        'fields' 	=> $Post_rename_fields,
        'std' 	=> false
    )
);  


$options_panel->CloseTab();