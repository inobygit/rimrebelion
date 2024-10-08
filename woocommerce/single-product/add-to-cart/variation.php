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
	<div class="woocommerce-variation-availability">{{{ (data.variation.availability_html.includes('instock') ? `<p class="stock instock"> <?= __('In stock', 'rimrebellion') ?> </p>` : (data.variation.availability_html.includes('onbackorder') ? `<p class="stock onbackorder"> <?= __('On backorder', 'rimrebellion') ?> </p>` : (data.variation.availability_html.includes('outofstock') ? `<p class="stock outofstock"> <?= __('Out of stock', 'rimrebellion') ?> </p>` : data.variation.availability_html))) }}}</div>
</script>