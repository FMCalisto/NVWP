<?php
if(!isset($attr)){
///////////////PREVIEW
    $current_path = $_SERVER['SCRIPT_FILENAME'];
    $dir_arr = explode( 'wp-content', $current_path );
    $dir = $dir_arr[0];
    require_once( $dir . '/wp-load.php' );
    $attr = $_REQUEST;
}

    $show_arr = explode(',', $attr['show']);

    switch($attr['order_by']){
    	case 'name':
    		$orderby = 'title';
    	break;
    	case 'date':
    		$orderby = 'date';
    	break;
    	case 'rand':
    		$orderby = 'rand';
    	break;
    	case 'last_name':
    		$orderby = 'name';
    		$last_name = true;
    	break;    	
    }

    if($attr['limit']==0) $limit = -1;
    else $limit = $attr['limit'];

    $args = array(
    	'posts_per_page'   => $limit,
    	'orderby'          => $orderby,
    	'order'            => $attr['order'],
    	'post_type'        => IMT_POST_TYPE,
    	'post_status'      => 'publish',
        );

    if(isset($attr['filter_teams'])){
        $terms_arr = explode(',', $attr['filter_teams']);
        $args['tax_query'] = array(
                                            array(
                           			            'taxonomy' => IMT_TAXONOMY,
                                                'field' => 'slug',
                                                'terms' => $terms_arr
                                        )
                                    );
    }
    elseif($attr['team']=='all' || $attr['team'][0]=='all'){
    	$args['tax_query'] = array();
    }
    else {
    	if(strpos($attr['team'], ',')!==FALSE){
    		$attr['team'] = explode(',', $attr['team']);
    	}
    	$args['tax_query'] = array(

                                    array(
                   			            'taxonomy' => IMT_TAXONOMY,
                                        'field' => 'slug',
                                        'terms' => $attr['team']
                                )
                            );
    }

    $the_posts = get_posts($args);

    #reorder by last name
    if(isset($last_name) && $last_name==true) $the_posts = imt_reorder_by_last_name($the_posts, $attr['order']);

    //final_str will contain the output
    $final_str = "";

    
if(count($the_posts)>0){

    if($attr['slider_set']==1){
        $parent_class = 'carousel_view';
    }else    $parent_class = 'ict_content_cl';

    $num = rand(1, 10000);
    $div_parent_id = 'indeed_carousel_view_widget_' . $num;
    $arrow_wrapp_id = 'wrapp_arrows_widget_' . $num;
    $ul_id = 'indeed_ul_' . $num;

    $theme_file = IMT_DIR_PATH .'themes/'. $attr['theme'] . "/index.php";
    if( file_exists( $theme_file ) ) include $theme_file;
    else die();
    
    $final_str .= '<link rel="stylesheet" href="'.IMT_DIR_URL .'themes/'.$attr['theme'].'/style.css" type="text/css" media="all">';
    if(isset($attr['color_scheme']) && $attr['color_scheme']!=''){
    	$final_str .= '<link rel="stylesheet" href="'. IMT_DIR_URL . 'layouts/style_' . $attr['color_scheme'] . '.css" type="text/css" media="all">';
    	$color_class = 'style_' . $attr['color_scheme'];
    }else $color_class = '';    
    
    //RESPONSIVE
    $responsive_css = '';
    $general_settings_data = imt_general_settings_meta();
    if(isset($general_settings_data['imt_responsive_settings_small']) &&  $general_settings_data['imt_responsive_settings_small']!='auto'){
    	$li_w = 100 / $general_settings_data['imt_responsive_settings_small'];
    	$responsive_css .= '
    						@media only screen and (max-width: 479px) {
    							#'.$div_parent_id.' ul li{
    								width: calc('.$li_w.'% - 1px) !important;
    							}
    						}
    					';
    }
    if(isset($general_settings_data['imt_responsive_settings_medium']) && $general_settings_data['imt_responsive_settings_medium']!='auto'){
    	$li_w = 100 / $general_settings_data['imt_responsive_settings_medium'];
    	$responsive_css .= '
    						@media only screen and (min-width: 480px) and (max-width: 767px){
    							#'.$div_parent_id.' ul li{
    								width: calc('.$li_w.'% - 1px) !important;
    							}
    						}
    					';
    }
    if(isset($general_settings_data['imt_responsive_settings_large']) && $general_settings_data['imt_responsive_settings_large']!='auto'){
    	$li_w = 100 / $general_settings_data['imt_responsive_settings_large'];
    	$responsive_css .= '
    						@media only screen and (min-width: 768px) and (max-width: 959px){
    							#'.$div_parent_id.' ul li{
    								width: calc('.$li_w.'% - 1px) !important;
    							}
    						}
    					';
    }
    $css = '';
    if(isset($attr['hide_small_icons']) && $attr['hide_small_icons']==1){
    	$css .= '#'.$div_parent_id.' [class^="glyphicont-"], #'.$div_parent_id.' [class^="icont-"]{display: none !important;}';
    }
    if(isset($attr['align_center']) && $attr['align_center']==1) $css .= '#'.$div_parent_id.' ul{text-align: center;}'; # ALIGN CENTER
    //CUSTOM CSS
    if(isset($general_settings_data['imt_custom_css']) && $general_settings_data['imt_custom_css']!=''){
    	$css .= $general_settings_data['imt_custom_css'];
    }    
    if($responsive_css!='' || $css!='') $final_str .= '<style>' . $responsive_css . $css . '</style>';
	
	if(isset($attr['color_scheme']) && $attr['color_scheme']!=''){
  		$final_str .= '<style>
					 .style_'.$attr['color_scheme'].' .owl-theme .owl-dots .owl-dot.active span, .style_'.$attr['color_scheme'].'  .owl-theme .owl-dots .owl-dot:hover span { background: #'.$attr['color_scheme'].' !important; }
					 .style_'.$attr['color_scheme'].' .pag-theme1 .owl-theme .owl-nav [class*="owl-"]:hover{ background-color: #'.$attr['color_scheme'].'; }
					 .style_'.$attr['color_scheme'].' .pag-theme2 .owl-theme .owl-nav [class*="owl-"]:hover{ color: #'.$attr['color_scheme'].'; }
					 .style_'.$attr['color_scheme'].' .pag-theme3 .owl-theme .owl-nav [class*="owl-"]:hover{ background-color: #'.$attr['color_scheme'].';}';
  		$final_str .= '</style>'; 	
  	}
	
    $final_str .= "<div class='$color_class'>";
    $final_str .= "<div class='{$attr['theme']} {$attr['pagination_theme']}'>";
    $final_str .= "<div class='ict_wrapp'>";
    $final_str .= "<div class='$parent_class' id='$div_parent_id' >";

    $default_item = $list_item_template;

    $social_media_string = '';
    $default_details_arr = $details_arr;

    $li_width = 100 / $attr['columns'];
    $li_width = 'calc('.$li_width.'% - 1px)';
    $j = 1;
    $breaker_div = 1;
    $new_div = 1;
    $total_items = count($the_posts);
    
	if($attr['slider_set']==1) $items_per_slide = $attr['items_per_slide'];
    else $items_per_slide = $total_items;
    


if(isset($attr['filter_set']) && $attr['filter_set']==1){

  /////////////////////////////////////FILTER\\\\\\\\\\\\\\\\\\\\
  
  $filter_rand_num = rand(1,5000);
  if(isset($attr['color_scheme']) && $attr['color_scheme']!=''){
  	//// additional STYLE
  	$final_str .= '<style>
  		/*
	  	.teamContainer li{
		  	webkit-transition-duration: 0.8s;
		  	-moz-transition-duration: 0.8s;
		  	transition-duration: 0.8s;
	  	}
	  	*/
	  	.teamFilter_'.$filter_rand_num.' .teamFilterlink-small_text:hover{
	  		color: #'.$attr['color_scheme'].';
	  	}
	  	.teamFilter-wrapper-small_text  .teamFilter_'.$filter_rand_num.' .current{
	  		color: #'.$attr['color_scheme'].';
	  	}
	  	.teamFilter_'.$filter_rand_num.' .teamFilterlink-big_text:hover{
	  		color: #'.$attr['color_scheme'].';
	  	}
	  	.teamFilter-wrapper-big_text  .teamFilter_'.$filter_rand_num.' .current{
	  		color: #'.$attr['color_scheme'].';
	  	}
	  	.teamFilter_'.$filter_rand_num.' .teamFilterlink-small_button:hover{
	  		background-color:#'.$attr['color_scheme'].';
	  		color:#fff;
	  	}
	  	.teamFilter-wrapper-small_button  .teamFilter_'.$filter_rand_num.' .current{
	  		background-color:#'.$attr['color_scheme'].';
	  		color:#fff;
	  	}
	  	.teamFilter_'.$filter_rand_num.' .teamFilterlink-big_button:hover{
	  		background-color:#'.$attr['color_scheme'].';
	  		border-color:#'.$attr['color_scheme'].';
	  		color:#fff;
	  	}
	  	.teamFilter-wrapper-big_button .teamFilter_'.$filter_rand_num.'  .current{
	  		background-color:#'.$attr['color_scheme'].';
	  		border-color:#'.$attr['color_scheme'].';
	  		color:#fff;
	  	}
	  		
	  	.teamFilter_'.$filter_rand_num.' .teamFilterlink-dropdown:hover{
	  		border-color:#'.$attr['color_scheme'].';
	  	}
  	</style>
  	';  	
  }

  //// additional JS
  $final_str .= "<script>

					jQuery(window).load(function(){
						var container = jQuery('.indeed_team_filter_".$filter_rand_num."');
						container.isotope({
							filter: '*',
							layoutMode: 'masonry',
							transitionDuration: '1s',
						});
  				";
  if($attr['filter_select_t']=='dropdown'){
  	$final_str .= "

                        jQuery('.teamFilterlink-select_".$filter_rand_num."').change(function(){
							var selector = jQuery('.teamFilterlink-select_".$filter_rand_num."').val();
							container.isotope({
								filter: selector,
								layoutMode: 'masonry',
								transitionDuration: '1s',
							 });
							 return false;
                        });
                   ";
  }else{
  	$final_str .= "
  						jQuery('.teamFilter_".$filter_rand_num." div').click(function(){
  							jQuery('.teamFilter_".$filter_rand_num." .current').removeClass('current');
  							jQuery(this).addClass('current');
  	
  							var selector = jQuery(this).attr('data-filter');
  							container.isotope({
  									filter: selector,
  									layoutMode: 'masonry',
  									transitionDuration: '1s',
  							});
  							return false;
  						});
  					";  	
  }
  	$final_str .= "
					});
					</script>";
	
  //// FILTER

  $attr['slider_set'] = 0;//secure slider at 0
  $final_str .= '<div class="teamFilter-wrapper teamFilter-wrapper-'.$attr['filter_select_t'].'" style="text-align:'.$attr['filter_align'].';">';
    $final_str .= '<div class="teamFilter_'.$filter_rand_num.'">';

    if(isset($terms_arr) && count($terms_arr)>0){
            if($attr['filter_select_t']=='dropdown'){
                //DROPDOWN
                    $final_str .= '<div class="teamFilterlink-'.$attr['filter_select_t'].'">';
                    $final_str .= '<select class="teamFilterlink-select_'.$filter_rand_num.'">';
                    $final_str .= '<option  value="*">'.__('All', 'imt').'</option>';
                    foreach($terms_arr as $term){
                        $team_name = get_term_by('slug', $term, IMT_TAXONOMY);
                        $final_str .= '<option value=".'.$term.'">'. $team_name->name .'</option>';
                    }
                    $final_str .= '</select>';
                    $final_str .= '</div>';
            }else{
                //SMALL text,button BIG text,buttons

                    $final_str .= '<div class="teamFilterlink teamFilterlink-'.$attr['filter_select_t'].'" data-filter="*">All</div>';
                    foreach($terms_arr as $term){
                        $team_name = get_term_by('slug', $term, IMT_TAXONOMY);
                        $final_str .= '<div class="teamFilterlink-'.$attr['filter_select_t'].'" data-filter=".'.$term.'">'. $team_name->name .'</div>';
                    }
                    $final_str .= '</div>';
            }
    }



  $final_str .= '</div>';
	/// LIST
    $final_str .= "<ul class='teamContainer indeed_team_filter_".$filter_rand_num."'>";
    foreach($the_posts as $post){
        $team_terms_arr = get_the_terms( $post->ID, IMT_TAXONOMY );
        $team_slug_str = '';
        foreach($team_terms_arr as $term_arr){
        	if($team_slug_str!='') $team_slug_str .= ' ';
            $team_slug_str .= $term_arr->slug;
        }
        $final_str .= "<li style='width: $li_width' class='$team_slug_str' data-category='$team_slug_str'>";
        ////NAME
        if(in_array('name', $show_arr)){
            $name = get_the_title($post->ID);
            $list_item_template = str_replace("ICT_NAME", $name, $list_item_template);
        }else $list_item_template = str_replace("ICT_NAME", "", $list_item_template);

        ////PHOTO
        if(in_array('photo', $show_arr)){
            $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
            $list_item_template = str_replace("ICT_IMAGE", $src[0],$list_item_template);
        }else $list_item_template = str_replace("ICT_IMAGE", "", $list_item_template);

        ////LINKS
        if( $attr['page_inside']==1 ){
            $link = get_permalink( $post->ID );
            if($attr['inside_template']!="default"){
                $u_template = urlencode( $attr['inside_template'] );
                $link = add_query_arg( array('team_cpt' => $u_template ), $link );
            }
            $list_item_template = str_replace("#POST_LINK#", ' href="'.$link.'" ', $list_item_template);
        }else $list_item_template = str_replace("#POST_LINK#", "", $list_item_template);

        ////DESCRIPTION
        if(in_array('description', $show_arr)){
            $description = $post->post_content;
            $list_item_template = str_replace("ICT_DESCRIPTION", $description, $list_item_template);
        }else $list_item_template = str_replace("ICT_DESCRIPTION", "", $list_item_template);

        ////JOB
        if(in_array('job', $show_arr)){
            $job = get_post_meta( $post->ID, 'in_team_jobtitle', true );
            $list_item_template = str_replace("ICT_JOB", $job, $list_item_template);
        }else $list_item_template = str_replace("ICT_JOB", "", $list_item_template);

        ///EMAIL
        if(in_array('email', $show_arr)){
            $email = get_post_meta( $post->ID, 'in_team_email', true );
            if(!empty($email)) $the_email = str_replace("#EMAIL#", $email, $details_arr['in_team_email']);
            else $the_email = "";
            $list_item_template = str_replace("ICT_EMAIL", $the_email, $list_item_template);
        }$list_item_template = str_replace("ICT_EMAIL", "", $list_item_template);

        ///LOCATION
        if(in_array('location', $show_arr)){
            $location = get_post_meta( $post->ID, 'in_team_location', true );
            if(!empty($location)) $the_location = str_replace("#LOCATION#", $location, $details_arr['in_team_location']);
            else $the_location = "";
            $list_item_template = str_replace("ICT_LOCATION", $the_location, $list_item_template);
        }$list_item_template = str_replace("ICT_LOCATION", "", $list_item_template);

        ////TELEPHONE
        if(in_array('tel', $show_arr)){
            $telephone = get_post_meta( $post->ID, 'in_team_telephone', true );
            if(!empty($telephone)) $phone = str_replace("#PHONE#", $telephone, $details_arr['in_team_telephone']);
            else $phone = "";
            $list_item_template = str_replace("ICT_PHONE", $phone, $list_item_template);
        }else $list_item_template = str_replace("ICT_PHONE", "", $list_item_template);

        ////WEBSITE
        if(in_array('website', $show_arr)){
            $website = get_post_meta( $post->ID, 'in_team_website', true );
			$website = str_replace("http://","",$website);
			$website = str_replace("https://","",$website);
            if(!empty($website)) $the_website = str_replace("#WEBSITE#", $website, $details_arr['in_team_website']);
            else $the_website = "";
            $list_item_template = str_replace("ICT_WEBSITE", $the_website, $list_item_template);
        }else $list_item_template = str_replace("ICT_WEBSITE", "", $list_item_template);

        ////SKILLS
        if(in_array('skills', $show_arr)){
            $skill_str = "";
            $skill_arr = array();
            $percent = array();
            for($i=0;$i<4;$i++){
                $skill_arr[] = get_post_meta($post->ID, 'indeed_team_skill_'.$i, true);
                $percent[] = get_post_meta($post->ID, 'indeed_skill_percent_'.$i, true);
            }
            foreach($skill_arr as $k=>$skill){
                if(!empty($skill)) $skill_str .= "<div class=\"skill-label\">$skill</div><div class=\"skill-prog\"><div class=\"fill\" data-progress-animation=\"{$percent[$k]}%\"data-appear-animation-delay=\"400\" style=\"width:{$percent[$k]}%;\"></div></div>";
            }
            $list_item_template = str_replace("ICT_SKILLS", $skill_str, $list_item_template);
        }else $list_item_template = str_replace("ICT_SKILLS", "", $list_item_template);

        //social media

		$social_media_string = '';
		if( in_array('social_icon', $show_arr) ){
            $facebook = get_post_meta( $post->ID, 'indeed_fb_lnk', true );
            if( ! empty( $facebook ) ) {   $social_media_string .= str_replace("FB", $facebook, $socials_arr['in_team_fb']); }
			$twitter = get_post_meta( $post->ID, 'indeed_tw_lnk', true );
            if( ! empty( $twitter ) ) {   $social_media_string .= str_replace("TW", $twitter, $socials_arr['in_team_tw']); }
            $linkedin = get_post_meta( $post->ID, 'indeed_ld_lnk', true );
            if( ! empty( $linkedin ) ) {   $social_media_string .= str_replace("LIN", $linkedin, $socials_arr['in_team_lin']); }
            $google_plus = get_post_meta( $post->ID, 'indeed_gp_lnk', true );
            if( ! empty( $google_plus ) ) {   $social_media_string .= str_replace("GP", $google_plus, $socials_arr['in_team_gp']); }
            $instagram = get_post_meta( $post->ID, 'indeed_ins_lnk', true );
            if( ! empty( $instagram ) ) {   $social_media_string .= str_replace("INS", $instagram, $socials_arr['in_team_ins']); }
		}
		$list_item_template = str_replace("ICT_SOCIAL_MEDIA", $social_media_string, $list_item_template);

        $final_str .= $list_item_template;
        $final_str .= "</li>";

        $list_item_template = $default_item;
        $details_arr = $default_details_arr;
    }
    $final_str .= "<div class='clear'></div></ul>";
	
	
}else{
  ////WITHOUT FILTER

    foreach($the_posts as $post){

        if($new_div==1){
            $div_id = $ul_id.'_' . $breaker_div;
            $final_str .= "<ul id='$div_id' class=''>"; /////ADDING THE UL
        }
            $final_str .= "<li style='width: $li_width'>";

        ////NAME
        if(in_array('name', $show_arr)){
            $name = get_the_title($post->ID);
            $list_item_template = str_replace("ICT_NAME", $name, $list_item_template);
        }else $list_item_template = str_replace("ICT_NAME", "", $list_item_template);

        ////PHOTO
        if(in_array('photo', $show_arr)){
            $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
            $list_item_template = str_replace("ICT_IMAGE", $src[0],$list_item_template);
        }else $list_item_template = str_replace("ICT_IMAGE", "", $list_item_template);
        
        ////LINKS
        if( $attr['page_inside']==1 ){
        	$link = get_permalink( $post->ID );
        	if($attr['inside_template']!="default"){
        		$u_template = urlencode( $attr['inside_template'] );
        		$link = add_query_arg( array('team_cpt' => $u_template ), $link );
        	}
        	$list_item_template = str_replace("#POST_LINK#", ' href="'.$link.'" ', $list_item_template);
        }else $list_item_template = str_replace("#POST_LINK#", "", $list_item_template);
        
        ////DESCRIPTION
        if(in_array('description', $show_arr)){
        	$description = $post->post_content;
        	$list_item_template = str_replace("ICT_DESCRIPTION", $description, $list_item_template);
        }else $list_item_template = str_replace("ICT_DESCRIPTION", "", $list_item_template);
        
        ////JOB
        if(in_array('job', $show_arr)){
        	$job = get_post_meta( $post->ID, 'in_team_jobtitle', true );
        	$list_item_template = str_replace("ICT_JOB", $job, $list_item_template);
        }else $list_item_template = str_replace("ICT_JOB", "", $list_item_template);
        
        ///EMAIL
        if(in_array('email', $show_arr)){
        	$email = get_post_meta( $post->ID, 'in_team_email', true );
        	if(!empty($email)) $the_email = str_replace("#EMAIL#", $email, $details_arr['in_team_email']);
        	else $the_email = "";
        	$list_item_template = str_replace("ICT_EMAIL", $the_email, $list_item_template);
        }$list_item_template = str_replace("ICT_EMAIL", "", $list_item_template);
        
        ///LOCATION
        if(in_array('location', $show_arr)){
        	$location = get_post_meta( $post->ID, 'in_team_location', true );
        	if(!empty($location)) $the_location = str_replace("#LOCATION#", $location, $details_arr['in_team_location']);
        	else $the_location = "";
        	$list_item_template = str_replace("ICT_LOCATION", $the_location, $list_item_template);
        }$list_item_template = str_replace("ICT_LOCATION", "", $list_item_template);
        
        ////TELEPHONE
        if(in_array('tel', $show_arr)){
        	$telephone = get_post_meta( $post->ID, 'in_team_telephone', true );
        	if(!empty($telephone)) $phone = str_replace("#PHONE#", $telephone, $details_arr['in_team_telephone']);
        	else $phone = "";
        	$list_item_template = str_replace("ICT_PHONE", $phone, $list_item_template);
        }else $list_item_template = str_replace("ICT_PHONE", "", $list_item_template);
        
        ////WEBSITE
        if(in_array('website', $show_arr)){
        	$website = get_post_meta( $post->ID, 'in_team_website', true );
        	$website = str_replace("http://","",$website);
        	$website = str_replace("https://","",$website);
        	if(!empty($website)) $the_website = str_replace("#WEBSITE#", $website, $details_arr['in_team_website']);
        	else $the_website = "";
        	$list_item_template = str_replace("ICT_WEBSITE", $the_website, $list_item_template);
        }else $list_item_template = str_replace("ICT_WEBSITE", "", $list_item_template);
        
        ////SKILLS
        if(in_array('skills', $show_arr)){
        	$skill_str = "";
        	$skill_arr = array();
        	$percent = array();
        	for($i=0;$i<4;$i++){
        		$skill_arr[] = get_post_meta($post->ID, 'indeed_team_skill_'.$i, true);
        		$percent[] = get_post_meta($post->ID, 'indeed_skill_percent_'.$i, true);
        	}
        	foreach($skill_arr as $k=>$skill){
        		if(!empty($skill)) $skill_str .= "<div class=\"skill-label\">$skill</div><div class=\"skill-prog\"><div class=\"fill\" data-progress-animation=\"{$percent[$k]}%\"data-appear-animation-delay=\"400\" style=\"width:{$percent[$k]}%;\"></div></div>";
        	}
        	$list_item_template = str_replace("ICT_SKILLS", $skill_str, $list_item_template);
        }else $list_item_template = str_replace("ICT_SKILLS", "", $list_item_template);
        
        //social media
        
        $social_media_string = '';
        if( in_array('social_icon', $show_arr) ){
        	$facebook = get_post_meta( $post->ID, 'indeed_fb_lnk', true );
        	if( ! empty( $facebook ) ) {
        		$social_media_string .= str_replace("FB", $facebook, $socials_arr['in_team_fb']);
        	}
        	$twitter = get_post_meta( $post->ID, 'indeed_tw_lnk', true );
        	if( ! empty( $twitter ) ) {
        		$social_media_string .= str_replace("TW", $twitter, $socials_arr['in_team_tw']);
        	}
        	$linkedin = get_post_meta( $post->ID, 'indeed_ld_lnk', true );
        	if( ! empty( $linkedin ) ) {
        		$social_media_string .= str_replace("LIN", $linkedin, $socials_arr['in_team_lin']);
        	}
        	$google_plus = get_post_meta( $post->ID, 'indeed_gp_lnk', true );
        	if( ! empty( $google_plus ) ) {
        		$social_media_string .= str_replace("GP", $google_plus, $socials_arr['in_team_gp']);
        	}
        	$instagram = get_post_meta( $post->ID, 'indeed_ins_lnk', true );
        	if( ! empty( $instagram ) ) {
        		$social_media_string .= str_replace("INS", $instagram, $socials_arr['in_team_ins']);
        	}
        }
        $list_item_template = str_replace("ICT_SOCIAL_MEDIA", $social_media_string, $list_item_template);

        $final_str .= $list_item_template;
        $final_str .= "</li>";
        //if($attr['columns']<=$items_per_slide && $j % $attr['columns']==0) $final_str .= "<div class='clear'></div>";

        $list_item_template = $default_item;
        $details_arr = $default_details_arr;

      if( $j % $items_per_slide==0 || $j==$total_items ){
      	  $breaker_div++;
      	  $new_div = 1;
          $final_str .= "<div class='clear'></div></ul>";
      }else $new_div = 0;
      $j++;
    }
	
}

	$final_str .= "</div>";
        

        $final_str .="<script>
        				/* fill the skills */                            		
	jQuery('.team-member').each(function() {
		var current_set = jQuery(this).find('.fill');
		var show_details = jQuery(this).find('.show-details');
		jQuery('.team-member').find('.fill').css('width','0%');
		if (!show_details.is('div')) {
		current_set.each(function() {
				var i = 0; 
				var current_fill = jQuery(this);
				var progress = current_fill.attr('data-progress-animation');
				var current_width = current_fill.width();
				if (current_width == 0) {
					progress = progress.substring(0, progress.length - 1);
					var check = function() {
						if (i > progress) {
							return false;
						}
						else {
							i += 1;
							current_fill.css('width', i + '%');
							setTimeout(check, 1);
						}
					}
					check();
				}
			});
		}
	});
	jQuery('.team-member').hover(function() {
		
		var current_set = jQuery(this).find('.fill');
		var show_details = jQuery(this).find('.show-details');
		if (show_details.is('div')) {
			current_set.each(function() {
				var i = 0;
				var current_fill = jQuery(this);
				var progress = current_fill.attr('data-progress-animation');
				var current_width = current_fill.width();
				if (current_width == 0) {
					progress = progress.substring(0, progress.length - 1);
					var check = function() {
						if (i > progress) {
							return false;
						}
						else {
							i += 1;
							current_fill.css('width', i + '%');
							setTimeout(check, 1);
						}
					}
					check();
					// each
				}
			});
		}
	});
        </script>";
        
    if($attr['slider_set']==1){
            $total_pages = $total_items / $items_per_slide;

            if($total_pages>1){
              $navigation = 'false';
              $bullets = 'false';
              $autoplay = 'false';
			  $autoheight = 'false';
              $stop_hover = 'false';
              $loop = 'false';
              $responsive = 'false';
              $lazy_load = 'false';
			  $autoplayTimeout = 5000;
              $animation_in = 'false';
              $animation_out = 'false';

              if( strpos( $attr['slide_opt'], 'nav_button')!==FALSE) $navigation = 'true';
              if( strpos( $attr['slide_opt'], 'bullets')!==FALSE) $bullets = 'true';
			  if( strpos( $attr['slide_opt'], 'autoheight')!==FALSE) $autoheight = 'true';
              if( strpos( $attr['slide_opt'], 'autoplay')!==FALSE){
              	$autoplay = 'true';
				$autoplayTimeout = $attr['slide_speed'];
              }
              if( strpos( $attr['slide_opt'], 'stop_hover')!==FALSE) $stop_hover = 'true';
			  if( strpos( $attr['slide_opt'], 'loop')!==FALSE) $loop = 'true';
              if( strpos( $attr['slide_opt'], 'responsive')!==FALSE) $responsive = 'true';
              if( strpos( $attr['slide_opt'], 'lazy_load')!==FALSE) $lazy_load = 'true';
              if( $attr['animation_in']!='none' ) $animation_in = "'{$attr['animation_in']}'";
			  if( $attr['animation_out']!='none' ) $animation_out = "'{$attr['animation_out']}'";

                $final_str .= "<script>
                            		jQuery(document).ready(function() {
                            		  var owl = jQuery('#{$div_parent_id}');
                            		  owl.owlCarousel({
										    items : 1,
											mouseDrag: true,
											touchDrag: true,
											
											autoHeight: $autoheight,
											
											animateOut: $animation_out,
    										animateIn: $animation_in,
											
											lazyLoad : $lazy_load,
											loop: $loop,
											
											autoplay : $autoplay,
											autoplayTimeout: $autoplayTimeout,
											autoplayHoverPause: $stop_hover,
											autoplaySpeed: {$attr['slide_pagination_speed']},
											
											nav : $navigation,
											navSpeed : {$attr['slide_pagination_speed']},
											navText: [ '', '' ],
											
											dots: $bullets,
											dotsSpeed : {$attr['slide_pagination_speed']},
											
											responsiveClass: $responsive,
                                			responsive:{
											0:{
												nav:false
											},
											450:{
												nav : $navigation
											}
										}
                            		  });
                            		});
                               </script>";
            }
        }
        $final_str .= "</div>";//end of ict_wrapp
        $final_str .= "</div>";//end of theme_n
        $final_str .= "</div>";//end of style_xxxxxx

        if(!isset($return_str) || $return_str!=true ) echo $final_str;
}

?>