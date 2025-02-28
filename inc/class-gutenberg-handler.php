<?php
/**
 * Gutenberg Handler
 * Handles the Controls and Settings for the Block Editor
 *
 * @package GutenBoot
 */

namespace GutenBoot;

use WP_Block_Editor_Context;

/**
 * Gutenberg Handler
 */
class Gutenberg_Handler {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_assets' ) );
		add_action( 'after_setup_theme', array( $this, 'block_theme_support' ), 50 );
		add_action( 'init', array( $this, 'register_block_pattern_categories' ) );
		add_filter( 'block_editor_settings_all', array( $this, 'restrict_gutenberg_ui' ), 10, 1 );
		add_filter( 'allowed_block_types_all', array( $this, 'restrict_block_types' ), 10, 2 );
	}

	/**
	 * Check if the current user is an administrator.
	 *
	 * @return bool
	 */
	private function is_admin(): bool {
		return current_user_can( 'activate_plugins' );
	}

	/**
	 * Enqueue the block editor assets that control the layout of the Block Editor.
	 */
	public function enqueue_block_assets() {
		new Asset_Loader( 'registerBlockVariations', Enqueue_Type::script, 'admin' );
		new Asset_Loader( 'editDefaultBlocks', Enqueue_Type::script, 'admin' );
		new Asset_Loader( 'unregisterBlocks', Enqueue_Type::script, 'admin', array( 'wp-edit-post' ) );
	}

	/**
	 * Init theme supports specific to the block editor.
	 */
	public function block_theme_support() {
		$opt_in_features = array(
			'responsive-embeds',
			'editor-styles',
		);
		foreach ( $opt_in_features as $feature ) {
			add_theme_support( $feature );
		}
		$opt_out_features = array(
			'core-block-patterns',
			'align-wide',
			'wp-block-styles',
		);
		foreach ( $opt_out_features as $feature ) {
			remove_theme_support( $feature );
		}
	}

	/**
	 * Register the block pattern category.
	 */
	public function register_block_pattern_categories() {
		$categories = array(
			'cno' => array(
				'bootstrap-layouts'    => array(
					'label'       => 'Bootstrap Layouts',
					'description' => 'pre-built layouts using Bootstrap',
				),
				'bootstrap-elements'   => array(
					'label'       => 'Bootstrap Elements',
					'description' => 'Bootstrap elements',
				),
				'bootstrap-components' => array(
					'label'       => 'Bootstrap Components',
					'description' => 'Bootstrap components (e.g. Accordion, Modal, etc.)',
				),
			),
			'twm' => array(
				'ui' => array(
					'label'       => 'UI Elements',
					'description' => 'UI elements',
				),
			),
		);
		foreach ( $categories as $namespace => $category ) {
			foreach ( $category as $slug => $args ) {
				register_block_pattern_category( "{$namespace}/{$slug}", $args );
			}
		}
	}

	/**
	 * Restrict access to the locking UI to Administrators.
	 *
	 * @param array $settings Default editor settings.
	 */
	public function restrict_gutenberg_ui( $settings, ) {
		$is_administrator = $this->is_admin();

		if ( ! $is_administrator ) {
			$settings['canLockBlocks']      = false;
			$settings['codeEditingEnabled'] = false;
		}

		return $settings;
	}

	/**
	 * Filters the list of allowed block types in the block editor.
	 *
	 * This function restricts the available block types to Heading, List, Image, and Paragraph only.
	 *
	 * @param array|bool $allowed_block_types Array of block type slugs, or boolean to enable/disable all.
	 * @param object     $block_editor_context The current block editor context.
	 *
	 * @return array|bool The array of allowed block types or boolean to enable/disable all.
	 */
	public function restrict_block_types( array|bool $allowed_block_types ): array|bool {
		$is_administrator = $this->is_admin();
		// Get all registered blocks if $allowed_block_types is not already set.
		if ( ! is_array( $allowed_block_types ) || empty( $allowed_block_types ) ) {
			$registered_blocks   = \WP_Block_Type_Registry::get_instance()->get_all_registered();
			$allowed_block_types = array_keys( $registered_blocks );
		}
		if ( $is_administrator ) {
			$disallowed_blocks = array(
				'core/archives',
				'core/avatar',
				'core/button',
				'core/buttons',
				'core/calendar',
				'core/categories',
				'core/comments',
				'core/comment-author-name',
				'core/comment-content',
				'core/comment-date',
				'core/comment-edit-link',
				'core/comment-reply-link',
				'core/comment-template',
				'core/comment-pagination-previous',
				'core/comments-author-avatar',
				'core/comments-pagination',
				'core/comments-pagination-next',
				'core/comments-pagination-numbers',
				'core/comments-title',
				'core/embed',
				'core/home-link',
				'core/file',
				'core/latest-comments',
				'core/latest-posts',
				'core/loginout',
				'core/missing',
				'core/navigation',
				'core/navigation-link',
				'core/navigation-submenu',
				'core/nextpage',
				'core/page-list-item',
				'core/page-list',
				'core/post-author',
				'core/post-author-biography',
				'core/post-author-name',
				'core/post-comment',
				'core/post-comments',
				'core/post-comments-count',
				'core/post-comments-form',
				'core/post-comments-link',
				'core/post-date',
				'core/post-navigation-link',
				'core/post-terms',
				'core/rss',
				'core/search',
				'core/site-logo',
				'core/site-tagline',
				'core/site-title',
				'core/social-link',
				'core/social-links',
				'core/spacer',
				'core/tag-cloud',
				'core/term-description',
				'core/video',
			);

			// Create a new array for the allowed blocks.
			$filtered_blocks = array();

			// Loop through each block in the allowed blocks list.
			foreach ( $allowed_block_types as $block ) {

				// Check if the block is not in the disallowed blocks list.
				if ( ! in_array( $block, $disallowed_blocks, true ) ) {

					// If it's not disallowed, add it to the filtered list.
					$filtered_blocks[] = $block;
				}
			}

			// Return the filtered list of allowed blocks
			return $filtered_blocks;
		}
		if ( ! $is_administrator ) {
			$allowed_block_types = array(
				'core/heading',
				'core/list',
				'core/image',
				'core/paragraph',
				'core/gallery',
				'core/shortcode',
				'core/freeform',
				'core/pattern',
				'core/table',
				'core/quote',
				'core/pullquote',
				'core/code',
				'core/html',
				'core/block',
				'core/buttons',
				'core/button',
				'gravityforms/form',
			);
			return $allowed_block_types;
		}
		return $allowed_block_types;
	}
}
