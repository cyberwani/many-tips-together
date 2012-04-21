<?php
/*
Part of Plugin: Many Tips Together
*/

// Make sure that we are uninstalling
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}

// Leave no trail
delete_option('ManyTipsTogether');

?>