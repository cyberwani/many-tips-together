<?php
// BODY
$body_color      = $devOptions['loginpage_body_color'];
$body_position   = $devOptions['loginpage_body_position'];
$body_repeat     = $devOptions['loginpage_body_repeat'];
$body_attachment = $devOptions['loginpage_body_attachment'];
$body_img        = $devOptions['loginpage_body_img'];
//
$body_color      = ($body_color != '' && $body_color != ' ') ? 'background-color:' . $body_color . ';' : '';
$body_position   = ($body_position != '') ? $body_position . ' ' : '';
$body_repeat     = ($body_repeat != '') ? $body_repeat . ' ' : '';
$body_attachment = ($body_attachment != '') ? $body_attachment . ' ' : '';
$body_img        = ($body_img != '') ? 'url(' . $body_img . ')' : '';
//
$css_img = ($body_img != '') ? 'background:' . $body_position . $body_repeat . $body_attachment . $body_img .';' : '';
//
$htmlbody = 'body,body.login{height:100%;' . $css_img . $body_color . '} ';


// LOGO
$logo_height = $devOptions['loginpage_logo_height'];
$logo_img    = $devOptions['loginpage_logo_img'];
//
$logo_height = ($logo_height != '') ? 'height:' . $logo_height . 'px; ' : '';
$logo_img    = ($logo_img != ' ') ? 'background-image:url(' . $logo_img . ') !important;' : '';
//
$div_login_h1 = '#login h1 a { margin:0px;width:auto; ' . $logo_height . $logo_img . '} ';


// COLUMN WIDTH
$form_width   = $devOptions['loginpage_form_width'];
$form_width   = ($form_width != '') ? 'width:' . $form_width . 'px; ' : '';
$logo_padding = $devOptions['loginpage_logo_padding'];
$logo_padding = ($logo_padding != '') ? 'padding:' . $logo_padding . 'px 0 0; ' : '';

$div_login = ($form_width != '' || $logo_padding != '') ? '#login{' . $form_width . $logo_padding . '} ' : '';


// FORM
$frm_height  = $devOptions['loginpage_form_height'];
$frm_shadow  = $devOptions['loginpage_form_noshadow'];
$frm_rounded = $devOptions['loginpage_form_rounded'];
$frm_border  = $devOptions['loginpage_form_border'];
$frm_bg      = $devOptions['loginpage_form_bg_img'];
$frm_color      = $devOptions['loginpage_form_bg_color'];
//
$frm_height  = ($frm_height != '') ? 'height: ' . $frm_height . 'px;padding-top:40px;' : '';
$frm_shadow  = ($frm_shadow) ? '-moz-box-shadow: none;-webkit-box-shadow:none;box-shadow:none;' : '';
$frm_rounded = ($frm_rounded != '') ? '-webkit-border-radius:' . $frm_rounded . 'px;border-radius:' . $frm_rounded . 'px;' : '';
$frm_border  = ($frm_border != '') ? 'border:' . $frm_border . ';' : '';
$frm_bg      = ($frm_bg != ' ') ? 'background: url(' . $frm_bg . ') no-repeat;' : '';
$frm_color   = ($frm_color != ' ') ? 'background-color: ' . $frm_color . ';' : '';
//
$div_loginform = '#loginform {' . $frm_border . $frm_height . $frm_shadow . $frm_rounded . $frm_bg . $frm_color .  '} ';


// LOGIN BUTTON
$p_submit = $devOptions['loginpage_button_position'];
$p_submit = ($p_submit != '') ? '#wp-submit{margin-top: ' . $p_submit . 'px;} ' : '';


// BACK TO BLOG
$p_backtoblog = ($devOptions['loginpage_backsite_hide'] != '') ? '
	p#backtoblog{display:none;} ' : '';


// REMOVE TEXT SHADOW
$div_nav_backtoblog = ($devOptions['loginpage_text_shadow']) ? '#nav, #backtoblog { text-shadow: none !important; }' : '';


// LINKS POSITION
$l_d_v         = $devOptions['loginpage_links_position'];
$login_div_nav = ($l_d_v != '') ? '.login #nav {margin: ' . $l_d_v . 'px 0 0 16px}.login #backtoblog {margin: 0 0 0 16px}' : '';

$extra_css = ($devOptions['loginpage_extra_css'] != '') ? $devOptions['loginpage_extra_css'] : '';
echo '<style type="text/css">' . $htmlbody . $div_login_h1 . $div_login . $div_loginform . $p_submit . $p_backtoblog . $div_nav_backtoblog . $login_div_nav . $extra_css . '</style>';