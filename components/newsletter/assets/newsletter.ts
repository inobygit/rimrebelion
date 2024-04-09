import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";

class FeaturedProductComponent extends InobyModule {
  public run() {
    this.openPopup();
    this.closePopup();
  }

  private openPopup() {
    var $openButtonTrigger = $(".component-newsletter .button-wrap a.button");
    $openButtonTrigger.click(function () {
      $(this).parent().next(".newsletter-popup").addClass("active").show();
    });
  }

  private closePopup() {
    var $closeButtonTrigger = $(".component-newsletter .newsletter-popup .close-btn");
    var $newsletterPopup = $(".component-newsletter .newsletter-popup");

    $closeButtonTrigger.click(function () {
      $(this).parent().parent(".newsletter-popup.active").removeClass("active");
    });

    $(document).on("keydown", function (e) {
      if ($newsletterPopup.hasClass("active")) {
        if (e.keyCode === 27) {
          // ESC
          $newsletterPopup.removeClass("active");
        }
      }
    });
  }
}

new FeaturedProductComponent().runOnReady();
