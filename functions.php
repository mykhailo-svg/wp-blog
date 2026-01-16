<?php
/**
 * Hyring functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Hyring 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'hyring_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Hyring 1.0
	 *
	 * @return void
	 */
	function hyring_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'hyring_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'hyring_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Hyring 1.0
	 *
	 * @return void
	 */
	function hyring_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'hyring_editor_style' );

// Enqueues the theme stylesheet on the front.
if ( ! function_exists( 'hyring_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since Hyring 1.0
	 *
	 * @return void
	 */
	function hyring_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'hyring-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'hyring-style',
			'path',
			get_parent_theme_file_path( $src )
		);

		// Enqueue dedicated header stylesheet
		wp_enqueue_style(
			'hyring-header',
			get_theme_file_uri( 'assets/css/header.css' ),
			array( 'hyring-style' ),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'hyring-header',
			'path',
			get_theme_file_path( 'assets/css/header.css' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'hyring_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'hyring_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Hyring 1.0
	 *
	 * @return void
	 */
	function hyring_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'hyring' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'hyring_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'hyring_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Hyring 1.0
	 *
	 * @return void
	 */
	function hyring_pattern_categories() {

		register_block_pattern_category(
			'hyring_page',
			array(
				'label'       => __( 'Pages', 'hyring' ),
				'description' => __( 'A collection of full page layouts.', 'hyring' ),
			)
		);

		register_block_pattern_category(
			'hyring_post-format',
			array(
				'label'       => __( 'Post formats', 'hyring' ),
				'description' => __( 'A collection of post format patterns.', 'hyring' ),
			)
		);
	}
endif;
add_action( 'init', 'hyring_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'hyring_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Hyring 1.0
	 *
	 * @return void
	 */
	function hyring_register_block_bindings() {
		register_block_bindings_source(
			'hyring/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'hyring' ),
				'get_value_callback' => 'hyring_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'hyring_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'hyring_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Hyring 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function hyring_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
