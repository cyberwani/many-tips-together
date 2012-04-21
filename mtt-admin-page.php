<?php
global $wpdb;
if( isset($_POST[ 'my_reset_options' ]) && $_POST[ 'my_reset_options' ] == 'Y' )
    $this->resetAdminOptions();

$devOptions = $this->getAdminOptions();

$badUrl = '<span style="color:red;font-weight:bold;"> * '.__('Bad formed URL','mtt').'</span>';
$badValue = '<span style="color:red;font-weight:bold;"> * '.__('Invalid value','mtt').'</span>';
$badProfile = '<span style="color:red;font-weight:bold;"> * '.__('Uncheck the previous option, so this one will work.','mtt').'</span>';
$warnAllErrors = '<span style="color:red;font-weight:bold;"> * '.__('Check the errors below...','mtt').'</span>';

$warnUpdate = ""; // if any warning bellow is filled, this one will be filled too

	$warnUrl = "";
	$warnUrlImg = "";
	$warnUrlBody = "";
	$warnUrlLogoUrl = "";
	$warnRevisions = "";
	$warnAutoSave = "";
	$warnHeight = "";
	$warnProfile = "";

// magicQuotes issue
// http://goo.gl/aOpxD and http://goo.gl/d97mu
if (get_magic_quotes_gpc()) $_POST = stripslashes_deep($_POST);


 // DELETE REVISIONS 
	if( isset($_POST[ 'my_erase_revisions' ]) && $_POST[ 'my_erase_revisions' ] == 'Y' ) {
	    $wpdb->query( "DELETE a,b,c FROM $wpdb->posts a LEFT JOIN  $wpdb->term_relationships b ON (a.ID = b.object_id) LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) WHERE a.post_type = 'revision'" );
	?>
	<div id="updated2" class="updated"><p><strong><?php _e('Revisions deleted from database.','mtt'); ?></strong></p></div>
	<?php 
	} 
// END IF(isset) 

// RESET OPTIONS 
	if( isset($_POST[ 'my_reset_options' ]) ) {
	?>
	<div id="updated3" class="updated"><p><strong><?php _e('Settings reseted.','mtt'); ?></strong></p></div>
<?php 
	} 
// END IF(isset) 
	
	
// MAIN OPTIONS	
	if (isset($_POST['update_mttSettings'])) { 
		
		
		/* PLUGIN CONFIGURATION */
		$devOptions['verbose_plugin'] = (isset($_POST['mttVerbose']) && $_POST['mttVerbose']) ? 1 : 0;
		$devOptions['small_plugin'] = (isset($_POST['mttSmall']) && $_POST['mttSmall']) ? 1 : 0;


		/* MAINTENANCE MODE */
		$devOptions['maintenance_mode'] = (isset($_POST['mttMaintenance']) && $_POST['mttMaintenance']) ? 1 : 0;
		if (isset($_POST['mttMaintenanceTitle'])) 
			$devOptions['maintenance_mode_title'] = $_POST['mttMaintenanceTitle'];
		if (isset($_POST['mttMaintenanceTxt1'])) 
			$devOptions['maintenance_mode_line1'] = $_POST['mttMaintenanceTxt1'];
		if (isset($_POST['mttMaintenanceTxt2'])) 
			$devOptions['maintenance_mode_line2'] = $_POST['mttMaintenanceTxt2'];
		if (isset($_POST['mttMaintenanceLevel'])) 
			$devOptions['maintenance_mode_level'] = $_POST['mttMaintenanceLevel'];


		/* WORDPRESS BEHAVIOR */
		$devOptions['update_wp'] = (isset($_POST['mttUpdateWp']) && $_POST['mttUpdateWp']) ? 1 : 0;	
		$devOptions['update_plg'] = (isset($_POST['mttUpdatePlg']) && $_POST['mttUpdatePlg']) ? 1 : 0;
		$devOptions['disable_nourl'] = (isset($_POST['mttNoUrl']) && $_POST['mttNoUrl']) ? 1 : 0;		
		$devOptions['disable_smartquotes'] = (isset($_POST['mttSmartQuotes']) && $_POST['mttSmartQuotes']) ? 1 : 0;		
		$devOptions['disable_capitalp'] = (isset($_POST['mttCapitalP']) && $_POST['mttCapitalP']) ? 1 : 0;		
		$devOptions['disable_autop'] = (isset($_POST['mttAutoP']) && $_POST['mttAutoP']) ? 1 : 0;		
		$devOptions['disable_selfping'] = (isset($_POST['mttSelfPing']) && $_POST['mttSelfPing']) ? 1 : 0;		
		$devOptions['disable_version_full'] = (isset($_POST['mttVersionFull']) && $_POST['mttVersionFull']) ? 1 : 0;
		$devOptions['disable_version_number'] = (isset($_POST['mttVersionNumber']) && $_POST['mttVersionNumber']) ? 1 : 0;
		

		/* REMOVE FROM DASHBOARD */
		$devOptions['remove_dashboard_quick_press'] = (isset($_POST['mttDashQuickpress']) && $_POST['mttDashQuickpress']) ? 1 : 0;
		$devOptions['remove_dashboard_incoming_links'] = (isset($_POST['mttDashIncoming']) && $_POST['mttDashIncoming']) ? 1 : 0;
		$devOptions['remove_dashboard_right_now'] = (isset($_POST['mttDashRightnow']) && $_POST['mttDashRightnow']) ? 1 : 0;
		$devOptions['remove_dashboard_plugins'] = (isset($_POST['mttDashPlugins']) && $_POST['mttDashPlugins']) ? 1 : 0;
		$devOptions['remove_dashboard_recent_drafts'] = (isset($_POST['mttDashDrafts']) && $_POST['mttDashDrafts']) ? 1 : 0;
		$devOptions['remove_dashboard_recent_comments'] = (isset($_POST['mttDashComments']) && $_POST['mttDashComments']) ? 1 : 0;
		$devOptions['remove_dashboard_primary'] = (isset($_POST['mttDashPrimary']) && $_POST['mttDashPrimary']) ? 1 : 0;
		$devOptions['remove_dashboard_secondary'] = (isset($_POST['mttDashSecondary']) && $_POST['mttDashSecondary']) ? 1 : 0;
		

		/* ADD DASHBOARDS */
		$devOptions['enable_dashboard1_mtt'] = (isset($_POST['mttAddDash1']) && $_POST['mttAddDash1']) ? 1 : 0;
		if (isset($_POST['mttAddDash1Title'])) 
			$devOptions['enable_dashboard1_mtt_title'] = $_POST['mttAddDash1Title'];
		if (isset($_POST['mttAddDash1Content'])) 
			$devOptions['enable_dashboard1_mtt_content'] = $_POST['mttAddDash1Content'];
		
		$devOptions['enable_dashboard2_mtt'] = (isset($_POST['mttAddDash2']) && $_POST['mttAddDash2']) ? 1 : 0;
		if (isset($_POST['mttAddDash2Title'])) 
			$devOptions['enable_dashboard2_mtt_title'] = $_POST['mttAddDash2Title'];
		if (isset($_POST['mttAddDash2Content'])) 
			$devOptions['enable_dashboard2_mtt_content'] = $_POST['mttAddDash2Content'];
		
		$devOptions['enable_dashboard3_mtt'] = (isset($_POST['mttAddDash3']) && $_POST['mttAddDash3']) ? 1 : 0;
		if (isset($_POST['mttAddDash3Title'])) 
			$devOptions['enable_dashboard3_mtt_title'] = $_POST['mttAddDash3Title'];
		if (isset($_POST['mttAddDash3Content'])) 
			$devOptions['enable_dashboard3_mtt_content'] = $_POST['mttAddDash3Content'];
		

		/* REVISIONS AND AUTOSAVE */
		if (isset($_POST['mttRevisionNum'])) {
			$theRevNum = $_POST['mttRevisionNum'];
			if(is_numeric($theRevNum) && $theRevNum > -2)
				$devOptions['post_revision'] = $theRevNum;
			elseif ($theRevNum == "")
				$devOptions['post_revision'] = $theRevNum;
			else
				$warnRevisions = $badValue;
		} 
		
		if (isset($_POST['mttAutoSave'])) {
			$theSaveNum = $_POST['mttAutoSave'];
			if(is_numeric($theSaveNum) && $theSaveNum > 0)
				$devOptions['post_autosave'] = $theSaveNum;
			elseif ($theSaveNum == "")
				$devOptions['post_autosave'] = $theSaveNum;
			else
				$warnAutoSave = $badValue;
		}  
		

		/* LOG IN */
		$devOptions['loginpage_backsite'] = (isset($_POST['mttLoginBackSite']) && $_POST['mttLoginBackSite']) ? 1 : 0;
		$devOptions['loginpage_errors'] = (isset($_POST['mttLoginError']) && $_POST['mttLoginError']) ? 1 : 0;		
		if (isset($_POST['mttLoginErrorMsg'])) 
			$devOptions['loginpage_error_msg'] = $_POST['mttLoginErrorMsg'];		
		if (isset($_POST['mttToolTip'])) 
			$devOptions['loginpage_tooltip'] = strip_tags($_POST['mttToolTip']);
		if (isset($_POST['mttLoginAltura'])) {
			$theHeight = $_POST['mttLoginAltura'];
			if (is_numeric($theHeight)&&$theHeight<=MTT_LOGO_HEIGHT) 
				$devOptions['loginpage_height'] = $_POST['mttLoginAltura'];
			elseif ($theHeight == "")
				$devOptions['loginpage_height'] = $theHeight;
			else
				$warnHeight = $badValue;
		}  
		if (isset($_POST['mttLoginImagem'])) {
			$theLoginImg = $_POST['mttLoginImagem'];
			if ($this->validateUrl($theLoginImg)) 
				$devOptions['loginpage_logo'] = $theLoginImg;
			else 
				$warnUrlImg = $badUrl;
		} 
		if (isset($_POST['mttLoginLogoURL'])) {
			$theLoginLogoUrl = $_POST['mttLoginLogoURL'];
			if ($this->validateUrl($theLoginLogoUrl)) 
				$devOptions['loginpage_logo_url'] = $theLoginLogoUrl;
			else 
				$warnUrlLogoUrl = $badUrl;
		} 
		if (isset($_POST['mttLoginBody'])) {
			$theLoginBody = $_POST['mttLoginBody'];
			if ($this->validateUrl($theLoginBody)) 
				$devOptions['loginpage_body'] = $theLoginBody;
			else 
				$warnUrlBody = $badUrl;
		} 
		if (isset($_POST['mttCustomColor'])) 
			$devOptions['loginpage_color'] = substr(strip_tags($_POST['mttCustomColor']),1);

		/* LOG OUT */
		$devOptions['logout'] = (isset($_POST['mttLogOut']) && $_POST['mttLogOut']) ? 1 : 0;
		if (isset($_POST['mttLogOutUrl'])) {
			$theLogoutUrl = $_POST['mttLogOutUrl'];
			if ($this->validateUrl($theLogoutUrl)) 
				$devOptions['logout_url'] = $theLogoutUrl;
			else 
				$warnUrl = $badUrl;
		} 
			

		/* USER PROFILE */
		$devOptions['contato_social'] = (isset($_POST['mttContatoSocial']) && $_POST['mttContatoSocial']) ? 1 : 0;
		$devOptions['contato_none'] = (isset($_POST['mttContatoNenhum']) && $_POST['mttContatoNenhum']) ? 1 : 0;		
		// can't be both at same time
		if($devOptions['contato_social']==1&&$devOptions['contato_none']==1) {
			$devOptions['contato_none'] = 0;
			$warnProfile = $badProfile;
		}			
		$devOptions['contato_slim'] = (isset($_POST['mttContatoSlim']) && $_POST['mttContatoSlim']) ? 1 : 0;			
		$devOptions['contato_hidden'] = (isset($_POST['mttContatoHidden']) && $_POST['mttContatoHidden']) ? 1 : 0;			
		$devOptions['contato_bio'] = (isset($_POST['mttContatoBio']) && $_POST['mttContatoBio']) ? 1 : 0;			
		$devOptions['admin_bar'] = (isset($_POST['mttAdminBar']) && $_POST['mttAdminBar']) ? 1 : 0;
					

		/* ERROR WARNINGS */
		if ($warnUrl != "" || $warnUrlImg != "" || $warnUrlBody != "" || $warnRevisions != "" || $warnAutoSave != "" || $warnHeight != "" || $warnProfile != "" || $warnUrlLogoUrl !="") $warnUpdate = $warnAllErrors;
		
		
		update_option($this->adminOptionsName, $devOptions);
?>
<div class="updated"><p><strong><?php _e('Settings updated.',
'mtt'); echo $warnUpdate; ?></strong></p></div>

<?php
	} 
	//END IF(ISSET) 
?>
	<div class=wrap> 
		<div id="icon-options-mtt" class="icon32">
			<a href="http://www.rodbuaiz.com"><img src="<?php echo $this->logo; ?>" alt="rodbuaiz.com" title="rodbuaiz.com"/></a>
		</div>
	<h2>Many Tips Together <em style="font-size:.5em;">version <?php echo MTT_VERSION; ?></em></h2> 
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>"> 
		
	<!--Main Settings-->	
	<div id="poststuff" class="metabox-holder">
	<div class="meta-box-sortables ui-sortable">
		<div class="submit update-button"><input type="submit" class="button-primary" name="update_mttSettings"
		value="<?php _e('Update settings', 'mtt') ?>" /></div> 

			<!-- PLUGIN CONFIGURATION -->
			<div class="postbox help-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Plugin Configuration', 'mtt'); ?></span></h3>
				<div class="inside">
					<ul>					
						<li>
							<label><input name="mttVerbose" id="mttVerbose" type="checkbox" <?php if ($devOptions['verbose_plugin']) echo ' checked="yes"'; ?>> <?php _e('Hide plugin help','mtt'); ?></label>
						</li>
						<li>
							<label><input name="mttSmall" id="mttSmall" type="checkbox" <?php if ($devOptions['small_plugin']) echo ' checked="yes"'; ?>> <?php _e('Start with all tabs closed','mtt'); ?></label>
						</li>
					</ul>
				</div>
			</div><!--postbox-->

			<!-- MAINTENANCE MODE -->
			<div class="postbox maintenance-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Maintenance Mode', 'mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>						
						<li>
							<label><input name="mttMaintenance" id="mttMaintenance" type="checkbox" <?php if ($devOptions['maintenance_mode']) echo ' checked="yes"'; ?>> <?php _e('Enable maintenance mode','mtt'); ?></label><p class="desc"><?php _e('Block the site to visitors and not-admins. To display your own custom page, follow the instruction in the file <em><strong>many-tips-together/maintenance/index.php</strong></em>.','mtt'); ?></p>
						</li>					
						<li class="theMaintenance">
							<label class="textinput"><?php _e('Browser Title &lt;title&gt;','mtt'); ?></label><input type="text" size="50" name="mttMaintenanceTitle" id="mttMaintenanceTitle" value="<?php echo $devOptions['maintenance_mode_title']; ?>">
						</li>
						<li class="theMaintenance">
							<label class="textinput"><?php _e('Text for the first line','mtt'); ?></label><input type="text" size="50" name="mttMaintenanceTxt1" id="mttMaintenanceTxt1" value="<?php echo esc_html(stripslashes($devOptions['maintenance_mode_line1'])); ?>">
						</li>
						<li class="theMaintenance">
							<label class="textinput"><?php _e('Link for the second line, without http://','mtt'); ?></label><input type="text" size="50" name="mttMaintenanceTxt2" id="mttMaintenanceTxt2" value="<?php echo esc_html(stripslashes($devOptions['maintenance_mode_line2'])); ?>">
						</li>
						<li class="theMaintenance">
							<label class="textinput"><?php _e('Minimum user level to see site content.','mtt'); ?></label>
							<select name="mttMaintenanceLevel" id="mttMaintenanceLevel">
							<option value="a"<?php if ( $devOptions['maintenance_mode_level'] == "a" ) { echo " selected='selected'"; } ?>><?php _e('Administrator','mtt'); ?></option>
							<option value="e"<?php if ( $devOptions['maintenance_mode_level'] == "e" ) { echo " selected='selected'"; } ?>><?php _e('Editor','mtt'); ?></option>
							<option value="t"<?php if ( $devOptions['maintenance_mode_level'] == "t" ) { echo " selected='selected'"; } ?>><?php _e('Author','mtt'); ?></option>
							<option value="c"<?php if ( $devOptions['maintenance_mode_level'] == "c" ) { echo " selected='selected'"; } ?>><?php _e('Contributor','mtt'); ?></option>
							<option value="s"<?php if ( $devOptions['maintenance_mode_level'] == "s" ) { echo " selected='selected'"; } ?>><?php _e('Subscriber','mtt'); ?></option>
							</select>
						</li>
					</ul>
				</div>
			</div><!--postbox-->

				
			<!-- WORDPRESS BEHAVIOR -->		
			<div class="postbox frontend-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('WordPress Behavior','mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>						
						<li>
							<label><input name="mttUpdateWp" id="mttUpdateWp" type="checkbox" <?php if ($devOptions['update_wp']) echo ' checked="yes"'; ?>> <?php _e('Block WordPress upgrade warnings','mtt'); ?></label><p class="desc"><?php _e('Yes, I know that, but don\'t bug me, please...','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttUpdatePlg" id="mttUpdatePlg" type="checkbox" <?php if ($devOptions['update_plg']) echo ' checked="yes"'; ?>> <?php _e('Block plugins upgrade warnings','mtt'); ?></label><p class="desc"><?php _e('Yeah, I know...','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttNoUrl" id="mttNoUrl" type="checkbox" <?php if ($devOptions['disable_nourl']) echo ' checked="yes"'; ?>> <?php _e('Hide blog URL from WordPress "phone home"','mtt'); ?></label><p class="desc"><?php _e('Filter out the blog URL from the data that is sent to wordpress.org - Check this <a href="http://lynnepope.net/wordpress-privacy">article</a> to learn more.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttSmartQuotes" id="mttSmartQuotes" type="checkbox" <?php if ($devOptions['disable_smartquotes']) echo ' checked="yes"'; ?>> <?php _e('Disable SmartQuotes','mtt'); ?><p class="desc"><?php _e('Prevent the conversion of straight quotes into directional quotes.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttCapitalP" id="mttCapitalP" type="checkbox" <?php if ($devOptions['disable_capitalp']) echo ' checked="yes"'; ?>> <?php _e('Disable Capital P','mtt'); ?></label><p class="desc"><?php _e('Prevents WordPress of auto-correcting mispellings of its name. Check this <a href="http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit">article</a>','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttAutoP" id="mttAutoP" type="checkbox" <?php if ($devOptions['disable_autop']) echo ' checked="yes"'; ?>> <?php _e('Disable Auto P','mtt'); ?></label><p class="desc"><?php _e('Prevents WordPress from inserting automatic &lt;p&gt; tags in your code.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttSelfPing" id="mttSelfPing" type="checkbox" <?php if ($devOptions['disable_selfping']) echo ' checked="yes"'; ?>> <?php _e('Disable Self Ping','mtt'); ?></label><p class="desc"><?php _e('Prevents WordPress from sending pings to your own site.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttVersionFull" id="mttVersionFull" type="checkbox" <?php if ($devOptions['disable_version_full']) echo ' checked="yes"'; ?>> <?php _e('Completely eliminate WordPress version in &lt;head&gt;','mtt'); ?></label><p class="desc"><?php //_e('','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttVersionNumber" id="mttVersionNumber" type="checkbox" <?php if ($devOptions['disable_version_number']) echo ' checked="yes"'; ?>> <?php _e('Eliminate only the WordPress version number in &lt;head&gt;','mtt'); ?></label><p class="desc"><?php //_e('','mtt'); ?></p>
						</li>
					</ul>
				</div>
			</div><!--postbox-->
				
			<!-- REMOVE FROM DASHBOARD -->
			<div class="postbox dashboard-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Remove from Dashboard','mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>											
						<li>
							<label><input name="mttDashQuickpress" id="mttDashQuickpress" type="checkbox" <?php if ($devOptions['remove_dashboard_quick_press']) echo ' checked="yes"'; ?>> <?php _e('QuickPress'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashIncoming" id="mttDashIncoming" type="checkbox" <?php if ($devOptions['remove_dashboard_incoming_links']) echo ' checked="yes"'; ?>> <?php _e('Incoming Links'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashRightnow" id="mttDashRightnow" type="checkbox" <?php if ($devOptions['remove_dashboard_right_now']) echo ' checked="yes"'; ?>> <?php _e('Right now'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashPlugins" id="mttDashPlugins" type="checkbox" <?php if ($devOptions['remove_dashboard_plugins']) echo ' checked="yes"'; ?>> <?php _e('Plugins'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashDrafts" id="mttDashDrafts" type="checkbox" <?php if ($devOptions['remove_dashboard_recent_drafts']) echo ' checked="yes"'; ?>> <?php _e('Recent Drafts'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashComments" id="mttDashComments" type="checkbox" <?php if ($devOptions['remove_dashboard_recent_comments']) echo ' checked="yes"'; ?>> <?php _e('Recent Comments'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashPrimary" id="mttDashPrimary" type="checkbox" <?php if ($devOptions['remove_dashboard_primary']) echo ' checked="yes"'; ?>> <?php _e('WordPress_Blog : *in the Dashboard, you can configure this one, and change its title and feed address*','mtt'); ?></label>
						</li>						
						<li>
							<label><input name="mttDashSecondary" id="mttDashSecondary" type="checkbox" <?php if ($devOptions['remove_dashboard_secondary']) echo ' checked="yes"'; ?>> <?php _e('Other WordPress News : *this one too!*', 'mtt'); ?></label>
						</li>						
					</ul>
				</div>
			</div><!--postbox-->
				
			<!-- ADD DASHBOARDS -->
			<div class="postbox add-dashboard-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Add Dashboards', 'mtt'); ?></span></h3>
				<div class="inside closenow">
				<div class="inside-pdash1">
					<ul>
						<li>
							<label><input name="mttAddDash1" id="mttAddDash1" type="checkbox" <?php if ($devOptions['enable_dashboard1_mtt']) echo ' checked="yes"'; ?>> <?php _e('Enable Personal Dashboard 1','mtt'); ?></label><p class="desc"><?php _e('Use this dashboards to put your own messages or iframes or embeds.','mtt'); ?></p>
						</li>
					
						<li class="theAddDash1"><label class="textinput"><?php _e('Title','mtt'); ?></label><input type="text" size="50" name="mttAddDash1Title" id="mttAddDash1Title" value="<?php echo esc_textarea(stripslashes($devOptions['enable_dashboard1_mtt_title'])); ?>">
						</li>

						<li class="theAddDash1"><label class="textinput"><?php _e('Content','mtt'); ?></label><textarea name="mttAddDash1Content" style="width: 70%; height: 100px;"><?php echo esc_html(stripslashes($devOptions['enable_dashboard1_mtt_content'])); ?></textarea>
						</li>
					</ul>
				</div>
				<div class="inside-pdash2">
					<ul>
						<li>
							<label><input name="mttAddDash2" id="mttAddDash2" type="checkbox" <?php if ($devOptions['enable_dashboard2_mtt']) echo ' checked="yes"'; ?>> <?php _e('Enable Personal Dashboard 2','mtt'); ?></label>
						</li>
					
						<li class="theAddDash2"><label class="textinput"><?php _e('Title','mtt'); ?></label><input type="text" size="50" name="mttAddDash2Title" id="mttAddDash2Title" value="<?php echo esc_html(stripslashes($devOptions['enable_dashboard2_mtt_title'])); ?>">
						</li>

						<li class="theAddDash2"><label class="textinput"><?php _e('Content','mtt'); ?></label><textarea name="mttAddDash2Content" style="width: 70%; height: 100px;"><?php echo esc_html(stripslashes($devOptions['enable_dashboard2_mtt_content'])); ?></textarea>
						</li>
					</ul>
				</div>
				<div class="inside-pdash3">
					<ul>
						<li>
							<label><input name="mttAddDash3" id="mttAddDash3" type="checkbox" <?php if ($devOptions['enable_dashboard3_mtt']) echo ' checked="yes"'; ?>> <?php _e('Enable Personal Dashboard 3','mtt'); ?></label>
						</li>
					
						<li class="theAddDash3"><label class="textinput"><?php _e('Title','mtt'); ?></label><input type="text" size="50" name="mttAddDash3Title" id="mttAddDash3Title" value="<?php echo esc_html(stripslashes($devOptions['enable_dashboard3_mtt_title'])); ?>">
						</li>

						<li class="theAddDash3"><label class="textinput"><?php _e('Content','mtt'); ?></label><textarea name="mttAddDash3Content" style="width: 70%; height: 100px;"><?php echo esc_html(stripslashes($devOptions['enable_dashboard3_mtt_content'])); ?></textarea>
						</li>
					</ul>
				</div>
				</div>
			</div><!--postbox-->

			<!-- REVISIONS AND AUTOSAVE -->
			<div class="postbox revisions-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Revisions and autosave','mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>
						<li>
							<label class="textinput"><?php _e('Number of revisions to maintain for each post','mtt'); ?></label><input type="text" name="mttRevisionNum" id="mtt_revision_num" size="1" maxlength="2" value="<?php echo $devOptions['post_revision']; ?>"> <?php echo $warnRevisions; ?><p class="desc"><?php _e('-1 (unlimited) | 0 (none) | 1 or more (custom)','mtt'); ?></p>
						</li>
					</ul>
					<ul>
						<li>
							<label class="textinput"><?php _e('Auto-save interval <em>in minutes</em>','mtt'); ?></label><input type="text" size="1" maxlength="2" name="mttAutoSave" id="mtt_auto_save" value="<?php echo $devOptions['post_autosave']; ?>"> <?php echo $warnAutoSave; ?></p>
						</li>
					</ul>					
				</div>
			</div><!--postbox-->
			
			<!-- LOG IN -->
			<div class="postbox login-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Log In','mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>						
						<li>
							<label class="textinput"><?php _e('Title for logo','mtt'); ?></label><input type="text" name="mttToolTip" id="mttToolTip" size="50" value="<?php echo $devOptions['loginpage_tooltip']; ?>"></small><p class="desc"><?php _e('Appears as tooltip. The default text is: "Powered by WordPress")','mtt'); ?></p>
						</li>
						<li>
							<label class="textinput"><?php _e('Custom logo image (full URL)','mtt'); ?></label><input type="text" name="mttLoginImagem" id="mttLoginImagem" size="50" value="<?php echo $devOptions['loginpage_logo']; ?>"> <?php echo $warnUrlImg; ?><p class="desc"><?php echo sprintf( __( 'if you want to try it right now, copy the url bellow and define the logo height to 160<br /><code>%s</code><br /><br /><em>There are some issues changing the width, so stick to 367px...</em>', 'mtt' ), MTT_URL.'images/logo_test.png' ); ?></p>
						</li>
						<li>
							<label class="textinput"><?php _e('Custom logo height','mtt'); ?></label><input type="text" name="mttLoginAltura" id="mttLoginAltura" size="1" maxlength="3" value="<?php echo $devOptions['loginpage_height']; ?>"> <?php echo $warnHeight; ?><p class="desc"><?php echo sprintf( __( 'default: 67 - maximum value allowed:  %s', 'mtt' ), MTT_LOGO_HEIGHT ); ?></p>
						</li>
						<li>
							<label class="textinput"><?php _e('Custom logo link (full URL)','mtt'); ?></label><input type="text" name="mttLoginLogoURL" id="mttLoginLogoURL" size="50" value="<?php echo $devOptions['loginpage_logo_url']; ?>"> <?php echo $warnUrlLogoUrl; ?><p class="desc"><?php _e( 'Link for the logo, default: wordpress.org', 'mtt' ); ?></p>
						</li>
						<li>
							<label class="textinput"><?php _e('Custom background image (full URL)','mtt'); ?></label><input type="text" name="mttLoginBody" id="mttLoginBody" size="50" value="<?php echo $devOptions['loginpage_body']; ?>"> <?php echo $warnUrlBody; ?><p class="desc"><?php echo sprintf( __( 'if you want to try it right now, copy the url bellow<br /><code>%s</code><br /><br /><em>The behavior is "repeat", but you can change that, at the begining of the plugin code</em>', 'mtt' ), MTT_URL.'images/pattern.png' ); ?></p>
						</li>
						 <li>
							<label class="textinput"><?php _e('Custom background color','mtt'); ?></label><div id="mtt_color_sample" style="float:left;padding:0 6px;height:20px;width:50px;margin:1px 6px 0 10px;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;border:1px solid rgba(0,0,0,0.1);background:#FBFBFB;color:#EEE;text-shadow:0 -1px 0 rgba(0,0,0,0.25);"></div><div><input type="text" class="regular-text" style="width:70px;" maxlength="7" value="#<?php if ( $devOptions['loginpage_color'] != '' ) echo $devOptions['loginpage_color']; ?>" id="mttCustomColor" name="mttCustomColor"/><div id="mttColorPicker" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div><!-- <a class="hide-if-no-js" href="#" id="mtt_pickcolor"><?php _e('Select a Color','mtt'); ?></a>--> <a class="hide-if-no-js" href="#" id="mtt_resetcolor"><?php _e('Reset','mtt'); ?></a></div>
						</li>
						<li>
							<label><input name="mttLoginBackSite" id="mttLoginBackSite" type="checkbox" <?php if ($devOptions['loginpage_backsite']) echo ' checked="yes"'; ?>> <?php echo sprintf( __( 'Hide link "Back to %s"', 'mtt' ), get_bloginfo('name') ); ?></label><p class="desc"><?php _e('You can use the logo for that.','mtt'); ?></p>							
						</li>
						<li>
							<label><input name="mttLoginError" id="mttLoginError" type="checkbox" <?php if ($devOptions['loginpage_errors']) echo ' checked="yes"'; ?>> <?php _e('Custom error message','mtt'); ?></small></label><p class="desc"><?php _e('(don\'t reveal what\'s the mistake, user or password)','mtt'); ?></p>
						</li>
						<li id="laMsgErr"><textarea name="mttLoginErrorMsg" style="width: 100%; height: 100px;"><?php echo esc_html(stripslashes($devOptions['loginpage_error_msg'])); ?></textarea><p class="desc"><?php _e('Don\'t use html code.','mtt'); ?></p>
						</li>						
					</ul>
				</div>
			</div><!--postbox-->

			<!-- LOG OUT -->
			<div class="postbox logout-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('Log Out','mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>
						<li>
							<label><input name="mttLogOut" id="mttLogOut" type="checkbox" <?php if ($devOptions['logout']) echo ' checked="yes"'; ?>> <?php _e('Redirect logout to another address','mtt'); ?></label><p class="desc"><?php _e('The default behavior is being redirected to the login page...','mtt'); ?></p>
						</li>
						
						<li id="laUrl"><?php _e('What\'s the URL you want to redirect to','mtt'); ?> <input type="text" size="50" name="mttLogOutUrl" id="mttLogOutUrl" value="<?php echo $devOptions['logout_url']; ?>"> <?php echo $warnUrl; ?>
						</li>
					</ul>
				</div>
			</div><!--postbox-->

			<!-- USER PROFILE -->
			<div class="postbox profile-box">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php _e('User profile','mtt'); ?></span></h3>
				<div class="inside closenow">
					<ul>					
						<li>
							<label><input name="mttContatoSocial" id="mttContatoSocial" type="checkbox" <?php if ($devOptions['contato_social']) echo ' checked="yes"'; ?>> <?php _e('Change <strong>Aim</strong>-<strong>Yim</strong>-<strong>Jabber</strong> for <strong>Twitter</strong>-<strong>Facebook</strong>-<strong>LinkedIn</strong>','mtt'); ?></label><p class="desc"><?php _e('You have to choose between this one or the next one.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttContatoNenhum" id="mttContatoNenhum" type="checkbox" <?php if ($devOptions['contato_none']) echo ' checked="yes"'; ?>> <?php _e('Remove Aim/Yim/Jabber','mtt'); ?> <?php echo $warnProfile; ?></label><p class="desc"><?php _e('Read above.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttContatoSlim" id="mttContatoSlim" type="checkbox" <?php if ($devOptions['contato_slim']) echo ' checked="yes"'; ?>> <?php _e('Remove Visual Editor, Admin Color Scheme and Keyboard Shortcuts','mtt'); ?></label><p class="desc"><?php _e('These are kind of difficult to hide one by one, so it has to be in block.','mtt'); ?></p>
						</li>						
						<li>
							<label><input name="mttContatoHidden" id="mttContatoHidden" type="checkbox" <?php if ($devOptions['contato_hidden']) echo ' checked="yes"'; ?>> <?php _e('Completely hide the Personal Options block','mtt'); ?></label><p class="desc"><?php _e('If you\'re going to use the previous and the next options, use this one and the next instead.','mtt'); ?></p>
						</li>
						<li>
							<label><input name="mttAdminBar" id="mttAdminBar" type="checkbox" <?php if ($devOptions['admin_bar']) echo ' checked="yes"'; ?>> <?php _E( 'Disable Admin Bar globally', 'mtt' ); ?></label><p class="desc"><?php echo sprintf( __( 'Alternatively, you can disable it in a per user basis in each user <a href="%s/wp-admin/profile.php">profile page</a>', 'mtt' ), site_url() ); ?> </p>
						</li>
						<li>
							<label><input name="mttContatoBio" id="mttContatoBio" type="checkbox" <?php if ($devOptions['contato_bio']) echo ' checked="yes"'; ?>> <?php _e('Hide the About Yourself title and Biographical Info box','mtt'); ?></label><p class="desc"><?php //_e('','mtt'); ?></p>
						</li>						
					</ul>
				</div>
			</div><!--postbox-->
		
			<div class="submit update-button update-last"><input type="submit" class="button-primary" name="update_mttSettings"
			value="<?php _e('Update settings', 'mtt') ?>" /></div> 

		</div><!--meta-box-sortables-->
	</div><!--poststuff-->
	</form>

	<!--Delete Post Revisions-->
	<div id="poststuff" class="metabox-holder">
	<form name="form2" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="my_erase_revisions" value="Y">
	<div class="meta-box-sortables">
		<div class="postbox database-box">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span><?php _e('Database','mtt'); ?></span></h3>
			<div class="inside closenow">
				<ul>
					<li><strong><?php _e('Total number of revisions (all posts and pages)','mtt'); ?>:</strong> <?php 
					$myrows = count($wpdb->get_results( "SELECT id FROM $wpdb->posts WHERE post_type = 'revision'" )); 
					$red = ($myrows > 0) ? " red-revisions" : ""; ?>
					<span class="revisions-number<?php echo $red; ?>"><?php echo $myrows; ?></span><p class="desc"><?php _e('A big number of revisions can decrease your database performance.','mtt'); ?></p>
					</li>
				
					<li>
						<label><input name="mttEraseRevisions" id="mttEraseRevisions" type="checkbox"> <?php _e('Delete revisions','mtt'); ?></label>
					</li>
				

					<li id="deleteRevisions">
						<input type="submit" name="Submit" class="button-primary" value="<?php _e('Yes, please delete them!','mtt'); ?>" />
					</li>
				</ul>				
			</div>
		</div><!--postbox-->
	</div><!--meta-box-sortables-->
	</form>
	</div><!--poststuff-->

	<!--Reset Plugin Options-->
	<div id="poststuff" class="metabox-holder">
	<form name="form3" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="my_reset_options" value="Y">
	<div class="meta-box-sortables">
		<div class="postbox resetoptions-box">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span><?php _e('Reset plugin settings','mtt'); ?></span></h3>
			<div class="inside closenow">
				<ul>
					<li>
						<label><input name="mttResetOptions" id="mttResetOptions" type="checkbox"> <?php _e('Reset settings','mtt'); ?></label><p class="desc"><?php _e('Return to defaults... Being: no changes in my WordPress.','mtt'); ?></p>
					</li>
				
					<li id="resetOptions">
						<input type="submit" name="Submit" class="button-primary" value="<?php _e('Yes, please reset it!','mtt'); ?>" />
					</li>
				</ul>				
			</div>
		</div><!-- post-box -->
	</div><!--meta-box-sortables-->
	</form>
	</div><!-- post-stuff --><?php /*
	<div id="poststuff" class="metabox-holder plugin-observations">
	<hr /><hr />
		My personal observations...<hr />
	</div>*/ ?>
	</div><!-- end-wrap -->
	<?php 
?>