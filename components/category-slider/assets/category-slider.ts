import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";
import KeenSliderHelper from "@lib/keen-slider-helper";

class CategorySliderComponent extends InobyModule {
  public run() {
    const $sliderContainers = $(".component-category-slider .category-slider");
    $(".component-category-slider .category-slider").addClass("keen-slider");
    KeenSliderHelper.registerSlider($sliderContainers, {
        selector: ".category-slide",
        slides: {
            perView: 6,
            spacing: 20,
        },
        loop: false,
        breakpoints: {
            "(max-width: 1440px)": {
                slides: {
                    perView: 5,
                    spacing: 10,
                },
            },
            "(max-width: 1280px)": {
                slides: {
                    perView: 4,
                    spacing: 10,
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
  }

  
}

new CategorySliderComponent().runOnReady();
