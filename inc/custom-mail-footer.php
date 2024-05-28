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
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_footer_container">
    <tr>
        <td valign="top" align="center">
            <table border="0" cellpadding="10" cellspacing="0" width="<?php echo esc_attr( $content_width ); ?>"
                id="template_footer">
                <tr>
                    <td valign="top" id="template_footer_inside">
                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                            <?php if ( false != $social_enable && ! empty( $social_links ) && is_array( $social_links ) ) { ?>
                            <tr>
                                <td valign="top">
                                    <table id="footersocial" border="0" cellpadding="10" cellspacing="0" width="100%">
                                        <tr>
                                            <?php
														$items = count( $social_links );
														foreach ( $social_links as $social_link ) {
															?>
                                            <td valign="middle"
                                                style="text-align:center; width:<?php echo esc_attr( round( 100 / $items, 2 ) ); ?>%">
                                                <a href="<?php echo esc_url( $social_link->link ); ?>"
                                                    class="ft-social-link"
                                                    style="display:block; text-decoration: none;">
                                                    <?php
															if ( 'customizer_repeater_image' == $social_link->choice ) {
																echo '<img src="' . esc_attr( $social_link->image_url ) . '" width="24" style="vertical-align: bottom;">';
															} else if ( 'customizer_repeater_icon' == $social_link->choice ) {
																$img_string = str_replace( 'kt-woomail-', '', $social_link->icon_value );
																if ( isset( $social_link->icon_color ) && ! empty( $social_link->icon_color ) ) {
																	$color = $social_link->icon_color;
																} else {
																	$color = 'black';
																}
																echo '<img alt="' . esc_attr( $img_string ) . '" src="' . esc_attr( KT_WOOMAIL_URL . 'assets/images/' . $color . '/' . $img_string ) . '.png" width="24" style="vertical-align: bottom;">';
															}
															?>
                                                    <span
                                                        class="ft-social-title"><?php echo esc_html( $social_link->title ); ?></span>
                                                </a>
                                            </td>
                                            <?php
														}
														?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td valign="top">
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                        <tr>
                                            <td colspan="2" valign="middle" id="credit">
                                                <?php echo wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
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
add_action('kadence_woomail_designer_email_footer', array($custom_designer, 'email_footer_content'), 10);