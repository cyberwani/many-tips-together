<?php

!defined( 'ABSPATH' ) AND exit;


/**
 * SHORTCODES
 */
$options_panel->OpenTab( 'shortcodes' );

$options_panel->Title( __( 'Shortcodes', 'mtt' ) );


// TODO: Tip via: https://github.com/toscho/WordPress-Shortcodes/
$options_panel->addCheckbox( 
    'shortcodes_everywhere', 
    array(
        'name' => __( 'Enable shortcodes everywhere', 'mtt' ),
        'desc' => __( 'In the text widget, excerpts, content and category/tag/taxonomy descriptions'),
        'std'  => false
    )
);


$tubedesc = '<div class="desc">' 
    . __( 'Usage:', 'mtt' ) 
        . ' [poptube id="VIDEO-ID" title="TITLE-OVER-THUMBNAIL" color="#CCCF27" button="WATCH NOW"]
            <div style="text-align:center;width:150px;margin:0 0 15px">
            <h2 style="color:#CCCF27;text-shadow:none;padding:0;margin-bottom:0;">' 
        . __( 'TITLE-OVER', 'mtt' ) 
        . '</h2>
            <a href="http://www.youtube.com/watch_popup?v=s-c_urzTWYQ" target="_blank">
            <img src="http://i3.ytimg.com/vi/s-c_urzTWYQ/default.jpg" alt="youtube thumbnail" style="margin-bottom:-19px"/>
            </a><br />
            <a class="button-secondary" href="http://www.youtube.com/watch_popup?v=s-c_urzTWYQ" target="_blank">' 
        . __( 'WATCH NOW', 'mtt' ) 
        . '</a></div>' 
        . __( 'The "color" attribute is for the title.<br />
            This is the default backend style, for adpating it in your theme 
            use the class "mtt-poptube" for the elements', 'mtt' ) 
        . ' <em>&lt;h2&gt;</em>, <em>&lt;img&gt;</em> ' 
        . __( 'and', 'mtt' ) . ' <em>&lt;a&gt;</em></div>';

$options_panel->addCheckbox( 'shortcodes_tube', array(
    'name' => __( 'Enable YouTube shortcode', 'mtt' ),
    'desc' => $tubedesc,
    'std'  => false
        )
);


$options_panel->addCheckbox( 
    'shortcodes_scloud', 
    array(
        'name' => __( 'Enable SoundCloud shortcode', 'mtt' ),
        'desc' => __( 'Soundcloud offers a shortcode for use in WordPress.COM. This will enable the use of that shortcode.<br />Usage: in SoundCloud, select the button <em>Share</em>, then select the button <em>Edit your widget</em>, after customizing copy the WordPress shortcode and paste in your site. <a href="http://help.soundcloud.com/customer/portal/articles/search?q=embed" target="_blank">Check SoundCloud documentation</a>', 'mtt' ),
        'std'  => false
    )
);


$options_panel->addCheckbox( 
    'shortcodes_gdocs',
    array(
        'name' => __('Enable Google Docs Preview Document shortcode', 'mtt'),
        'desc' => __('Use Google Docs for preview PDF, Word, Excel docuemtns online. <a href="http://docs.google.com/viewer?url=partners.adobe.com/public/developer/en/xml/AdobeXMLFormsSamples.pdf" target="_blank">Example</a>.<br />Usage: [gdocs url="http://www.domain.com/document.pdf" class="my-doc-class"]View Document[/gdocs]', 'mtt'),
         'std' => false
    )
);


$options_panel->CloseTab();