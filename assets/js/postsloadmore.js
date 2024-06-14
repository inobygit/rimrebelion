jQuery(function ($) {
  $(".posts_loadmore_child").on("click", function () {
    var button = $(this),
      data = {
        action: "loadmore_child",
        query: posts_loadmore_params.posts, // that's how we get params from wp_localize_script() function
        card_template: button.attr("card-template") ?? "",
        card_classes: button.attr("card-classes") ?? "",
        looks_gender: button.attr('gender') ?? "",
        page: posts_loadmore_params.current_page,
      };
    $.ajax({
      // you can also use $.post here
      url: posts_loadmore_params.ajaxurl, // AJAX handler
      data: data,
      type: "POST",
      beforeSend: function (xhr) {
        var btnLoad = button.attr('load-text');
        button.text(btnLoad); // change the button text, you can also add a preloader image
      },
      success: function (data) {
        if (data) {
          var btnText = button.attr('more-text');
          button.text(btnText);
          $("#load-more-posts").prev().after(data); // insert new posts
          posts_loadmore_params.current_page++;
          if (posts_loadmore_params.current_page == posts_loadmore_params.max_page) button.remove(); // if last page, remove the button
          // you can also fire the "post-load" event here if you use a plugin that requires it
          // $( document.body ).trigger( 'post-load' );
        } else {
          button.remove(); // if no data, remove the button as well
        }
      },
    });
  });
});
