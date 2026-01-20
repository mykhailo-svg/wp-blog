<?php

/**
 * Title: More posts
 * Slug: hyring/more-posts
 * Description: Displays a list of posts with title and date.
 * Categories: query
 * Block Types: core/query
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Hyring 1.0
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60); margin-top:32px; margin-bottom:32px;">
	<!-- wp:heading {"align":"wide","style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"700","letterSpacing":"1.4px"}},"fontSize":"small"} -->
	<h2 class="wp-block-heading alignwide has-small-font-size" style="font-style:normal;font-weight:700;letter-spacing:1.4px;text-transform:uppercase; font-size: 26px !important"><?php esc_html_e('Recommended articles', 'hyring'); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","style":{"spacing":{"margin":{"top":"16px"}}},"layout":{"type":"default"}} -->
	<div style="margin-top: 16px;" class="wp-block-query alignwide">
		<!-- wp:post-template {"align":"full","style":{"spacing":{"blockGap":"32px"}},"layout":{"type":"default"}} -->

		<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/1.2","style":{"border":{"radius":"12px"}}} /-->
		<!-- wp:post-title {"isLink":true,"style":{"spacing":{"margin":{"top":"12px","bottom":"4px"}},"typography":{"fontSize":"36px","fontWeight":"700","lineHeight":"29px"},"color":{"text":"#292E3D"}}} /-->
		<!-- wp:post-excerpt {"moreText":"","showMoreOnNewLine":false,"excerptLength":40,"style":{"spacing":{"margin":{"top":"4px"}},"typography":{"fontSize":"17px","lineHeight":"22px","fontWeight":"400"},"color":{"text":"#667399"}}} /-->

		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->