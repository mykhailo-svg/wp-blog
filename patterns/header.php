<?php

/**
 * Title: Header
 * Slug: hyring/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Site header with site title and navigation.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Hyring 1.0
 */

?>
<!-- wp:group {"align":"full","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group custom_header_content">
		<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:image {"align":"left","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image alignleft size-full">
				<a class="site-logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
					<img src="<?php echo esc_url(get_theme_file_uri('assets/images/hyring-logo.png')); ?>" alt="<?php esc_attr_e('Hyring logo', 'hyring'); ?>" />
				</a>
			</figure>
			<!-- /wp:image -->
			<!-- <div class="custom_burger-menu">
				<div></div>
				<div></div>
				<div></div>
			</div> -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->