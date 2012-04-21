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


require_once "./../../../../wp-load.php";
$theUrl = WP_PLUGIN_URL . '/many-tips-together/maintenance/';


// custom images values
$stripes = $theUrl.'pattern.png';
$logo = $theUrl.'glow.png';
$bg = $theUrl.'bg.jpg';


// H1
$siteName = get_bloginfo('name');


// get plugin options
$adminOptionsName = "ManyTipsTogether";
$devOptions = get_option($adminOptionsName);
$line1Text = $devOptions['maintenance_mode_line1'];
$line2Text = $devOptions['maintenance_mode_line2'];


// CSS of this file
echo <<<CSS
<style type="text/css">
	*{padding:0;margin:0}
	html{background:url('$stripes') repeat}
	body{border:0;width:900px;height:600px;background:url('$bg')  no-repeat;font-family:'Myriad Pro',Arial,Helvetica,sans-serif;}
	#logo.blank{background:url('$logo') no-repeat;text-indent:0}
	#logo{height:397px;margin-bottom:-200px}
	#when,.textwidget{font-size:18px;text-align:center;margin-top:45px;}
	#wrapper{width:467px;margin:80px auto}
	h1{padding-top:180px;color:#fff;font-size:36px;font-weight:bold;text-align:center;white-space:nowrap;text-shadow: 0.1em 0.1em 0.2em black}
	h2{color:#fff;font-size:12px;letter-spacing: 0.1em;font-weight:bold;text-align:center;text-shadow: 0.1em 0.1em 1.2em black;}
	#when,.textwidget{color:#65a70e; font-size:1.2em;}
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