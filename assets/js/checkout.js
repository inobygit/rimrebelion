jQuery(function ($) {
  // $(".init-payment").on("click", function(e) {
  //   e.preventDefault();
    
  //   if (!$('#terms-checkbox').is(':checked')) {
  //     $('#terms-checkbox')[0].scrollIntoView({
  //       behavior: 'smooth'
  //     });
  //   }

  //   $("button[name='woocommerce_checkout_place_order']").trigger('click');
  // });
  $('.shipping-payment-btn').on('click', function(e){
      if($('.wc_payment_method.payment_method_cheque.is-checked').length){
        $('.wc_payment_method.payment_method_cheque.is-checked').removeClass('is-checked');
                $('.wc_payment_method.payment_method_cheque').find('input[type="radio"]').prop('checked', false);
                $('.wc_payment_method.payment_method_cheque').find('input[type="radio"]').attr('checked', false);
                $('.wc_payment_method.payment_method_cheque').find('input[type="radio"]').checked = false;

                $('.wc_payment_method.payment_method_gpwebpaygpebinder').addClass('is-checked');
                $('.wc_payment_method.payment_method_gpwebpaygpebinder').find('input[type="radio"]').prop('checked',true);
                $('.wc_payment_method.payment_method_gpwebpaygpebinder').find('input[type="radio"]').attr('checked',true);
                $('.wc_payment_method.payment_method_gpwebpaygpebinder').find('input[type="radio"]').checked = true;
            }
  });
  jQuery(document).ready(function($) {
    // Funkcia na zmenu tabu
    var changeTab = function (tabNameToShow, currentTab) {
        $(document.body).trigger("tab.change.before", { oldTab: currentTab, newTab: tabNameToShow });
        $('.tab[data-tab*="' + currentTab + '"]').removeClass("active");
        $('.tab[data-tab*="' + tabNameToShow + '"]').addClass("active");
        $('.tab-content[data-tab*="' + currentTab + '"]').hide().removeClass("active");
        $('.tab-content[data-tab*="' + tabNameToShow + '"]').show().addClass("active");
        var $mainTabToShow = $('.main[data-tab*="' + tabNameToShow + '"]');
        if ($mainTabToShow.length > 0) {
            $('html, body').animate({
                scrollTop: $mainTabToShow.offset().top
            }, 500);
        } else {
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        }
        
        // Pridanie triedy na body podľa aktívneho tabu
        $('body').removeClass(currentTab).addClass(tabNameToShow);
    };


    // Pri každom kliknutí na .tab-btn
    // $('.tab-btn').on('click', function(e) {
    //     e.preventDefault(); // Zabránenie predvolenému správaniu odkazu/buttonu

    //     // Získanie cieľového tabu z atribútu data-next-tab alebo data-prev-tab
    //     var targetTab = $(this).data('next-tab') || $(this).data('prev-tab');

    //     // Získanie aktuálneho tabu z atribútu data-current-tab
    //     var currentTab = $(this).data('current-tab');

    //     // Zmena tabu
    //     changeTab(targetTab, currentTab);
    // });
});

});

