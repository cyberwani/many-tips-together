jQuery(document).ready(function ($) {


    // RESTRICT INPUT TO NUMBERS AND ENTER
    $('#widget_rss_update_timer,#loginpage_logo_height,#postpageslist_title_column_width,#postpages_post_autosave,#wprss_delay_publish_time,#media_jpg_quality,#loginpage_form_width,#loginpage_form_height,#loginpage_form_rounded,#loginpage_logo_padding').each(function () {
        $(this).keypress(function (e) {
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });
    // RESTRICT INPUT TO NUMBERS, DASH AND ENTER
    $('#postpages_post_revision,#loginpage_button_position,#loginpage_links_position').each(function () {
        $(this).keypress(function (e) {
            if (e.which != 13 && e.which != 8 && e.which != 45 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

    $(".postbox li:last-child").css({borderBottom:"none", paddingBottom:"0"});


    // COLOR BOXES
    $('#mtt-cp-1').hide();
    $('#mtt-cp-1').farbtastic("#loginpage_body_color");
    $("#loginpage_body_color").click(function () {
        jQuery('#mtt-cp-1').slideToggle('fast')
    });
    $("#loginpage_body_color").blur(function () {
        jQuery('#mtt-cp-1').slideUp()
    });

    $('#mtt-cp-101').hide();
    $('#mtt-cp-101').farbtastic("#loginpage_form_bg_color");
    $("#loginpage_form_bg_color").click(function () {
        jQuery('#mtt-cp-101').slideToggle('fast')
    });
    $("#loginpage_form_bg_color").blur(function () {
        jQuery('#mtt-cp-101').slideUp()
    });

    $('#mtt-cp-2').hide();
    $('#mtt-cp-2').farbtastic("#postpageslist_status_draft");
    $("#postpageslist_status_draft").click(function () {
        jQuery('#mtt-cp-2').slideToggle('fast')
    });
    $("#postpageslist_status_draft").blur(function () {
        jQuery('#mtt-cp-2').slideUp()
    });

    $('#mtt-cp-3').hide();
    $('#mtt-cp-3').farbtastic("#postpageslist_status_pending");
    $("#postpageslist_status_pending").click(function () {
        jQuery('#mtt-cp-3').slideToggle('fast')
    });
    $("#postpageslist_status_pending").blur(function () {
        jQuery('#mtt-cp-3').slideUp()
    });

    $('#mtt-cp-4').hide();
    $('#mtt-cp-4').farbtastic("#postpageslist_status_future");
    $("#postpageslist_status_future").click(function () {
        jQuery('#mtt-cp-4').slideToggle('fast')
    });
    $("#postpageslist_status_future").blur(function () {
        jQuery('#mtt-cp-4').slideUp()
    });

    $('#mtt-cp-5').hide();
    $('#mtt-cp-5').farbtastic("#postpageslist_status_private");
    $("#postpageslist_status_private").click(function () {
        jQuery('#mtt-cp-5').slideToggle('fast')
    });
    $("#postpageslist_status_private").blur(function () {
        jQuery('#mtt-cp-5').slideUp()
    });

    $('#mtt-cp-6').hide();
    $('#mtt-cp-6').farbtastic("#postpageslist_status_password");
    $("#postpageslist_status_password").click(function () {
        jQuery('#mtt-cp-6').slideToggle('fast')
    });
    $("#postpageslist_status_password").blur(function () {
        jQuery('#mtt-cp-6').slideUp()
    });

    $('#mtt-cp-7').hide();
    $('#mtt-cp-7').farbtastic("#postpageslist_status_others");
    $("#postpageslist_status_others").click(function () {
        jQuery('#mtt-cp-7').slideToggle('fast')
    });
    $("#postpageslist_status_others").blur(function () {
        jQuery('#mtt-cp-7').slideUp()
    });


    $('#mtt-cp-8').hide();
    $('#mtt-cp-8').farbtastic("#plugins_inactive_bg_color");
    $("#plugins_inactive_bg_color").click(function () {
        jQuery('#mtt-cp-8').slideToggle('fast')
    });
    $("#plugins_inactive_bg_color").blur(function () {
        jQuery('#mtt-cp-8').slideUp()
    });


    // LOGOUT
    if ($("#logout_redirect_enable").is(":checked")) {
        $("#laUrl").show();
    } else {
        $("#laUrl").hide();
    }
    $("#logout_redirect_enable").click(function () {
        $("#laUrl").slideToggle('fast');
    });


    // ERROR MESSAGES
    if ($("#loginpage_errors").is(":checked"))
        $("#laMsgErr").show();
    else
        $("#laMsgErr").hide();
    $("#loginpage_errors").click(function () {
        $("#laMsgErr").slideToggle('fast');
    });


    // ERASE REVISIONS
    if ($("#mttEraseRevisions").is(":checked"))
        $("#deleteRevisions").show();
    else
        $("#deleteRevisions").hide();
    $("#mttEraseRevisions").click(function () {
        $("#deleteRevisions").slideToggle('fast');
    });


    // RESET PLUGIN OPTIONS
    if ($("#mttResetOptions").is(":checked"))
        $("#resetOptions").show();
    else
        $("#resetOptions").hide();

    $("#mttResetOptions").click(function () {
        $("#resetOptions").slideToggle('fast');
    });


    // MAINTENANCE MODE
    if ($("#maintenance_mode_enable").is(":checked"))
        $(".theMaintenance").show();
    else
        $(".theMaintenance").hide();

    $("#maintenance_mode_enable").click(function () {
        $(".theMaintenance").slideToggle('fast');
    });


    // POSTS RENAME
    if ($("#posts_rename_enable").is(":checked"))
        $(".thePostRename").show();
    else
        $(".thePostRename").hide();

    $("#posts_rename_enable").click(function () {
        $(".thePostRename").slideToggle('fast');
    });


    // ADMIN NOTICES
    if ($("#admin_notice_header_allpages_enable").is(":checked"))
        $(".theNoticeRoles").show();
    else
        $(".theNoticeRoles").hide();

    $("#admin_notice_header_allpages_enable").click(function () {
        $(".theNoticeRoles").slideToggle('fast');
    });

    if ($("#admin_notice_header_settings_enable").is(":checked"))
        $(".theNoticeSettings").show();
    else
        $(".theNoticeSettings").hide();

    $("#admin_notice_header_settings_enable").click(function () {
        $(".theNoticeSettings").slideToggle('fast');
    });

    if ($("#admin_notice_footer_message_enable").is(":checked"))
        $(".theFooterMsg").show();
    else
        $(".theFooterMsg").hide();

    $("#admin_notice_footer_message_enable").click(function () {
        $(".theFooterMsg").slideToggle('fast');
    });

    $('#admin_notice_footer_hide').click(function () {
        var shortfooter = $('#admin_notice_footer_message_enable').is(':checked');
        if (shortfooter) $('#admin_notice_footer_message_enable').attr('checked', false);
        $(".theFooterMsg").hide();
    });

    $('#admin_notice_footer_message_enable').click(function () {
        var fullfooter = $('#admin_notice_footer_hide').is(':checked');
        if (fullfooter) $('#admin_notice_footer_hide').attr('checked', false);
    });


    // POSTS PAGES META BOXES
    $('#postpages_disable_mbox_author').change(function () {
        if($(this).val() !='none') {
            var fullmeta = $('#postpages_move_author_metabox').is(':checked');
            if (fullmeta) $('#postpages_move_author_metabox').attr('checked', false);
        }
    });

    $('#postpages_move_author_metabox').click(function () {
        if($(this).attr('checked')) {
            var fullmeta = $('#postpages_disable_mbox_author').val();
            if (fullmeta!='none') $('#postpages_disable_mbox_author').val('none');
        }
    });

    $('#postpages_disable_mbox_comment_status').change(function () {
        if($(this).val() !='none') {
            var fullmeta = $('#postpages_move_comments_metabox').is(':checked');
            if (fullmeta) $('#postpages_move_comments_metabox').attr('checked', false);
        }
    });

    $('#postpages_move_comments_metabox').click(function () {
        if($(this).attr('checked')) {
            var fullmeta = $('#postpages_disable_mbox_comment_status').val();
            if (fullmeta!='none') $('#postpages_disable_mbox_comment_status').val('none');
        }
    });



    // WIDGETS
    $('#widget_remove_meta').click(function () {
        var fullmeta = $('#widget_meta_enable').is(':checked');
        if (fullmeta) $('#widget_meta_enable').attr('checked', false);
        $(".theMetaWidget").hide();
    });

    $('#widget_meta_enable').click(function () {
        var shortmeta = $('#widget_remove_meta').is(':checked');
        if (shortmeta) $('#widget_remove_meta').attr('checked', false);
    });

    if ($("#widget_meta_enable").is(":checked"))
        $(".theMetaWidget").show();
    else
        $(".theMetaWidget").hide();

    $("#widget_meta_enable").click(function () {
        $(".theMetaWidget").slideToggle('fast');
    });

    if ($("#widget_meta_link1").is(":checked"))
        $('.theMetaWidgetLink1').css({ opacity:1 });
    else
        $('.theMetaWidgetLink1').css({ opacity:0.3 });

    $("#widget_meta_link1").click(function () {
        var full = $('#widget_meta_link1').is(':checked');
        if (full) $('.theMetaWidgetLink1').css({ opacity:1 });
        else $('.theMetaWidgetLink1').css({ opacity:0.3 });
    });

    if ($("#widget_meta_link2").is(":checked"))
        $('.theMetaWidgetLink2').css({ opacity:1 });
    else
        $('.theMetaWidgetLink2').css({ opacity:0.3 });

    $("#widget_meta_link2").click(function () {
        var full = $('#widget_meta_link2').is(':checked');
        if (full) $('.theMetaWidgetLink2').css({ opacity:1 });
        else $('.theMetaWidgetLink2').css({ opacity:0.3 });
    });


    // WORDPRESS BEHAVIOR
    if ($("#wprss_delay_publish_enable").is(":checked"))
        $(".theFeedDelay").show();
    else
        $(".theFeedDelay").hide();
    $("#wprss_delay_publish_enable").click(function () {
        $(".theFeedDelay").slideToggle('fast');
    });

    if ($("#wpdisable_help_texts_enable").is(":checked"))
        $(".theHelpTexts").show();
    else
        $(".theHelpTexts").hide();
    $("#wpdisable_help_texts_enable").click(function () {
        $(".theHelpTexts").slideToggle('fast');
    });

    if ($("#wpdisable_howdy_enable").is(":checked"))
        $(".theHowdyRemove").show();
    else
        $(".theHowdyRemove").hide();
    $("#wpdisable_howdy_enable").click(function () {
        $(".theHowdyRemove").slideToggle('fast');
    });


    // ENABLE DASHBOARDS
    if ($("#dashboard_mtt1_enable").is(":checked"))
        $(".theAddDash1").show();
    else
        $(".theAddDash1").hide();
    $("#dashboard_mtt1_enable").click(function () {
        $(".theAddDash1").slideToggle('fast');
    });

    if ($("#dashboard_mtt2_enable").is(":checked"))
        $(".theAddDash2").show();
    else
        $(".theAddDash2").hide();
    $("#dashboard_mtt2_enable").click(function () {
        $(".theAddDash2").slideToggle('fast');
    });

    if ($("#dashboard_mtt3_enable").is(":checked"))
        $(".theAddDash3").show();
    else
        $(".theAddDash3").hide();
    $("#dashboard_mtt3_enable").click(function () {
        $(".theAddDash3").slideToggle('fast');
    });


    // ADMIN BAR
    if ($("#adminbar_sitename_enable").is(":checked"))
        $(".theAdminBarSiteLink").show();
    else
        $(".theAdminBarSiteLink").hide();

    $("#adminbar_sitename_enable").click(function () {
        $(".theAdminBarSiteLink").slideToggle('fast');
    });

    if ($("#adminbar_custom_enable").is(":checked"))
        $(".theAdminMenu").show();
    else
        $(".theAdminMenu").hide();

    $("#adminbar_custom_enable").click(function () {
        $(".theAdminMenu").slideToggle('fast');
    });

    if ($("#wpenable_custom_gravatars_enable").is(":checked"))
        $(".theGravatar").show();
    else
        $(".theGravatar").hide();

    $("#wpenable_custom_gravatars_enable").click(function () {
        $(".theGravatar").slideToggle('fast');
    });


    // OPEN CLOSE METABOXES
    $('.hndle').click(function () {
        $(this).next('.inside').toggle();
    });

    $('.handlediv').click(function () {
        $(this).nextAll('.inside').toggle();
    });


    // START WITH ALL OPTIONS CLOSED
    if ($("#mtt_small_plugin").is(':checked')) {
        $("div.inside").css("display", "none");
    } else {
        $("div.inside").css("display", "block");
    }

    $('#mtt_small_plugin').click(function () {
        var short = $('#mtt_small_plugin').is(':checked');
        if (short) $("div.closenow").css("display", "none");
        else $("div.closenow").css("display", "block");
    });


    // HIDE HELP MESSAGES
    jQuery("#mtt_verbose_plugin").change(
        function () {
            if (jQuery("#mtt_verbose_plugin").is(':checked')) {
                jQuery(".desc").css("display", "none");
            } else {
                jQuery(".desc").css("display", "block");
            }
        }).change();


    // PROFILE PAGE
    $('#profile_social').click(function () {
        var short = $('#profile_none').is(':checked');
        if (short) $('#profile_none').attr('checked', false);
    });

    $('#profile_none').click(function () {
        var full = $('#profile_social').is(':checked');
        if (full) $('#profile_social').attr('checked', false);
    });

    $('#profile_slim').click(function () {
        var short = $('#profile_hidden').is(':checked');
        if (short) $('#profile_hidden').attr('checked', false);
    });

    $('#profile_hidden').click(function () {
        var full = $('#profile_slim').is(':checked');
        if (full) $('#profile_slim').attr('checked', false);
    });


    // DEVELOPER
    $("#dev_show_all_options").click(function () {
        $("#mtt-all-options-table").slideToggle('fast');
    });


    // DISABLE WP VERSION
    $('#wpdisable_version_full').click(function () {
        var short = $('#wpdisable_version_number').is(':checked');
        if (short) $('#wpdisable_version_number').attr('checked', false);
    });

    $('#wpdisable_version_number').click(function () {
        var full = $('#wpdisable_version_full').is(':checked');
        if (full) $('#wpdisable_version_full').attr('checked', false);
    });

});

