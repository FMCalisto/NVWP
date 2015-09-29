<?php
if(!isset($instance) || count($instance)==0){
    $instance = imt_init_widget_arr();
}
?>
<script>
    var instance_no = '<?php echo $instance_no;?>';
</script>
<div class="widget_wrapp">
    <div class="border_bottom">
        <table>
            <tr>
                <td><b><?php echo __('Team:', 'imt');?></b></td>
                        <?php
                                $args = array(
                                	'type'                     => IMT_POST_TYPE,
                                	'child_of'                 => 0,
                                	'parent'                   => '',
                                	'orderby'                  => 'name',
                                	'order'                    => 'ASC',
                                	'hide_empty'               => 1,
                                	'hierarchical'             => 1,
                                	'exclude'                  => '',
                                	'include'                  => '',
                                	'number'                   => '',
                                	'taxonomy'                 => IMT_TAXONOMY,
                                	'pad_counts'               => false
                                );
                                $categories = get_categories( $args );
                    ?>
                    <td>
                        <select name="<?php echo $this->get_field_name( 'team' );?>">
                                <?php $selected = checkIfSelected($instance['team'], 'all', 'select'); ?>
                                        <option value="all" <?php echo $selected;?> ><?php echo __('All', 'imt');?></option>
                                <?php
                                if(isset($categories) && count($categories)>0){
                                    foreach($categories as $cat){
                                        $selected = checkIfSelected($instance['team'], $cat->slug, 'select');
                                        ?>
                                            <option value="<?php echo $cat->slug;?>" <?php echo $selected;?>><?php echo $cat->name;?></option>
                                        <?php
                                    }
                                }
                                ?>
                        </select>
                    </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo __('Number of items:', 'imt');?></b>
                </td>
                <td>
                    <input type="number" value="<?php echo $instance['limit'];?>" min="0" name="<?php echo $this->get_field_name( 'limit' );?>" style="width: 50px;"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="space_b_divs"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo __('Order By:', 'imt');?></b>
                </td>
                <td>
                    <select name="<?php echo $this->get_field_name( 'order_by' );?>" onChange="disableOtherDD( this, 'rand', '#order_<?php echo $div_id_pre;?>');">
                            <?php $selected = checkIfSelected($instance['order_by'], 'date', 'select');?>
                        <option value="date" <?php echo $selected;?>><?php echo __('Date', 'imt');?></option>
                            <?php $selected = checkIfSelected($instance['order_by'], 'name', 'select');?>
                        <option value="name" <?php echo $selected;?>><?php echo __('Name', 'imt');?></option>
                            <?php $selected = checkIfSelected($instance['order_by'], 'rand', 'select');?>
                        <option value="rand" <?php echo $selected;?>><?php echo __('Random', 'imt');?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo __('Order Type:', 'imt');?></b>
                </td>
                <td>
                <?php
                    $disabled = '';
                    if($instance['order_by']=='rand') $disabled = 'disabled="disabled"';
                ?>
                    <select name="<?php echo $this->get_field_name( 'order' );?>" id="order_<?php echo $div_id_pre;?>" <?php echo $disabled;?> >
                            <?php $selected = checkIfSelected($instance['order'], 'ASC', 'select');?>
                        <option value="ASC" <?php echo $selected;?> ><?php echo __('ASC', 'imt');?></option>
                            <?php $selected = checkIfSelected($instance['order'], 'DESC', 'select');?>
                        <option value="DESC" <?php echo $selected;?> ><?php echo __('DESC', 'imt');?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="border_bottom">
        <b><?php echo __('Custom Field To Show:', 'imt');?> </b>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'name')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_name_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'name', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?>/> <?php echo __('Name', 'imt');?>
            </div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'photo')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_photo_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'photo', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?>/> <?php echo __('Photo', 'imt');?>
            </div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'description')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" onClick="make_inputh_string(this, 'description', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Photo', 'imt');?> <?php echo __('Description', 'imt');?>
            </div>
            <div class="space_b_divs"></div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'job')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_job_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'job', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Job Title', 'imt');?>
            </div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'email')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_email_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'email', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('E-mail', 'imt');?>
            </div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'location')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_location_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'location', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Location', 'imt');?>
            </div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'tel')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_tel_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'tel', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Telephone', 'imt');?>
            </div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'website')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_website_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'website', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Website', 'imt');?>
            </div>
            <div class="space_b_divs"></div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'social_icon')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_social_icon_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'social_icon', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Social Icons', 'imt');?>
            </div>
            <div class="space_b_divs"></div>
            <div>
                <?php
                    $selected = '';
                    if(strpos($instance['show'], 'skills')!==false) $selected = "checked='checked'";
                ?>
                <input type="checkbox" id="show_skills_<?php echo $div_id_pre;?>" onClick="make_inputh_string(this, 'skills', '#show_cf_list_<?php echo $div_id_pre;?>');" <?php echo $selected;?> /> <?php echo __('Skills', 'imt');?>
            </div>
            <input type="hidden" value="<?php echo $instance['show'];?>" name="<?php echo $this->get_field_name( 'show' );?>" id="show_cf_list_<?php echo $div_id_pre;?>" />
    </div>
    <div class="border_bottom">
        <table>
            <tr>
                <td><b><?php echo __('Theme:', 'imt');?></b></td>
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
                    <select class="ict_select_field_m" name="<?php echo $this->get_field_name( 'theme' );?>" >
                    	
                    <?php
                        foreach($themes_arr as $key=>$theme){
                            $value = strtolower($theme) . '_' . $key;
                            $label = ucfirst($theme) . ' ' . $key;
                            $selected = checkIfSelected($instance['theme'], $value, 'select'); 
                            ?>
                            <option value="<?php echo $value;?>" <?php echo $selected;?> ><?php echo $label;?></option>
                            <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
                        <tr>
                             <td colspan="2">
                                <div class="space_b_divs"></div>
                             </td>
                        </tr>
            <tr>
                <td colspan="2"><?php echo __('Select Color Scheme', 'imt');?>
                    <ul id="colors_ul_<?php echo $div_id_pre;?>" class="colors_ul">
                        <?php
                            $color_scheme = array('0a9fd8', '38cbcb', '27bebe', '0bb586', '94c523', '6a3da3', 'f1505b', 'ee3733', 'f36510', 'f8ba01');
                            $i = 0;
                            foreach($color_scheme as $color){
                                if( $i%5==0 ) echo "<div class='clear'></div>";
                                $class="color_scheme_item";
                                if($instance['color_scheme']==$color) $class = 'color_scheme_item-selected';
                                ?>
                                    <li class="<?php echo $class;?>" onClick="changeColorScheme_widget('#colors_ul_<?php echo $div_id_pre;?>', this, '<?php echo $color;?>', '#color_scheme_<?php echo $div_id_pre;?>');" style="background-color: #<?php echo $color;?>;"></li>
                                <?php
                                $i++;
                            }
                        ?>
                    </ul>
                    <input type="hidden" id="color_scheme_<?php echo $div_id_pre;?>" value="<?php echo $instance['color_scheme'];?>" name="<?php echo $this->get_field_name( 'color_scheme' );?>"/>
                    <div class="clear"></div>
                </td>
            </tr>
                        <tr>
                             <td colspan="2">
                                <div class="space_b_divs"></div>
                             </td>
                        </tr>
            <tr>
                <td><?php echo __('Number of Columns:', 'imt');?></td>
                <td>
                    <select name="<?php echo $this->get_field_name( 'columns' );?>" >
                        <?php
                            for($i=1;$i<7;$i++){
                                $selected = checkIfSelected($instance['columns'], $i, 'select');
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
                                <div class="space_b_divs"></div>
                             </td>
                        </tr>
            <tr>
                <td>
                    <b><?php echo __('Show as Slider', 'imt');?></b>
                </td>
                <td>
                    <?php $selected = checkIfSelected($instance['slider_set'], 1, 'checkbox');?>
                    <input type="checkbox" <?php echo $selected;?> onClick="check_and_h(this, '#slider_set_<?php echo $div_id_pre;?>');jQuery('#slider_options_<?php echo $div_id_pre;?>').toggle();" />
                    <input type="hidden" name="<?php echo $this->get_field_name( 'slider_set' );?>" value="<?php echo $instance['slider_set'];?>" id="slider_set_<?php echo $div_id_pre;?>" />
                </td>
            </tr>
       </table>
                <?php
                    $display = 'none';
                    if($instance['slider_set']==1) $display = 'block';
                ?>
            <div id="slider_options_<?php echo $div_id_pre;?>" style="display: <?php echo $display;?>">
                <table>
                        <tr>
                            <td>
                                <?php echo __('Items per Slide:', 'imt');?>
                            </td>
                            <td>
                                <input type="number" min="1" id="items_per_slide_<?php echo $div_id_pre;?>" name="<?php echo $this->get_field_name( 'items_per_slide' );?>" value="<?php echo $instance['items_per_slide'];?>" style="width: 50px;"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 <?php echo __('Bullets', 'imt');?>
                            </td>
                            <td>
                                <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'bullets')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'bullets', '#slide_opt_list_<?php echo $div_id_pre;?>');" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('Nav Button', 'imt');?>
                            </td>
                            <td>
                                <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'nav_button')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'nav_button', '#slide_opt_list_<?php echo $div_id_pre;?>');"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('Autoplay', 'imt');?>
                            </td>
                            <td>
                                <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'autoplay')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'autoplay', '#slide_opt_list_<?php echo $div_id_pre;?>');"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('Stop Hover', 'imt');?>
                            </td>
                            <td>
                                <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'stop_hover')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'stop_hover', '#slide_opt_list_<?php echo $div_id_pre;?>');" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('Speed', 'imt');?>
                            </td>
                            <td>
                                <input type="number" value="<?php echo $instance['slide_speed'];?>" name="<?php echo $this->get_field_name( 'slide_speed' );?>" class="ict_input_num_field" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('Pagination Speed', 'imt');?>
                            </td>
                            <td>
                                <input type="number" value="<?php echo $instance['slide_pagination_speed'];?>" name="<?php echo $this->get_field_name( 'slide_pagination_speed' );?>" class="ict_input_num_field"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 <?php echo __('Responsive', 'imt');?>
                            </td>
                            <td>
                                <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'responsive')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'responsive', '#slide_opt_list_<?php echo $div_id_pre;?>');"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 <?php echo __('Lazy Load', 'imt');?>
                            </td>
                            <td>
                                <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'lazy_load')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'lazy_load', '#slide_opt_list_<?php echo $div_id_pre;?>');" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('Lazy Effect', 'imt');?>
                            </td>
                            <td>
                                  <?php
                                    $selected = '';
                                    if(strpos($instance['slide_opt'], 'lazy_effect')!==false) $selected = "checked='checked'";
                                ?>
                                <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'lazy_effect', '#slide_opt_list_<?php echo $div_id_pre;?>');" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo __('CSS3 Transition', 'imt');?>
                            </td>
                            <td>
                                <select name="<?php echo $this->get_field_name( 'slide_css_transition' );?>">
                                        <?php $selected = checkIfSelected($instance['slide_css_transition'], 'none', 'select');?>
                                    <option value="none" <?php echo $selected;?> ><?php echo __('None', 'imt');?></option>
                                        <?php $selected = checkIfSelected($instance['slide_css_transition'], 'fade', 'select');?>
                                    <option value="fade" <?php echo $selected;?> ><?php echo __('fade', 'imt');?></option>
                                        <?php $selected = checkIfSelected($instance['slide_css_transition'], 'backSlide', 'select');?>
                                    <option value="backSlide" <?php echo $selected;?> ><?php echo __('backSlide', 'imt');?></option>
                                        <?php $selected = checkIfSelected($instance['slide_css_transition'], 'goDown', 'select');?>
                                    <option value="goDown" <?php echo $selected;?> ><?php echo __('goDown', 'imt');?></option>
                                        <?php $selected = checkIfSelected($instance['slide_css_transition'], 'fadeUp', 'select');?>
                                    <option value="fadeUp" <?php echo $selected;?> ><?php echo __('fadeUp', 'imt');?></option>
                                </select>
                            </td>
                        </tr>
                </table>
                <input type="hidden" value="<?php echo $instance['slide_opt'];?>" name="<?php echo $this->get_field_name( 'slide_opt' );?>" id="slide_opt_list_<?php echo $div_id_pre;?>" />
            </div>
    </div>
    <div>
            <div>
                <?php $selected = checkIfSelected($instance['page_inside'], 1, 'checkbox');?>
                <input type="checkbox" <?php echo $selected;?> onClick="check_and_h(this, '#show_inside_page_<?php echo $div_id_pre;?>')" /> <b><?php echo __('Show Inside Page', 'imt');?></b>
                <input type="hidden" value="<?php echo $instance['page_inside'];?>" name="<?php echo $this->get_field_name( 'page_inside' );?>" id="show_inside_page_<?php echo $div_id_pre;?>" />
            </div>
            <div>
                <b><?php echo __('Template', 'imt');?></b>
                <select name="<?php echo $this->get_field_name( 'inside_template' );?>" style="max-width: 215px;">
                	<option value="IMT_PAGE_TEMPLATE"><?php echo __('Indeed Custom Team Page', 'imt');?></option>
                    <option value="default"><?php echo __('Default Template', 'imt');?></option>
                    <?php
                        $templates = get_page_templates();
                        if(isset($templates) && count($templates)>0){
                             foreach($templates as $template_name => $template_page){
                                $template_page = str_replace('.php', '', $template_page);
                                $selected = checkIfSelected($instance['inside_template'], $template_page, 'select');
                                ?>
                                    <option value="<?php echo $template_page;?>" <?php echo $selected;?> ><?php echo $template_name;?></option>
                                <?php
                             }
                        }
                    ?>
                </select>
            </div>
            <div>
                <span class="warning_grey_span">( <?php echo __('If you want to use this options do not move theme files from their original location.', 'imt');?> )</span>
            </div>
    </div>
</div>