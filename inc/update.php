<?php
/**
 * Created by brasofilo
 * Date: 4/21/12
 * Time: 11:25 PM
 */
$devOptions      = get_option($this->adminOptionsName);
//$devOptions['adminbar_custom_0_title'] = 'tereza';
foreach( $devOptions as $o ) {
	if( get_option( $o['loginpage'] ) ) {
		//update_option( $o['new_name'], get_option( $o['old_name'] ) );
		delete_option( $o['loginpage'] ); //clean up behind yourself
	}
}
//update_option($this->adminOptionsName, $devOptions);
//update_option('ManyTipsTogetherUPDATE', 'done299!!');
