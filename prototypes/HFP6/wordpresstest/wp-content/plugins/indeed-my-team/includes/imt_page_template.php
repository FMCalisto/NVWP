<?php 
/**
 * Template Name: Indeed My Team
 */
get_header(); 
?>
<?php 
	$str = imt_return_infos_str_for_template();//str is an array with all info, check functions.php
?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div class="imt_inside_page">
			<?php if(isset($str['photo'][0])){?>
				<div class="imt_item_img">
					<img src="<?php echo $str['photo'][0];?>"/>
				</div>
			<?php }?>
				<div class="imt_item_details">
					<div class="imt_name"><?php echo $str['name'];?></div>
					<div class="imt_job"><?php echo $str['job'];?></div>
					<?php if($str['email'] !='') { ?>
						<div class="imt_email">					
							<i class="glyphiconinside-envelope"></i><a href="mailto:<?php echo $str['email'];?>"><?php echo $str['email'];?></a>
						</div>
					<?php } ?>
					
					<?php if($str['website'] !='') { ?>
						<div class="imt_website">
							<i class="glyphiconinside-globe"></i><a href="http://<?php echo $str['website'];?>" target="_blank"><?php echo $str['website'];?></a>
						</div>
					<?php } ?>
					<?php if($str['tel'] !='') { ?>
						<div class="imt_tel">						
							<i class="iconinside-phone"></i><?php echo $str['tel'];?>
						</div>
					<?php } ?>
					<div class="imt_location"><?php echo $str['location'];?></div>
					<?php if(isset($str['skills'])){?>
						<div class="member-skills-wrapper"><?php echo $str['skills'];?></div>
					<?php }?>
					<div class="member-social">
					<?php if($str['social_icon']['fb'] !='') echo '<a href="'.$str['social_icon']['fb'].'" class="facebook"><i class="iconinside-facebook"></i></a>';?>
					<?php if($str['social_icon']['tw'] !='') echo '<a href="'.$str['social_icon']['tw'].'" class="twitter"><i class="iconinside-twitter-2"></i></a>';?>
					<?php if($str['social_icon']['ld'] !='') echo '<a href="'.$str['social_icon']['ld'].'" class="linkedin"><i class="iconinside-linkedin"></i></a>';?>
					<?php if($str['social_icon']['gp'] !='') echo '<a href="'.$str['social_icon']['gp'].'" class="gplus"><i class="iconinside-gplus"></i></a>';?>
					<?php if($str['social_icon']['ins'] !='') echo '<a href="'.$str['social_icon']['ins'].'" class="instagramm"><i class="iconinside-instagramm"></i></a>';?>
					</div>
				</div>
				<div class="imt_clear"></div>
					<div class="imt_description"><?php echo $str['description'];?></div>
				<?php
					#latest posts
					if(isset($str['author_id']) && $str['author_id']!=''){
							$args = array(
									'author' => $str['author_id'],
									'numberposts' => -1,
									'post_status' => 'publish'
							);
						
							$post_query = new WP_Query($args);
							
							if($post_query->have_posts()){
								while($post_query->have_posts()){
									$post_query->the_post();
									get_template_part( 'content', get_post_format() );
								}
								// Previous/next page navigation.
								twentyfourteen_paging_nav();
							}else{
								get_template_part( 'content', 'none' );
							}					
					}
					#end of latest posts
				?>
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();