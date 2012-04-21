<?php


?>
<table id="mtt-all-options-table">
    <tr>
        <th colspan="2" style="font-weight:normal"><?php _e('<h4>Reference only, no values can be modified.</h4>Go to <a href="/wp-admin/options.php">/wp-admin/options.php</a> to change some of them.<br/><em>But</em> the serizalized settings are not shown there...','mtt'); ?><br/><br/><?php _e('This listing is based in <a href="http://sillybean.net/2010/09/wordpress-hidden-gems-options-php/comment-page-1/#comment-30586" target="_blank">this code</a>, with style modifications and removal of the _transient options.','mtt'); ?><br/><br/><br/>
        </th>
    </tr>
    <?php
    $options = $wpdb->get_results("SELECT * FROM $wpdb->options ORDER BY option_name");

    foreach ((array)$options as $option) :
        $disabled = false;
        if ($option->option_name == '')
            continue;
        if (is_serialized($option->option_value)) {
            if (is_serialized_string($option->option_value)) {
                // this is a serialized string, so we should display it
                $value = maybe_unserialize($option->option_value);
                $class = 'all-options';
            } else {
                $value = $option->option_value;
                $class = 'all-options serialized';
            }
        } else {
            $value = $option->option_value;
            $class = 'all-options';
        }
        $name = esc_attr($option->option_name);
        if (strpos($name, '_transient') !== 0 && strpos($name, '_site_transient') !== 0):
            echo "
<tr>
    <th scope='row' style='text-align:right;padding-right:10px;width:30%'><label>" . esc_html($option->option_name) . "</label></th>
<td style='width:60%'>";
            if (strpos($value, "\n") !== false || strpos($class, 'serialized') !== false)
                echo "<textarea class='$class' name='$name' id='$name' rows='5' style='width:100%'  readonly='readonly'>" . wp_htmledit_pre($value) . "</textarea>";
            else
                echo "<input class='regular-text $class' type='text'  style='width:100%' readonly='readonly' name='$name' id='$name' value='" . esc_attr($value) . "'" . disabled($disabled, true, false) . " />";
            echo "</td>
</tr>";
        endif;
    endforeach;
    ?>
</table>
<?php
//function safe_get_serverinfo() {
global $wpdb;
$sqlversion = $wpdb->get_var("SELECT VERSION() AS version");
$mysqlinfo  = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
if (is_array($mysqlinfo)) {
    $sql_mode = $mysqlinfo[0]->Value;
}
if (empty($sql_mode)) {
    $sql_mode = 'Not set';
}
$sm = ini_get('safe_mode');
if (strcasecmp('On', $sm) == 0) {
    $safe_mode = 'On';
}
else {
    $safe_mode = 'Off';
}
if (ini_get('allow_url_fopen')) {
    $allow_url_fopen = __('On','mtt');
}
else {
    $allow_url_fopen = 'Off';
}
if (ini_get('upload_max_filesize')) {
    $upload_max = ini_get('upload_max_filesize');
}
else {
    $upload_max = 'N/A';
}
if (ini_get('post_max_size')) {
    $post_max = ini_get('post_max_size');
}
else {
    $post_max = 'N/A';
}
if (ini_get('max_execution_time')) {
    $max_execute = ini_get('max_execution_time');
}
else {
    $max_execute = 'N/A';
}
if (ini_get('memory_limit')) {
    $memory_limit = ini_get('memory_limit');
}
else {
    $memory_limit = 'N/A';
}
if (function_exists('memory_get_usage')) {
    $memory_usage = round(memory_get_usage() / 1024 / 1024, 2) . ' MByte';
}
else {
    $memory_usage = __('N/A');
}
if (is_callable('exif_read_data')) {
    $exif = 'Yes' . " ( V" . substr(phpversion('exif'), 0, 4) . ")";
}
else {
    $exif = 'No';
}
if (is_callable('iptcparse')) {
    $iptc = 'Yes';
}
else {
    $iptc = 'No';
}
if (is_callable('xml_parser_create')) {
    $xml = 'Yes';
}
else {
    $xml = 'No';
}
?>
<h4><?php _e('BASIC SYSTEM INFORMATION', 'mtt'); ?></h4>
Operating System : <strong><?php echo PHP_OS; ?></strong><br/>
Server : <strong><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></strong><br/>
Memory usage : <strong><?php echo $memory_usage; ?></strong><br/>
MYSQL Version : <strong><?php echo $sqlversion; ?></strong><br/>
SQL Mode : <strong><?php echo $sql_mode; ?></strong><br/>
PHP Version : <strong><?php echo PHP_VERSION; ?></strong><br/>
PHP Safe Mode : <strong><?php echo $safe_mode; ?></strong><br/>
PHP Allow URL fopen : <strong><?php echo $allow_url_fopen; ?></strong><br/>
PHP Memory Limit : <strong><?php echo $memory_limit; ?></strong><br/>
PHP Max Upload Size : <strong><?php echo $upload_max; ?></strong><br/>
PHP Max Post Size : <strong><?php echo $post_max; ?></strong><br/>
PHP Max Script Execute Time : <strong><?php echo $max_execute; ?>s</strong><br/>
PHP Exif support : <strong><?php echo $exif; ?></strong><br/>
PHP IPTC support : <strong><?php echo $iptc; ?></strong><br/>
PHP XML support : <strong><?php echo $xml; ?></strong>  <br/>
<?php
if ($GLOBALS['table_prefix'] == 'wp_') {
    echo '<span style="color:#f00">'. __('Your table prefix should not be <strong><em>wp_</em></strong>', 'mtt') . '</span><br />';
}

if (WP_DEBUG)
    echo '<span style="color:#f00">' . __('WordPress DEBUG is turned ON.', 'mtt') . '</span>';  ?>
	