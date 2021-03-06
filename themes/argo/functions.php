<?php
/**
 * Argo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Argo
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'argo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function argo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Argo, use a find and replace
		 * to change 'argo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'argo', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'portfolio-square', 800, 800, true );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Navbar', 'argo' ),
				'menu-2' => esc_html__( 'Footer', 'argo' ),

			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		// add_theme_support(
		// 	'custom-background',
		// 	apply_filters(
		// 		'argo_custom_background_args',
		// 		array(
		// 			'default-color' => 'ffffff',
		// 			'default-image' => '',
		// 		)
		// 	)
		// );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'argo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function argo_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'argo_content_width', 640 );
}
add_action( 'after_setup_theme', 'argo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function argo_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'argo' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'argo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
// add_action( 'widgets_init', 'argo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function argo_scripts() {
	// wp_enqueue_style( 'argo-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style('main-styles', get_template_directory_uri() . '/dist/bundle.css', array(), filemtime(get_template_directory() . '/dist/bundle.css'), false);

	wp_style_add_data( 'argo-style', 'rtl', 'replace' );

	wp_enqueue_script( 'argo-bundle', get_template_directory_uri() . '/dist/bundle.js', array(), _S_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'argo_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Remove emoji.
 */
require get_template_directory() . '/inc/remove-emoji.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*
 * Advanced Custom Fields Fields
 */

require get_template_directory() . '/inc/acf-fields.php';

add_action ( 'wp_head', 'putInHeader' );
function putInHeader() {

	//preload fonts
	foreach(glob(get_template_directory().'/fonts/*.woff2') as &$val) {
		$output_array = array();
		preg_match('/\/fonts\/.*/', $val, $output_array);
		echo '<link rel="preload" href="'.get_template_directory_uri().$output_array[0].'" as="font" type="font/woff2" crossorigin>';
	}

	// preload animations
	// if(is_front_page()) {
	// 	foreach(glob(get_template_directory().'/media/*.json') as &$val) {
	// 		$output_array = array();
	// 		preg_match('/\/media\/.*/', $val, $output_array);
	// 		echo '<link rel="preload" href="'.get_template_directory_uri().$output_array[0].'" as="fetch" crossorigin>';
	// 	}
	// }
}

add_shortcode('lottie-element', 'lottie_element_function');
function lottie_element_function($atts = array()) {
	$a = shortcode_atts( array(
		'file' => 'illustration'
 ), $atts );

	return '<div data-lottie data-animation-path="'.get_template_directory_uri().'/media/'.$a['file'].'.json"></div>';
}

add_filter('the_seo_framework_indicator', '__return_false');
