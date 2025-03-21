import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";

class ProductArchiveModule extends InobyModule {
  run() { 
  $('html').on('click', function() {
    $('.expandable-wrp').removeClass('expanded');
    $('.expandable-wrp').find('input[type="hidden"]').val('0');
  });

    $('.expandable-wrp').on('click', function(e) {
      e.stopPropagation();
      var shouldRemove = false;
      if($(this).hasClass('expanded')){
          shouldRemove = true;
        } else {
          shouldRemove = false;
        }
        $('.expandable-wrp').removeClass('expanded');
        $('.expandable-wrp').find('input[type="hidden"]').val('0');
      setTimeout(() => {
        if(shouldRemove){
          $(this).removeClass('expanded');
          $(this).find('input[type="hidden"]').val('0');
        } else {
          $(this).addClass('expanded');
          $(this).find('input[type="hidden"]').val('1');
        }
      
      }, 100);
      });

  $(document).ajaxComplete(function(event, xhr, options) {
    $('.expandable-wrp').off('click');
    $('.expandable-wrp').on('click', function(e) {
      e.stopPropagation();
      var shouldRemove = false;
      if($(this).hasClass('expanded')){
          shouldRemove = true;
        } else {
          shouldRemove = false;
        }
        $('.expandable-wrp').removeClass('expanded');
        $('.expandable-wrp').find('input[type="hidden"]').val('0');
      setTimeout(() => {
        if(shouldRemove){
          $(this).removeClass('expanded');
          $(this).find('input[type="hidden"]').val('0');
        } else {
          $(this).addClass('expanded');
          $(this).find('input[type="hidden"]').val('1');
        }
      
      }, 100);
      });

    if (options.url.includes('?rc-ajax=get_products')) {
      $('#inoby-preloader').show();
      $('#inoby-preloader').removeClass("loaded");
      $('#inoby-preloader').css('opacity', 0.9);
      $('html, body').off('scroll touchmove mousewheel');

      $('#categories').load(' #categories > *', function() {
        $("a[rel~=keep-search").off('click');
        $("a[rel~=keep-search]").on("click", (e) => {
          const link: any = e.currentTarget;
          if (link?.href) {
              e.preventDefault();
              const searchParams: any = new URLSearchParams(window.location.search);
              if(searchParams.has('lang')){
                  searchParams.delete('lang');
                  if(searchParams.size != 0){
                      var newUrl = `${link.href}&${searchParams.toString()}`;
                  } else {
                      var newUrl = `${link.href}`;
                  }
                  window.location.href = newUrl;
              } else {
                  window.location.href = `${link.href}${window.location.search}`;
              }
          }
      });

      $('#inoby-preloader').addClass("loaded");
      $('#inoby-preloader').hide();
      $('#inoby-preloader').css('opacity', 0);
      $(document).trigger('customEvent');
          
      });

    }
  });

  }
}

new ProductArchiveModule().runOnReady();
