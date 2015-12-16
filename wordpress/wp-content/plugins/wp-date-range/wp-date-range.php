<?php
/*
Plugin Name: WP Date Range
Plugin URL: 
Description: Date range
Version: 1.2
Author: sevy
Author URL: 
*/


if ( !function_exists('add_action') ) :
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit();
endif;


define( 'DATE_RANGE_BASEDIR', dirname( plugin_basename(__FILE__) ) );
define( 'DATE_RANGE_FROM', 'metafrom' );
define( 'DATE_RANGE_TO', 'metato' );
define( 'DATE_RANGE_OPTION', 'date_range_options' );
define( 'DATE_RANGE_NONCE', 'wpdaterange' );
define( 'DATE_RANGE_PAGE', 'date_range_setting' );


class wp_date_range {

  var $dateFormat;
  var $language;
  var $separator;
  var $template;
  var $langcode;
  var $sepcode;
  var $formatcode;
  var $postTypes;

  function __construct() {

	$this->formatcode = array('m/d/Y' => 'mm dd yyyy', 'd/m/Y' => 'dd mm yyyy', 'Y/m/d' => 'yyyy mm dd');
	$this->sepcode = array('/', '-', '.');
	
	$this->langcode = array(
	  'af' => 'Afrikaans',
	  'ar-DZ' => 'Algerian Arabic',
	  'ar' => 'Arabic',
	  'az' => 'Azerbaijani',
	  'bg' => 'Bulgarian',	
	  'bs' => 'Bosnian',	
	  'ca' => 'Català',	
	  'da' => 'Danish',	
	  'de' => 'German',	
	  'el' => 'Greek',	
	  'en-AU' => 'English/Australia',	
	  'en-GB' => 'English/New Zealand',
	  'en-US' => 'English/US',
	  'eo' => 'Esperanto',	
	  'es' => 'Español',	
	  'et' => 'Estonian',
	  'eu' => 'Euskarako',	
	  'fa' => 'Persian',
	  'fi' => 'Finnish',
	  'fo' => 'Faroese',	
	  'fr-CH' => 'Swiss-French',	
	  'fr' => 'French',
	  'gl' => 'Galician',	
	  'he' => 'Hebrew',
	  'hr' => 'Croatian',
	  'hu' => 'Hungarian',	
	  'hy' => 'Armenian',	
	  'id' => 'Indonesian',
	  'is' => 'Icelandic',	
	  'it' => 'Italian',
	  'ja' => 'Japanese',
	  'ko' => 'Korean',	
	  'kz' => 'Kazakh',	
	  'lt' => 'Lithuanian',	
	  'lv' => 'Latvian',	
	  'ml' => 'Malayalam',	
	  'ms' => 'Malaysian',
	  'nl' => 'Dutch',	
	  'no' => 'Norwegian',	
	  'pl' => 'Polish',	
	  'pt-BR' => 'Brazilian',	
	  'pt' => 'Portuguese',	
	  'rm' => 'Romansh',	
	  'ro' => 'Romanian',	
	  'ru' => 'Russian',	
	  'sk' => 'Slovak',	
	  'sl' => 'Slovenian',	
	  'sq' => 'Albanian',	
	  'sr-SR' => 'Serbian',	
	  'sr' => 'Serbian',	
	  'sv' => 'Swedish',	
	  'ta' => 'Tamil',	
	  'th' => 'Thai',	
	  'tj' => 'Tajiki',	
	  'tr' => 'Turkish',	
	  'uk' => 'Ukrainian',	
	  'vi' => 'Vietnamese',	
	  'zh-CN' => 'Chinese',	
	  'zh-HK' => 'Chinese',
	  'zh-TW' => 'Chinese'
	);
		
	$options = $this->getOptions();	
    $this->dateFormat = $options['post_format'];
	$this->separator = $options['post_separator'];
	$this->language = $options['post_lang'];
	$this->postTypes = $options['post_types'];
	
	if (is_array($options['post_types'])) {
	  $this->postTypes = $options['post_types'];	
	} else {
	  $this->postTypes = array();	
	}


	if ( is_admin() ) {
	
	  add_action( 'admin_init', array(&$this, 'admin_init') );

	  add_action( 'admin_enqueue_scripts', array(&$this, 'enqueue_script'), 20 );
	  add_action( 'admin_head', array(&$this, 'enqueue_style') );
	  add_action( 'admin_print_scripts', array(&$this, 'admin_print_js'), 30 );

	  add_action( 'save_post', array(&$this, 'save_post') );

	  add_action('admin_menu', array(&$this, 'custom_option') );

	  add_filter( 'plugin_row_meta', array(&$this, 'settings_date_range' ), 10, 2 );

	  register_activation_hook( __FILE__, array(&$this, 'install') );
	  register_deactivation_hook( __FILE__, array(&$this, 'uninstall') );
	  //register_uninstall_hook( __FILE__, array(&$this, 'uninstall') );

	} else {
		
	  add_action( 'template_include', array(&$this, 'date_range_template'), 999 );	
	  add_action( 'posts_join' , array(&$this, 'date_range_join') );
	  add_action( 'posts_where', array(&$this, 'date_range_where') ); 
	  add_action( 'pre_get_posts', array(&$this, 'pre_date_range') );

	}
	
	add_action( 'init', array(&$this, 'init') );

  }


  public function getOptions() {

    //default data	
	$opt = array();
    $opt['post_format'] = array('m'=> 0, 'd' => 1, 'Y' => 2);
	$opt['post_separator'] = '/';
	$opt['post_lang'] = 'en-US';
	$opt['post_types'] = array();
	$opt['post_delall'] = 0;
	$opt['post_deltype'] = 0;


	if ( $options = get_option(DATE_RANGE_OPTION) ) {
	  if ($options != '') {
	    $opt = maybe_unserialize($options);
	  }
	}

	return $opt;

  }


  public function getPostTypeFromTemplateFile() {
	
	$postType = '';
	if ($this->template != '') {
	  $postType = str_replace('.php', '', str_replace('archive-', '', end(explode( '/', $this->template)))); 	  
	}

	return $postType;

  }


  public function date_range_template($template) {

	$this->template = $template;
		
	return $template;
  }


  public function admin_init() {
				
	$post_types = get_post_types();
		
	if ( $post_types ) {

	  foreach ( $post_types as $post_type ) {
		  
		if (in_array($post_type, $this->postTypes)) {
		  add_meta_box( 'daterange', __( 'Date range', 'wp-date_range' ), array(&$this, 'metabox'), $post_type, 'side' );
		}
	  }

	}

  }



  public function enqueue_script() {
	
	//http://codex.wordpress.org/Function_Reference/wp_enqueue_script
	wp_enqueue_script('jquery' );
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
/*	
	wp_enqueue_script( 'wp-daterange-localize', WP_PLUGIN_URL . '/' . DATE_RANGE_BASEDIR . '/js/jquery.ui.datepicker-fr.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker') );
*/
    if (!($this->dateFormat == 'en-US' || $this->dateFormat == '')) {
      wp_enqueue_script( 'wp-daterange-localize', WP_PLUGIN_URL . '/' . DATE_RANGE_BASEDIR . '/js/jquery-ui-i18n.min.custom.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker') );
	}
	
	wp_enqueue_script( 'wp-daterange', WP_PLUGIN_URL . '/' . DATE_RANGE_BASEDIR . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker') );

  }


  public function enqueue_style() {	
	
	wp_enqueue_style( 'wp-css-jquery-ui', WP_PLUGIN_URL . '/' . DATE_RANGE_BASEDIR . '/css/smoothness/jquery-ui-1.8.11.custom.css' );
	wp_enqueue_style( 'wp-css-jquery-ui-custom', WP_PLUGIN_URL . '/' . DATE_RANGE_BASEDIR . '/css/wp-daterange.css' );
	
  }


  public function admin_print_js(){
  
    $df = array_flip($this->dateFormat);
  
	echo '<script type="text/javascript">
jQuery(function($){
  $(\'.datepicker\').datepicker();';
    if (!($this->dateFormat == 'en-US' || $this->dateFormat == '')) {
	  echo '$.datepicker.setDefaults($.datepicker.regional[\'' . $this->language . '\']);';
	}
	echo '$.datepicker.setDefaults({dateFormat: \'' . strtolower(str_repeat($df[0], 2)) . $this->separator . strtolower(str_repeat($df[1], 2)) . $this->separator . strtolower(str_repeat($df[2], 2)) . '\'});';
echo '});	
</script>';
  }




  public function custom_option() {
  	add_options_page( __( 'Date range settings', 'wp-date_range' ), __( 'Date range settings', 'wp-date_range' ), 'manage_options', DATE_RANGE_PAGE, array($this, 'date_range_setting'));
  }

  public function date_range_setting() {

	global $wpdb;

    $msg = '';

	if (isset($_POST[DATE_RANGE_NONCE . '_nonce'])) {

	  if ( !wp_verify_nonce( $_POST[DATE_RANGE_NONCE . '_nonce'], DATE_RANGE_NONCE ) ) {
		return;
	  }
  
  
  	  $data = $_POST['pagemeta'];

	  $fdata = explode('/', $_POST['page_format']);
	  if (count($fdata) == 3) {
	    $data['post_format'] = array($fdata[0] => 0, $fdata[1] => 1, $fdata[2] => 2);
	  }
  
	  update_option(DATE_RANGE_OPTION, serialize($data));
	  
	  $options = $this->getOptions();
	  
	  if ($options['post_deltype']) {

		$post_types = get_post_types();
		if ( $post_types ) {
		  foreach ( $post_types as $post_type ) {
			  
			if (!in_array($post_type, $options['post_types'])) {
			  $q = "
				  DELETE a 
				  FROM " . $wpdb->prefix . "postmeta AS a
				  JOIN (   
					SELECT postmeta.meta_id FROM wp_postmeta postmeta
					INNER JOIN " . $wpdb->prefix . "posts posts ON postmeta.post_id = posts.ID
					WHERE (postmeta.meta_key = '" . DATE_RANGE_FROM . "' OR postmeta.meta_key = '" . DATE_RANGE_TO . "') AND posts.post_type = '" . $post_type . "'
				  ) AS b ON b.meta_id = a.meta_id
				  ";
			  
			  $wpdb->query($q);
			  
			} 

		  }
		}

	  }



      $msg = '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' . __('Settings saved.') . '</strong></p></div>';

	}

    include_once( 'admin-panel.php' );

  }


  public function metabox( $post ) {
	
	global $wpdb;

    wp_nonce_field( DATE_RANGE_NONCE, DATE_RANGE_NONCE . '_nonce' );
	
	$from = '';
	$to = '';
	
	$ufrom = get_post_meta( $post->ID, DATE_RANGE_FROM, TRUE );
	$uto = get_post_meta( $post->ID, DATE_RANGE_TO, TRUE );
	
	
	$df = array_flip($this->dateFormat);
	
	if ($ufrom != '') {
	  $from = date($df[0] . $this->separator . $df[1] . $this->separator . $df[2], $ufrom);
	}

	if ($uto != '') {
	  $to = date($df[0] . $this->separator . $df[1] . $this->separator . $df[2], $uto);
	}

	include_once( 'meta-box-panel.php' );

  }



  public function save_post( $post_id ) {
		
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  {
	  return;
	}

    
	if ( !wp_verify_nonce( $_POST[DATE_RANGE_NONCE . '_nonce'], DATE_RANGE_NONCE) ) {
	  return;
    }


    $from = '';
	$ufrom = '';
	
	if (!empty($_POST[DATE_RANGE_FROM])) {
	  $from = $_POST[DATE_RANGE_FROM];
	  //$d = explode($this->separator, $from);
	  $d = preg_split( '/[-.\/]/', $from);
      $ufrom = mktime(0, 0, 0, $d[$this->dateFormat['m']], $d[$this->dateFormat['d']], $d[$this->dateFormat['Y']]);
 
	}
	
	$to = '';
	$uto = '';
	
	if (!empty($_POST[DATE_RANGE_TO])) {
	  $to = $_POST[DATE_RANGE_TO];
	  //$d = explode($this->separator, $to);
	  $d = preg_split( '/[-.\/]/', $to);
	  //mktime(0, 0, 0, $month, $day, $year);
      $uto = mktime(23, 59, 59, $d[$this->dateFormat['m']], $d[$this->dateFormat['d']], $d[$this->dateFormat['Y']]);
	 
	}

	update_post_meta( $post_id, DATE_RANGE_FROM, $ufrom );
	update_post_meta( $post_id, DATE_RANGE_TO, $uto );
 
  }


  public function settings_date_range( $links, $file ) {
	  
	$plugin = plugin_basename( __FILE__ );
	if ( $file == $plugin ) {
	  return array_merge($links, array( '<a href="' . admin_url( 'options-general.php?page=' . DATE_RANGE_PAGE ) . '">' . __('Settings', 'wp-date_range' ) . '</a>' ));
	}
	return $links; 
	
  }



  public function init() {
  	  
	load_plugin_textdomain( 'wp-date_range', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );

  }



  public function install() {
	  
  }


  public function uninstall() {
	
	global $wpdb;	
	
	$options = $this->getOptions();

	if ($options['post_delall']) {
		
	  $wpdb->delete($wpdb->prefix . 'postmeta', array( 'meta_key' => DATE_RANGE_FROM ));
	  $wpdb->delete($wpdb->prefix . 'postmeta', array( 'meta_key' => DATE_RANGE_TO ));
	  
	}
	
  }


  //http://stackoverflow.com/questions/5785857/showing-posts-between-a-certain-date-range
  //http://wordpress.stackexchange.com/questions/34016/using-custom-meta-query-with-relation-not-working-as-expected
  
  public function date_range_join($join) {

  	
  
	global $wpdb;
 
	$join .= " LEFT JOIN " . $wpdb->prefix . "postmeta postmeta_" . DATE_RANGE_FROM . " ON " . $wpdb->prefix . "posts.ID = postmeta_" . DATE_RANGE_FROM . ".post_id AND postmeta_" . DATE_RANGE_FROM . ".meta_key = '"  . DATE_RANGE_FROM . "' ";
	$join .= " LEFT JOIN " . $wpdb->prefix . "postmeta postmeta_" . DATE_RANGE_TO . " ON " . $wpdb->prefix . "posts.ID = postmeta_" . DATE_RANGE_TO . ".post_id AND postmeta_" . DATE_RANGE_TO . ".meta_key = '"  . DATE_RANGE_TO . "' ";

	return $join;

	

  }
  



  public function date_range_where( $where) {

  	
  
	$where .= " AND (
	  
	  (
		CAST(postmeta_" . DATE_RANGE_FROM . ".meta_value AS UNSIGNED) <= CAST(UTC_TIMESTAMP() AS UNSIGNED)
		AND
		CAST(postmeta_" . DATE_RANGE_TO . ".meta_value AS UNSIGNED) >= CAST(UTC_TIMESTAMP() AS UNSIGNED)
	  )
	  OR
	  (
		CAST(postmeta_" . DATE_RANGE_FROM . ".meta_value AS UNSIGNED) <= CAST(UTC_TIMESTAMP() AS UNSIGNED)
		AND
		IFNULL(postmeta_" . DATE_RANGE_TO . ".meta_value, '') = ''
	  )
	  OR
	  (
		IFNULL(postmeta_" . DATE_RANGE_FROM . ".meta_value, '') = ''
		AND
		CAST(postmeta_" . DATE_RANGE_TO . ".meta_value AS UNSIGNED) >= CAST(UTC_TIMESTAMP() AS UNSIGNED)
	  )
	  OR
	  (
		IFNULL(postmeta_" . DATE_RANGE_FROM . ".meta_value, '') = ''
		AND
		IFNULL(postmeta_" . DATE_RANGE_TO . ".meta_value, '') = ''
	  )
	
	)";


	
	return $where;
  
  }


  
  public function pre_date_range($query) {
  
    /*
	echo '1-' . $_GET['post_type'] . ' - 2-' . $query->query_vars['post_type'] . ' - 3-' . $query->get( 'post_type' ) . ' - 4-' . get_query_var('post_type');
	echo ' - 5-' . $query->is_main_query() . ' - 6-' . get_option('page_for_posts') . ' - 7-';
	echo $this->getPostTypeFromTemplateFile() . ' - 8-' . is_archive() . ' - 9-' . $query->is_main_query();
    */

	
	if (!(
	    (
		  (
		       (get_option('page_for_posts') == get_queried_object_id())
		    || (is_archive() && $query->query_vars['post_type'] == '')
  		  ) 
		  && in_array('post', $this->postTypes) && $query->is_main_query() == 1
  		)
	    ||
	    (
	         in_array($query->query_vars['post_type'], $this->postTypes)
		  || in_array($query->get['post_type'], $this->postTypes)
		  || in_array(@$_GET['post_type'], $this->postTypes)
		  || in_array(get_query_var('post_type'), $this->postTypes)
		  || in_array($this->getPostTypeFromTemplateFile(), $this->postTypes)
	    )
		||
		(
		  is_search()
		)
		||
		(
		  $query->is_feed 
		)
		
	) && !is_admin()) {

	  remove_action('posts_join' , array(&$this, 'date_range_join'));
	  remove_action('posts_where', array(&$this, 'date_range_where'));
	  
	}
	
	
  }
  

}


$wpdaterange = new wp_date_range();

?>