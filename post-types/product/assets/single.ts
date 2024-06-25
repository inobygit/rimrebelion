import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";
import KeenSlider, { KeenSliderPlugin } from "keen-slider";
import { SliderGallerySettings } from "./slider-gallery.d";
import { arrows, dots } from "@lib/keen-slider-plugins";

class ProductSingleModule extends InobyModule {

  run() { 

    setTimeout(() => {
      $('.wc-tabs li.active').removeClass('active');
      $('.woocommerce-Tabs-panel').hide();
      $('.wc-tabs li').on('click', function (e) {
        e.preventDefault();
        if($(this).hasClass('active')) {
          $(this).toggleClass('disabled');
          $('.woocommerce-Tabs-panel').toggleClass('hidden');
        } else {
          $(this).removeClass('disabled');
          $('.woocommerce-Tabs-panel').removeClass('hidden');
        }
      });
    }, 50);


    var priceWrp = $("#price-wrp");

    $(document.body).on("found_variation", function (event, variation) {
      if (variation.price_html) {
        $('.stock-status').addClass('price-wrp-hide');
        $(priceWrp).addClass("price-wrp-hide");
      }
    });
    // ked nemam kompletne vybraty variant tak neviem cenu
    $(document.body).on("hide_variation", () => {
        $('.stock-status').removeClass('price-wrp-hide');
      $(priceWrp).removeClass("price-wrp-hide");
    });

    // create slider for each component on page
    $(".inoby-slider-gallery").each((i, gallery) => {
      const $gallery = $(gallery);
      const settings = $gallery.data("settings") as SliderGallerySettings;
      settings.spacing = Number.parseInt(
        getComputedStyle(gallery).getPropertyValue("--slider-spacing")
      );
      this.createSlider($gallery, settings);
    });

    const selectElement = $('.single_variation_wrap').find('select').get(0) as HTMLSelectElement;
    const customOrder = ['xxs', 'xs', 's', 'm', 'l', 'xl', 'xxl', '3xl'];
    if(selectElement){
      const options = Array.from(selectElement.options);

      options.sort((a, b) => {
        const baseSizeA = a.value.split('-')[0];
        const baseSizeB = b.value.split('-')[0];

        const valueA = (baseSizeA === '3xl') ? 10 : (isNaN(parseFloat(baseSizeA)) ? customOrder.indexOf(baseSizeA) : parseFloat(baseSizeA));
        const valueB = (baseSizeB === '3xl') ? 10 : (isNaN(parseFloat(baseSizeB)) ? customOrder.indexOf(baseSizeB) : parseFloat(baseSizeB));

        if (valueA < valueB) {
            return -1;
        } else if (valueA > valueB) {
            return 1;
        } else {
            // Compare language strings if they exist
            const langA = a.value.split('-')[1] || '';
            const langB = b.value.split('-')[1] || '';
            return langA.localeCompare(langB);
        }
    });
      
      options.forEach(option => selectElement.add(option));
    }
  }

  private createSlider(
    $gallery: JQuery<HTMLElement>,
    settings: SliderGallerySettings
  ) {
    const container = $gallery.find(".gallery").get(0);
    let plugins: KeenSliderPlugin[] = [
    ];

      plugins.push(arrows);
      plugins.push(dots);
    return new KeenSlider(
      container,
      {
        selector: ".gallery-slide",
        loop: true,
        slides: { origin: "center", perView: 1, spacing: 0 },
        
      },
      plugins
    );
  }

}

new ProductSingleModule().runOnReady();
