jQuery(document).ready(function() {

	jQuery(window).resize(
		function(){
			if(!jQuery('body').hasClass('cherry-fixed-layout')) {
				jQuery('.full-width-block').width(jQuery(window).width());
				jQuery('.full-width-block').css({width: jQuery(window).width(), "margin-left": (jQuery(window).width()/2)*-1, left: "50%"});
			};
		}
	).trigger('resize');

	var resizeScrollFunc = function(e) {
		var windowHeight = jQuery(window).height();
		var windowTopOffset = jQuery(window).scrollTop();

		if ((windowHeight > 600) && (windowTopOffset < 50)) {
			var adminPanelHeight = jQuery('#wpadminbar').innerHeight();
			jQuery('.parallax-slider').css({'height': windowHeight-adminPanelHeight});
		}
	}
	jQuery(window).scroll(resizeScrollFunc).resize(resizeScrollFunc);

	jQuery('.single-post .title-section .breadcrumb, .single-portfolio .title-section .breadcrumb').find('li:last-child').prev('.divider').addClass('hidden');

	var i = 1;
	jQuery('#commentform p.field').each(function(){
		jQuery(this).addClass('item-'+i);
		i++;
	})

	var j = 1;
	jQuery('.circle-container').each(function(){
		if(!jQuery(this).hasClass('count')) {
			jQuery(this).parent().addClass('circle-count-wrap').addClass('item-'+j);
			j++;
		}
	})
})