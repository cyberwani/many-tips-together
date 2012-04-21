<?php
/*

  ATTENTION!
  If the path of your wp-content directory is not in the default location,
  than you must adjust the "require_once" path


  CUSTOMIZATION INSTRUCTIONS
  If you want to customize the Maintenance Screen, do as follows:

  - copy the entire folder "maintenance" into your "wp-content" folder, don't change its name

  - add the next line to your wp-config.php (near WPLANG)
    define('MTT_CUSTOM_MAINTENANCE', true);

  - substitute the first two lines of this file with the following
	require_once "./../../wp-load.php";
	$theUrl = content_url() . '/maintenance/';
	
  - replace the image files with your own, 
    keep their names or adjust the custom images values

  - if you wish, you can adjust the CSS block at the end of this file

*/


function brsfl_get_wp_config_path() {
    $base = dirname(__FILE__);
    $path = false;
    if (@file_exists(dirname(dirname($base)) . "/wp-load.php")) {
        $path = dirname(dirname($base));
    } elseif (@file_exists(dirname(dirname(dirname($base))) . "/wp-load.php")) {
        $path = dirname(dirname(dirname($base)));
    } elseif (@file_exists(dirname(dirname(dirname(dirname($base)))) . "/wp-load.php")) {
        $path = dirname(dirname(dirname(dirname($base))));
    } elseif (@file_exists(dirname(dirname(dirname(dirname(dirname($base))))) . "/wp-load.php")) {
        $path = dirname(dirname(dirname(dirname(dirname($base)))));
    } else {
        $path = false;
    }
    if ($path != false) {
        $path = str_replace("\\", "/", $path);
    }
    return $path;
}

if (brsfl_get_wp_config_path()) {
    require_once brsfl_get_wp_config_path() . "/wp-load.php";
    if (!defined('MTT_CUSTOM_MAINTENANCE')) $theUrl = WP_PLUGIN_URL . '/many-tips-together/maintenance/';
    else $theUrl = content_url() . '/maintenance/';
} else {
    // REMOVE ALL THIS IF/ELSE AND PUT THE FOLLOWING LINE WITH THE CORRECT PATH TO YOUR WORDPRESS INSTALLATION
    // require_once "./../wp-load.php";
    die('Sorry, we couldn\'t figure WordPress Directory, please hardcode it directly in the file /wp-content/maintenance/index.php');
}


// custom images values
$custom_stripes = $theUrl . 'pattern.png';
$custom_logo    = $theUrl . 'glow.png';
$custom_bg      = $theUrl . 'bg.jpg';



// get plugin options
$adminOptionsName = "ManyTipsTogether";
$devOptions       = get_option($adminOptionsName);
$line1Text        = $devOptions['maintenance_mode_line1'];
$line2Text        = $devOptions['maintenance_mode_line2'];
$stripes          = $devOptions['maintenance_mode_html_img'];
$extraCss         = $devOptions['maintenance_mode_extra_css'];
$siteName = ($devOptions['maintenance_mode_line0']!='') ? $devOptions['maintenance_mode_line0'] : get_bloginfo('name');

if ($stripes == '0') {
    $stripes = '';
} elseif ($stripes != '' && $stripes != ' ')  {
    $stripes = 'html{background:url('.$stripes.') repeat}';
} else {
    $stripes = 'html{background:url('.$custom_stripes.') repeat}';
}
$bg          = $devOptions['maintenance_mode_body_img'];
$radious     = '-webkit-border-radius: 23px; border-radius: 23px; -moz-box-shadow: 5px 5px 8px #DCDCDC; -webkit-box-shadow: 5px 5px 8px #DCDCDC; box-shadow: 5px 5px 8px #DCDCDC;';
if ($bg == '0') {
	$bg = 'background:transparent;';
	$radious = '';
} elseif ($bg != '' && $bg != ' ')  {
	$bg = 'background:url('.$bg.') no-repeat;';
} else {
	$bg = 'background:url('.$custom_bg.') no-repeat;';
}
$logo          = $devOptions['maintenance_mode_glow_img'];
if ($logo == '0') {
    $logo = '';
} elseif ($logo != '' && $logo != ' ')  {
    $logo = 'background:url('.$logo.') no-repeat';
} else {
    $logo = 'background:url('.$custom_logo.') no-repeat';
}

// CSS of this file
echo <<<CSS
<style type="text/css">
	*{padding:0;margin:0}
	$stripes
	body{
		border:0;
		width:900px;
		max-width:900px;
		height:560px;
		$bg ;
		font-family:'Myriad Pro',Arial,Helvetica,sans-serif;
		margin: 0 auto;
		$radious;
	}
	#logo.blank{ $logo ;text-indent:0}
	#logo{height:397px;margin-bottom:-200px}
	#when,.textwidget{font-size:18px;text-align:center;margin-top:45px;}
	#wrapper{width:467px;margin:80px auto}
	h1{padding-top:180px;color:#fff;font-size:36px;font-weight:bold;text-align:center;white-space:nowrap;text-shadow: 0.1em 0.1em 0.2em black}
	h2{color:#fff;font-size:12px;letter-spacing: 0.1em;font-weight:bold;text-align:center;text-shadow: 0.1em 0.1em 1.2em black;}
	#when,.textwidget{color:#65a70e; font-size:1.2em;}
	$extraCss
</style>
CSS;


// html of this file
echo <<<EOT
<div id="wrapper">
<div id="logo" class="blank">
<h1>{$siteName}</h1>
</div>
<div id="when">
{$line1Text}
<h2><a href="http://{$line2Text}">{$line2Text}</a></h2>
</div>

</div>
EOT;
?>