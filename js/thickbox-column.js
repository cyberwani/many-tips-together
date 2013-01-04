jQuery(document).ready( function($) {
        $('.filename.new').each(function(i,e){
                var filename = $(this).next('.slidetoggle').find('thead').find('span[id^="media-dims-"]').clone().appendTo(this);
                filename.css('float','right').css('margin-right','100px');
        });
});