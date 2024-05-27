import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";
import KeenSliderHelper from "@lib/keen-slider-helper";

class LastViewedComponent extends InobyModule {
  public run() {
    $(document.body).bind('last-seen-products-loaded', function() {
        $('.last-viewed-row').show();
      initProductsSlick();
    } );

    function initProductsSlick(){
        const $sliderContainers = $(".last-seen-products .products");
        $(".last-seen-products .products").addClass("keen-slider");
        KeenSliderHelper.registerSlider($sliderContainers, {
            selector: ".product-card",
            slides: {
                perView: 4,
                spacing: 30,
            },
            loop: true,
            breakpoints: {
                "(max-width: 1280px)": {
                    slides: {
                        perView: 4,
                        spacing: 30,
                    },
                },
                "(max-width: 920px)": {
                    slides: {
                        perView: 3,
                        spacing: 10,
                    },
                },
                "(max-width: 768px)": {
                    slides: {
                        perView: 2,
                        spacing: 10,
                    },
                },
                "(max-width: 420px)": {
                    slides: {
                        perView: 1,
                        spacing: 10,
                    },
                },
            }
        }, true);
    };
  }

  
}

new LastViewedComponent().runOnReady();
