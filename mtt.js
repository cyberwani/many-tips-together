(function($){
	var farbtastic;

	mttFarbtastic = {
		init:function() {
			$(document).ready(function() {
				$('#mttCustomColor').click(function() {
					$('#mttColorPicker').show();
					return false;
				});
				$('#mtt_resetcolor').click(function(event) {
					event.preventDefault();
					$('#mttCustomColor').val('#');
					$('#mtt_color_sample').css('background-color','#FBFBFB');
					return false;
				});
				$('#mttCustomColor').keyup(function() {
					var _hex = $('#mttCustomColor').val(), hex = _hex;
					if ( hex.charAt(0) != '#' )
						hex = '#' + hex;
					hex = hex.replace(/[^#a-fA-F0-9]+/, '');
					if ( hex != _hex )
						$('#mttCustomColor').val(hex);
					if ( hex.length == 4 || hex.length == 7 )
						mttFarbtastic.pickColor( hex );
				});
				farbtastic = jQuery.farbtastic('#mttColorPicker', function(color) {
					mttFarbtastic.pickColor(color);
				});
				mttFarbtastic.pickColor($('#mttCustomColor').val());
				$(document).mousedown(function(){
					$('#mttColorPicker').each(function(){
						var display = $(this).css('display');
						if ( display == 'block' )
							$(this).fadeOut(2);
					});
				});
			});
		},

		pickColor:function(color) {
			farbtastic.setColor(color);
			$('#mttCustomColor').val(color);
			$('#mtt_color_sample').css('background-color',color);
		}

	};

})(jQuery);
jQuery(document).ready( function($) {
	mttFarbtastic.init();
    //Hide div w/id extra
   	if ($("#mttLogOut").is(":checked")) {
        //show the hidden div
        $("#laUrl").show();
    } else {      
        //otherwise, hide it 
        $("#laUrl").hide();
    }	
    // Add onclick handler to checkbox w/id checkme
	// http://cl.ly/383F0W1D04413l0Q1C43
	$("#mttLogOut").click(function() {
		$("#laUrl").slideToggle();
	});
   

   	if ($("#mttLoginError").is(":checked")) 
        $("#laMsgErr").show();
    else      
        $("#laMsgErr").hide();	
	$("#mttLoginError").click(function() {
		$("#laMsgErr").slideToggle();
	});


   	if ($("#mttEraseRevisions").is(":checked")) 
        $("#deleteRevisions").show();
    else      
        $("#deleteRevisions").hide();	
	$("#mttEraseRevisions").click(function() {
		$("#deleteRevisions").slideToggle();
	});


   	if ($("#mttResetOptions").is(":checked")) 
        $("#resetOptions").show();
    else      
        $("#resetOptions").hide();
	
	$("#mttResetOptions").click(function() {
		$("#resetOptions").slideToggle();
	});

   	if ($("#mttMaintenance").is(":checked")) 
        $(".theMaintenance").show();
    else
        $(".theMaintenance").hide();
	
	$("#mttMaintenance").click(function() {
		$(".theMaintenance").slideToggle();
	});
	
   	if ($("#mttAddDash1").is(":checked")) 
        $(".theAddDash1").show();
    else
        $(".theAddDash1").hide();	
	$("#mttAddDash1").click(function() {
		$(".theAddDash1").slideToggle();
	});
	
   	if ($("#mttAddDash2").is(":checked")) 
        $(".theAddDash2").show();
    else
        $(".theAddDash2").hide();	
	$("#mttAddDash2").click(function() {
		$(".theAddDash2").slideToggle();
	});
	
   	if ($("#mttAddDash3").is(":checked")) 
        $(".theAddDash3").show();
    else
        $(".theAddDash3").hide();	
	$("#mttAddDash3").click(function() {
		$(".theAddDash3").slideToggle();
	});
	
	$('.hndle').click(function(){
	    $(this).next('.inside').toggle();
	    });
	
	$('.handlediv').click(function(){
	    $(this).nextAll('.inside').toggle();
	    });

	if ($("#mttSmall").is(':checked')) {
		$("div.inside").css("display","none");
	} else {
		$("div.inside").css("display","block");
	}

	$('#mttSmall').click(function (){
		var short = $('#mttSmall').is(':checked');
		if(short) $("div.closenow").css("display","none");
		else $("div.closenow").css("display","block");
	});

	jQuery("#mttVerbose").change(function() {
		if (jQuery("#mttVerbose").is(':checked')) {
			jQuery("p.desc").css("display","none");
		} else {
			jQuery("p.desc").css("display","block");
		}
	}).change();
	
	
	$('#mttContatoSocial').click(function (){
		var short = $('#mttContatoNenhum').is(':checked');
		if (short) $('#mttContatoNenhum').attr('checked', false);
	});
	
	$('#mttContatoNenhum').click(function (){
		var full = $('#mttContatoSocial').is(':checked');
		if (full) $('#mttContatoSocial').attr('checked', false);
	});
	
	$('#mttVersionFull').click(function (){
		var short = $('#mttVersionNumber').is(':checked');
		if (short) $('#mttVersionNumber').attr('checked', false);
	});
	
	$('#mttVersionNumber').click(function (){
		var full = $('#mttVersionFull').is(':checked');
		if (full) $('#mttVersionFull').attr('checked', false);
	});
	
	$('#mttContatoSlim').click(function (){
		var short = $('#mttContatoHidden').is(':checked');
		if (short) $('#mttContatoHidden').attr('checked', false);
	});
	
	$('#mttContatoHidden').click(function (){
		var full = $('#mttContatoSlim').is(':checked');
		if (full) $('#mttContatoSlim').attr('checked', false);
	});
	
});

