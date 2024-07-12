<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<?= '<h2>'. __( 'Account details' , 'rootscope' ) .'</h2>' ?>
<?= '<h5>'. __( 'Personal data' , 'rootscope' ) .'</h5>' ?>
<form class="woocommerce-EditAccountForm edit-account edit-account-form" action="" method="post"
    <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>

    <div class="woocommerce-address-fields">
        <div class="woocommerce-address-fields__field-wrapper">
            <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

            <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                <label for="account_first_name"><?php esc_html_e( 'First name', 'rootscope' ); ?>&nbsp;<abbr
                        class="required" title="required">*</abbr></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                    name="account_first_name" id="account_first_name" autocomplete="given-name"
                    placeholder="<?php esc_html_e( 'First name', 'rootscope' ); ?>"
                    value="<?php echo esc_attr( $user->first_name ); ?>" />
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                <label for="account_last_name"><?php esc_html_e( 'Last name', 'rootscope' ); ?>&nbsp;<abbr
                        class="required" title="required">*</abbr></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name"
                    id="account_last_name" autocomplete="family-name"
                    placeholder="<?php esc_html_e( 'Last name', 'rootscope' ); ?>"
                    value="<?php echo esc_attr( $user->last_name ); ?>" />
            </p>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="account_display_name"><?php esc_html_e( 'My nickname', 'rootscope' ); ?>&nbsp;<abbr
                        class="required" title="required">*</abbr></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                    name="account_display_name" id="account_display_name"
                    value="<?php echo esc_attr( $user->display_name ); ?>"
                    placeholder="<?php esc_html_e( 'My nickname', 'rootscope' ); ?>" />
                <span class="message">
                    <?= __('This is how your name will appear in the account section and in reviews.', 'inoby') ?>
                </span>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="account_email"><?php esc_html_e( 'Email', 'rootscope' ); ?>&nbsp;<abbr class="required"
                        title="required">*</abbr></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email"
                    id="account_email" autocomplete="email" placeholder="<?php esc_html_e( 'Email', 'rootscope' ); ?>"
                    value="<?php echo esc_attr( $user->user_email ); ?>" />
            </p>

            <?php do_action( 'woocommerce_edit_account_form' ); ?>


        </div>
    </div>



    <fieldset class="change-password">
        <h5><?php esc_html_e("Change password", "woocommerce"); ?></h5>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
            <label for="password_current" class="inplace-label"><?php esc_html_e("Actual password", "inoby"); ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                name="password_current" id="password_current" autocomplete="off"
                placeholder="<?php esc_html_e("Actual password", "inoby"); ?>" />
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
            <label for="password_1" class="inplace-label"><?php esc_html_e("New password", "inoby"); ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1"
                id="password_1" autocomplete="off" placeholder="<?php esc_html_e("New password", "inoby"); ?>" />
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
            <label for="password_2" class="inplace-label"><?php esc_html_e("New password again", "inoby"); ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2"
                id="password_2" autocomplete="off" placeholder="<?php esc_html_e("New password again", "inoby"); ?>" />
        </p>
    </fieldset>

    <?php do_action("woocommerce_edit_account_form"); ?>

    <p>
        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
        <button type="submit" class="woocommerce-Button button triangleBoth black" name="save_account_details"
            value="<?php esc_attr_e( 'Save changes', 'rootscope' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
        <input type="hidden" name="action" value="save_account_details" />
    </p>

    <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>