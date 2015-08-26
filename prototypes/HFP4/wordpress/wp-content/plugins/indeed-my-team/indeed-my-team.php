<?php
/*
Plugin Name: Indeed My Team
Plugin URI: http://www.wpindeed.com/
Description: The best looking and easy to use plugin that helps you to display your team in different showcases
Version: 2.4
Author: indeed
Author URI: http://www.wpindeed.com
*/


if( get_option('imt_post_type_slug')!==FALSE && get_option('imt_post_type_slug')!='' ){
  define('IMT_POST_TYPE', get_option('imt_post_type_slug'));
  if(IMT_POST_TYPE=='team') define('IMT_TAXONOMY', 'team_cats');
  else define('IMT_TAXONOMY', IMT_POST_TYPE.'_cats');
}else{
  define('IMT_POST_TYPE', 'team');
  define('IMT_TAXONOMY', 'team_cats');
}
define('IMT_DIR_PATH', plugin_dir_path(__FILE__));
define('IMT_DIR_URL', plugin_dir_url(__FILE__));

//LANGUAGES
add_action('init', 'imt_load_language');
function imt_load_language(){
  load_plugin_textdomain( 'imt', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}


///FUNCTIONS
include_once IMT_DIR_PATH . 'includes/functions.php';

add_action( 'init', 'imt_post_team' );
function imt_post_team() {
  $labels = array(
    'name'               => __('Members', 'imt'),
    'singular_name'      => __('Team', 'imt'),
    'add_new'            => __('Add New Member', 'imt'),
    'add_new_item'       => __('Add New Member', 'imt'),
    'edit_item'          => __('Edit Member', 'imt'),
    'new_item'           => __('New Member', 'imt'),
    'all_items'          => __('All Members', 'imt'),
    'view_item'          => __('View Member', 'imt'),
    'search_items'       => __('Search Team Member', 'imt'),
    'not_found'          => __('No Team Members available', 'imt'),
    'not_found_in_trash' => __('No Team Members found in Trash', 'imt'),
    'parent_item_colon'  => '',
    'menu_name'          => __('Team Members', 'imt')
  );
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 8,
    'menu_icon'          => IMT_DIR_URL . 'files/images/ed-gray.png',
    'supports'           => array( 'title', 'editor', 'thumbnail' )
  );
    register_post_type( IMT_POST_TYPE, $args );
}
////////////TAXONOMY
add_action( 'init', 'imt_taxonomy_team', 0 );
function imt_taxonomy_team() {
  $labels = array(
    'name'              => _x( 'Teams', 'taxonomy general name' ),
    'singular_name'     => _x( 'Team', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Teams', 'imt' ),
    'all_items'         => __( 'All Teams', 'imt' ),
    'parent_item'       => __( 'Parent Category', 'imt' ),
    'parent_item_colon' => __( 'Parent Category:', 'imt' ),
    'edit_item'         => __( 'Edit Team', 'imt' ),
    'update_item'       => __( 'Update Category', 'imt' ),
    'add_new_item'      => __( 'Add New Team', 'imt' ),
    'new_item_name'     => __( 'New Category Name', 'imt' ),
    'menu_name'         => __( 'Teams', 'imt' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => IMT_TAXONOMY ),
  );
register_taxonomy( IMT_TAXONOMY, IMT_POST_TYPE, $args );
}
///////////////SHORTCODE GENERATOR ( SUBMENU )
add_action( 'admin_menu', 'imt_shortcode_menu_team' );
function imt_shortcode_menu_team(){
    add_submenu_page( 'edit.php?post_type='.IMT_POST_TYPE, __('Shortcode Generator', 'imt'), __('Shortcode Generator', 'imt'), 'manage_options', 'team_shortcode_generator', 'imt_shortcode_page_team' );
    add_submenu_page( 'edit.php?post_type='.IMT_POST_TYPE, __('General Settings', 'imt'), __('General Settings', 'imt'), 'manage_options', 'imt_general_settings', 'imt_general_settings' );
}
function imt_shortcode_page_team(){
    include IMT_DIR_PATH . 'includes/imt_shortcode_generator.php';
}
function imt_general_settings(){
  include_once IMT_DIR_PATH .'includes/general_settings.php';
}



#Enable feature image for IMT_POST_TYPE
add_action( 'init', 'imt_theme_suport');
function imt_theme_suport(){
  $postTypes = get_theme_support( 'post-thumbnails' );
  if(isset($postTypes) && is_array($postTypes)){
    $postTypes[] = IMT_POST_TYPE;
    add_theme_support( 'post-thumbnails', $postTypes );
  }else{
    add_theme_support( 'post-thumbnails' );   
  }
}


/************************ META BOXES *************************/
    #PERSONAL INFOS
  add_action( 'add_meta_boxes', 'imt_cf_ti' );
    function imt_cf_ti(){
        add_meta_box('team_personal_info',
                     __('Personal Information', 'imt'),
                     'imt_metabox_ti', //function available in function.php
                     IMT_POST_TYPE,
                     'normal',
                     'high');
    }
    #SOCIAL MEDIA
    add_action( 'add_meta_boxes', 'imt_cf_tsm' );
    function imt_cf_tsm(){
        add_meta_box('indeed_team_sm',
                     __('Social Media', 'imt'),
                     'imt_metabox_tsm', //function available in function.php
                     IMT_POST_TYPE,
                     'normal',
                     'high');
    }
    #TEAM SKILLS
    add_action( 'add_meta_boxes', 'imt_cf_ts' );
    function imt_cf_ts(){
        add_meta_box('indeed_team_skills',
                     __('Skills', 'imt'),
                     'imt_metabox_ts', //function available in function.php
                     IMT_POST_TYPE,
                     'normal',
                     'high');
    }
  #FEATURE IMAGE
  add_action( 'add_meta_boxes', 'imt_cf_mp' );
    function imt_cf_mp(){
    remove_meta_box( 'postimagediv', IMT_POST_TYPE, 'side' );
        add_meta_box('postimagediv',
                     __('Member Picture', 'imt'),
                     'post_thumbnail_meta_box', 
                     IMT_POST_TYPE,
                     'side',
                     'low');
    }
    #SELECT AUTHOR
    add_action( 'add_meta_boxes', 'imt_select_author' );
    function imt_select_author(){
      add_meta_box('postexcerpt',
          __('Select an correlated Author', 'imt'),
          'imtSelectAuthorMetaBox',
          IMT_POST_TYPE,
          'normal',
          'high');
    }
add_action('save_post', 'imt_save_post_meta_values');
/************************ END OF META BOXES *************************/


////////SHORTCODE
add_shortcode( 'indeed-my-team', 'imt_shortcode_func_team' );
function imt_shortcode_func_team($attr){
    $return_str = true;
    include IMT_DIR_PATH . 'includes/imt_view.php';
    return $final_str;
}
////////WIDGET
class IndeedMyTeamWidget extends WP_Widget {
  function IndeedMyTeamWidget() {
    // Instantiate the parent object
    parent::__construct( false, 'Indeed My Team' );
  }
  function widget( $args, $instance ) {
      $current_instance_id = explode('-', $this->id);
    $instance_no = $current_instance_id[1];
        $attr = $instance;
        include IMT_DIR_PATH . 'includes/imt_view.php';
        global $wp_query;
        $a = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
  }
  function update( $new_instance, $old_instance ){
    $instance = $old_instance;
        $instance['color_scheme'] = $new_instance['color_scheme'];
        $instance['theme'] = $new_instance['theme'];
        $instance['show'] = $new_instance['show'];
        $instance['team'] = $new_instance['team'];
        $instance['limit'] = $new_instance['limit'];
        $instance['order'] = $new_instance['order'];
        $instance['order_by'] = $new_instance['order_by'];
        $instance['page_inside'] = $new_instance['page_inside'];
        $instance['inside_template'] = $new_instance['inside_template'];
        $instance['columns'] = $new_instance['columns'];
        //SLIDER
        $instance['slider_set'] = $new_instance['slider_set'];
        $instance['items_per_slide'] = $new_instance['items_per_slide'];
        $instance['slide_speed'] = $new_instance['slide_speed'];
        $instance['slide_pagination_speed'] = $new_instance['slide_pagination_speed'];
        $instance['slide_css_transition'] = $new_instance['slide_css_transition'];
        $instance['slide_opt'] = $new_instance['slide_opt'];
        return $instance;
  }
  function form( $instance ) {
        wp_enqueue_script( 'imt_js_functions', IMT_DIR_URL.'files/js/functions.js');
        wp_enqueue_style( 'imt_be_style', IMT_DIR_URL.'files/css/style.css');
      $current_instance_id = explode('-', $this->id);
    $instance_no = $current_instance_id[1];
        $div_id_pre = $this->id;
        include IMT_DIR_PATH.'includes/imt_widget_form.php';
  }
}
function register_IndeedMyTeamWidget() {
  register_widget( 'IndeedMyTeamWidget' );
}
add_action( 'widgets_init', 'register_IndeedMyTeamWidget' );


////STYLE AND JS
add_action('wp_enqueue_scripts', 'imt_fe_head');
function imt_fe_head(){
  wp_enqueue_style ( 'imt_font-awesome', IMT_DIR_URL.'files/css/font-awesome.min.css' );
  wp_enqueue_style ( 'imt_be_style', IMT_DIR_URL.'files/css/style.css' );
  wp_enqueue_style ( 'imt_owl_carousel_css', IMT_DIR_URL.'files/css/owl.carousel.css' );
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'imt_isotope_pkgd_min', IMT_DIR_URL.'files/js/isotope.pkgd.min.js', array(), null );
  wp_enqueue_script( 'imt_owl_carousel_js', IMT_DIR_URL.'files/js/owl.carousel.js', array(), null );

}
add_action("admin_enqueue_scripts", 'imt_be_head');
function imt_be_head(){
  $screen = get_current_screen();
    if( isset($screen->post_type) && $screen->post_type==IMT_POST_TYPE){
          wp_enqueue_style ( 'imt_font-awesome', IMT_DIR_URL.'files/css/font-awesome.min.css' );
          wp_enqueue_style ( 'imt_indeed_style', IMT_DIR_URL.'files/css/style.css' );
          wp_enqueue_style ( 'imt_owl.carousel', IMT_DIR_URL.'files/css/owl.carousel.css' );
          wp_enqueue_script( 'jquery' );
          wp_enqueue_script( 'imt_functions', IMT_DIR_URL.'files/js/functions.js', array(), null );
          wp_enqueue_script( 'imt_owl.carousel', IMT_DIR_URL.'files/js/owl.carousel.js', array(), null );
    }
}
//////


//////
add_filter( 'template_include', 'imt_page_template_func', 99 );
function imt_page_template_func( $template ) {
    if(get_post_type()==IMT_POST_TYPE && isset($_REQUEST['team_cpt']) && $_REQUEST['team_cpt']!=''){
      if($_REQUEST['team_cpt']=='IMT_PAGE_TEMPLATE'){
        //return our awesome page template
        return IMT_DIR_PATH.'includes/imt_page_template.php';
      }
        $template = urldecode($_REQUEST['team_cpt']);
        $template .= ".php";
      $new_template = locate_template( $template );
        return $new_template;
    }
    else return $template;
}



///Ajax change post type name
function imt_change_post_type(){
  if(isset($_REQUEST['post_name']) && $_REQUEST['post_name']!=''){
    if(get_option('imt_post_type_slug')!==FALSE) update_option('imt_post_type_slug', $_REQUEST['post_name']);
    else add_option('imt_post_type_slug', $_REQUEST['post_name']);
    echo $_REQUEST['post_name'];
  }
  die();
}
add_action('wp_ajax_imt_change_post_type', 'imt_change_post_type');
add_action('wp_ajax_nopriv_imt_change_post_type', 'imt_change_post_type');

///All custom post type admin dashboard
add_filter('manage_edit-'.IMT_POST_TYPE.'_columns', 'imt_image_admin_column');
function imt_image_admin_column($columns) {
  $new_columns['cb'] = '<input type="checkbox" />';
  $new_columns['title'] = __('Member Name', '');
  $new_columns['postimagediv'] = 'Member Picture';
  $new_columns['taxonomy-'.IMT_TAXONOMY] = 'Teams';
  $new_columns['date'] = _x('Date', 'column name');
  return $new_columns;
}

add_action('manage_posts_custom_column',  'imt_display_columns' );
function imt_display_columns($name) {
    global $post;
    $screen = get_current_screen();
    if($screen->post_type==IMT_POST_TYPE){
      switch($name){
          case 'postimagediv':
              $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail', false, '' );
              if($src!='') echo "<img src='{$src[0]}' width='50' height='50' title='{$post->post_title}'/>";
          break;
      }
    }
}


?>