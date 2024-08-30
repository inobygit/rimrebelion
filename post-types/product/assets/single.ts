import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";
import KeenSlider, { KeenSliderPlugin } from "keen-slider";
import { SliderGallerySettings } from "./slider-gallery.d";
import { arrows, dots } from "@lib/keen-slider-plugins";
import KeenSliderHelper from "@assets/js/lib/keen-slider-helper";

class ProductSingleModule extends InobyModule {

  run() { 
    const customOrder = ['xxs', 'xs', 's', 'm', 'l', 'xl', 'xxl', '3xl', 'xxs-sk', 'xs-sk', 's-sk', 'm-sk', 'l-sk', 'xl-sk', 'xxl-sk', '3xl-sk'];
    const radioButtons = $('.rudr-variation-radios input');

    // Sort radio buttons based on custom order
    const sortedRadioButtons = Array.from(radioButtons).sort((a, b) => {
        const valueA = customOrder.indexOf((a as HTMLInputElement).value); // Cast to HTMLInputElement
        const valueB = customOrder.indexOf((b as HTMLInputElement).value); // Cast to HTMLInputElement
        return valueA - valueB;
    });

    // Clear existing radio buttons and append sorted ones
    $('.rudr-variation-radios').empty().append(sortedRadioButtons.map(rb => $(rb).parent()));

    $('#size-help').on('click', function(e){
      e.preventDefault();
      if($(window).width() > 767){
        $('html, body').animate({
          scrollTop: $(".woocommerce-tabs.desktop .size-help_tab").offset().top - 150
        }, 1000);
        // Toggle the size-help_tab
        $('.wc-tabs li').removeClass('active'); // Remove active class from all tabs
        $('#tab-title-size-help').removeClass('disabled').addClass('active'); // Add active class to size-help tab
        $('.woocommerce-Tabs-panel').hide(); // Hide all tab panels
        $('#tab-size-help').removeClass('hidden'); // Show size-help tab panel
        $('#tab-size-help').show(); // Show size-help tab panel
      } else {
        $('html, body').animate({
          scrollTop: $(".woocommerce-tabs.mobile .size-help_tab").offset().top - 150
        }, 1000);
        $('.wc-tabs li').removeClass('active'); // Remove active class from all tabs
        $('#tab-title-size-help-mobile').removeClass('disabled').addClass('active'); // Add active class to size-help tab
        $('#tab-size-help-mobile').removeClass('hidden'); // Show size-help tab panel
      }
    });

    if($('.stock-wrp .stock-status .stock').hasClass('onbackorder')) {
      $('.availability-date *').hide();
      $('.availability-date-onbackorder').show();
    }

    if($('.stock-wrp .stock-status .stock').hasClass('instock')) {
      $('.availability-date *').hide();
      var currentTime = new Date();
      var hours = currentTime.getHours();
      if (hours < 16 ) {
        $('.availability-date-tomorrow').show();
      } else {
        $('.availability-date-default').show();
      }
    }

    if($('.stock-wrp .stock-status .stock').hasClass('outofstock')) {
      $('.availability-date *').hide();
    }
    // on radio button change(click)
	$( document ).on( 'change', '.rudr-variation-radios input', function() {
		// for each checked radio button we reflect the same changes to select dropdowns
    $('.rudr-variation-radios label').each(function(index, element) {
      $(element).removeClass('selected');
    });
		$( '.rudr-variation-radios input:checked' ).each( function( index, element ) {
			const radio = $(element)
      const label = $(element).parent();
      label.addClass('selected');
			const radioName = radio.attr( 'name' )
			const radioValue  = radio.attr( 'value' )
			$( 'select[name="' + radioName + '"]' ).val( radioValue ).trigger( 'change' );
		})

    var stockStatus = $('.single_variation_wrap .woocommerce-variation-availability');
    $('.stock-wrp .stock-status').html(stockStatus.html());
    var stock = stockStatus.find('.stock');

    if(stock.hasClass('onbackorder')) {
      $('.availability-date *').hide();
      $('.availability-date-onbackorder').show();
    }

    if(stock.hasClass('instock')) {
      $('.availability-date *').hide();
      var currentTime = new Date();
      var hours = currentTime.getHours();
      if (hours < 16 ) {
        $('.availability-date-tomorrow').show();
      } else {
        $('.availability-date-default').show();
      }
    }

    if(stock.hasClass('outofstock')) {
      $('.availability-date *').hide();
    }

    stockStatus.hide();
	})

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


     $('.woocommerce-tabs.mobile li').each(function(index, element) {
        let panel = $(element).find('.wc-tab').get(0);
        if(panel){
          panel.style.setProperty('--height', panel.clientHeight + 'px');
          panel.style.height = '0px';
        }
     });

     $('.table-wrap').on('click', function(e) {
      e.stopPropagation();
     });

    var priceWrp = $("#price-wrp");

    $(document.body).on("found_variation", function (event, variation) {
      if (variation.price_html) {
        $(priceWrp).addClass("price-wrp-hide");
      }
    });
    // ked nemam kompletne vybraty variant tak neviem cenu
    $(document.body).on("hide_variation", () => {
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


class RelatedProductsSlieder extends InobyModule {
  run() {
    const $sliderContainer = $("[id^=child-related-slider]");
    $sliderContainer.removeClass('row').addClass("keen-slider");

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
          "(min-width: 0px)": {
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
              perView: 4,
              spacing: 30,
            },
          },
        },
      },
      true
    );
  }
}


new RelatedProductsSlieder().runOnReady();

new ProductSingleModule().runOnReady();
