<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.5.0
 */

defined("ABSPATH") || exit(); ?>
<script type="text/template" id="tmpl-variation-template">
    <div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-availability">{{{ (data.variation.is_in_stock ? `<p class="stock instock"> <?= __('In stock', 'rimrebellion') ?> </p>` : data.vatiation.availability_html) }}}</div>
</script>