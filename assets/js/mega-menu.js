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
        if ($subMenuList.length > 4) {
            $subMenuList.slice(4).hide();
            const $toggleButton = $(`<li class="show-more"><a href="#">${showMoreText}</a></li>`);
            $(this).find('.sub-menu').append($toggleButton);

            $toggleButton.on('click', 'a', function(e) {
                e.preventDefault();
                const isVisible = $subMenuList.slice(4).is(':visible');
                if (isVisible) {
                    $subMenuList.slice(4).slideUp();
                    $(this).text(showMoreText);
                } else {
                    $subMenuList.slice(4).slideDown();
                    $(this).text(showLessText);
                }
            });
        }
    });
});