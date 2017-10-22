/*global jQuery:true*/
/* Jquery NoConflict */
jQuery(document).ready(function($) {

/* ---------------------------------------------------------------------- */
/*	Isotope
/* ---------------------------------------------------------------------- */
// modified Isotope methods for gutters in masonry
	$.Isotope.prototype._getMasonryGutterColumns = function() {
		/*global containerWidth:true*/
		var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
			containerWidth = this.element.width();
		this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
					// or use the size of the first item
					this.$filteredAtoms.outerWidth(true) ||
					// if there's no items, use size of container
					containerWidth;

		this.masonry.columnWidth += gutter;

		this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
		this.masonry.cols = Math.max( this.masonry.cols, 1 );
	};

	$.Isotope.prototype._masonryReset = function() {
		// layout-specific props
		this.masonry = {};
		// FIXME shouldn't have to call this again
		this._getMasonryGutterColumns();
		var i = this.masonry.cols;
		this.masonry.colYs = [];
		while (i--) {
			this.masonry.colYs.push( 0 );
		}
	};

	$.Isotope.prototype._masonryResizeChanged = function() {
		var prevSegments = this.masonry.cols;
		// update cols/rows
		this._getMasonryGutterColumns();
		// return if updated cols/rows is not equal to previous
		return ( this.masonry.cols !== prevSegments );
	};

	$(function(){

	var $container = $('.portfolio-col-2, .portfolio-col-3, .portfolio-col-4');
	
	$container.imagesLoaded( function(){
		$container.isotope({
			layoutMode: 'masonry',
			itemSelector: '.work-post-preview',
			animationEngine: 'jquery',
			animationOptions: {
				duration: 1000,
				easing: 'easeOutBack',
				queue: false
			},
			filter: '*',
			masonry: {
					gutterWidth: 20
			}
		});
	});

	// filter items when filter link is clicked
	$('.category-nav li a').click(function(){
		// select current
		var $optionSet = $(this).parents('.category-nav li a');
		$optionSet.find('.selected').removeClass('selected');
		$(this).addClass('selected');
		
		var selector = $(this).attr('data-filter');
		$container.isotope({ filter: selector });
		return false;
	});

		$(window).resize(function() {

		$container.isotope('reLayout');

	}).trigger("resize");

});

/* ---------------------------------------------------------------------- */
/*	PrettyPhoto
/* ---------------------------------------------------------------------- */

	$('.work-post-preview a[data-rel]').each(function() {
		$(this).attr('rel', $(this).data('rel'));
	});
	$(".work-post-preview a[rel^='prettyPhoto']").prettyPhoto({
		/*global ppstyles*/
		theme: ppstyles.lightbox_style,
		show_title: false,
		overlay_gallery: false,
		social_tools: false	
	});

/* ---------------------------------------------------------------------- */
/*	Navigation menu and responsivness
/* ---------------------------------------------------------------------- */

$(function(){
	$("header nav ul li").hover(function(){
		$(this).addClass("hover");
		$('ul:first',this).css('visibility', 'visible');
	}, function(){
		$(this).removeClass("hover");
		$('ul:first',this).css('visibility', 'hidden');
	});

	// Append for second level
	$("header nav ul li ul li:has(ul)").find("a:first").append(" &raquo; ");

	// Responsive select
	$("header nav ul").tinyNav({
		active: 'selected', // String: Set the "active" class
		header: 'Navigation' // String: Specify text for "header" and show header instead of the active item
	});

});

/* ---------------------------------------------------------------------- */
/*	MISC
/* ---------------------------------------------------------------------- */
	
	// Tooltip
	$('a, li[data-rel]').each(function() {
    	$(this).attr('rel', $(this).data('rel'));
	});
	$('a[rel=tooltip], li[rel=tooltip]').tooltip();
	
	// Tabs
	$('.featured-posts-tab').tabs();
	
	// Alert shortcode close
	$('.close').click(function(e) {
		e.preventDefault();
		$(this).parent().fadeOut(800, 'linear');
	});

	// FitVids
	$(document).ready(function(){
		$(".videos, .blog-post-content, .image").fitVids();
	});
	
	// Icons for image or video if present
	$('.thumb-zoom a').each(function(){
	if(this.href.match(/\.(jpe?g|png|bmp|gif|tiff?)$/i)){
		$(this).parents('li').addClass('zoom');
		} else {
			$(this).parents('li').addClass('video');
		}
	});

});