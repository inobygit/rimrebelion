import $ from "jquery";

$(function () {
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