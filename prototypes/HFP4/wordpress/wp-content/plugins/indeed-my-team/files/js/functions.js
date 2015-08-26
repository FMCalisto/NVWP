function ict_preview(){
    jQuery('#preview').html('');
    jQuery("#preview").html('<div style="background:#fff;width: 100%;text-align:center;"><img src="'+window.dir_url+'files/images/loading.gif" class=""/></div>');
    var show = new Array();
      if(jQuery('#show_name').is(":checked")) show.push('name');
      if(jQuery('#show_photo').is(":checked")) show.push('photo');
      if(jQuery('#show_descript').is(":checked")) show.push('description');
      if(jQuery('#show_job').is(":checked")) show.push('job');
      if(jQuery('#show_email').is(":checked")) show.push('email');
      if(jQuery('#show_location').is(":checked")) show.push('location');
      if(jQuery('#show_tel').is(":checked")) show.push('tel');
      if(jQuery('#show_website').is(":checked")) show.push('website');
      if(jQuery('#show_social_icon').is(":checked")) show.push('social_icon');
      if(jQuery('#show_skills').is(":checked")) show.push('skills');
    var show_str = show.join(',');
    var slide_opt = new Array();
        if(jQuery('#bullets').is(":checked")) slide_opt.push('bullets');
        if(jQuery('#nav_button').is(":checked")) slide_opt.push('nav_button');
        if(jQuery('#autoplay').is(":checked")) slide_opt.push('autoplay');
        if(jQuery('#stop_hover').is(":checked")) slide_opt.push('stop_hover');
        if(jQuery('#lazy_load').is(":checked")) slide_opt.push('lazy_load');
        if(jQuery('#responsive').is(":checked")) slide_opt.push('responsive');
        if(jQuery('#autoheight').is(":checked")) slide_opt.push('autoheight');
        if(jQuery('#loop').is(":checked")) slide_opt.push('loop');
    var slide_opt_str = slide_opt.join(',');
    var value = {
        team : jQuery("#team").val(),
        order_by : jQuery("#order_by").val(),
        order : jQuery("#order").val(),
        limit : jQuery('#limit').val(),
        inside_template : jQuery('#inside_template').val(),
        theme : jQuery('#theme').val(),
        color_scheme : jQuery('#color_scheme').val(),
        show : show_str,
        columns : jQuery('#columns_num').val(),
        items_per_slide : jQuery('#items_per_slide').val(),
        slide_opt : slide_opt_str,
        slide_speed : jQuery('#speed').val(),
        slide_pagination_speed : jQuery('#pagination_speed').val(),
        pagination_theme : jQuery('#pagination_theme').val(),
		animation_in : jQuery('#animation_in').val(),
		animation_out : jQuery('#animation_out').val(),
    };
    if(jQuery('#page_inside').is(":checked")) value.page_inside = 1;
    else value.page_inside = 0;
    if(jQuery('#slider_set').is(":checked")) value.slider_set = 1;
    else value.slider_set = 0;
    if(jQuery('#filtering').is(":checked")){
        value.filter_set = 1;
        value.filter_teams = jQuery('#filter_teams').val();
        value.filter_select_t = jQuery('#filter_select_t').val();
        value.filter_align = jQuery('#filter_align').val();
    }
    else value.filter_set = 0;
    if(jQuery('#hide_small_icons').is(':checked')) value.hide_small_icons = 1;
    if(jQuery('#imt_align_center').is(':checked')) value.align_center = 1;
    
    if(typeof value.team=='object'){
    	value.team = value.team.join(','); 
    }
    
    //loading data
    jQuery.get(dir_url+"includes/imt_view.php", value, function(data) {
        jQuery("#preview").html(data);
     });
     //update shortcode
     ict_update_shortcode(value);
}
function ict_update_shortcode(value){
    // CREATE SHORTCODE
    var str = "[indeed-my-team ";
    str += "team='"+value.team+"' ";
    str += "order_by='"+value.order_by+"' ";
    str += "order='"+value.order+"' ";
    str += "limit='"+value.limit+"' ";
    str += "show='"+value.show+"' ";
    str += "page_inside='"+value.page_inside+"' ";
    str += "inside_template='"+value.inside_template+"' ";
    str += "theme='"+value.theme+"' ";
    str += "color_scheme='"+value.color_scheme+"' ";
    str += "slider_set='"+value.slider_set+"' ";
    str += "columns='"+value.columns+"' ";
	if(value.slider_set==1){
    str += "items_per_slide='"+value.items_per_slide+"' ";
    str += "slide_opt='"+value.slide_opt+"' ";
    str += "slide_speed='"+value.slide_speed+"' ";
    str += "slide_pagination_speed='"+value.slide_pagination_speed+"' ";
    str += "pagination_theme='"+value.pagination_theme+"' ";
	str += "animation_in='"+value.animation_in+"' ";
	str += "animation_out='"+value.animation_out+"' ";
	}
    if(value.filter_set==1){
    	str += "filter_set=1 ";
        str += "filter_teams='"+value.filter_teams+"' ";
        str += "filter_select_t='"+value.filter_select_t+"' ";
        str += "filter_align='"+value.filter_align+"' ";
    }
    if(value.hide_small_icons==1) str += "hide_small_icons=1 ";
    if(value.align_center==1) str += "align_center=1 ";
    str += "]";
    jQuery('.the_shortcode').html(str);
    jQuery(".php_code").html('&lt;?php echo do_shortcode("'+str+'");?&gt;');
}
//widget funcs
function make_inputh_string(divCheck, showValue, hidden_input_id){
    str = jQuery(hidden_input_id).val();
    if(str!='') show_arr = str.split(',');
    else show_arr = new Array();
    if(jQuery(divCheck).is(':checked')){
        show_arr.push(showValue);
    }else{
        var index = show_arr.indexOf(showValue);
        show_arr.splice(index, 1);
    }
    str = show_arr.join(',');
    jQuery(hidden_input_id).val(str);
}
function check_and_h(from, where) {
	if (jQuery(from).is(":checked")) {
		jQuery(where).val(1);
	} else {
		jQuery(where).val(0);
	}
}
function checkandShow(checkID, targetID, display_type){
    if(jQuery(checkID).is(':checked')){
      jQuery(targetID).css('display', display_type);
    }else jQuery(targetID).css('display', 'none');
}
function checkandModfCss(checkID, targetID, cssAttr, cssValue_true, cssValue_false){
    if(jQuery(checkID).is(':checked')){
        jQuery(targetID).css(cssAttr, cssValue_true);
        //filtering
        jQuery('#filtering_options').css('opacity', '0.5');
        jQuery('#filtering').attr('checked', false);
        jQuery('#team').removeAttr('disabled');
    }else jQuery(targetID).css(cssAttr, cssValue_false);
}
function filtering_set_unset(checkInput){
    if(jQuery(checkInput).is(':checked')){
        jQuery('#filtering_options').css('opacity', '1');
        jQuery('#slider_options').css('opacity', '0.5');
        jQuery('#slider_set').attr('checked', false);
        jQuery('#team').attr('disabled', 'disabled');
    }else{
        jQuery('#filtering_options').css('opacity', '0.5');
        jQuery('#team').removeAttr('disabled');
    }
}
function make_inputh_string(divCheck, showValue, hidden_input_id){
    str = jQuery(hidden_input_id).val();
    if(str!='') show_arr = str.split(',');
    else show_arr = new Array();
    if(jQuery(divCheck).is(':checked')){
        show_arr.push(showValue);
    }else{
        var index = show_arr.indexOf(showValue);
        show_arr.splice(index, 1);
    }
    str = show_arr.join(',');
    jQuery(hidden_input_id).val(str);
}
function changeColorScheme(id, value, where ){
    jQuery('#colors_ul li').each(function(){
        jQuery(this).attr('class', 'color_scheme_item');
    });
    jQuery(id).attr('class', 'color_scheme_item-selected');
    jQuery(where).val(value);
}
function changeColorScheme_widget(parentId, id, value, where ){
    jQuery(parentId+' li').each(function(){
        jQuery(this).attr('class', 'color_scheme_item');
    });
    jQuery(id).attr('class', 'color_scheme_item-selected');
    jQuery(where).val(value);
}
function disableOtherDD( checkInput, value,targetInput){
    if(jQuery(checkInput).val()==value) jQuery(targetInput).attr('disabled', 'disabled');
    else jQuery(targetInput).removeAttr('disabled');
}

function imt_change_post_type_name(base_path){
    jQuery.ajax({
        type : "post",
        url : base_path+'/wp-admin/admin-ajax.php',
        data : {
                   action: "imt_change_post_type",
                   post_name: jQuery('#imt_post_type_name').val()
               },
        success: function(response){
        	if(response!='') window.location = base_path+'/wp-admin/edit.php?post_type='+response+'&page=imt_general_settings';
        }
     });
}

function ict_select_team(id){
	the_value = jQuery(id).val();
	if(the_value.indexOf('all')>-1){
		jQuery(id).val('all');
	}
}