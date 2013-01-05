
function toggle_help(how)
{
    if('none' == how)
        jQuery(".desc-field").fadeOut();
    else
        jQuery(".desc-field").fadeIn('slow');
//            jQuery(".desc-field").css("display", how);
}
function close_update_msg()
{
    window.setTimeout(function(){
        jQuery("#alert_bar").slideUp("slow")
    },7500
    );

}
jQuery(document).ready(function ($) 
{
    // Change text of "Help" tab
    $('#contextual-help-link').text('More info');
    
    // "Help" tab is hidden by CSS, animate appearance 
    // slideUp is from an internal element, double fx
    $('#screen-meta-links').delay(500).fadeIn(1500);
    $('#contextual-help-link-wrap').slideUp().delay(500).slideDown(500);

    $("#mtt_verbose_plugin_helper").change(function () {
        if ($(this).is(':checked')) {
            toggle_help('none');
        } else {
            toggle_help('block');
        }
        $('input[name="mtt_verbose_plugin[]"]').trigger('click');
    });
      
    // SUBMIT FORM
    $('#mtt-submit').click(function()  {
        document.mttform.submit();
        return false;
    });
    
    // GOTO BRASOFILO ;)
    $("#bsf-link").click(function () {
        window.open('http://brasofilo.com');
        return false;
    });
    
    // HIDE HELP MESSAGES
    if ($('input[name="mtt_verbose_plugin[]"]').is(':checked')) {
        toggle_help('none');
        $('#mtt_verbose_plugin_helper').attr('checked', true);
    } else {
        toggle_help('block');
        $('#mtt_verbose_plugin_helper').attr('checked', false);
    }
         
    // PLUGIN INFO
    $("#open-tb").click(function() {                 
        tb_show(mtt.title, mtt.network+"plugin-install.php?tab=plugin-information&plugin=many-tips-together&section=changelog&TB_iframe=true");
        return false;
    });
       
});