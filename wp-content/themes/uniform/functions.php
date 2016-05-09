<?php
/**
 * Uniform functions and definitions
 *
 * @package Uniform
 */

if ( ! function_exists( 'uniform_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function uniform_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Uniform, use a find and replace
	 * to change 'uniform' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'uniform', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'uniform' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'uniform_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // uniform_setup
add_action( 'after_setup_theme', 'uniform_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function uniform_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uniform_content_width', 640 );

	/**
	 * Crop image in required size
	 */
	add_image_size( 'uniform_single_default', 1040, 450, true );
	add_image_size( 'uniform_home_section_thumb', 300, 200, true );
}
add_action( 'after_setup_theme', 'uniform_content_width', 0 );

/**
 * Define Theme version
 */
    $my_theme = wp_get_theme();
    $theme_version = $my_theme->get( 'Version' );
    define( 'UNIFORM_THEME_VERSION', esc_attr( $theme_version ) );

/**
 * Defines required Directory
 */
define( 'UNIFORM_PARENT_DIR', get_template_directory() );
define( 'UNIFORM_CHILD_DIR', get_stylesheet_directory() );

define( 'UNIFORM_INCLUDES_DIR', UNIFORM_PARENT_DIR. '/inc' );
define( 'UNIFORM_CSS_DIR', UNIFORM_PARENT_DIR . '/css' );
define( 'UNIFORM_JS_DIR', UNIFORM_PARENT_DIR . '/js' );
define( 'UNIFORM_LANGUAGES_DIR', UNIFORM_PARENT_DIR . '/languages' );

define( 'UNIFORM_ADMIN_DIR', UNIFORM_INCLUDES_DIR . '/admin' );
define( 'UNIFORM_WIDGETS_DIR', UNIFORM_INCLUDES_DIR . '/widgets' );

define( 'UNIFORM_ADMIN_IMAGES_DIR', UNIFORM_ADMIN_DIR . '/images' );

define( 'UNIFORM_PANEL_DIR', UNIFORM_ADMIN_DIR . '/panels' );

/**
 * Define URL Location Constants
 */
define( 'UNIFORM_PARENT_URL', get_template_directory_uri() );
define( 'UNIFORM_CHILD_URL', get_stylesheet_directory_uri() );

define( 'UNIFORM_INCLUDES_URL', UNIFORM_PARENT_URL. '/inc' );
define( 'UNIFORM_CSS_URL', UNIFORM_PARENT_URL . '/css' );
define( 'UNIFORM_JS_URL', UNIFORM_PARENT_URL . '/js' );
define( 'UNIFORM_LANGUAGES_URL', UNIFORM_PARENT_URL . '/languages' );

define( 'UNIFORM_ADMIN_URL', UNIFORM_INCLUDES_URL . '/admin' );
define( 'UNIFORM_WIDGETS_URL', UNIFORM_INCLUDES_URL . '/widgets' );

define( 'UNIFORM_ADMIN_IMAGES_URL', UNIFORM_ADMIN_URL . '/images' );
 
/**
 * Implement the Custom Header feature.
 */
require_once ( UNIFORM_INCLUDES_DIR . '/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require ( UNIFORM_INCLUDES_DIR . '/template-tags.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require ( UNIFORM_INCLUDES_DIR . '/extras.php' );

/**
 * Customizer additions.
 */
require ( UNIFORM_INCLUDES_DIR . '/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
require ( UNIFORM_INCLUDES_DIR . '/jetpack.php' );

/**
 * Load uniform custom function file.
 */
require ( UNIFORM_INCLUDES_DIR . '/uniform-functions.php' );

/**
 * Add metabox for sidebar layout
 */
require ( UNIFORM_ADMIN_DIR. '/sidebar-metabox.php' ); // Call to Action widget

/**
 * Load uniform custom widget area and related functions.
 */
require ( UNIFORM_WIDGETS_DIR . '/uniform-widget-area.php' );

/**
 * Load widgets file.
 */
require ( UNIFORM_WIDGETS_DIR. '/uniform-widget-fields.php' ); // Widget fields
require ( UNIFORM_WIDGETS_DIR. '/uniform-cta.php' ); // Call to Action widget

/**
 * Load function sanitize file.
 */
require ( UNIFORM_ADMIN_DIR . '/uniform-sanitize.php' );

/**
 * Load custom classes file.
 */
require ( UNIFORM_ADMIN_DIR . '/uniform-custom-classes.php' );

/**
 * Load custom styles.
 */
//require UNIFORM_CSS_DIR . '/styles.php';

/**
 * Load uniform's required panels file
 */
require ( UNIFORM_PANEL_DIR . '/uniform-general.php' ); // Load general settings panel file
require ( UNIFORM_PANEL_DIR . '/uniform-header.php' ); // Load header settings panel file
require ( UNIFORM_PANEL_DIR . '/uniform-homepage.php' ); // Load homepage settings panel file
require ( UNIFORM_PANEL_DIR . '/uniform-design.php' ); // Load design settings panel file
require ( UNIFORM_PANEL_DIR . '/uniform-footer.php' ); // Load footer settings panel file



add_action( 'vfb_confirmation', 'vfb_action_confirmation', 10, 2 );
function vfb_action_confirmation( $form_id, $entry_id ){
	if ($form_id === 1) {
		$mobileNumberContainer = 0;
		$firstname = "";
		$lastname = "";
		if (isset($_POST['vfb-9'])) {
			$mobileNumberContainer = str_replace(" ", "", $_POST['vfb-9']);
			$_POST['vfb-9'] = $mobileNumberContainer;
		}
		$mobileNumberContainer = floatval($mobileNumberContainer);

		$curlURL = "http://data.dncsystem.website/index.php/dispo/accidentsurvey/".$mobileNumberContainer;
		$httpParams = array(
				"first_name"=>$_POST['vfb-5'],
				"last_name"=>$_POST['vfb-6'],
				"address1"=>"",
			);
		$curlURL .= "?".http_build_query($httpParams);
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		//$curlResRaw = curl_exec($curlres);
	}
}
add_filter( 'vfb_entries_save_new', 'vfb_filter_clean_mobile', 10, 2 );
function vfb_filter_clean_mobile( $save, $form_id ){    

		/**
		 * One submission a day implementation
		 */
		$entriestTable = 'wp_vfb_pro_entries';
		$currentIpAddress = $_SERVER['REMOTE_ADDR'];

		// PDO Connection to MySQL
		$conn = new PDO('mysql:host=localhost;dbname=worthadv_db', 'worthadv_db', 'hitman052529');
		$query = $conn->prepare("select count(entries_id) as numOfEntries from wp_vfb_pro_entries WHERE entry_approved = 1 and ip_address = '{$currentIpAddress}' and date(date_submitted) = date(NOW())");
		$query->execute();
		$queryResult = $query->fetch( PDO::FETCH_ASSOC );
		$numOfEntries = intval($queryResult['numOfEntries']);
		if ($numOfEntries >= 1) {
			$save = false;
		}
	if (isset($_POST['vfb-9']) && $form_id === 1) {
		$mobileNumberContainer = str_replace(" ", "", $_POST['vfb-9']);
		$_POST['vfb-9'] = $mobileNumberContainer;
	}
    return $save;
}