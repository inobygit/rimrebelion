<?php
/**
 * Template Name: Landing page
 */

 inoby_enqueue_parted_script("landing", "page_templates");
inoby_enqueue_parted_style("landing", "page_templates");

get_header('landing');

?>

<main id="pt-landing">
    <?php if (
        is_plugin_active(
          "woocommerce-product-search/woocommerce-product-search.php",
        )
      ) { ?>
    <div id="search">
        <div class="search-wrapper">
            <div id="search-close">✕</div>
            <?php echo do_shortcode(
            '[woocommerce_product_search 
									placeholder="' .
              __("Vyhľadajte značku, kategóriu, produkt", "rootscope") .
              '"
									no_results="' .
              __(
                "Neboli nájdené žiadne výsledky. Skúste iné kľúčové slovo.",
                "rootscope",
              ) .
              '"
									submit_button="no"
									tags="no"
									sku="yes"
									attributes="no"
									product_thumbnails="yes"
									show_add_to_cart="no"
									show_price="yes"
									excerpt="yes"
									categories="yes"
									category_results="yes"
									delay="250"
                  wpml="yes"
								]',
          ); ?>
        </div>
    </div>
    <?php } ?>
    <?= the_content() ?>
</main>

<?php get_footer('landing');