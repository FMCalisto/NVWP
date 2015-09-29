jQuery(document).ready(function($) {

	$('.wplikebtns').buttonset();

	$(document).on('change', '#nm-general-news-nav-menu-yes, #nm-general-news-nav-menu-no', function() {
		if($(this).val() === 'yes') {
			$('#nm_news_nav_menu_opt').fadeIn(300);
		} else {
			$('#nm_news_nav_menu_opt').fadeOut(300);
		}
	});

	$(document).on('change', '#nm-general-use-tags-yes, #nm-general-use-tags-no', function() {
		if($(this).val() === 'yes') {
			$('#nm_general_use_tags_opt').fadeIn(300);
		} else {
			$('#nm_general_use_tags_opt').fadeOut(300);
		}
	});

	$(document).on('change', '#nm-general-use-categories-yes, #nm-general-use-categories-no', function() {
		if($(this).val() === 'yes') {
			$('#nm_general_use_categories_opt').fadeIn(300);
		} else {
			$('#nm_general_use_categories_opt').fadeOut(300);
		}
	});

	$(document).on('change', '#nm-permalinks-single-news-prefix-yes, #nm-permalinks-single-news-prefix-no', function() {
		if($(this).val() === 'yes') {
			$('#nm_permalinks_single_news_prefix_opt').fadeIn(300);
		} else {
			$('#nm_permalinks_single_news_prefix_opt').fadeOut(300);
		}
	});

	$(document).on('change', '#nm-permalinks-single-news-prefix-type-category, #nm-permalinks-single-news-prefix-type-tag', function() {
		if($(this).val() === 'category') {
			$('#nm_permalinks_single_news_prefix_code').html(nmArgs.categoriesRewriteURL);
		} else {
			$('#nm_permalinks_single_news_prefix_code').html(nmArgs.tagsRewriteURL);
		}
	});

	$(document).on('change', '#nm-general-use-tags-yes, #nm-general-use-tags-no, #nm-general-use-categories-yes, #nm-general-use-categories-no, #nm-general-use-dedicated-tags, #nm-general-use-builtin-tags, #nm-general-use-dedicated-categories, #nm-general-use-builtin-categories', function() {
		if(($('#nm-general-use-tags-no').prop('checked') === true && $('#nm-general-use-categories-no').prop('checked') === true) || ($('#nm-general-use-tags-yes').prop('checked') === true && $('#nm-general-use-dedicated-tags').prop('checked') === true && $('#nm-general-use-categories-no').prop('checked') === true) || ($('#nm-general-use-tags-no').prop('checked') === true && $('#nm-general-use-categories-yes').prop('checked') === true && $('#nm-general-use-dedicated-categories').prop('checked') === true) || ($('#nm-general-use-tags-yes').prop('checked') === true && $('#nm-general-use-categories-yes').prop('checked') === true && $('#nm-general-use-dedicated-tags').prop('checked') === true && $('#nm-general-use-dedicated-categories').prop('checked') === true)) {
			$('#nm-general-display-news-in-tags-and-categories-yes').button('disable');
			$('#nm-general-display-news-in-tags-and-categories-no').button('disable');
		} else {
			$('#nm-general-display-news-in-tags-and-categories-yes').button('enable');
			$('#nm-general-display-news-in-tags-and-categories-no').button('enable');
		}
	});

	$(document).on('click', 'input#reset_nm_general, input#reset_nm_capabilities, input#reset_nm_permalinks', function() {
		return confirm(nmArgs.resetToDefaults);
	});
});