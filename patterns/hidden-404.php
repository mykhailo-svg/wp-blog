<?php

/**
 * Title: 404
 * Slug: hyring/hidden-404
 * Inserter: no
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Hyring 1.0
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:0;padding-left:0">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"verticalAlignment":"bottom"} -->
		<div class="wp-block-column is-vertically-aligned-bottom">
			<!-- wp:group {"layout":{"type":"default"}} -->
			<div class="wp-block-group">
				<!-- wp:heading {"level":1} -->
				<h1 class="wp-block-heading">
					<?php echo esc_html_x('Page not found', '404 error message', 'hyring'); ?>
				</h1>
				<!-- /wp:heading -->
				<!-- wp:paragraph -->
				<p><?php echo esc_html_x('The page you are looking for doesn\'t exist, or it has been moved.', '404 error message', 'hyring'); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->