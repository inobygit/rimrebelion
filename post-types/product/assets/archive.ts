import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";

class ProductArchiveModule extends InobyModule {
  run() { 
  $(document).ajaxComplete(function(event, xhr, options) {

    if (options.url.includes('?rc-ajax=get_products')) {
      $('#inoby-preloader').show();
      $('#inoby-preloader').removeClass("loaded");
      $('#inoby-preloader').css('opacity', 0.5);
      $('html, body').off('scroll touchmove mousewheel');

      $('#categories').load(' #categories > *', function() {

        $("a[rel~=keep-search").off('click');
        $("a[rel~=keep-search]").on("click", (e) => {
        const link: any = e.currentTarget;
          if (link?.href) {
              e.preventDefault();
              const searchParams = new URLSearchParams(window.location.search);
              if(searchParams.has('lang')){
                  searchParams.delete('lang');
                  const newUrl = `${link.href}&${searchParams.toString()}`;
                  window.location.href = newUrl;
              } else {
                  window.location.href = `${link.href}${window.location.search}`;
              }
          }
      });
          
          $('#inoby-preloader').addClass("loaded");
          $('#inoby-preloader').hide();
          $('#inoby-preloader').css('opacity', 0);
      });

    }
  });

  }
}

new ProductArchiveModule().runOnReady();
