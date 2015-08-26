<?php 
	if(isset($_REQUEST['imt_submit'])) imt_save_update_metas();
	$metas = imt_general_settings_meta();
?>
<div class="ict_wrap">
	    <div class="">
	        <h3>
	        	<i class="icon-cogs"></i><?php echo __('General Settings', 'imt');?>
	        </h3>
	    </div>

	<form method="post" action="">	    
		<div class="stuffbox">
                    <h3>
                        <label><?php echo __('Responsive Settings', 'imt');?></label>
                    </h3>
                    <div class="inside">
                        <table class="form-table indeed_admin_table">
        	                <tbody>
                                <tr>
									<td><?php echo __('Screen Max-Width:', 'imt');?> <b>479px</b></td>
									<td>
										<select name="imt_responsive_settings_small">
											<?php 
												for($i=1;$i<7;$i++){
													$selected = '';
													if($metas['imt_responsive_settings_small']==$i) $selected = 'selected="selected"';
													?>
														<option value="<?php echo $i;?>" <?php echo $selected;?> ><?php echo $i.' '.__('Columns', 'imt');?></option>
													<?php 
												}
												$selected = '';
												if($metas['imt_responsive_settings_small']=='auto') $selected = 'selected="selected"';
												?>
													<option value="auto" <?php echo $selected;?> ><?php echo __('Auto', 'imt');?></option>
												<?php 
											?>
										</select>
									</td>
                                </tr>
                                <tr>
									<td><?php echo __('Screen Min-Width:', 'imt');?> <b>480px</b> <?php echo __('and Screen Max-Width:', 'imt');?> <b>767px</b></td>
									<td>
										<select name="imt_responsive_settings_medium">
											<?php 
												for($i=1;$i<7;$i++){
													$selected = '';
													if($metas['imt_responsive_settings_medium']==$i) $selected = 'selected="selected"';													
													?>
														<option value="<?php echo $i;?>" <?php echo $selected;?> ><?php echo $i.' '.__('Columns', 'imt');?></option>
													<?php 
												}
												$selected = '';
												if($metas['imt_responsive_settings_medium']=='auto') $selected = 'selected="selected"';
												?>
													<option value="auto" <?php echo $selected;?> ><?php echo __('Auto', 'imt');?></option>
												<?php 
											?>
										</select>
									</td>
                                </tr>
                                <tr>
									<td><?php echo __('Screen Min-Width:', 'imt');?> <b>768px</b> <?php echo __('and Screen Max-Width:', 'imt');?> <b>959px</b></td>
									<td>
										<select name="imt_responsive_settings_large">
											<?php 
												for($i=1;$i<7;$i++){
													$selected = '';
													if($metas['imt_responsive_settings_large']==$i) $selected = 'selected="selected"';													
													?>
														<option value="<?php echo $i;?>" <?php echo $selected;?> ><?php echo $i.' '.__('Columns', 'imt');?></option>
													<?php 
												}
												$selected = '';
												if($metas['imt_responsive_settings_large']=='auto') $selected = 'selected="selected"';
												?>
													<option value="auto" <?php echo $selected;?> ><?php echo __('Auto', 'imt');?></option>
												<?php 
											?>
										</select>
									</td>
                                </tr>                                
                            </tbody>
                        </table>
                        <div class="submit">
                            <input type="submit" value="<?php echo __('Save changes', 'imt');?>" name="imt_submit" class="button button-primary button-large" />
                        </div>
                    </div>
		</div>
		<div class="stuffbox">
                    <h3>
                        <label><?php echo __('Inside Page', 'imt');?></label>
                    </h3>
                    <div class="inside">
                        <table class="form-table indeed_admin_table">
        	                <tbody>
                                <tr>
									<td><?php echo __('Entry Information', 'imt');?>:</td>
                                </tr>
                                <tr>
									<td>
				                      <div>
				                          <?php
				                          		$infos = explode(',', $metas['imt_custom_page_entry_infos']);
				                          		$selected = '';
				                          		if(in_array('name', $infos)) $selected = 'checked="checked"';	
				                          ?>
				                          <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'name', '#imt_custom_page_entry_infos');"/> <?php echo __('Member Name', 'imt');?>
				                      </div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('photo', $infos)) $selected = 'checked="checked"';				                        
				                          ?>
				                          <input type="checkbox" <?php echo $selected;?> onClick="make_inputh_string(this, 'photo', '#imt_custom_page_entry_infos');"/> <?php echo __('Photo', 'imt');?>
				                      </div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('description', $infos)) $selected = 'checked="checked"';				                        
				                          ?>
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'description', '#imt_custom_page_entry_infos');" /> <?php echo __('Description', 'imt');?>
				                      </div>
				                      <div class="space_b_divs"></div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('job', $infos)) $selected = 'checked="checked"';				                        
				                          ?>
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'job', '#imt_custom_page_entry_infos');"/> <?php echo __('Job Title', 'imt');?>
				                      </div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('email', $infos)) $selected = 'checked="checked"';				                        
				                          ?>				                      
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'email', '#imt_custom_page_entry_infos');"/> <?php echo __('E-mail', 'imt');?>
				                      </div>
				                      <div class="space_b_divs"></div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('website', $infos)) $selected = 'checked="checked"';				                        
				                          ?>	
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'website', '#imt_custom_page_entry_infos');" /> <?php echo __('Website', 'imt');?>
				                      </div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('tel', $infos)) $selected = 'checked="checked"';				                        
				                          ?>					       
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'tel', '#imt_custom_page_entry_infos');"/> <?php echo __('Telephone', 'imt');?>
				                      </div>
				                      <div class="space_b_divs"></div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('location', $infos)) $selected = 'checked="checked"';				                        
				                          ?>				                         
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'location', '#imt_custom_page_entry_infos');"/> <?php echo __('Location', 'imt');?>
				                      </div>
				                      <div class="space_b_divs"></div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('social_icon', $infos)) $selected = 'checked="checked"';				                        
				                          ?>						                    
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'social_icon', '#imt_custom_page_entry_infos');"/> <?php echo __('Social Icons', 'imt');?>
				                      </div>
				                      <div>
				                          <?php
				                          		$selected = '';
				                          		if(in_array('skills', $infos)) $selected = 'checked="checked"';				                        
				                          ?>						                    
				                          <input type="checkbox" <?php echo $selected;?> id="" onClick="make_inputh_string(this, 'skills', '#imt_custom_page_entry_infos');"/> <?php echo __('Skills', 'imt');?>
				                      </div>
				                      
				                      <input type="hidden" value="<?php echo $metas['imt_custom_page_entry_infos'];?>" id="imt_custom_page_entry_infos" name="imt_custom_page_entry_infos" />
				                      
				                      <div class="space_b_divs"></div>
				                      <div class="space_b_divs"></div>
				                      
				                      <div>
                        				<?php 
                        					$checked = '';
                        					if($metas['imt_latest_posts']==1) $checked = 'checked="checked"';
                        				?>
                        				<input type="checkbox" onClick="check_and_h(this, '#imt_latest_posts');" <?php echo $checked;?>/>
                        				<input type="hidden" value="<?php echo $metas['imt_latest_posts'];?>" name="imt_latest_posts" id="imt_latest_posts" />	
                        				<label><strong><?php echo __('Display Latest Posts', 'imt');?></strong></label>	
										<div style="margin-left: 10px;"><i><?php echo __('Activate when the team member was correlated with an WP author', 'imt');?></i></div>		                      		
				                      </div>
				                      
									</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="submit">
                            <input type="submit" value="<?php echo __('Save changes', 'imt');?>" name="imt_submit" class="button button-primary button-large" />
                        </div>
                    </div>
		</div>
		<div class="stuffbox">
               <h3>
               		<label><?php echo __('Custom CSS', 'imt');?></label>
               </h3>
               <div class="inside">
			   <div style="margin-left: 10px;"><b><?php echo __('Add   !important;  after each style option and full style path to be sure that it will take effect!', 'imt');?></b></div>
                        <table class="form-table indeed_admin_table">
                        	<tr>
                        		<td>
                        			<textarea name="imt_custom_css" style="min-width: 500px;min-height: 100px;"><?php echo $metas['imt_custom_css'];?></textarea>
                        		</td>
                        	</tr>
                        </table>
                    <div class="submit">
                    	<input type="submit" value="<?php echo __('Save changes', 'imt');?>" name="imt_submit" class="button button-primary button-large" />
                    </div>           
               </div>     
        </div> 
        
	</form>
		<div class="stuffbox">
                    <h3>
                        <label><?php echo __('Post Type', 'imt');?></label>
                    </h3>
                    <div class="inside">
                        <table class="form-table indeed_admin_table">
        	                <tbody>
                                <tr>
									<td>
										<?php echo __('Name', 'imt');?>: 
									</td>
                                    <td>
										<input type="text" value="<?php echo IMT_POST_TYPE;?>" id="imt_post_type_name" style="min-width: 300px;"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-left: 10px;"><b><?php echo __('If You change the Post Type, the current Team will not be available anymore!', 'imt');?></b></div>
                        <div class="submit">
                            <input type="button" onClick="imt_change_post_type_name('<?php echo get_site_url();?>');" value="<?php echo __('Save changes', 'imt');?>" name="imtst_submit" class="button button-primary button-large" />
                        </div>
                    </div>
		</div>
</div>