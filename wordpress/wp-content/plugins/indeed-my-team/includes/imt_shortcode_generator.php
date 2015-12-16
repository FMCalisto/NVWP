<?php
$shortcode_arr = imt_init_plugin_arr();
?>
<script>
var dir_url = '<?php echo IMT_DIR_URL;?>';
jQuery(document).ready(function(){
    ict_preview();
});
</script>
<div id="main">
<div class="ict_wrap">
<div class="">
    <h1><?php echo __('Shortcode Generator', 'imt');?></h1>
     <div  class="ict_settings_wrapper">
        <div class="box-title">
            <h3><i class="icon-cogs"></i><?php echo __('Settings', 'imt');?></h3>
            <div class="actions pointer">
			    <a onclick="jQuery('#the_shc_settings').slideToggle();" class="btn btn-mini content-slideUp">
                    <i class="icon-angle-down"></i>
                </a>
			</div>
            <div class="clear"></div>
        </div>
         <div id="the_shc_settings" class="ict_settings_wrapp">
            <div class="ict_column column_one">
                    <h4><?php echo __('Display Entries', 'imt');?></h4>
					<div class="ict_settings_inner">
						<table>
                            <tr>
                                <td valign="top">
                                    <span class="ict-strong"><?php echo __('Teams:', 'imt');?></span>
                                </td>
                                <td>
                                    <select id="team" onchange="ict_select_team(this);ict_preview();" class="ict_select_field_vl" multiple>
                                            <?php $selected = checkIfSelected($shortcode_arr['team'], 'all', 'select');?>
                                        <option value="all" <?php echo $selected;?>><?php echo __('All', 'imt');?></option>
                                         <?php
                                            $args = array( 'taxonomy' => IMT_TAXONOMY,
                                                           'type' => IMT_POST_TYPE );
                                            $cats = get_categories($args);
                                                if( isset($cats) && count($cats)>0 ){
                                                foreach($cats as $cat){
                                                    $selected = checkIfSelected($shortcode_arr['team'], $cat->slug, 'select');
                                                    ?>
                                                  <option value="<?php echo $cat->slug;?>" <?php echo $selected;?> ><?php echo $cat->name;?></option>
                                                    <?php
                                                }
                                            }
                                         ?>
                                    </select>
                                </td>
                            </tr>
							<tr>
                                <td colspan="2">
                                    <span class="warning_grey_span">( <?php echo __('Select one or many Teams with Members', 'imt');?> )</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="ict-strong"><?php echo __('Number Of Entries:', 'imt');?></span>
                                </td>
                                <td>
                                    <input type="number" min="1" max="" id="limit" value="<?php echo $shortcode_arr['limit'];?>" onChange="ict_preview();" onKeyup="ict_preview();" class="ict_input_num_field"/>
                                </td>
                            </tr>
                            <tr>
                                 <td colspan="2">
                                    <div class="spacewp_b_divs"></div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                   	<span class="ict-strong"><?php echo __('Order By:', 'imt');?></span>
                                </td>
                                <td>
                                    <select id="order_by" onClick="ict_preview();disableOtherDD( this, 'rand', '#order');" class="ict_select_field_vl">
                                            <?php $selected = checkIfSelected($shortcode_arr['order_by'], 'date', 'select');?>
                                        <option value="date" <?php echo $selected;?>><?php echo __('Date', 'imt');?></option>
                                            <?php $selected = checkIfSelected($shortcode_arr['order_by'], 'name', 'select');?>
                                        <option value="name" <?php echo $selected;?>><?php echo __('Name', 'imt');?></option>
                                            <?php $selected = checkIfSelected($shortcode_arr['order_by'], 'last_name', 'select');?>
                                        <option value="last_name" <?php echo $selected;?>><?php echo __('Last Name', 'imt');?></option>                                        
                                            <?php $selected = checkIfSelected($shortcode_arr['order_by'], 'rand', 'select');?>
                                        <option value="rand" <?php echo $selected;?>><?php echo __('Random', 'imt');?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="ict-strong"><?php echo __('Order Type:', 'imt');?></span>
                                </td>
                                <td>
                                    <?php
                                        $disable = '';
                                        if($shortcode_arr['order_by']=='rand') $disable = 'disabled="disabled"';
                                    ?>
                                    <select id="order" onClick="ict_preview();" class="ict_select_field_vl" <?php echo $disable;?>>
                                            <?php $selected = checkIfSelected($shortcode_arr['order'], 'ASC', 'select');?>
                                        <option value="ASC" <?php echo $selected;?> ><?php echo __('ASC', 'imt');?></option>
                                            <?php $selected = checkIfSelected($shortcode_arr['order'], 'DESC', 'select');?>
                                        <option value="DESC" <?php echo $selected;?> ><?php echo __('DESC', 'imt');?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                 <td colspan="2">
                                    <div class="spacewp_b_divs"></div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="ict-strong"><?php echo __('Show Inside Page', 'imt');?></span>
                                </td>
                                <td>
                                    <?php $selected = checkIfSelected($shortcode_arr['page_inside'], 1, 'checkbox');?>
                                    <input type="checkbox" <?php echo $selected;?> id="page_inside" onClick="ict_preview();"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="ict-strong"><?php echo __('Template', 'imt');?></span>
                                        <select id="inside_template" onChange="ict_preview();" class="mddl_select_tag">
                                        	<option value="IMT_PAGE_TEMPLATE"><?php echo __('Indeed Custom Team Page', 'imt');?></option>
                                            <option value="default"><?php echo __('Default Template', 'imt');?></option>
                                            <?php
                                                $templates = get_page_templates();
                                                if(isset($templates) && count($templates)>0){
                                                     foreach($templates as $template_name => $template_page){
                                                        $template_page = str_replace('.php', '', $template_page);
                                                        $selected = checkIfSelected($shortcode_arr['inside_template'], $template_page, 'select');
                                                        ?>
                                                            <option value="<?php echo $template_page;?>" <?php echo $selected;?> ><?php echo $template_name;?></option>
                                                        <?php
                                                     }
                                                }
                                            ?>
                                        </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="warning_grey_span">( <?php echo __('If you want to use this options do not move theme files from their original location.', 'imt');?> )</span>
                                </td>
                            </tr>
                    </table>
				</div>
            </div><!--end of column one-->
            <div class="ict_column column_two">
                  <h4><?php echo __('Entry Information', 'imt');?></h4>
				  <div class="ict_settings_inner">
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['name'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_name" onClick="ict_preview();"/> <?php echo __('Member Name', 'imt');?>
                      </div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['photo'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_photo" onClick="ict_preview();" /> <?php echo __('Photo', 'imt');?>
                      </div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['description'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_descript" onClick="ict_preview();"/> <?php echo __('Description', 'imt');?>
                      </div>
                      <div class="space_b_divs"></div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['job'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_job" onClick="ict_preview();"/> <?php echo __('Job Title', 'imt');?>
                      </div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['email'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_email" onClick="ict_preview();"/> <?php echo __('E-mail', 'imt');?>
                      </div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['website'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_website" onClick="ict_preview();"/> <?php echo __('Website', 'imt');?>
                      </div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['tel'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_tel" onClick="ict_preview();"/> <?php echo __('Telephone', 'imt');?>
                      </div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['location'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_location" onClick="ict_preview();"/> <?php echo __('Location', 'imt');?>
                      </div>
                      <div class="space_b_divs"></div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['social_icon'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_social_icon" onClick="ict_preview();"/> <?php echo __('Social Icons', 'imt');?>
                      </div>
                      <div class="space_b_divs"></div>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['skills'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="show_skills" onClick="ict_preview();"/> <?php echo __('Skills', 'imt');?>
                      </div>
                      <div class="space_b_divs"></div>
                 </div>
            </div><!--end of column_two-->
             <div class="ict_column column_three">
                <h4>Template</h4>
				  <div class="ict_settings_inner">
                    <table>
                        <tr>
                            <td><span class="ict-strong"><?php echo __('Select Theme', 'imt');?></span></td>
                            <td>
                                  <?php
                                        $handle = opendir( IMT_DIR_PATH . 'themes' );
                                        while (false !== ($entry = readdir($handle))) {
                                            if( $entry!='.' && $entry!='..' ){
                                                $arr_str = explode('_', $entry);
                                                $themes_arr[$arr_str[1]] = $arr_str[0];
                                            }
                                        }
                                        ksort($themes_arr);
                                  ?>
                                <select id="theme" onChange="ict_preview();" class="ict_select_field_m">
                                <?php
                                        foreach($themes_arr as $key=>$theme){
                                               $selected = checkIfSelected($shortcode_arr['theme'], $theme, 'select');
                                               $value = strtolower($theme) . '_' . $key;
                                               $label = ucfirst($theme) . ' ' . $key;
                                               ?>
                                               <option value="<?php echo $value;?>" <?php echo $selected;?> ><?php echo $label;?></option>
                                               <?php
                                        }
                                  ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><span class="ict-strong"><?php echo __('Color Scheme', 'imt');?></span></td>
                            <td>
                            <ul id="colors_ul" class="colors_ul">
                                <?php
                                    $color_scheme = array('0a9fd8', '38cbcb', '27bebe', '0bb586', '94c523', '6a3da3', 'f1505b', 'ee3733', 'f36510', 'f8ba01');
                                    $i = 0;
                                    foreach($color_scheme as $color){
                                        if( $i==5 ) echo "<div class='clear'></div>";
                                        ?>
                                            <li class="color_scheme_item" onClick="changeColorScheme(this, '<?php echo $color;?>', '#color_scheme');ict_preview();" style="background-color: #<?php echo $color;?>;"></li>
                                        <?php
                                        $i++;
                                    }
                                ?>
                            </ul>
                            <input type="hidden" id="color_scheme" value="<?php echo $shortcode_arr['color_scheme'];?>" />
                            <div class="clear"></div>
                            </td>
                        </tr>
						<tr>
                             <td colspan="2">
                             </td>
                        </tr>
                        <tr>
                            <td><span class="ict-strong"><?php echo __('Columns:', 'imt');?></span></td>
                            <td>
                                <select id="columns_num" onChange="ict_preview();" class="ict_select_field_m">
                                    <?php
                                        for($i=1;$i<7;$i++){
                                            $selected = checkIfSelected($shortcode_arr['columns'], $i, 'select');
                                            ?>
                                                <option value='<?php echo $i;?>' <?php echo $selected;?>><?php echo $i;?> <?php echo __('columns', 'imt');?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                             <td colspan="2">
                                <div class="spacewp_b_divs"></div>
                             </td>
                        </tr>
                    </table>
                      <div>
                          <?php $selected = checkIfSelected($shortcode_arr['hide_small_icons'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="hide_small_icons" onClick="ict_preview();"/> <?php echo __('Hide Small Icons', 'imt');?> 
						  <span class="warning_grey_span" style="display:block;"><?php echo __('Available for icons from Email,Website,Telephone fields', 'imt');?></span>                     
                      </div> 
                      <div style="margin-top:10px;">
                          <?php $selected = checkIfSelected($shortcode_arr['align_center'], 1, 'checkbox');?>
                          <input type="checkbox" <?php echo $selected;?> id="imt_align_center" onClick="ict_preview();"/> <?php echo __('Align the Items Centered', 'imt');?>                      
                      </div>  
				 </div>	                       
             </div><!--end of column three-->
               <div class="ict_column column_four">
			      <h4>Slider ShowCase</h4>
				  <div class="ict_settings_inner" style="padding-bottom:10px;">
                  <div class="ict-selection">
                        <?php $selected = checkIfSelected($shortcode_arr['slider_set'], 1, 'checkbox');?>
                        <input type="checkbox" <?php echo $selected;?> id="slider_set" onClick="checkandModfCss(this, '#slider_options', 'opacity', 1, '0.5');ict_preview();"/> <?php echo __('Show as Slider', 'imt');?>
                 		 <span class="warning_grey_span" style="display:block;"><?php echo __('If Slider Showcase is used, Filter Showcase is disabled.', 'imt');?></span> 
				  </div>
                  <div style="opacity:0.5" id="slider_options" >
                      <table>
                          <tr>
                              <td><span class="ict-strong"><?php echo __('Items per Slide:', 'imt');?></span></td>
                              <td>
                                  <input type="number" min="1" id="items_per_slide" onChange="ict_preview();" onKeyup="ict_preview();" value="<?php echo $shortcode_arr['items_per_slide'];?>" class="ict_input_num_field"/>
                              </td>
                          </tr>
						  <tr>
                              <td>
                                  <span class="ict-strong"><?php echo __('Slide TimeOut', 'imt');?></span>
                              </td>
                              <td>
                                  <input type="number" value="<?php echo $shortcode_arr['speed'];?>" id="speed" onChange="ict_preview();" onKeyup="ict_preview();" class="ict_input_num_field" />
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <span class="ict-strong"><?php echo __('Pagination Speed', 'imt');?></span>
                              </td>
                              <td>
                                  <input type="number" value="<?php echo $shortcode_arr['pagination_speed'];?>" id="pagination_speed" onChange="ict_preview();" onKeyup="ict_preview();" class="ict_input_num_field"/>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['bullets'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="bullets" onClick="ict_preview();"/> <?php echo __('Bullets', 'imt');?>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['nav_button'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="nav_button" onClick="ict_preview();"/> <?php echo __('Nav Button', 'imt');?>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['autoplay'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="autoplay" onClick="ict_preview();"/> <?php echo __('Autoplay', 'imt');?>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['stop_hover'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="stop_hover" onClick="ict_preview();"/> <?php echo __('Stop Hover', 'imt');?>
                              </td>
                          </tr>
						  <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['responsive'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="responsive" onClick="ict_preview();"/> <?php echo __('Responsive', 'imt');?>
                              </td>
                          </tr>
						  <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['autoheight'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="autoheight" onClick="ict_preview();"/> <?php echo __('Auto Height', 'imt');?>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['lazy_load'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="lazy_load" onClick="ict_preview();"/> <?php echo __('Lazy Load', 'imt');?>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <?php $selected = checkIfSelected($shortcode_arr['loop'], 1, 'checkbox');?>
                                  <input type="checkbox" <?php echo $selected;?> id="loop" onClick="ict_preview();"/> <?php echo __('Play in Loop', 'imt');?>
                              </td>
                          </tr>
                          
                          
                          <tr>
                              <td colspan="2">
                                  <span class="ict-strong"><?php echo __('Pagination Theme', 'imt');?></span>                      
                                  <select id="pagination_theme" onChange="ict_preview();" style="min-width:162px;">
                                          <?php $selected = checkIfSelected($shortcode_arr['pagination_theme'], 'pag-theme1', 'select');?>
                                      <option value="pag-theme1" <?php echo $selected;?> ><?php echo __('Pagination Theme 1', 'imt');?></option>
									  <?php $selected = checkIfSelected($shortcode_arr['pagination_theme'], 'pag-theme2', 'select');?>
                                      <option value="pag-theme2" <?php echo $selected;?> ><?php echo __('Pagination Theme 2', 'imt');?></option>
									  <?php $selected = checkIfSelected($shortcode_arr['pagination_theme'], 'pag-theme3', 'select');?>
                                      <option value="pag-theme3" <?php echo $selected;?> ><?php echo __('Pagination Theme 3', 'imt');?></option>
                                  </select>
                              </td>
                          </tr>
						  <tr>
                              <td colspan="2">
                                  <span class="ict-strong"><?php echo __('Animation Slide In', 'imt');?></span>
                                  <select onChange="ict_preview();" id="animation_in" style="min-width:162px;">
									  <option value="none">None</option>
									  <option value="fadeIn">fadeIn</option>
									  <option value="fadeInDown">fadeInDown</option>
									  <option value="fadeInUp">fadeInUp</option>
									  <option value="slideInDown">slideInDown</option>
									  <option value="slideInUp">slideInUp</option>
									  <option value="flip">flip</option>
									  <option value="flipInX">flipInX</option>
									  <option value="flipInY">flipInY</option>
									  <option value="bounceIn">bounceIn</option>
									  <option value="bounceInDown">bounceInDown</option>
									  <option value="bounceInUp">bounceInUp</option>
									  <option value="rotateIn">rotateIn</option>
									  <option value="rotateInDownLeft">rotateInDownLeft</option>
									  <option value="rotateInDownRight">rotateInDownRight</option>
									  <option value="rollIn">rollIn</option>
									  <option value="zoomIn">zoomIn</option>
									  <option value="zoomInDown">zoomInDown</option>
									  <option value="zoomInUp">zoomInUp</option>
								  </select>
                              </td>
                          </tr>
						  <tr>
								<td colspan="2">
                                  <span class="ict-strong"><?php echo __('Animation Slide out', 'imt');?></span>
                                  <select onChange="ict_preview();" id="animation_out" style="min-width:162px;">
									  <option value="none">None</option>
									  <option value="fadeOut">fadeOut</option>
									  <option value="fadeOutDown">fadeOutDown</option>
									  <option value="fadeOutUp">fadeOutUp</option>
									  <option value="slideOutDown">slideOutDown</option>
									  <option value="slideOutUp">slideOutUp</option>
									  <option value="flip">flip</option>
									  <option value="flipOutX">flipOutX</option>
									  <option value="flipOutY">flipOutY</option>
									  <option value="bounceOut">bounceOut</option>
									  <option value="bounceOutDown">bounceOutDown</option>
									  <option value="bounceOutUp">bounceOutUp</option>
									  <option value="rotateOut">rotateOut</option>
									  <option value="rotateOutUpLeft">rotateOutUpLeft</option>
									  <option value="rotateOutUpRight">rotateOutUpRight</option>
									  <option value="rollOut">rollOut</option>
									  <option value="zoomOut">zoomOut</option>
									  <option value="zoomOutDown">zoomOutDown</option>
									  <option value="zoomOutUp">zoomOutUp</option>
								  </select>
                              </td>
                          </tr>
                      </table>
                  </div>
				 </div>
               </div> <!--end of column four-->
               <div class="ict_column column_five">
			   <h4>Filter ShowCase</h4>
			   <div class="ict_settings_inner">
                    <div class="ict-selection">
                        <input type="checkbox" id="filtering" onClick="filtering_set_unset(this);ict_preview();" /> <?php echo __('Filter:', 'imt');?>
						<span class="warning_grey_span" style="display:block;"><?php echo __('If Filter Showcase is used, Slider Showcase is disabled.', 'imt');?></span> 
                    </div>
                    <div id="filtering_options" style="opacity:0.5;">
                        <table>
                            <tr>
                                <td><div class="space_b_divs"></div></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                	<span class="ict-strong"><?php echo __('Teams:', 'imt');?></span>
                                    <?php
                                      $args = array( 'taxonomy' => IMT_TAXONOMY,
                                                     'type' => IMT_POST_TYPE );
                                      $cats = get_categories($args);
                                      if( isset($cats) && count($cats) ){
                                          foreach($cats as $cat){
                                              ?>
                                          		<div>
                                          			<input type="checkbox" value="<?php echo $cat->slug;?>" onClick="make_inputh_string(this, '<?php echo $cat->slug;?>', '#filter_teams');ict_preview();" checked="checked"><?php echo $cat->name;?>
                                          		</div>
                                          	<?php
                                            $team_arr_h[] = $cat->slug;
                                          }
                                          $str_hidden = implode(',', $team_arr_h);
                                      }else {
                                            $str_hidden = '';
                                            echo __('Empty', 'imt');
                                      }
                                      ?>
                                      <input type="hidden" value="<?php echo $str_hidden;?>" id="filter_teams" />
                                </td>
                            </tr>
                            <tr>
                                <td><div class="space_b_divs"></div></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                	<span class="ict-strong">Theme</span>
                                    <select id="filter_select_t" onChange="ict_preview();">
                                        <option value="small_text"><?php echo __('Small Text', 'imt');?></option>
                                        <option value="big_text"><?php echo __('Big Text', 'imt');?></option>
                                        <option value="small_button"><?php echo __('Small Buttons', 'imt');?></option>
                                        <option value="big_button"><?php echo __('Big Buttons', 'imt');?></option>
                                        <option value="dropdown"><?php echo __('DropDown', 'imt');?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="space_b_divs"></div></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><span class="ict-strong"><?php echo __('Align', 'imt');?></span></td>
                                <td>
                                    <select id="filter_align" onChange="ict_preview();">
                                        <option value="left"><?php echo __('Left', 'imt');?></option>
                                        <option value="center"><?php echo __('Center', 'imt');?></option>
                                        <option value="right"><?php echo __('Right', 'imt');?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
				  </div>	
               </div>
             <div class="clear"></div>
        </div><!--end of display entrires -->
    </div>
</div>
    <div class="shortcode_wrapp">
        <div class="content_shortcode">
            <div>
                <span style="font-weight:bolder; color: #333; font-style:italic; font-size:11px;"><?php echo __('ShortCode :', 'imt');?> </span>
                <span class="the_shortcode"></span>
            </div>
            <div style="margin-top:10px;">
                <span style="font-weight:bolder; color: #333; font-style:italic; font-size:11px;"><?php echo __('PHP Code:', 'imt');?> </span>
                <span class="php_code"></span>
            </div>
        </div>
    </div>
<div class="ict_preview_wrapp">
    <div class="box_title">
        <h2><i class="icon-eyes"></i><?php echo __('Preview', 'imt');?></h2>
            <div class="actions_preview pointer">
			    <a onclick="jQuery('#preview').slideToggle();" class="btn btn-mini content-slideUp">
                    <i class="icon-angle-down"></i>
                </a>
			</div>
        <div class="clear"></div>
    </div>
    <div id="preview" class="ict_preview"></div>
</div>
<div style="clear:both;"></div>
</div>
</div>