import $ from "jquery";

$(function () {
  $(document.body).on("click", "#search-trigger", function () {
    $("#rc_search").focus();
  });


  $(document.body).on("click", ".search-results .close-btn", function () {
    $("#search").removeClass("active");
  });

  const headerResizeObserver = new ResizeObserver((h) => {
    h.forEach((newSize) => {
      let pageOffset = newSize.borderBoxSize[0].blockSize;
      window.rcScrollOffset = pageOffset;
      window.pageScrollOffset = pageOffset;
      document.documentElement.style.setProperty(
        "--header-height",
        pageOffset + "px"
      );
    });
  });

  if($('#header-landing').length){
    headerResizeObserver.observe(document.getElementById("header-landing"));
  }
});
