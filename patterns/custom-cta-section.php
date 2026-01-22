<?php

/**
 * Title: Custom CTA Section
 * Slug: hyring/custom-cta-section
 * Categories: call-to-action
 * Description: Custom call-to-action section with background image.
 *
 * @package WordPress
 * @subpackage Hyring
 * @since Hyring 1.0
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div id="download_links" style="padding:38px 10px !important;min-height:432px; gap:0px !important;width:100%;max-width:100%;background: url('<?php echo esc_url(get_theme_file_uri('assets/images/start_hiring_bg.jpg')); ?>') no-repeat bottom center;
background-size: cover; display: flex; flex-direction:column; align-items:center;justify-content:flex-end;">


  <style>
    @media (min-width: 676px) {
      #download_links {
        position: relative;
      }

      #download_links::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(4px);
        z-index: 0;
      }

      #download_links>* {
        position: relative;
        z-index: 1;
      }

      #download_links {
        background-position-y: center !important;
      }
    }
  </style>
  <p
    style="
        margin: 0px;
        color: #ffffff;
        margin-bottom: 16px;
        font-weight: 700;
        font-size: 26px;
        line-height: 34px;
      ">
    Start Hiring
  </p>

  <a target="_blank" style="margin:0px !important;" href="https://play.google.com/store/apps/details?id=ai.hyring.app"><img style="width: 227px" src="<?php echo esc_url(get_theme_file_uri('assets/images/google_play.svg')); ?>" alt="App Store"></a>
  <a target="_blank" style="margin:0px !important;" href="https://apps.apple.com/us/app/hyring-ai/id6502471201"><img style="width: 227px" src="<?php echo esc_url(get_theme_file_uri('assets/images/app_store.svg')); ?>" alt="App Store"></a>

</div>
<!-- /wp:group -->