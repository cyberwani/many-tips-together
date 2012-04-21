<?php
/**
 * Created by brasofilo
 * Date: 4/21/12
 * Time: 11:25 PM
 */
$devOptions      = get_option($this->adminOptionsName);

foreach( $devOptions as $key => $value ) {
	if( $key == 'loginpage' ) {
		unset( $devOptions[$key] );
	}
	if( $key == 'admin_bar') {
		$devOptions['adminbar_disable'] = $value;
		unset( $devOptions[$key] );
	}

	if( $key == 'contato_bio') {
		$devOptions['profile_bio'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'contato_hidden') {
		$devOptions['profile_hidden'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'contato_none') {
		$devOptions['profile_none'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'contato_slim') {
		$devOptions['profile_slim'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'contato_social') {
		$devOptions['profile_social'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_autop') {
		$devOptions['wpdisable_autop'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_capitalp') {
		$devOptions['wpdisable_capitalp'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_nourl') {
		$devOptions['wpdisable_nourl'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_selfping') {
		$devOptions['wpdisable_selfping'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_smartquotes') {
		$devOptions['wpdisable_smartquotes'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_version_full') {
		$devOptions['wpdisable_version_full'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'disable_version_number') {
		$devOptions['wpdisable_version_number'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard1_mtt') {
		$devOptions['dashboard_mtt1_enable'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard1_mtt_content') {
		$devOptions['dashboard_mtt1_content'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard1_mtt_title') {
		$devOptions['dashboard_mtt1_title'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard2_mtt') {
		$devOptions['dashboard_mtt2_enable'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard2_mtt_content') {
		$devOptions['dashboard_mtt2_content'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard2_mtt_title') {
		$devOptions['dashboard_mtt2_title'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard3_mtt') {
		$devOptions['dashboard_mtt3_enable'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard3_mtt_content') {
		$devOptions['dashboard_mtt3_content'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'enable_dashboard3_mtt_title') {
		$devOptions['dashboard_mtt3_title'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_backsite') {
		$devOptions['loginpage_backsite_hide'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_body') {
		$devOptions['loginpage_body_img'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_color') {
		$devOptions['loginpage_body_color'] = '#'.$value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_height') {
		$devOptions['loginpage_logo_height'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_logo') {
		$devOptions['loginpage_logo_img'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_logo_url') {
		$devOptions['loginpage_logo_url'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'loginpage_tooltip') {
		$devOptions['loginpage_logo_tooltip'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'logout') {
		$devOptions['logout_redirect_enable'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'logout_url') {
		$devOptions['logout_redirect_url'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'maintenance_mode') {
		$devOptions['maintenance_mode_enable'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'post_autosave') {
		$devOptions['postpages_post_autosave'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'post_revision') {
		$devOptions['postpages_post_revision'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_incoming_links') {
		$devOptions['dashboard_remove_incoming_links'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_plugins') {
		$devOptions['dashboard_remove_plugins'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_primary') {
		$devOptions['dashboard_remove_primary'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_quick_press') {
		$devOptions['dashboard_remove_quick_press'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_recent_comments') {
		$devOptions['dashboard_remove_recent_comments'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_recent_drafts') {
		$devOptions['dashboard_remove_recent_drafts'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_right_now') {
		$devOptions['dashboard_remove_right_now'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'remove_dashboard_secondary') {
		$devOptions['dashboard_remove_secondary'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'small_plugin') {
		$devOptions['mtt_small_plugin'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'update_plg') {
		$devOptions['wpblock_update_plugins'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'update_wp') {
		$devOptions['wpblock_update_wp'] = $value;
		unset( $devOptions[$key] );
	}
	if( $key == 'verbose_plugin') {
		$devOptions['mtt_verbose_plugin'] = $value;
		unset( $devOptions[$key] );
	}
}
update_option($this->adminOptionsName, $devOptions);