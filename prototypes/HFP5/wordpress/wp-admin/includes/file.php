<?php
/**
 * Functions for reading, writing, modifying, and deleting files on the file system.
 * Includes functionality for theme-specific files as well as operations for uploading,
 * archiving, and rendering output when necessary.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** The descriptions for theme files. */
$wp_file_descriptions = array(
	'index.php' => __( 'Main Index Template' ),
	'style.css' => __( 'Stylesheet' ),
	'editor-style.css' => __( 'Visual Editor Stylesheet' ),
	'editor-style-rtl.css' => __( 'Visual Editor RTL Stylesheet' ),
	'rtl.css' => __( 'RTL Stylesheet' ),
	'comments.php' => __( 'Comments' ),
	'comments-popup.php' => __( 'Popup Comments' ),
	'footer.php' => __( 'Footer' ),
	'header.php' => __( 'Header' ),
	'sidebar.php' => __( 'Sidebar' ),
	'archive.php' => __( 'Archives' ),
	'author.php' => __( 'Author Template' ),
	'tag.php' => __( 'Tag Template' ),
	'category.php' => __( 'Category Template' ),
	'page.php' => __( 'Page Template' ),
	'search.php' => __( 'Search Results' ),
	'searchform.php' => __( 'Search Form' ),
	'single.php' => __( 'Single Post' ),
	'404.php' => __( '404 Template' ),
	'link.php' => __( 'Links Template' ),
	'functions.php' => __( 'Theme Functions' ),
	'attachment.php' => __( 'Attachment Template' ),
	'image.php' => __('Image Attachment Template'),
	'video.php' => __('Video Attachment Template'),
	'audio.php' => __('Audio Attachment Template'),
	'application.php' => __('Application Attachment Template'),
	'my-hacks.php' => __( 'my-hacks.php (legacy hacks support)' ),
	'.htaccess' => __( '.htaccess (for rewrite rules )' ),
	// Deprecated files
	'wp-layout.css' => __( 'Stylesheet' ),
	'wp-comments.php' => __( 'Comments Template' ),
	'wp-comments-popup.php' => __( 'Popup Comments Template' ),
);

/**
 * Get the description for standard WordPress theme files and other various standard
 * WordPress files
 *
 * @since 1.5.0
 *
 * @global array $wp_file_descriptions
 * @param string $file Filesystem path or filename
 * @return string Description of file from $wp_file_descriptions or basename of $file if description doesn't exist
 */
function get_file_description( $file ) {
	global $wp_file_descriptions;

	if ( isset( $wp_file_descriptions[basename( $file )] ) ) {
		return $wp_file_descriptions[basename( $file )];
	}
	elseif ( file_exists( $file ) && is_file( $file ) ) {
		$template_data = implode( '', file( $file ) );
		if ( preg_match( '|Template Name:(.*)$|mi', $template_data, $name ))
			return sprintf( __( '%s Page Template' ), _cleanup_header_comment($name[1]) );
	}

	return trim( basename( $file ) );
}

/**
 * Get the absolute filesystem path to the root of the WordPress installation
 *
 * @since 1.5.0
 *
 * @return string Full filesystem path to the root of the WordPress installation
 */
function get_home_path() {
	$home    = set_url_scheme( get_option( 'home' ), 'http' );
	$siteurl = set_url_scheme( get_option( 'siteurl' ), 'http' );
	if ( ! empty( $home ) && 0 !== strcasecmp( $home, $siteurl ) ) {
		$wp_path_rel_to_home = str_ireplace( $home, '', $siteurl ); /* $siteurl - $home */
		$pos = strripos( str_replace( '\\', '/', $_SERVER['SCRIPT_FILENAME'] ), trailingslashit( $wp_path_rel_to_home ) );
		$home_path = substr( $_SERVER['SCRIPT_FILENAME'], 0, $pos );
		$home_path = trailingslashit( $home_path );
	} else {
		$home_path = ABSPATH;
	}

	return str_replace( '\\', '/', $home_path );
}

/**
 * Returns a listing of all files in the specified folder and all subdirectories up to 100 levels deep.
 * The depth of the recursiveness can be controlled by the $levels param.
 *
 * @since 2.6.0
 *
 * @param string $folder Optional. Full path to folder. Default empty.
 * @param int    $levels Optional. Levels of folders to follow, Default 100 (PHP Loop limit).
 * @return bool|array False on failure, Else array of files
 */
function list_files( $folder = '', $levels = 100 ) {
	if ( empty($folder) )
		return false;

	if ( ! $levels )
		return false;

	$files = array();
	if ( $dir = @opendir( $folder ) ) {
		while (($file = readdir( $dir ) ) !== false ) {
			if ( in_array($file, array('.', '..') ) )
				continue;
			if ( is_dir( $folder . '/' . $file ) ) {
				$files2 = list_files( $folder . '/' . $file, $levels - 1);
				if ( $files2 )
					$files = array_merge($files, $files2 );
				else
					$files[] = $folder . '/' . $file . '/';
			} else {
				$files[] = $folder . '/' . $file;
			}
		}
	}
	@closedir( $dir );
	return $files;
}

/**
 * Returns a filename of a Temporary unique file.
 * Please note that the calling function must unlink() this itself.
 *
 * The filename is based off the passed parameter or defaults to the current unix timestamp,
 * while the directory can either be passed as well, or by leaving it blank, default to a writable temporary directory.
 *
 * @since 2.6.0
 *
 * @param string $filename Optional. Filename to base the Unique file off. Default empty.
 * @param string $dir      Optional. Directory to store the file in. Default empty.
 * @return string a writable filename
 */
function wp_tempnam( $filename = '', $dir = '' ) {
	if ( empty( $dir ) ) {
		$dir = get_temp_dir();
	}

	if ( empty( $filename ) || '.' == $filename || '/' == $filename ) {
		$filename = time();
	}

	// Use the basename of the given file without the extension as the name for the temporary directory
	$temp_filename = basename( $filename );
	$temp_filename = preg_replace( '|\.[^.]*$|', '', $temp_filename );

	// If the folder is falsey, use it's parent directory name instead
	if ( ! $temp_filename ) {
		return wp_tempnam( dirname( $filename ), $dir );
	}

	$temp_filename .= '.tmp';
	$temp_filename = $dir . wp_unique_filename( $dir, $temp_filename );
	touch( $temp_filename );

	return $temp_filename;
}

/**
 * Make sure that the file that was requested to edit, is allowed to be edited
 *
 * Function will die if if you are not allowed to edit the file
 *
 * @since 1.5.0
 *
 * @param string $file file the users is attempting to edit
 * @param array $allowed_files Array of allowed files to edit, $file must match an entry exactly
 * @return string|null
 */
function validate_file_to_edit( $file, $allowed_files = '' ) {
	$code = validate_file( $file, $allowed_files );

	if (!$code )
		return $file;

	switch ( $code ) {
		case 1 :
			wp_die( __( 'Sorry, that file cannot be edited.' ) );

		// case 2 :
		// wp_die( __('Sorry, can&#8217;t call files with their real path.' ));

		case 3 :
			wp_die( __( 'Sorry, that file cannot be edited.' ) );
	}
}

/**
 * Handle PHP uploads in WordPress, sanitizing file names, checking extensions for mime type,
 * and moving the file to the appropriate directory within the uploads directory.
 *
 * @since 4.0.0
 *
 * @see wp_handle_upload_error
 *
 * @param array       $file      Reference to a single element of $_FILES. Call the function once for each uploaded file.
 * @param array|false $overrides An associative array of names => values to override default variables. Default false.
 * @param string      $time      Time formatted in 'yyyy/mm'.
 * @param string      $action    Expected value for $_POST['action'].
 * @return array On success, returns an associative array of file attributes. On failure, returns
 *               $overrides['upload_error_handler'](&$file, $message ) or array( 'error'=>$message ).
*/
function _wp_handle_upload( &$file, $overrides, $time, $action ) {
	// The default error handler.
	if ( ! function_exists( 'wp_handle_upload_error' ) ) {
		function wp_handle_upload_error( &$file, $message ) {
			return array( 'error' => $message );
		}
	}

	/**
	 * Filter the data for a file before it is uploaded to WordPress.
	 *
	 * The dynamic portion of the hook name, `$action`, refers to the post action.
	 *
	 * @since 2.9.0 as 'wp_handle_upload_prefilter'.
	 * @since 4.0.0 Converted to a dynamic hook with `$action`.
	 *
	 * @param array $file An array of data for a single file.
	 */
	$file = apply_filters( "{$action}_prefilter", $file );

	// You may define your own function and pass the name in $overrides['upload_error_handler']
	$upload_error_handler = 'wp_handle_upload_error';
	if ( isset( $overrides['upload_error_handler'] ) ) {
		$upload_error_handler = $overrides['upload_error_handler'];
	}

	// You may have had one or more 'wp_handle_upload_prefilter' functions error out the file. Handle that gracefully.
	if ( isset( $file['error'] ) && ! is_numeric( $file['error'] ) && $file['error'] ) {
		return $upload_error_handler( $file, $file['error'] );
	}

	// Install user overrides. Did we mention that this voids your warranty?

	// You may define your own function and pass the name in $overrides['unique_filename_callback']
	$unique_filename_callback = null;
	if ( isset( $overrides['unique_filename_callback'] ) ) {
		$unique_filename_callback = $overrides['unique_filename_callback'];
	}

	/*
	 * This may not have orignially been intended to be overrideable,
	 * but historically has been.
	 */
	if ( isset( $overrides['upload_error_strings'] ) ) {
		$upload_error_strings = $overrides['upload_error_strings'];
	} else {
		// Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
		$upload_error_strings = array(
			false,
			__( 'The uploaded file exceeds the upload_max_filesize directive in php.ini.' ),
			__( 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.' ),
			__( 'The uploaded file was only partially uploaded.' ),
			__( 'No file was uploaded.' ),
			'',
			__( 'Missing a temporary folder.' ),
			__( 'Failed to write file to disk.' ),
			__( 'File upload stopped by extension.' )
		);
	}

	// All tests are on by default. Most can be turned off by $overrides[{test_name}] = false;
	$test_form = isset( $overrides['test_form'] ) ? $overrides['test_form'] : true;
	$test_size = isset( $overrides['test_size'] ) ? $overrides['test_size'] : true;

	// If you override this, you must provide $ext and $type!!
	$test_type = isset( $overrides['test_type'] ) ? $overrides['test_type'] : true;
	$mimes = isset( $overrides['mimes'] ) ? $overrides['mimes'] : false;

	// A correct form post will pass this test.
	if ( $test_form && ( ! isset( $_POST['action'] ) || ( $_POST['action'] != $action ) ) ) {
		return call_user_func( $upload_error_handler, $file, __( 'Invalid form submission.' ) );
	}
	// A successful upload will pass this test. It makes no sense to override this one.
	if ( isset( $file['error'] ) && $file['error'] > 0 ) {
		return call_user_func( $upload_error_handler, $file, $upload_error_strings[ $file['error'] ] );
	}

	$test_file_size = 'wp_handle_upload' === $action ? $file['size'] : filesize( $file['tmp_name'] );
	// A non-empty file will pass this test.
	if ( $test_size && ! ( $test_file_size > 0 ) ) {
		if ( is_multisite() ) {
			$error_msg = __( 'File is empty. Please upload something more substantial.' );
		} else {
			$error_msg = __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.' );
		}
		return call_user_func( $upload_error_handler, $file, $error_msg );
	}

	// A properly uploaded file will pass this test. There should be no reason to override this one.
	$test_uploaded_file = 'wp_handle_upl