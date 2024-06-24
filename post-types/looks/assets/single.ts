import { InobyModule } from "@lib/inoby-module";
import GLightbox from "glightbox";
import * as $ from "jquery";
import KeenSlider from "keen-slider";
import { dots, adaptiveHeight, arrows } from "@lib/keen-slider-plugins";
import KeenSliderHelper from "@assets/js/lib/keen-slider-helper";

class LooksSingleModule extends InobyModule {
  run() {
      this.initProductGallery();

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

  }

  initProductGallery(): void {
    // replace HTML attrbites on element
    const replaceAttrs = (el: Element, newEl: Element, children = true) => {
      newEl.getAttributeNames().forEach((attr) => {
        el.setAttribute(attr, newEl.getAttribute(attr));
        if (children && el.firstChild && newEl.firstChild) {
          replaceAttrs(el.firstElementChild, newEl.firstElementChild, children);
        }
      });
    };

    var popups: Array<any> = [];
    // init popup gallery
    $('.woocommerce-product-gallery .slider').each(function () {
      popups[Number($(this).attr('id').split('-')[1])] = GLightbox({
        selector: "#" + $(this).attr('id') + " .woocommerce-product-gallery__image img",
        slideEffect: "fade",
      });
    });



    var mobileSlider: any = null;
    $('.woocommerce-product-gallery .slider').each(function () {
      mobileSlider = new KeenSlider(
        '#'+$(this).attr('id'),
        {
          selector: ".woocommerce-product-gallery__image",
        },
        [dots, adaptiveHeight, arrows]
      );
    });

    // prevent clicking on image links
    $(document).on("click", ".woocommerce-product-gallery__image", (e) => e.preventDefault());

    // open gallery on master-image/thumbs clicks
    $(document).on("click", ".gallery .woocommerce-product-gallery__image", (e) => {
      let idx = 0;
      let parentID = null;
      if ($(e.target).hasClass("woocommerce-product-gallery__image")) {
        idx = $(e.target).data("gallery-index");
        parentID = $(e.target).data("gallery-parent");
      } else {
        idx = $(e.target).parents(".woocommerce-product-gallery__image").data("gallery-index");
        parentID = $(e.target).parents(".woocommerce-product-gallery__image").data("gallery-parent");
      }

      popups[Number(parentID.split('-')[1])].openAt(idx);
    });
  }
}

class UpSellProductsSlieder extends InobyModule {
  run() {
    const $sliderContainer = $("[id^=up-sell-slider]");
    $sliderContainer.removeClass("row").addClass("keen-slider");
    KeenSliderHelper.registerSlider(
      $sliderContainer,
      {
        selector: ".content-product-wrap",
        loop: true,
        origin: "auto",
        slides: {
          perView: 4,
          spacing: 30,
        },
        breakpoints: {
          "(min-width: 320px)": {
            slides: {
              perView: 1.5,
              spacing: 15,
              mode: "free",
            },
          },
          "(min-width: 576px)": {
            slides: {
              perView: 1.5,
              spacing: 30,
              mode: "free",
            },
          },
          "(min-width: 768px)": {
            slides: {
              perView: 2.5,
              spacing: 30,
            },
          },
          "(min-width: 1200px)": {
            slides: {
              perView: 4.5,
              spacing: 30,
              origin: "auto",
            },
          },
        },
      },
      true
    );
  }
}

class RelatedProductsSlieder extends InobyModule {
  run() {
    const $sliderContainer = $("[id^=related-slider]");
    $sliderContainer.removeClass("row").addClass("keen-slider");
    KeenSliderHelper.registerSlider(
      $sliderContainer,
      {
        selector: ".content-product-wrap",
        loop: true,
        slides: {
          perView: 4,
          spacing: 30,
        },
        breakpoints: {
          "(min-width: 320px)": {
            slides: {
              perView: 1.5,
              spacing: 15,
              mode: "free",
            },
          },
          "(min-width: 576px)": {
            slides: {
              perView: 1.5,
              spacing: 30,
              mode: "free",
            },
          },
          "(min-width: 768px)": {
            slides: {
              perView: 2.5,
              spacing: 30,
            },
          },
          "(min-width: 1200px)": {
            slides: {
              perView: 4.2,
              spacing: 30,
              origin: "auto",
            },
          },
        },
      },
      true
    );
  }
}

new LooksSingleModule().runOnReady();

new RelatedProductsSlieder().runOnReady();

new UpSellProductsSlieder().runOnReady();
