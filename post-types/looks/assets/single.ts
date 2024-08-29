import { InobyModule } from "@lib/inoby-module";
import GLightbox from "glightbox";
import * as $ from "jquery";
import KeenSlider from "keen-slider";
import { dots, adaptiveHeight, arrows } from "@lib/keen-slider-plugins";
import KeenSliderHelper from "@assets/js/lib/keen-slider-helper";

class LooksSingleModule extends InobyModule {
  run() {
    const customOrder = ['xxs', 'xs', 's', 'm', 'l', 'xl', 'xxl', '3xl'];
    $('.rudr-variation-radios').each(function(index, element) {
      const radioButtons = $('#'+ $(element).attr('id') +' input');
      // Sort radio buttons based on custom order
      const sortedRadioButtons = Array.from(radioButtons).sort((a, b) => {
          const valueA = customOrder.indexOf((a as HTMLInputElement).value); // Cast to HTMLInputElement
          const valueB = customOrder.indexOf((b as HTMLInputElement).value); // Cast to HTMLInputElement
          return valueA - valueB;
      });
  
      // Clear existing radio buttons and append sorted ones
      $(element).empty().append(sortedRadioButtons.map(rb => $(rb).parent()));
    });
    $('.summary-col').each(function(index, element) {
      if($(element).find('.stock-wrp .stock-status .stock').hasClass('onbackorder')) {
        $(element).find('.availability-date *').hide();
        $(element).find('.availability-date-onbackorder').show();
      }
  
      if($(element).find('.stock-wrp .stock-status .stock').hasClass('instock')) {
        $(element).find('.availability-date *').hide();
        var currentTime = new Date();
        var hours = currentTime.getHours();
        if (hours < 16 ) {
          $(element).find('.availability-date-tomorrow').show();
        } else {
          $(element).find('.availability-date-default').show();
        }
      }
  
      if($(element).find('.stock-wrp .stock-status .stock').hasClass('outofstock')) {
        $(element).find('.availability-date *').hide();
      }
    });
    
    $('.rudr-variation-radios').each(function(index, element){
      $('#'+ $(element).attr('id') +' input').on('change', function(){
      const $variationRadios = $(this).closest('.rudr-variation-radios');
      // for each checked radio button we reflect the same changes to select dropdowns
      
      $variationRadios.find('label').each(function(index, element) {
        $(element).removeClass('selected');
      });
      $variationRadios.find('input:checked').each( function( index, element ) {
        const radio = $(element);
        const label = $(element).parent();
        label.addClass('selected');
        const radioName = radio.attr('name');
        const radioValue  = radio.attr('value');
        $variationRadios.parent().find('select[name="' + radioName + '"]').val(radioValue).trigger('change');
      });

      var stockStatus = $variationRadios.closest('.single_variation_wrap');
      var stockStatusAvailability = stockStatus.find('.woocommerce-variation-availability');
      stockStatus.find('.stock-wrp .stock-status').html(stockStatusAvailability.html());
      var stock = stockStatus.find('.stock-wrp .stock');

      if(stock.hasClass('onbackorder')) {
        stockStatus.find('.availability-date *').hide();
        stockStatus.find('.availability-date-onbackorder').show();
      }

      if(stock.hasClass('instock')) {
        stockStatus.find('.availability-date *').hide();
        var currentTime = new Date();
        var hours = currentTime.getHours();
        if (hours < 16 ) {
          stockStatus.find('.availability-date-tomorrow').show();
        } else {
          stockStatus.find('.availability-date-default').show();
        }
      }

      if(stock.hasClass('outofstock')) {
        stockStatus.find('.availability-date *').hide();
      }

      stockStatusAvailability.hide();
      });
    });

      this.initProductGallery();
      
      $(document.body).on("found_variation", function (event, variation) {
      if (variation.price_html) {
        $('.woocommerce-variation-add-to-cart-enabled').parent().find('.price-wrp').addClass("price-wrp-hide");
      }
    });
    // ked nemam kompletne vybraty variant tak neviem cenu
    $(document.body).on("hide_variation", () => {
      $('.woocommerce-variation-add-to-cart-disabled').parent().find('.price-wrp').removeClass("price-wrp-hide");
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
