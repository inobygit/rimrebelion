
import { InobyModule } from "@lib/inoby-module";

class PtLanding extends InobyModule {

  public run() {
    $(document).mouseup(function (e: any) {
    var search = $("#search");
    // if the target of the click isn't the search nor a descendant of the search
    if (search.hasClass("active")) {
      if (!search.is(e.target) && search.has(e.target).length === 0) {
        search.removeClass("active");
      }
    }
  });
    $(document.body).on("click", "#search-trigger", function () {
        $("#search").toggleClass("active");
        $(".product-search-field").focus();
    });
    $(document.body).on("click", "#search-close", function () {
        $("#search").removeClass("active");
    });
  }

  public runAdmin() {
    //
  }


}

new PtLanding().runOnReady();
