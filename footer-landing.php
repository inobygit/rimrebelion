<div id="copyright" class="copyright-left-right-center copyright-landing">
    <div class="container container-fluid">
        <div class="row">

            <div id="copyright-left" class="widget-area">
                <a href="<?= site_url() ?>">
                    <img src="<?= get_stylesheet_directory_uri() . '/assets/svg/logo-light.svg' ?>" alt="logo light">
                </a>
            </div>

            <?php if (is_active_sidebar("copyright-right")): ?>
            <div id="copyright-center" class="widget-area">
                <?php dynamic_sidebar("copyright-right"); ?>
            </div>
            <?php endif; ?>

            <div class="widget-area" id="copyright-right">
                <?php do_action("inoby_right_navigation_start"); ?>
                <?php if (
          is_plugin_active(
            "woocommerce-product-search/woocommerce-product-search.php",
          )
        ) { ?>
                <div id="lang-switcher" class="lang-switcher">
                    <?= do_shortcode('[wpml_language_selector_widget]') ?>
                </div>
                <div id="search-trigger" class="menu-search">
                    <a href="#0">
                        <img src="<?= get_theme_file_uri("/assets/icons/search-light.svg") ?>" alt="Hladať">
                    </a>
                </div>
                <?php } ?>
                <?php if (class_exists("WooCommerce")): ?>
                <div class="menu-account">
                    <?php if (!is_user_logged_in() && Inoby_Config::login_popup()): ?>
                    <a href="#0" class="xoo-el-login-tgr" title="<?= __(
            "Login / Register",
            "inoby",
          ) ?>"><img src="<?= get_theme_file_uri("/assets/icons/account-light.svg") ?>"
                            alt="<?= __("Login / Register", "inoby") ?>"></a>
                    <?php else: ?>
                    <a href="<?= get_permalink(
            get_option("woocommerce_myaccount_page_id"),
          ) ?>" title="<?= __("My Account", "inoby") ?>">
                        <img src="<?= get_theme_file_uri("/assets/icons/account-light.svg") ?>"
                            alt="<?= __("My Account", "inoby") ?>"></a>
                    <?php endif; ?>
                </div>
                <?php if (ESHOP_ENABLED): ?>
                <div class="menu-cart">
                    <a class="popup-trigger-btn" data-popup="cart-wrapper" href="#0">
                        <?php rc_cart_count(); ?>
                        <img src="<?= get_theme_file_uri(
              "/assets/icons/cart-light.svg",
            ) ?>" alt="<?= __("Cart", "inoby") ?>">
                    </a>
                </div>
                <?php endif; ?>
                <?php endif; ?>

            </div>

        </div>
    </div>

</div>
</div>
<?php wp_footer(); ?>
</body>

</html>