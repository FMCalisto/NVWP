<?php

/*

Plugin Name: Posts Date Ranges

Plugin URI: http://www.deshpradesh.com/posts-date-ranges

Description: This Plugin Will Add Options in admin posts lists page to pick up start-date and end-date ranges to filter posts in your wordpress admin. It will give you instant filter options without any type of configuration just install it and use it.

Author: Jaytesh Barange

Version: 2.2

Author URI: http://www.jaytesh.com/jaytesh

*/







function wp_pdr_admin_filters($query) {



	global $pagenow;



	if( $query->is_admin && ( 'edit.php' == $pagenow ) ) { 



		if(isset($_REQUEST['start_date'])||isset($_REQUEST['end_date']))



		{



		$filter=false;

			add_filter( 'posts_join', 'pdr_filter_join_custom' );

		add_filter( 'posts_where', 'pdr_filter_where_custom' );

		 

	

		}



	}

	return $query;



}



function pdr_filter_where_custom( $where = '' ) {



	global $wpdb;



	if(isset($_REQUEST['start_date'])&&!empty($_REQUEST['start_date']))



	{



	$start_date=$_REQUEST['start_date'];



	$where .= " AND post_date >='$start_date 00:00:00' ";



	}



	if(isset($_REQUEST['end_date'])&&!empty($_REQUEST['end_date']))



	{



	$end_date=$_REQUEST['end_date'];



	 $where .=" AND post_date <='$end_date 23:59:59' ";



	}

	if(isset($_REQUEST['no_feat_img'])&&($_REQUEST['no_feat_img']=="no_featured_img"))

	{

	$where .=" AND $wpdb->postmeta.post_id IS NULL ";

	}

	if(isset($_REQUEST['no_feat_img'])&&($_REQUEST['no_feat_img']=="featured_img"))

	{

	$where .=" AND $wpdb->postmeta.post_id IS NOT NULL ";

	}

	return $where;



}

function pdr_filter_join_custom( $join = '' ) {



	global $wp_query, $wpdb;



    if (isset($_REQUEST['no_feat_img'])) {

        $join .= " LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id

      AND $wpdb->postmeta.meta_key = '_thumbnail_id') ";

    }

	return $join;

}

// Jaytesh Barange loves to code



function wp_pdr_admin_filters_dropdowns() {



	global $wpdb;



if(isset($_REQUEST['start_date'])&&isset($_REQUEST['end_date']))



		{



		$start_date=$_REQUEST['start_date'];



	$end_date=$_REQUEST['end_date'];



	}



	?>



	<?php _e('Start Date');?>: <input type="text" name="start_date" class="datepick" id="frompdr" value="<?php echo $start_date;?>" size="10" /> <?php _e('End Date');?>: <input type="text" name="end_date" class="datepick" id="topdr" value="<?php echo $end_date;?>" size="10" /> 

	<?php

	$featu_img=""; 	

	if(isset($_REQUEST['no_feat_img'])){

	$featu_img=$_REQUEST['no_feat_img']; 

	}

	?>

    <select name="no_feat_img" >

    <option value="">-<?php _e('Select Filter');?>-</option>

    <option value="featured_img" <?php selected($featu_img,"featured_img"); ?>><?php _e('Having Featured Image');?></option>

    <option value="no_featured_img" <?php selected($featu_img,"no_featured_img"); ?>><?php _e('Not Having Featured Image');?></option>

    </select>





	<script type="text/javascript">



	jQuery(document).ready(function($){


        $( "#frompdr" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      dateFormat : 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#topdr" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#topdr" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      dateFormat : 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#frompdr" ).datepicker( "option", "maxDate", selectedDate );
      }
    });



	});



	</script>



	<?php



	return;



}







// Jaytesh Barange loves to code



add_filter('pre_get_posts', 'wp_pdr_admin_filters');



add_action('restrict_manage_posts', 'wp_pdr_admin_filters_dropdowns',2);

function wp_pdr_scripts_method() {
	wp_enqueue_script('jquery-ui-datepicker');

	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

}





add_action( 'admin_enqueue_scripts', 'wp_pdr_scripts_method' );



