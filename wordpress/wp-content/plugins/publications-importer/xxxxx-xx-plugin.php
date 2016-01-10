<?php
/*
Plugin Name: XXXXX-XX Plugin
Plugin URI: 
Description: 
Version: 1.2
Author: Francisco Maria Calisto
Author Email: francisco.mcalisto@gmail.com
*/
require_once 'xxxxx-xx.php';
//require_once 'xxxxx-xx-calls.php'; // Might not be needed

class InescIDPlugin {


	const name = 'XXXXX-XX Plugin';
	const slug = 'xxxxx-xx_plugin';
	
	/**
	 * Constructor
	 */
	function __construct() {
		register_activation_hook( __FILE__, array( &$this, 'install_xxxxx_xx_plugin' ) );


		add_action( 'init', array( &$this, 'init_xxxxx_xx_plugin' ) );
	}
  

	function install_xxxxx_xx_plugin() {

	}

	function init_xxxxx_xx_plugin() {
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

		$this->register_scripts_and_styles();


		add_shortcode( 'xxxxx-xx', array( &$this, 'render_shortcode' ) );
	
		if ( is_admin() ) {
			
		} else {
			
		}  
	}


	function render_shortcode($atts) {
		/*extract(shortcode_atts(array(
			'what' => '', 
			'cc' => ''
			), $atts));
      */
    renderXXXXXID($input, $atts);
	}
  

	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			$this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
			$this->load_file( self::slug . '-admin-style', '/css/admin.css' );
		} else {
			$this->load_file( self::slug . '-script', '/js/widget.js', true );
			$this->load_file( self::slug . '-style', '/css/widget.css' );
		}
	} 
	

	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} 
		} 

	} 
  
}
new InescIDPlugin();

?>