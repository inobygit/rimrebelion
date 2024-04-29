<?php
namespace Inoby\WooCommerce\Import;

class CustomImportMapper extends DefaultImportMapper {
    public function map_metaboxes(InobyProduct $product, $mb, $value) {
        if ($mb === 'slider-images') {
            $value = explode('|', $value);
            $value = array_map('trim', $value);
            $product->customMeta[$mb] = $value;
        } else {
            $product->customMeta[$mb] = $value;
        }
    }
}

add_filter("inoby_wooocommerce_import_mapper", function(){return new CustomImportMapper();});