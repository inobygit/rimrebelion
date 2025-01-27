import $ from "jquery";

function wpSendForm(action, form) {
    const data = Object.fromEntries(new FormData(form).entries());
    form.classList.add("loading");

    const modifiedData = {};

    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            if (key === 'xoo_el_reg_pass' || key === 'xoo_el_reg_pass_again' || key === 'xoo_el_reg_terms' || key === '_xoo_el_form' || key === 'xoo_el_redirect') {
                continue;
            }
            const newKey = key.replace('xoo_el_reg_', '');
            modifiedData[newKey] = data[key];
        }
    }

    return wpSendData(action, modifiedData).always(() =>
      form.classList.remove("loading")
    );
}

function wpSendData(action, data) {
    return $.ajax({
      type: "POST",
      url: window.inoby_vars.ajax.url,
      data: { action: action, nonce: window.inoby_vars.ajax.nonce, ...data },
      dataType: "json",
    });
}
$(function () {

    let popupShown = false;

    $('.next-step').on('click', function() {
        $(this).closest('.popup-step').removeClass('active').next('.popup-step').addClass('active');
    });

    $('.prev-step').on('click', function() {
        $(this).closest('.popup-step').removeClass('active').prev('.popup-step').addClass('active');
    });

    $('.close-popup').on('click', function() {
        setCookie('popupShown', 'true', 7); // Set cookie for 7 days
        $('.club-popup').fadeOut();
    });

    var form = null;

    $(document).ajaxSend(function(e, xhr, options) {
        if(popupShown){
            if (options.data && options.data.includes('xoo_el_form_action')) {
                form = $('.club-popup-wrapper .xoo-el-form-register');
            }
        }
    });

    $(document).ajaxComplete(function(e, xhr, options) {
        if(popupShown){
        if (options.data && options.data.includes('xoo_el_form_action')) {
            if(xhr.responseJSON.error != 1){
                wpSendForm("inoby_newsletter_subscribe", form.get(0))
                .done(() => {
                    setCookie('popupShown', 'true', 7); 
                    $(form).removeClass("fail").addClass("success");
                    $('.popup-step').removeClass('active');
                    $('.popup-step.step-3').addClass('active');
                })
                .fail((response) => {
                    console.warn("newsletter subscribe fail", response);
                    $(form).removeClass("success").addClass("fail");
                    setTimeout(() => $(form).removeClass("fail"), 5000);
                });
            } else {
                $('.xoo-el-notice-error, .xoo-el-notice-success, .xoo-el-notice-warning').show();
            }
        }
    }
    });
    

    // Function to set a cookie
    function setCookie(name, value, days) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
    }

    // Function to get a cookie
    function getCookie(name) {
        return document.cookie.split('; ').reduce((r, v) => {
            const parts = v.split('=');
            return parts[0] === name ? decodeURIComponent(parts[1]) : r;
        }, '');
    }

    // Function to show the popup
    function showPopup() {
        if (!popupShown && !getCookie('popupShown')) {
            $('.club-popup form.xoo-el-form-register').append('<input type="hidden" name="source" value="popup">');
            $('.club-popup').fadeIn('slow');
            popupShown = true;
        }
    }

    $('.popup-step .copy').on('click', function() {
        var couponCode = $(this).closest('.popup-step').find('.coupon-code').text();
        navigator.clipboard.writeText(couponCode);
        $(this).closest('.popup-step').find('.coupon-code').hide();
        $(this).closest('.popup-step').find('.copy').hide();
        $(this).closest('.popup-step').find('.message').fadeIn('slow');
    });

    // Show popup after 30 seconds on mobile
    if ($(window).width() < 768) {
        setTimeout(showPopup, 30000); // 30 seconds
    } else {
        // Show popup after 30 seconds or on exit intent for desktop
        setTimeout(showPopup, 30000); // 30 seconds

        $(document).on('mouseleave', function(e) {
            if (e.clientY < 0 && !popupShown) {
                showPopup();
            }
        });
    }

    const lang = $('html').attr('lang');
    let showMoreText = 'Zobraziť viac';
    let showLessText = 'Zobraziť menej';

    if (lang === 'en-US' || lang === 'en' || lang === 'en-GB') {
        showMoreText = 'Show more';
        showLessText = 'Show less';
    }

    $('#header .header .top-menu > div > ul.menu .sub-menu .menu-item-has-children').each(function() {
        const $subMenuList = $(this).find('.menu-item');
        if ($subMenuList.length > 12) {
            $subMenuList.slice(12).hide();
            const $toggleButton = $(`<li class="show-more"><a href="#">${showMoreText}</a></li>`);
            $(this).find('.sub-menu').append($toggleButton);

            $toggleButton.on('click', 'a', function(e) {
                e.preventDefault();
                const isVisible = $subMenuList.slice(12).is(':visible');
                if (isVisible) {
                    $subMenuList.slice(12).slideUp();
                    $(this).text(showMoreText);
                } else {
                    $subMenuList.slice(12).slideDown();
                    $(this).text(showLessText);
                }
            });
        }
    });

    $("a[rel~=keep-search").off('click');
    $("a[rel~=keep-search]").on("click", (e) => {
      const link = e.currentTarget;
        if (link?.href) {
            e.preventDefault();
            const searchParams = new URLSearchParams(window.location.search);
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

    $('.triangleright').each(function() {
        if(this.innerText.length > 18){
            $(this).addClass('big');
        }
        if(this.innerText.length > 24){
            $(this).removeClass('big')
            $(this).addClass('huge');
        }
        if(this.innerText.length < 13){
            $(this).addClass('small');
        }
    });

    $('.triangleBoth').each(function() {
        if(this.innerText.length > 15){
            $(this).addClass('big');
        }
        if(this.innerText.length < 10){
            $(this).addClass('small');
        }
    });

    $('#breadcrumbs > span span').each(function() {
        if(this.innerText.length > 11){
            $(this).addClass('big');
        }
        if(this.innerText.length > 22){
            $(this).removeClass('big');
            $(this).addClass('huge');
        }
        if(this.innerText.length > 28){
            $(this).removeClass('big');
            $(this).removeClass('huge');
            $(this).addClass('custom-big');
        }
        if(this.innerText.length < 5){
            $(this).addClass('small');
        }
    });

    $('#breadcrumbs > span span a').on('click', function(e){
        e.preventDefault();
        const link = e.currentTarget;
        const searchParams = new URLSearchParams(window.location.search);
            if(searchParams.has('lang')){
                if(!link.href.includes('lang=')){
                    const newUrl = `${link.href}?${searchParams.toString()}`;
                    window.location.href = newUrl;
                } else {
                    searchParams.delete('lang');
                    const newUrl = `${link.href}&${searchParams.toString()}`;
                    window.location.href = newUrl;
                }
            } else {
                window.location.href = `${link.href}${window.location.search}`;
            }
    });
});