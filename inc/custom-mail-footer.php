<?php

class Custom_Woomail_Designer extends Kadence_Woomail_Designer {
    /**
	 * Set up the footer content
	 */
	public function email_footer_content() {
		$content_width = Kadence_Woomail_Customizer::opt( 'content_width' );
		if ( empty( $content_width ) ) {
			$content_width = '600';
		}
		$content_width = str_replace( 'px', '', $content_width );
		$social_enable = Kadence_Woomail_Customizer::opt( 'footer_social_enable' );
		$social_links  = Kadence_Woomail_Customizer::opt( 'footer_social_repeater' );
		$social_links  = json_decode( $social_links );
		?>

<div class="terms-table-row">
    <a
        href="<?= __('/terms-and-conditions/#terms', 'rimrebellion') ?>"><?= __("Terms and conditions", 'rimrebellion') ?></a>
    <a href="<?= __('/privacy-policy/#privacy', 'rimrebellion') ?>"><?= __("GDPR", 'rimrebellion') ?></a>
</div>
<?php
	}
    
};
$custom_designer = new Custom_Woomail_Designer();

// Add your custom footer using the same instance
add_action('kadence_woomail_designer_email_footer', array($custom_designer, 'email_footer_content'), 100);