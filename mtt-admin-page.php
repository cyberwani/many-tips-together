<?php


global $wpdb;
if (isset($_POST['my_reset_options']) && $_POST['my_reset_options'] == 'Y')
	$this->resetAdminOptions();

$devOptions = $this->getAdminOptions();

$badUrl        = '<span style="color:red;font-weight:bold;"> * ' . __('Bad formed URL', 'mtt') . '</span>';
$badValue      = '<span style="color:red;font-weight:bold;"> * ' . __('Invalid value', 'mtt') . '</span>';
$warnAllErrors = '<span style="color:red;font-weight:bold;"> * ' . __('Check the errors marked in red...', 'mtt') . '</span>';

$init = 'no';

$warnUpdate        = ""; // if any warning bellow is filled, this one will be filled too
$warnUrl           = "";
$warnUrlImg        = "";
$warnUrlBody       = "";
$warnUrlLogoUrl    = "";
$warnRevisions     = "";
$warnAutoSave      = "";
$warnHeight        = "";
$warnProfile       = "";
$warnWidgetUrl1    = "";
$warnWidgetUrl2    = "";
$warnAdminTitleUrl = "";

// magicQuotes issue
// http://goo.gl/aOpxD and http://goo.gl/d97mu
if (get_magic_quotes_gpc()) $_POST = stripslashes_deep($_POST);


// DELETE REVISIONS
if (isset($_POST['my_erase_revisions']) && $_POST['my_erase_revisions'] == 'Y') {
	$wpdb->query("DELETE a,b,c FROM $wpdb->posts a LEFT JOIN  $wpdb->term_relationships b ON (a.ID = b.object_id) LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) WHERE a.post_type = 'revision'");
	?>
<div id="updated2" class="updated"><p><strong><?php _e('Revisions deleted from database.', 'mtt'); ?></strong></p></div>
<?php
}
// END IF(isset) 

// RESET OPTIONS 
if (isset($_POST['my_reset_options'])) {
	?>
<div id="updated3" class="updated"><p><strong><?php _e('Settings reset.', 'mtt'); ?></strong></p></div>
<?php
}
// END IF(isset) 


// MAIN OPTIONS	
if (isset($_POST['update_mttSettings'])) {

	/* BOOLEAN OPTIONS */
	foreach ($this->mttBooleanOptions as $option) {
		$devOptions[$option] = (isset($_POST[$option]) && $_POST[$option]) ? 1 : 0;
	}

	/* REGULAR STRING OPTIONS */
	foreach ($this->mttStringOptions as $option) {
		$devOptions[$option] = $_POST[$option];
	}


	/* URL CHECKERS */
	if (isset($_POST['mttMetaWidgetUrl1'])) {
		$theWidgetUrl1 = $_POST['mttMetaWidgetUrl1'];
		if ($this->validateUrl($theWidgetUrl1))
			$devOptions['widget_meta_link1_url'] = $theWidgetUrl1;
		else
			$warnWidgetUrl1 = $badUrl;
	}
	if (isset($_POST['mttMetaWidgetUrl2'])) {
		$theWidgetUrl2 = $_POST['mttMetaWidgetUrl2'];
		if ($this->validateUrl($theWidgetUrl2))
			$devOptions['widget_meta_link2_url'] = $theWidgetUrl2;
		else
			$warnWidgetUrl2 = $badUrl;
	}
	if (isset($_POST['adminbar_sitename_url'])) {
		$theAdminTitleUrl = $_POST['adminbar_sitename_url'];
		if ($this->validateUrl($theAdminTitleUrl))
			$devOptions['adminbar_sitename_url'] = $theAdminTitleUrl;
		else
			$warnAdminTitleUrl = $badUrl;
	}
	if (isset($_POST['mttLoginLogoURL'])) {
		$theLoginLogoUrl = $_POST['mttLoginLogoURL'];
		if ($this->validateUrl($theLoginLogoUrl))
			$devOptions['loginpage_logo_url'] = $theLoginLogoUrl;
		else
			$warnUrlLogoUrl = $badUrl;
	}
	if (isset($_POST['mttLogOutUrl'])) {
		$theLogoutUrl = $_POST['mttLogOutUrl'];
		if ($this->validateUrl($theLogoutUrl))
			$devOptions['logout_redirect_url'] = $theLogoutUrl;
		else
			$warnUrl = $badUrl;
	}

	/* ERROR WARNINGS */
	if ($warnUrl != "" || $warnUrlImg != "" || $warnUrlBody != "" || $warnRevisions != "" || $warnAutoSave != "" || $warnHeight != "" || $warnProfile != "" || $warnUrlLogoUrl != "" || $warnWidgetUrl1 != "" || $warnWidgetUrl2 != "" || $warnAdminTitleUrl != "") $warnUpdate = $warnAllErrors;


	update_option($this->adminOptionsName, $devOptions);

	// used to display Update message
	$init = 'yes';

} // - - - - - - - END IF(ISSET) - - - - - - - - -- - - - - - --  

?>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<div class="mtt-box">
	<div class="inner">
		<div id="icon-options-mtt" class="icon32"><a href="http://www.rodbuaiz.com"><img
			src="<?php echo $this->logo; ?>" alt="rodbuaiz.com" title="rodbuaiz.com"/></a></div>
		<h2>Many Tips Together<br/><em style="font-size:.5em;"><?php _e('version','mtt'); ?> <a class="thickbox" title="<?php echo  "Many Tips Together " . __('version','mtt') . $this->mtt_tb_title; ?>" href="<?php bloginfo('url'); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=many-tips-together&section=changelog&TB_iframe=true&width=640&height=559"><?php echo $this->version; ?></a></em>
		</h2>
		<ul class="left hl" style="margin: -12px 0 6px 0;text-align: right;">
			<li id="bsf-link"><?php _e("by", 'mtt'); ?> brasofilo</li>
			<script>
				jQuery("#bsf-link").click(function ($) {
					window.open('http://brasofilo.com');
					return false;
				});
			</script>
		</ul>
		<?php $this->mttPrintRepositoryData(); ?>
		<hr style="opacity:.3"/>
		<label for="mtt_verbose_plugin"><input name="mtt_verbose_plugin" id="mtt_verbose_plugin"
											   type="checkbox" <?php $checked = ($devOptions['mtt_verbose_plugin']) ? ' checked="yes"' : ''; echo $checked; ?>><?php _e('Hide plugin help', 'mtt'); ?>
		</label>

		<p class="desc"><span style="color:#C5C5C5"><?php _e('(some settings need a second refresh<br />for being visible)', 'mtt'); ?></span><br></p>
		<br style="clear:both"/>
		<label for="mtt_small_plugin"><input name="mtt_small_plugin" id="mtt_small_plugin"
											 type="checkbox" <?php $checked = ($devOptions['mtt_small_plugin']) ? ' checked="yes"' : ''; echo $checked; ?>><?php _e('Start with all tabs closed', 'mtt'); ?>
		</label>

		<br style="clear:both"/>
		<br style="clear:both"/>
		<div class="submit update-button mtt-update"><input type="submit" class="button-primary"
		                                                    name="update_mttSettings"
		                                                    value="<?php _e('Update settings', 'mtt') ?>"/></div>

		<br style="clear:both"/>

	</div>
	<div id="alert_bar" class="footer" style="display:none">
		<?php
		if ($init == 'yes') {
			echo '<script type="text/javascript">jQuery(document).ready( function($) {	$("#alert_bar").slideDown(); window.setTimeout(function(){$("#alert_bar").slideUp()},7500);});</script>';  ?>
			<p><strong><?php _e('Settings updated.',
				'mtt'); ?></strong></p><?php
			if (strlen($warnUpdate) > 0): ?>
				<div class="mtt-error">
					<script type="text/javascript">jQuery(document).ready(function ($) {
						window.setTimeout(function () {
							$("div.inside").css("display", "block");
						}, 100);
					});</script>
					<p><?php echo $warnUpdate; ?></p>
				</div><?php
			endif;
		} ?>
	</div>
	<div class="footer">

		<ul class="right hl">
			<li><a href="http://wordpress.org/extend/plugins/many-tips-together/"
				   target="_blank"><?php _e("Rate this plugin in wordpress.org", 'mtt'); ?></a></li>
		</ul>
	</div>
</div>

<div class=wrap>

<!--Main Settings-->
<div id="poststuff" class="metabox-holder">
<div class="meta-box-sortables ui-sortable">


<!-- LOGIN AND LOGOUT-->
<?php
$this->makeOpenCloseMetabox(true, 'login-box', __('Login and Logout', 'mtt'));


echo '<h4>' . __('LOGOUT - REDIRECTION', 'mtt') . '</h4>';
$this->makeCheckbox('logout_redirect_enable', __('Redirect logout to another address', 'mtt'), __('The default behavior is being redirected to the login page...', 'mtt'));
$this->makeTextbox('mttLogOutUrl', 'logout_redirect_url', __('URL to redirect to', 'mtt'), false, $warnUrl, ' id="laUrl"', '50', false);


echo '<br /><h4>' . __('LOGIN - BACKGROUND', 'mtt') . '</h4>';
$this->makeImageUploader('mttLoginBody', 'loginpage_body_img', __('Background image (full URL)', 'mtt'), false, false);
$this->makeColorPicker('loginpage_body_color', __('Background color', 'mtt'), false, 'mtt-cp-1');
$this->makeGenericList('loginpage_body_position', __('Background position', 'mtt'), false, array('', 'left top', 'left center', 'left bottom', 'right top', 'right center', 'right bottom', 'center top', 'center center', 'center bottom'));

$this->makeGenericList('loginpage_body_repeat', __('Background repeat', 'mtt'), false, array('', 'repeat', 'no-repeat'));

$this->makeGenericList('loginpage_body_attachment', __('Background scroll', 'mtt'), false, array('', 'fixed', 'scroll'));


echo '<br /><h4>' . __('LOGIN - LOGO', 'mtt') . '</h4>';
$this->makeTextbox('loginpage_logo_tooltip', 'loginpage_logo_tooltip', __('Title for logo', 'mtt'), __('Appears as tooltip.<br />The default text is: "Powered by WordPress"', 'mtt'), false, false, '50', false);
$this->makeTextbox('mttLoginLogoURL', 'loginpage_logo_url', __('Link for the logo (full URL)', 'mtt'), __('Link for the logo, default: wordpress.org', 'mtt'), $warnUrlLogoUrl, false, '50', false);
$this->makeImageUploader('mttLoginImage', 'loginpage_logo_img', __('Logo image (full URL)', 'mtt'), __('Select an image from your library, Upload a new one, or Paste the full URL of another one...', 'mtt'), false);
$this->makeTextbox('loginpage_logo_height', 'loginpage_logo_height', __('Logo height', 'mtt'), __('Default: 67 - maximum value recomended:  300px', 'mtt'), $warnHeight, false, '1', '3');
$this->makeTextbox('loginpage_logo_padding', 'loginpage_logo_padding', __('Logo margin from top', 'mtt'), __('Default: 114px', 'mtt'), false, false, '1', '3');


echo '<br /><h4>' . __('LOGIN - BOX', 'mtt') . '</h4>';
$this->makeTextbox('loginpage_form_width', 'loginpage_form_width', __('Width', 'mtt'), __('The logo width is limited by this one', 'mtt'), false, false, '1', '3');
$this->makeTextbox('loginpage_form_height', 'loginpage_form_height', __('Height', 'mtt'), false, false, false, '1', '3');
$this->makeCheckbox('loginpage_form_noshadow', __('Disable shadow', 'mtt'));
$this->makeTextbox('loginpage_form_rounded', 'loginpage_form_rounded', __('Rounded corners', 'mtt'), false, false, false, '1', '3');
$this->makeTextbox('loginpage_form_border', 'loginpage_form_border', __('Border -> CSS declaration', 'mtt'), __('Follow the default value...','mtt'), false, false, '50', false);
$this->makeColorPicker('loginpage_form_bg_color', __('Background color', 'mtt'), false, 'mtt-cp-101');
$this->makeImageUploader('mttLoginFormImage', 'loginpage_form_bg_img', __('Background image', 'mtt'), false, false);
$this->makeTextbox('loginpage_button_position', 'loginpage_button_position', __('Log In button position', 'mtt'), __('Negative numbers are ok','mtt'), false, false, '1', '4');


echo '<br /><h4>' . __('LOGIN - PASSWORD AND BACK TO SITE', 'mtt') . '</h4>';
$this->makeCheckbox('loginpage_backsite_hide', sprintf(__('Hide link "Back to %s"', 'mtt'), get_bloginfo('name')), __('You can use the logo for that.', 'mtt'));
$this->makeCheckbox('loginpage_text_shadow', __('Remove text shadow', 'mtt'));
$this->makeTextbox('loginpage_links_position', 'loginpage_links_position', __('Vertical position of the links', 'mtt'), __('Negative numbers are ok', 'mtt'), false, false, '1', '4');


echo '<br /><h4>' . __('LOGIN - EXTRA CSS', 'mtt') . '</h4>';
$this->makeTextArea('loginpage_extra_css', 'loginpage_extra_css', '', __('Extra CSS for the final touches', 'mtt'), false, 'width: 100%; height: 100px;', true);


echo '<br /><h4>' . __('LOGIN - ERRORS', 'mtt') . '</h4>';
$this->makeCheckbox('loginpage_errors', __('Error message', 'mtt'), __('Don\'t reveal what\'s the mistake, user or password', 'mtt'));
$this->makeTextArea('loginpage_error_msg', 'loginpage_error_msg', '', __('Don\'t use html code.', 'mtt'), ' id="laMsgErr"', 'width: 100%; height: 100px;', true);


$this->makeOpenCloseMetabox(false);
?>



<!-- ADMIN BAR -->
<?php
$this->makeOpenCloseMetabox(true, 'adminbar-box', __('Admin Bar', 'mtt'));

$this->makeCheckbox('adminbar_disable', __('Disable Admin Bar for all users in Frontend', 'mtt'), __('This works for the admin area too in WordPress 3.2.<br />In 3.3, instead of fighting it, I decided to customize as follows:', 'mtt'));

$this->makeCheckbox('adminbar_remove_comments', __('Remove Comments', 'mtt'));
$this->makeCheckbox('adminbar_remove_my_account', __('Remove My Account', 'mtt'));
$this->makeCheckbox('adminbar_remove_updates', __('Remove Updates', 'mtt'));
$this->makeCheckbox('adminbar_remove_wp_logo', __('Remove WordPress', 'mtt'));
$this->makeCheckbox('adminbar_remove_new_content', __('Remove New Content', 'mtt'));
$this->makeCheckbox('adminbar_remove_theme_options', __('Remove Theme Options', 'mtt'));
$this->makeCheckbox('adminbar_remove_site_name', __('Remove Site Name', 'mtt'), __('Use the next option to make a custom link to the site.', 'mtt'));
if(function_exists('wpseo_maybe_upgrade'))
	$this->makeCheckbox('adminbar_remove_seo_by_yoast', __('Remove SEO by Yoast', 'mtt'));

$this->makeCheckbox('adminbar_sitename_enable', __('Add Site Name with Icon', 'mtt'), __('Add a custom link with title and icon','mtt'));
$this->makeTextbox('adminbar_sitename_title', 'adminbar_sitename_title', __('Title', 'mtt'), false, false, ' class="theAdminBarSiteLink"', '50', false, true);

$this->makeImageUploader('mttAdminBarLogo', 'adminbar_sitename_icon', __('Icon (between 16x16 and 22x22 pixels)', 'mtt'), false, ' class="theAdminBarSiteLink"');
//$this->makeTextbox('adminbar_sitename_icon', 'adminbar_sitename_icon', __('Icon (between 16x16 and 22x22 pixels)','mtt'), false, false, ' class="theAdminBarSiteLink"', '50', false, true);

$this->makeTextbox('adminbar_sitename_url', 'adminbar_sitename_url', __('URL', 'mtt'), false, $warnAdminTitleUrl, ' class="theAdminBarSiteLink"', '50', false, true);

$this->makeCheckbox('adminbar_custom_enable', __('Enable Custom Menu', 'mtt'));

$this->makeTextbox('adminbar_custom_0_title', 'adminbar_custom_0_title', __('Menu name', 'mtt'), __('*Required', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeTextbox('adminbar_custom_0_url', 'adminbar_custom_0_url', __('Menu link', 'mtt'), __('If empty, makes a null link', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);

$this->makeTextbox('adminbar_custom_1_title', 'adminbar_custom_1_title', sprintf(__('Submenu %s name', 'mtt'), '1'), __('*Required', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeTextbox('adminbar_custom_1_url', 'adminbar_custom_1_url', sprintf(__('Submenu %s link', 'mtt'), '1'), __('If empty, makes a null link', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);

$this->makeTextbox('adminbar_custom_2_title', 'adminbar_custom_2_title', sprintf(__('Submenu %s name', 'mtt'), '2'), __('*Required', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeTextbox('adminbar_custom_2_url', 'adminbar_custom_2_url', sprintf(__('Submenu %s link', 'mtt'), '2'), __('If empty, makes a null link', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);

$this->makeTextbox('adminbar_custom_3_title', 'adminbar_custom_3_title', sprintf(__('Submenu %s name', 'mtt'), '3'), __('*Required', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeTextbox('adminbar_custom_3_url', 'adminbar_custom_3_url', sprintf(__('Submenu %s link', 'mtt'), '3'), __('If empty, makes a null link', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);

$this->makeTextbox('adminbar_custom_4_title', 'adminbar_custom_4_title', sprintf(__('Submenu %s name', 'mtt'), '4'), __('*Required', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeTextbox('adminbar_custom_4_url', 'adminbar_custom_4_url', sprintf(__('Submenu %s link', 'mtt'), '4'), __('If empty, makes a null link', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);

$this->makeTextbox('adminbar_custom_5_title', 'adminbar_custom_5_title', sprintf(__('Submenu %s name', 'mtt'), '5'), __('*Required', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeTextbox('adminbar_custom_5_url', 'adminbar_custom_5_url', sprintf(__('Submenu %s link', 'mtt'), '5'), __('If empty, makes a null link', 'mtt'), false, ' class="theAdminMenu"', '50', false, true);
$this->makeOpenCloseMetabox(false);
?>



<!-- DASHBOARD -->
<?php
$this->makeOpenCloseMetabox(true, 'dashboard-box', __('Dashboard', 'mtt'));

echo '<br /><h4>' . __('REMOVE DASHBOARD WIDGETS', 'mtt') . '</h4>';
$this->makeCheckbox('dashboard_remove_quick_press', __('Remove', 'mtt') . ' ' . __('QuickPress'));
$this->makeCheckbox('dashboard_remove_incoming_links', __('Remove', 'mtt') . ' ' . __('Incoming Links'));
$this->makeCheckbox('dashboard_remove_right_now', __('Remove', 'mtt') . ' ' . __('Right now'));
$this->makeCheckbox('dashboard_remove_plugins', __('Remove', 'mtt') . ' ' . __('Plugins'));
$this->makeCheckbox('dashboard_remove_recent_drafts', __('Remove', 'mtt') . ' ' . __('Recent Drafts'));
$this->makeCheckbox('dashboard_remove_recent_comments', __('Remove', 'mtt') . ' ' . __('Recent Comments'));
$this->makeCheckbox('dashboard_remove_primary', __('Remove', 'mtt') . ' ' . __('WordPress_Blog : *in the Dashboard, you can configure this one, and change its title and feed address*', 'mtt'));
$this->makeCheckbox('dashboard_remove_secondary', __('Remove', 'mtt') . ' ' . __('Other WordPress News : *this one too!*', 'mtt'));

echo '<br /><h4>' . __('CUSTOMIZE RIGHT NOW WIDGET', 'mtt') . '</h4>';
$this->makeCheckbox('dashboard_add_cpt_enable', __('Add Custom Post Types to Right Now Widget', 'mtt'), sprintf(__('Tip via: %s', 'mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/Y9zDQ')));
$this->makeCheckbox('dashboard_remove_footer_rightnow', __('Hide the footer of Right Now widget ', 'mtt'));
$this->makeFakeUl(false);
?>
<?php echo '<br /><h4>' . __('ADD CUSTOM WIDGETS', 'mtt') . '</h4>';        ?>
<div class="inside-pdash1">
	<ul>
		<?php
		$this->makeCheckbox('dashboard_mtt1_enable', __('Add Custom Widget', 'mtt') . ' 1', __('Use this dashboards to put your own messages or iframes or embeds.', 'mtt'));
		$this->makeTextbox('dashboard_mtt1_title', 'dashboard_mtt1_title', __('Title', 'mtt'), false, false, ' class="theAddDash1"', '50', false, true);
		$this->makeTextArea('dashboard_mtt1_content', 'dashboard_mtt1_content', __('Content', 'mtt'), false, ' class="theAddDash1"', 'width: 56%; height: 100px;', true);
		?>
	</ul>
</div>
<div class="inside-pdash2">
	<ul>
		<?php
		$this->makeCheckbox('dashboard_mtt2_enable', __('Add Custom Widget', 'mtt') . ' 2', false);
		$this->makeTextbox('dashboard_mtt2_title', 'dashboard_mtt2_title', __('Title', 'mtt'), false, false, ' class="theAddDash2"', '50', false, true);
		$this->makeTextArea('dashboard_mtt2_content', 'dashboard_mtt2_content', __('Content', 'mtt'), false, ' class="theAddDash2"', 'width: 56%; height: 100px;', true);
		?>
	</ul>
</div>
<div class="inside-pdash3">
	<ul>
		<?php
		$this->makeCheckbox('dashboard_mtt3_enable', __('Add Custom Widget', 'mtt') . ' 3', false);
		$this->makeTextbox('dashboard_mtt3_title', 'dashboard_mtt3_title', __('Title', 'mtt'), false, false, ' class="theAddDash3"', '50', false, true);
		$this->makeTextArea('dashboard_mtt3_content', 'dashboard_mtt3_content', __('Content', 'mtt'), false, ' class="theAddDash3"', 'width: 56%; height: 100px;', true);
		?>
	</ul>
</div>
<?php
$this->makeFakeUl(true);
$this->makeOpenCloseMetabox(false);
?>



<!-- ADMIN MENUS -->
<?php
$this->makeOpenCloseMetabox(true, 'admin-menus-box', __('Admin Menus - Remove', 'mtt'));
?>
<h4 style="font-weight:normal;font-style:italic"><?php _e('This is a simple fix and removes the menus for all users.<br>Note that this doesn\'t prevent the access using the actual url address of the item.<br/>For a better fine tuning use <a target="_blank" href="http://wordpress.org/extend/plugins/adminimize/">Adminimize</a>. And to really block the access use <a target="_blank" href="http://wordpress.org/extend/plugins/members/">Members</a> or <a target="_blank" href="http://wordpress.org/extend/plugins/user-role-editor/">User-Role-Editor</a>','mtt'); ?></h4>
<?php
$this->makeCheckbox('admin_menus_remove_posts', __('Posts'));
$this->makeCheckbox('admin_menus_remove_media', __('Media'));
$this->makeCheckbox('admin_menus_remove_links', __('Links'));
$this->makeCheckbox('admin_menus_remove_pages', __('Pages'));
$this->makeCheckbox('admin_menus_remove_comments', __('Comments'));
$this->makeCheckbox('admin_menus_remove_appearence', __('Appearence'));
$this->makeCheckbox('admin_menus_remove_plugins', __('Plugins'));
$this->makeCheckbox('admin_menus_remove_users', __('Users'));
$this->makeCheckbox('admin_menus_remove_tools', __('Tools'));
$this->makeOpenCloseMetabox(false);

?>



<!-- CHANGE POSTS FOR WHATEVER -->
<?php
$this->makeOpenCloseMetabox(true, 'rename-posts-box', __('Rename "Posts" to whatever you want (i.e. news, articles)', 'mtt'));

$this->makeCheckbox('posts_rename_enable', __('Enable renaming the word "Posts"', 'mtt'), sprintf(__('Maybe you prefer it to be called News or Articles and don\'t want to create a Custom Post Type for that.<br />Tip via: %s', 'mtt'), $this->makeTipCredit('new2wp', 'http://goo.gl/Gvkle')), false, false);

$this->makeTextbox('posts_rename_name', 'posts_rename_name', __('Name', 'mtt'), false, false, ' class="thePostRename"', '50');
$this->makeTextbox('posts_rename_singular_name', 'posts_rename_singular_name', __('Singular Name', 'mtt'), false, false, ' class="thePostRename"', '50');
$this->makeTextbox('posts_rename_add_new', 'posts_rename_add_new', __('Add New', 'mtt'), false, false, ' class="thePostRename"', '50');
$this->makeTextbox('posts_rename_edit_item', 'posts_rename_edit_item', __('Edit Posts', 'mtt'), false, false, ' class="thePostRename"', '50');
$this->makeTextbox('posts_rename_view_item', 'posts_rename_view_item', __('View Posts', 'mtt'), false, false, ' class="thePostRename"', '50');
$this->makeTextbox('posts_rename_search_items', 'posts_rename_search_items', __('Search Posts', 'mtt'), false, false, ' class="thePostRename"', '50');
$this->makeTextbox('posts_rename_not_found', 'posts_rename_not_found', __('No Posts found', 'mtt'), false, false, ' class="thePostRename"', '50', false, true);
$this->makeTextbox('posts_rename_not_found_in_trash', 'posts_rename_not_found_in_trash', __('No Posts found in trash', 'mtt'), false, false, ' class="thePostRename"', '50', false, true);

$this->makeOpenCloseMetabox(false);
?>



<!-- POST/PAGE LISTINGS -->
<?php
$this->makeOpenCloseMetabox(true, 'listings-box', __('Post and Page Listing', 'mtt'));

$this->makeCheckbox('postpageslist_persistent_list_view', __('Posts: persistent Post listing view', 'mtt'), sprintf(__('If you change the viewing mode (list or excerpt view), it doesn\'t stick... This is expected to be integrated in WordPress in version 3.5 :)<br /><img src="%s" alt="persistent listing"><br />Tip via: %s', 'mtt'), MTT_URL . "images/persistent-listing.jpg", $this->makeTipCredit('StackExchange', 'http://goo.gl/ijfb3')), false, false);

$this->makeCheckbox('postpageslist_template_filter_enable', __('Pages: enable filtering by Template', 'mtt'), false, false, false);

$this->makeCheckbox('postpageslist_enable_id_column', __('Posts-Pages: add ID column', 'mtt'), false, false, false);

$this->makeCheckbox('postpageslist_enable_thumb_column', __('Posts-Pages: add Thumbnail column', 'mtt'), sprintf(__('Shows the featured image or, if not set, the first attached.<br />Tip via: %s', 'mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/Y9zDQ')), false, false);

$this->makeTextbox('postpageslist_title_column_width', 'postpageslist_title_column_width', __('Posts-Pages: width of the Title column', 'mtt'), __('Sometimes the Title column gets shrinked by other columns, you may change this here', 'mtt'), false, false, '1', '3');

echo '<br /><h4>' . __('CUSTOM COLORS FOR DIFFENT TYPES OF CONTENT', 'mtt') . '</h4>';

$this->makeColorPicker('postpageslist_status_draft', __('Posts-Pages Draft color', 'mtt'), false, 'mtt-cp-2');

$this->makeColorPicker('postpageslist_status_pending', __('Posts-Pages Pending color', 'mtt'), false, 'mtt-cp-3');

$this->makeColorPicker('postpageslist_status_future', __('Posts-Pages Future color', 'mtt'), false, 'mtt-cp-4');

$this->makeColorPicker('postpageslist_status_private', __('Posts-Pages Private color', 'mtt'), false, 'mtt-cp-5');

$this->makeColorPicker('postpageslist_status_password', __('Posts-Pages Password Protected color', 'mtt'), false, 'mtt-cp-6');

$this->makeColorPicker('postpageslist_status_others', __('Posts-Pages Other Author\'s color', 'mtt'), false, 'mtt-cp-7');

$this->makeOpenCloseMetabox(false);
?>



<!-- POSTS AND PAGES EDITING -->
<?php
$this->makeOpenCloseMetabox(true, 'revision-box', __('Post and Page Editing', 'mtt'));

$this->makeCheckbox('postpages_enable_page_excerpts', __('Pages: enable Excerpt', 'mtt'), sprintf(__('Tip via: %s','mtt'), $this->makeTipCredit('Smashing Magazine', 'http://goo.gl/cSCpy')));

$this->makeTextbox('postpages_post_revision', 'postpages_post_revision', __('Posts-Pages: number of revisions to maintain', 'mtt'), __('-1 (unlimited) | 0 (none) | 1 or more (custom)', 'mtt'), $warnRevisions, false, '1', '2');

$this->makeTextbox('postpages_post_autosave', 'postpages_post_autosave', __('Posts-Pages: auto-save interval <em>in minutes</em>', 'mtt'), false, $warnAutoSave, false, '1', '2');

echo '<br /><h4>' . __('MOVE METABOXES', 'mtt') . '</h4>';

$this->makeCheckbox('postpages_move_author_metabox', __('Posts-Pages: move the Author metabox into the Publish metabox', 'mtt'), sprintf(__('Tip via: %s','mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/Y9zDQ')));

$this->makeCheckbox('postpages_move_comments_metabox', __('Posts-Pages: move the Comment Status metabox into the Publish metabox', 'mtt'), false);

echo '<br /><h4>' . __('REMOVE METABOXES<br /><small>although Adminimize can handle this filtering by roles, it only hides the meta box and it doen\'t removes it from the Screen Options</small>', 'mtt') . '</h4>';

$this->makeGenericList('postpages_disable_mbox_author', __('Disable Author meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeGenericList('postpages_disable_mbox_comment_status', __('Disable Comment Status meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeGenericList('postpages_disable_mbox_comment', __('Disable Comments meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeGenericList('postpages_disable_mbox_custom_fields', __('Disable Custom Fields meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeGenericList('postpages_disable_mbox_featured_image', __('Disable Featured Image meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeGenericList('postpages_disable_mbox_revisions', __('Disable Revisions meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeGenericList('postpages_disable_mbox_slug', __('Disable Slug meta box', 'mtt'), false, array('none', 'post', 'page', 'post and page'));

$this->makeCheckbox('postpages_disable_mbox_attributes', __('Pages: disable Attributes meta box', 'mtt'), false);

$this->makeCheckbox('postpages_disable_mbox_category', __('Posts: disable Category meta box', 'mtt'), false);

$this->makeCheckbox('postpages_disable_mbox_excerpt', __('Posts: disable Excerpt meta box', 'mtt'), false);

$this->makeCheckbox('postpages_disable_mbox_tags', __('Posts: disable Tags meta box', 'mtt'), false);

$this->makeCheckbox('postpages_disable_mbox_trackbacks', __('Posts: disable Trackbacks meta box', 'mtt'), false);

$this->makeOpenCloseMetabox(false);
?>



<!-- SHORTCODES -->
<?php
$this->makeOpenCloseMetabox(true, 'shortcodes-box', __('Shortcodes', 'mtt'));

$tubedesc = '<div class="desc">'.__('Usage:','mtt').' [poptube id="VIDEO-ID" title="TITLE-OVER-THUMBNAIL" color="#CCCF27" button="WATCH NOW"]<div style="text-align:center;width:150px;margin:0 0 15px"><h2 style="color:#CCCF27;text-shadow:none;padding:0;margin-bottom:0;">'.__('TITLE-OVER','mtt').'</h2><a href="http://www.youtube.com/watch_popup?v=s-c_urzTWYQ" target="_blank"><img src="http://i3.ytimg.com/vi/s-c_urzTWYQ/default.jpg" alt="youtube thumbnail" style="margin-bottom:-19px"/></a><br /><a class="button-secondary" href="http://www.youtube.com/watch_popup?v=s-c_urzTWYQ" target="_blank">'.__('WATCH NOW','mtt').'</a></div>'.__('The "color" attribute is for the title.<br />This is the default backend style, for adpating it in your theme use the class "mtt-poptube" for the elements','mtt').' <em>&lt;h2&gt;</em>, <em>&lt;img&gt;</em> '.__('and','mtt').' <em>&lt;a&gt;</em></div>';

$this->makeCheckbox('shortcodes_tube', __('Enable YouTube shortcode', 'mtt'), $tubedesc);

$this->makeCheckbox('shortcodes_scloud', __('Enable SoundCloud shortcode', 'mtt'), __('Soundcloud offers a shortcode for use in WordPress.COM. This will enable the use of that shortcode.<br />Usage: in SoundCloud, select the button <em>Share</em>, then select the button <em>Edit your widget</em>, after customizing copy the WordPress shortcode and paste in your site. <a href="http://help.soundcloud.com/customer/portal/articles/search?q=embed" target="_blank">Check SoundCloud documentation</a>', 'mtt'));

$this->makeCheckbox('shortcodes_gdocs', __('Enable Google Docs Preview Document shortcode', 'mtt'), __('Use Google Docs for preview PDF, Word, Excel docuemtns online. <a href="http://docs.google.com/viewer?url=partners.adobe.com/public/developer/en/xml/AdobeXMLFormsSamples.pdf" target="_blank">Example</a>.<br />Usage: [gdocs url="http://www.domain.com/document.pdf" class="my-doc-class"]View Document[/gdocs]', 'mtt'));

$this->makeOpenCloseMetabox(false);
?>



<!-- MEDIA -->
<?php
$this->makeOpenCloseMetabox(true, 'media-box', __('Media', 'mtt'));

$this->makeCheckbox('media_sanitize_filename', __('Sanitize filename', 'mtt'), sprintf(__('Removes symbols, spaces, latin and other languages characters from uploaded files and gives them "permalink" structure (clean characters, only lowercase and dahes)<br />Tip via: %s', 'mtt'), $this->makeTipCredit('CSS Tricks', 'http://goo.gl/k2yAq')));

$this->makeCheckbox('media_image_id_column_enable', __('Add ID column to the Media Library ', 'mtt'),false);

$this->makeCheckbox('media_image_size_column_enable', __('Add image size column to the Media Library ', 'mtt'), sprintf(__('Tip via: %s', 'mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/dfd8t')));

$this->makeCheckbox('media_better_attachment', __('Enables the re-attachemnt ', 'mtt'), sprintf(__('Change the parent of the media file to another post/page<br />Unfortunately, this disables the capability to sort the column... Tip via: %s', 'mtt'), $this->makeTipCredit('WPEngineer', 'http://goo.gl/wywy5')));

$this->makeCheckbox('media_adjust_youtube_oembed_enable', __('Prevent Youtube oEmbed from overriding your WordPress content', 'mtt'), sprintf(__('Tip via: %s', 'mtt'), $this->makeTipCredit('wpbeginner', 'http://goo.gl/KhZQ1')));

$this->makeCheckbox('media_jpg_sharpen', __('Sharpen resized images (only jpg) ', 'mtt'), sprintf(__('Check an <a href="http://i.stack.imgur.com/hkLaX.png" target="_blank">example</a>. . . Tip via: %s', 'mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/Y9zDQ')));

$this->makeTextbox('media_jpg_quality', 'media_jpg_quality', __('Quality of resized Jpegs', 'mtt'), __('From 1 to 100. WordPress default is 90.'), false, false, '1', '2');


$this->makeOpenCloseMetabox(false);
?>



<!-- WIDGETS -->
<?php

$this->makeOpenCloseMetabox(true, 'metawidget-box', __('Widgets', 'mtt'));

$this->makeCheckbox('widget_text_enable_shortcodes', __('Text Widget: enable shortcodes', 'mtt'), false);

$this->makeTextbox('widget_rss_update_timer', 'widget_rss_update_timer', __('RSS Widget: update timer (in minutes)', 'mtt'), sprintf(__('Default is 12 hours, leave blank for not activating<br />Tip via: %s', 'mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/Y9zDQ')), false, false, '1', '3');

echo '<br /><h4>' . __('REMOVE DEFAULT WIDGETS', 'mtt') . '</h4>';
$this->makeCheckbox('widget_remove_pages', __('Remove Pages', 'mtt'), false);
$this->makeCheckbox('widget_remove_calendar', __('Remove Calendar', 'mtt'), false);
$this->makeCheckbox('widget_remove_archives', __('Remove Archives', 'mtt'), false);
$this->makeCheckbox('widget_remove_links', __('Remove Links', 'mtt'), false);
$this->makeCheckbox('widget_remove_meta', __('Remove Meta', 'mtt'), false);
$this->makeCheckbox('widget_remove_search', __('Remove Search', 'mtt'), false);
$this->makeCheckbox('widget_remove_text', __('Remove Text', 'mtt'), false);
$this->makeCheckbox('widget_remove_categories', __('Remove Categories', 'mtt'), false);
$this->makeCheckbox('widget_remove_recent_posts', __('Remove Recent Posts', 'mtt'), false);
$this->makeCheckbox('widget_remove_recent_comments', __('Remove Recent Comments', 'mtt'), false);
$this->makeCheckbox('widget_remove_rss', __('Remove RSS', 'mtt'), false);
$this->makeCheckbox('widget_remove_tag_cloud', __('Remove Tag Cloud', 'mtt'), false);
$this->makeCheckbox('widget_remove_nav_menu', __('Remove Custom Menu', 'mtt'), false);
if(function_exists('widget_akismet_register'))
	$this->makeCheckbox('widget_remove_akismet', __('Remove Akismet', 'mtt'), false);

echo '<br /><h4>' . __('SIMPLE META WIDGET', 'mtt') . '</h4><em>[ '. __('based on the plugin <a target="_blank" href="http://wordpress.org/extend/plugins/customize-meta-widget/">Customize Meta Widget</a>, by <a target="_blank" href="http://jehy.ru/wp-plugins.en.html">Jahy','mtt') . '</a> ]</em>';
$this->makeCheckbox('widget_meta_enable', __('Customize Meta Widget', 'mtt'), false);

$this->makeTextbox('widget_meta_title', 'widget_meta_title', __('Widget Title', 'mtt'), false, false, ' class="theMetaWidget"', '50', false, true);

$this->makeCheckbox('widget_meta_link1', sprintf(__('Enable Extra Link %s', 'mtt'), '1'), false, ' class="theMetaWidget"');

$this->makeTextbox('widget_meta_link1_title', 'widget_meta_link1_title', sprintf(__('Title for Link %s', 'mtt'), '1'), false, false, ' class="theMetaWidget theMetaWidgetLink1"', '50', false, true);

$this->makeTextbox('widget_meta_link1_text', 'widget_meta_link1_text', sprintf(__('Text for Link %s', 'mtt'), '1'), false, false, ' class="theMetaWidget theMetaWidgetLink1"', '50', false, true);

$this->makeTextbox('mttMetaWidgetUrl1', 'widget_meta_link1_url', sprintf(__('URL for Link %s', 'mtt'), '1'), false, $warnWidgetUrl1, ' class="theMetaWidget theMetaWidgetLink1"', '50', false, true);


$this->makeCheckbox('widget_meta_link2', sprintf(__('Enable Extra Link %s', 'mtt'), '2'), false, ' class="theMetaWidget"');

$this->makeTextbox('widget_meta_link2_title', 'widget_meta_link2_title', sprintf(__('Title for Link %s', 'mtt'), '2'), false, false, ' class="theMetaWidget theMetaWidgetLink2"', '50', false, true);

$this->makeTextbox('widget_meta_link2_text', 'widget_meta_link2_text', sprintf(__('Text for Link %s', 'mtt'), '2'), false, false, ' class="theMetaWidget theMetaWidgetLink2"', '50', false, true);

$this->makeTextbox('mttMetaWidgetUrl2', 'widget_meta_link2_url', sprintf(__('URL for Link %s', 'mtt'), '2'), false, $warnWidgetUrl2, ' class="theMetaWidget theMetaWidgetLink2"', '50', false, true);

$this->makeOpenCloseMetabox(false);
?>



<!-- PLUGINS -->
<?php
$this->makeOpenCloseMetabox(true, 'plugins-box', __('Plugins', 'mtt'));

$this->makeCheckbox('plugins_remove_plugin_notice', __('Remove plugins notices', 'mtt'), __('Hides extra plugin messages (premium, update and other notices), ','mtt') );

$this->makeColorPicker('plugins_inactive_bg_color', __('Inactive Plugins background color', 'mtt'), false, 'mtt-cp-8');

if(function_exists('get_fields')) {
	if($this->checkAcfOptionsPage()) {
		$this->makeCheckbox('plugins_acf_hide_options', __('AdvancedCustomFields: hide "Options" from non-administrators', 'mtt'));
	}
}


$this->makeOpenCloseMetabox(false);
?>



<!-- USER PROFILE -->
<?php
$this->makeOpenCloseMetabox(true, 'profile-box', __('User profile', 'mtt'));

$this->makeCheckbox('profile_h3_titles', __('Remove All Titles', 'mtt'), __('Removes the titles: "Personal Options", "Name", "Contact Info" and "About Yourself"','mtt'));

$this->makeCheckbox('profile_descriptions', __('Remove All Descriptions', 'mtt'));

$this->makeCheckbox('profile_slim', __('Remove Visual Editor, Admin Color Scheme and Keyboard Shortcuts', 'mtt'), __('My guess is that or you want them all, or you don\'t want them at all :)', 'mtt'));

$this->makeCheckbox('profile_hidden', __('Completely hide the Personal Options block', 'mtt'));

$this->makeCheckbox('profile_display_name', __('Remove Display Name', 'mtt'));

$this->makeCheckbox('profile_nickname', __('Remove Nickname', 'mtt'));

$this->makeCheckbox('profile_website', __('Remove Website', 'mtt'));

$this->makeCheckbox('profile_social', __('Change <strong>Aim</strong>-<strong>Yim</strong>-<strong>Jabber</strong> for <strong>Twitter</strong>-<strong>Facebook</strong>-<strong>LinkedIn</strong>', 'mtt'), __('You have to choose between this one or the next one.', 'mtt'));

$this->makeCheckbox('profile_none', __('Remove Aim/Yim/Jabber', 'mtt'), __('Read above.', 'mtt'));

$this->makeCheckbox('profile_bio', __('Hide the About Yourself title and Biographical Info box', 'mtt'), false);

$this->makeTextArea('profile_css', 'profile_css', __('Custom CSS', 'mtt'), __('Add your custom css to further stylize the Profile page', 'mtt'), false, 'width: 56%; height: 100px;', true);

$this->makeOpenCloseMetabox(false);
?>



<!-- HEADER AND FOOTER NOTICES -->
<?php
$this->makeOpenCloseMetabox(true, 'admin-notices-box', __('Header and Footer', 'mtt'));

$this->makeCheckbox('admin_notice_header_settings_enable', __('Header: enable notice in the Settings page', 'mtt'), __('Useful for displaying a notice for clients: "<em>Change this settings at your own risk...</em>".<br />Tip via: %s', 'mtt'));

$this->makeTextArea('admin_notice_header_settings_text', 'admin_notice_header_settings_text', __('Message to display', 'mtt'), false, ' class="theNoticeSettings"', 'width: 56%; height: 100px;', true);

$this->makeCheckbox('admin_notice_header_allpages_enable', __('Header: Enable notice all admin pages', 'mtt'), __('Useful for displaying a message to all users of the site.', 'mtt'));

$this->makeTextArea('admin_notice_header_allpages_text', 'admin_notice_header_allpages_text', __('Message to display', 'mtt'), false, ' class="theNoticeRoles"', 'width: 56%; height: 100px;', true);

$this->makeRolesList('admin_notice_header_allpages_level', __('Minimum user level to see the messaage.', 'mtt'), ' class="theNoticeRoles"');

$this->makeCheckbox('admin_notice_footer_hide', __('Footer: hide', 'mtt'));

$this->makeCheckbox('admin_notice_footer_message_enable', __('Footer: show only your message', 'mtt'), __('Remove all WordPress and other plugins messages, so your message is the only one there...','mtt'));

$this->makeTextArea('admin_notice_footer_message_left', 'admin_notice_footer_message_left', __('Text to display on the left (html enabled)', 'mtt'), false, ' class="theFooterMsg"', 'width: 56%; height: 50px;', true);

$this->makeTextArea('admin_notice_footer_message_right', 'admin_notice_footer_message_right', __('Text to display on the right (html enabled)', 'mtt'), false, ' class="theFooterMsg"', 'width: 56%; height: 50px;', true);

$this->makeOpenCloseMetabox(false);
?>



<!-- EMAIL NOTIFICATIONS -->
<?php
$this->makeOpenCloseMetabox(true, 'email-box', __('Email Notifications', 'mtt'));

$this->makeCheckbox('email_notice_plain_html', __('Change email format to Html', 'mtt'), __('WordPress default format is Plain Text.<br />In reality, this is only useful if you are making custom emails. Check this <a href="http://goo.gl/Bqhxl" target="_blank"> Smashing Magazine article</a>.','mtt'));

$this->makeTextbox('email_notice_from_name', 'email_notice_from_name', __('Change "From" name', 'mtt'), __('WordPress default sender name is the Site Title defined in General Settings','mtt'), false, false, '50', false, true);

$this->makeTextbox('email_notice_site_email_address', 'email_notice_site_email_address', __('Change "From" address', 'mtt'), __('WordPress default sender address is the E-mail Address registered in General Settings','mtt'), false, false, '50', false, true);

//$this->makeTextbox('email_notice_retrieve_pw_title', 'email_notice_retrieve_pw_title', __('Title of the "Retrieve Password" e-mail', 'mtt'), false, false, false, '50', false, true);

//$this->makeCheckbox('email_notice_author_comment_warn', __('Warn author of pending comment', 'mtt'), __('WordPress default recipient is the E-mail Address registered in General Settings'));


$this->makeOpenCloseMetabox(false);
?>



<!-- WORDPRESS BEHAVIOR -->
<?php
$this->makeOpenCloseMetabox(true, 'frontend-box', __('General Settings', 'mtt'));

echo '<h4>' . __('FRONTEND', 'mtt') . '</h4>';

$this->makeCheckbox('wpenable_google_jquery', __('Load jQuery from Google Libraries', 'mtt'));

$this->makeCheckbox('wpdisable_version_full', __('Completely eliminate WordPress version in &lt;head&gt;', 'mtt'));

$this->makeCheckbox('wpdisable_version_number', __('Eliminate only the WordPress version number in &lt;head&gt;', 'mtt'));

echo '<h4>' . __('BACKEND', 'mtt') . '</h4>';

$this->makeCheckbox('wpblock_update_wp', __('Block WordPress upgrade warnings', 'mtt'), __('Yes, I know that, but don\'t bug me, please...', 'mtt'));

$this->makeCheckbox('wpblock_update_plugins', __('Block plugins upgrade warnings', 'mtt'), __('Yeah, I know...', 'mtt'));

$this->makeCheckbox('wpdisable_nourl', __('Hide blog URL from WordPress "phone home"', 'mtt'), __('Filter out the blog URL from the data that is sent to wordpress.org - Check this <a href="http://lynnepope.net/wordpress-privacy">article</a> to learn more.', 'mtt'));

$this->makeCheckbox('wpdisable_smartquotes', __('Disable SmartQuotes', 'mtt'), __('Prevent the conversion of straight quotes into directional quotes.', 'mtt'));

$this->makeCheckbox('wpdisable_capitalp', __('Disable Capital P', 'mtt'), __('Prevents WordPress of auto-correcting mispellings of its name. Check this <a href="http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit">article</a>', 'mtt'));

$this->makeCheckbox('wpdisable_autop', __('Disable Auto P', 'mtt'), __('Prevents WordPress from inserting automatic &lt;p&gt; tags in your code.', 'mtt'));

$this->makeCheckbox('wpdisable_selfping', __('Disable Self Ping', 'mtt'), __('Prevents WordPress from sending pings to your own site.', 'mtt'));

$this->makeCheckbox('wprss_delay_publish_enable', __('Delay RSS feed update', 'mtt'), sprintf(__('This can give you time to make corrections after publishing a post, delaying the update in your RSS feed. Or you can make your content web exclusive for a larger period. Tip via: %s','mtt'), $this->makeTipCredit('StackExchange', 'http://goo.gl/Y9zDQ') ) );

$this->makeTextbox('wprss_delay_publish_time', 'wprss_delay_publish_time', __('Number of delay', 'mtt'), false, false, ' class="theFeedDelay"', '1', '2');

$this->makeGenericList('wprss_delay_publish_period', __('Period of delay', 'mtt'), false, array(__('MINUTE', 'mtt'), __('HOUR', 'mtt'), __('DAY', 'mtt'), __('WEEK', 'mtt'), __('MONTH', 'mtt'), __('YEAR', 'mtt')), ' class="theFeedDelay"');

$this->makeCheckbox('wpenable_custom_gravatars_enable', __('Custom gravatars', 'mtt'), false);

$this->makeImageUploader('mttGravatarImage', 'wpenable_custom_gravatars_img', sprintf(__('Bellow are your new gravatars, and you can also upload your own image :)  <br /> <br /><img src="%s" width="36" height="36" alt="gravatar 1"> <img src="%s" width="36" height="36" alt="gravatar 2"> <img src="%s" width="36" height="36" alt="gravatar 3"><br /><a href="http://www.fasticon.com/" target="_blank">Icons by: FastIcon.com</a>', 'mtt'), MTT_URL . 'images/avatar1.png', MTT_URL . 'images/avatar2.png', MTT_URL . 'images/avatar3.png'), false, ' class="theGravatar"');

$this->makeCheckbox('wpdisable_help_texts_enable', __('Disable WordPress help texts', 'mtt'), __('CSS file copied from <a href="http://wordpress.org/extend/plugins/admin-expert-mode/" target="_blank">Admin Expert Mode</a>, by Scott Reilly. There this is set in a user basis, here in a role basis.','mtt'));

$this->makeRolesList('wpdisable_help_texts_level', __('Hide the help texts from this level up.', 'mtt'), ' class="theHelpTexts"');

$this->makeCheckbox('wpdisable_howdy_enable', __('Remove or change "Howdy"', 'mtt'), false);

global $wp_version;
if(version_compare($wp_version, "3.3", "<")) {
	$this->makeTextbox('wpdisable_howdy_search', 'wpdisable_howdy_search', __('Search for', 'mtt'), __('Put the "Howdy" in your language, include the comma if you want to remove it','mtt'), false, ' class="theHowdyRemove"', '50', false, true);
}
$this->makeTextbox('wpdisable_howdy_replace', 'wpdisable_howdy_replace', __('Replace with', 'mtt'), __('Leave empty for complete removal','mtt'), false, ' class="theHowdyRemove"', '50', false, true);

$this->makeOpenCloseMetabox(false);
?>



<!-- MAINTENANCE MODE -->
<?php
$this->makeOpenCloseMetabox(true, 'maintenance-box', __('Maintenance Mode', 'mtt'));

$this->makeCheckbox('maintenance_mode_enable', __('Enable maintenance mode', 'mtt'), __('Block the site to visitors and not-admins. To display your own custom page, follow the instruction in the file <em><strong>many-tips-together/maintenance/index.php</strong></em>.', 'mtt'));

$this->makeTextbox('maintenance_mode_title', 'maintenance_mode_title', __('Browser Title &lt;title&gt;', 'mtt'), false, false, '  class="theMaintenance"', '50', false, false);

$this->makeTextbox('maintenance_mode_line0', 'maintenance_mode_line0', __('Text for the first line', 'mtt'), false, false, '  class="theMaintenance"', '50', false, true);

$this->makeTextbox('maintenance_mode_line1', 'maintenance_mode_line1', __('Text for the second line', 'mtt'), false, false, '  class="theMaintenance"', '50', false, true);

$this->makeTextbox('maintenance_mode_line2', 'maintenance_mode_line2', __('Link for the third line, without http://', 'mtt'), false, false, '  class="theMaintenance"', '50', false, true);

$this->makeImageUploader('mttMaintenanceBg', 'maintenance_mode_html_img', __('Page background image (full URL)', 'mtt'), __('Use a pattern or a big image, or enter 0 (zero) to disable', 'mtt'), '  class="theMaintenance"');

$this->makeImageUploader('mttMaintenanceBody', 'maintenance_mode_body_img', __('Box background image (full URL)', 'mtt'), __('Use a pattern or a big image', 'mtt'), '  class="theMaintenance"');

$this->makeImageUploader('mttMaintenanceGlow', 'maintenance_mode_glow_img', __('Glow image in the center (full URL)', 'mtt'), __('Transparent image, or enter 0 (zero) to disable', 'mtt'), '  class="theMaintenance"');

$this->makeRolesList('maintenance_mode_level', __('Minimum user level to access site.', 'mtt'), ' class="theMaintenance"');

$this->makeCheckbox('maintenance_mode_admin', __('Block only admin area', 'mtt'), __('Useful when doing maintenance task that don\'t require taking the site down, but block non-admins from doing any changes.', 'mtt'), ' class="theMaintenance"', false);

$this->makeTextArea('maintenance_mode_extra_css', 'maintenance_mode_extra_css', __('Custom CSS', 'mtt'), __('Add your custom css to further stylize the Maintenance page', 'mtt'), ' class="theMaintenance"', 'width: 56%; height: 100px;', true);

$this->makeOpenCloseMetabox(false);
?>




<!-- DEVELOPER OPTIONS -->
<?php
$this->makeOpenCloseMetabox(true, 'developer-box', __('Developer', 'mtt'));

$this->makeCheckbox('dev_show_all_options', __('Show "All Settings"', 'mtt'), false);

include('inc/dev.php');

$this->makeOpenCloseMetabox(false);
?>

</div>
<!--meta-box-sortables-->
</div>
<!--poststuff-->
</form>

<!--Import Export-->
<div id="poststuff-export" class="metabox-holder">
	<div class="meta-box-sortables">
		<div class="postbox database-box">
			<div class="handlediv" title="Click to toggle"><br/></div>
			<h3 class="hndle mtt-hndle-bluee">&raquo; &raquo; <?php _e('Export/Import', 'mtt'); ?></h3>

			<div class="inside closenow"><br />
				<h4 style="font-weight:normal;font-style:italic"><?php _e('This feature is copied from the great <a target="_blank" href="http://wordpress.org/extend/plugins/adminimize/">Adminimize</a>. You are my hero, Frank!','mtt'); ?></h4> <br />
				<h4><?php _e('Export', 'mtt' ) ?></h4>
				<form name="export_options" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>&mtt_handle_options_export=true">
					<p><?php _e('Click to download a .seq file with your options.', 'mtt' ) ?></p>
					<p id="submitbutton-export">
						<input type="hidden" name="mtt_handle_options_export" value="true" />
						<input type="submit" name="mtt_handle_options_save" value="<?php _e('Export &raquo;', 'mtt' ) ?>" class="button" />
					</p>
				</form>
				<br />
				<h4><?php _e('Import', 'mtt' ) ?></h4>
				<form name="import_options" enctype="multipart/form-data" method="post" action="?page=<?php echo esc_attr( $_GET['page'] ); ?>">
					<?php wp_nonce_field('mtt_handle_options_nonce'); ?>
					<p><?php _e('Select the <em>.seq</em> with your options and click the button bellow.', 'mtt' ) ?></p>
					<p>
						<label for="datei_id"><?php _e('Choose a file from your computer', 'mtt' ) ?>: </label>
						<input name="datei" id="datei_id" type="file" />
					</p>
					<p id="submitbutton">
						<input type="hidden" name="mtt_handle_options_action" value="mtt_handle_options_import" />
						<input type="submit" name="mtt_handle_options_save" value="<?php _e('Upload and import &raquo; &raquo;', 'mtt' ) ?>" class="button" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div><!--poststuff-->


<!--Delete Post Revisions-->
<div id="poststuff-delete" class="metabox-holder mtt-advanced">
	<form name="form2" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<input type="hidden" name="my_erase_revisions" value="Y">

		<div class="meta-box-sortables">
			<div class="postbox database-box">
				<div class="handlediv" title="Click to toggle"><br/></div>
				<h3 class="hndle mtt-hndle-yelloww">&raquo; &raquo; <?php _e('Database', 'mtt'); ?></h3>

				<div class="inside closenow">
					<ul>
						<li><strong><?php _e('Total number of revisions (all posts and pages)', 'mtt'); ?>
							:</strong> <?php
							$myrows = count($wpdb->get_results("SELECT id FROM $wpdb->posts WHERE post_type = 'revision'"));
							$red    = ($myrows > 0) ? " red-revisions" : ""; ?>
							<span class="revisions-number<?php echo $red; ?>"><?php echo $myrows; ?></span>

							<p class="desc"><?php _e('A big number of revisions can decrease your database performance.', 'mtt'); ?></p>
						</li>

						<li>
							<label><input name="mttEraseRevisions" id="mttEraseRevisions"
										  type="checkbox"> <?php _e('Delete revisions', 'mtt'); ?></label>
						</li>


						<li id="deleteRevisions">
							<input type="submit" name="Submit" class="button-primary"
								   value="<?php _e('Yes, please delete them!', 'mtt'); ?>"/>
						</li>
					</ul>
				</div>
			</div>
			<!--postbox-->
		</div>
		<!--meta-box-sortables-->
	</form>
</div><!--poststuff-->

<!--Reset Plugin Options-->
<div id="poststuff-reset" class="metabox-holder mtt-advanced">
	<form name="form3" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<input type="hidden" name="my_reset_options" value="Y">

		<div class="meta-box-sortables">
			<div class="postbox resetoptions-box">
				<div class="handlediv" title="Click to toggle"><br/></div>
				<h3 class="hndle mtt-hndle-redd">&raquo; &raquo; <?php _e('Reset plugin settings', 'mtt'); ?></h3>

				<div class="inside closenow">
					<ul>
						<li>
							<label><input name="mttResetOptions" id="mttResetOptions"
										  type="checkbox"> <?php _e('Reset settings', 'mtt'); ?></label>

							<p class="desc"><?php _e('Return to defaults... Being: no changes in my WordPress.', 'mtt'); ?></p>
						</li>

						<li id="resetOptions">
							<input type="submit" name="Submit" class="button-primary"
								   value="<?php _e('Yes, please reset it!', 'mtt'); ?>"/>
						</li>
					</ul>
				</div>
			</div>
			<!-- post-box -->
		</div>
		<!--meta-box-sortables-->
	</form>
</div><!-- post-stuff -->
<!-- </div>end-wrap ??? -->