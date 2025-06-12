<div class="header">
    <div class="container">
        <div class="row">

            <div class="top-menu">
                <?php wp_nav_menu(["theme_location" => "primary"]); ?>
            </div>
            <?php
      $logo = rwmb_meta("main-logo", ["object_type" => "setting"], "options");
      if (empty($logo)): ?>
            <div class="logo"><a href="<?= get_home_url() ?>">
                    <?= __("Home") ?>
                </a></div>
            <?php else: ?>
            <div class="custom-logo"><a href="<?= get_home_url() ?>">
                    <?= __("Home") ?>
                    <?= mb_inoby_picture($logo, "o-6", [], 0, "Logo", false) ?>
                </a>
            </div>
            <?php endif;
      ?>
            <div class="right-navigation">
                <?php do_action("inoby_right_navigation_start"); ?>
                <div id="lang-switcher" class="lang-switcher">
                    <?= do_shortcode('[wpml_language_selector_widget]') ?>
                </div>
                <div id="search-trigger" class="menu-search">
                    <a href="#0">
                        <img loading="lazy" width="15px" height="15px"
                            src="<?= get_theme_file_uri("/assets/icons/search.svg") ?>" alt="Hladať">
                    </a>
                </div>
                <?php if (ESHOP_ENABLED && is_user_logged_in() && Inoby_Config::wishlist()) { echo '<a href="/wishlist/"><img style="max-width:48px;" src="'. get_theme_file_uri("/assets/icons/heart.svg") .'"
        alt="'.__("Wishlist", "inoby") .'"></a>'; } ?>
                <?php if (class_exists("WooCommerce")): ?>
                <div class="menu-account">
                    <?php if (!is_user_logged_in() && Inoby_Config::login_popup()): ?>
                    <a href="#0" class="xoo-el-login-tgr" title="<?= __(
            "Login / Register",
            "inoby",
          ) ?>"><img loading="lazy" width="15px" height="12px"
                            src="<?= get_theme_file_uri("/assets/icons/person.svg") ?>"
                            alt="<?= __("Login / Register", "inoby") ?>"></a>
                    <?php else: ?>
                    <a href="<?= get_permalink(
            get_option("woocommerce_myaccount_page_id"),
          ) ?>" class="logged-in" title="<?= __("My Account", "inoby") ?>">
                        <img loading="lazy" width="15px" height="12px"
                            src="<?= get_theme_file_uri("/assets/icons/person-logged.svg") ?>"
                            alt="<?= __("My Account", "inoby") ?>"></a>
                    <?php endif; ?>
                </div>
                <?php if (ESHOP_ENABLED): ?>
                <div class="menu-cart">
                    <a class="popup-trigger-btn" data-popup="cart-wrapper" href="#0">
                        <?php rc_cart_count(); ?>
                        <img loading="lazy" width="15px" height="14px" src="<?= get_theme_file_uri(
              "/assets/icons/cart.svg",
            ) ?>" alt="<?= __("Cart", "inoby") ?>">
                    </a>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <div class="trigger-mobile-menu">
                    <svg class="inline-svg" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px"
                        viewBox="0 0 32 22.5" enable-background="new 0 0 32 22.5" xml:space="preserve">
                        <title>Mobile Menu</title>
                        <g class="svg-menu-toggle">
                            <path class="bar" d="M20.945,8.75c0,0.69-0.5,1.25-1.117,1.25H3.141c-0.617,0-1.118-0.56-1.118-1.25l0,0
						c0-0.69,0.5-1.25,1.118-1.25h16.688C20.445,7.5,20.945,8.06,20.945,8.75L20.945,8.75z">
                            </path>
                            <path class="bar"
                                d="M20.923,15c0,0.689-0.501,1.25-1.118,1.25H3.118C2.5,16.25,2,15.689,2,15l0,0c0-0.689,0.5-1.25,1.118-1.25 h16.687C20.422,13.75,20.923,14.311,20.923,15L20.923,15z">
                            </path>
                            <path class="bar" d="M20.969,21.25c0,0.689-0.5,1.25-1.117,1.25H3.164c-0.617,0-1.118-0.561-1.118-1.25l0,0
						c0-0.689,0.5-1.25,1.118-1.25h16.688C20.469,20,20.969,20.561,20.969,21.25L20.969,21.25z">
                            </path>
                            <!-- needs to be here as a 'hit area' -->
                            <rect width="24px" height="24px" fill="none">
                            </rect>
                        </g>
                    </svg>
                </div>
            </div>
            <div id="search">
                    <?php rc_search([
    "placeholder"  => __("Write what you need, e.g.... Jerseys", "inoby"),
    "button"       => __("Search", 'inoby'),
    "button_class" => 'search-trigger',
]);
?>
            </div>
        </div>
    </div>
    <div class="mobile-menu">
        <div class="mobile-wrap">
            <?php
      wp_nav_menu(["theme_location" => "mobile"]);
      do_action("inoby_after_mobile_menu");
      ?>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/club-popup') ?>