<?php
namespace Inoby\WooCommerce\Import;
use Inoby\WooCommerce\Import\DefaultImportMapper;
class CustomImportMapper extends DefaultImportMapper {
    public function map_metaboxes(InobyProduct $product, $mb, $value) {
        if ($mb === 'slider-images') {
            $product_id = wc_get_product_id_by_sku($product->sku);
            
            delete_post_meta($product_id, 'slider-images');
            
            $value = explode('|', $value);
            $value = array_map('trim', $value);
            
            foreach ($value as $title) {
                $image_id = $this->get_image_id_by_title($title);
                add_post_meta($product_id, 'slider-images', $image_id);
            }

        } else {
            $product->customMeta[$mb] = $value;
        }
    }

    private function get_image_id_by_title($title){
        $attachment = get_page_by_title($title, OBJECT, 'attachment');
        if ($attachment) {
            return $attachment->ID;
        } else {
            return false;
        }
    }

    
};

add_filter("inoby_wooocommerce_import_mapper", function(){return new CustomImportMapper();});