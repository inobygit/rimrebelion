import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";

class ProductArchiveModule extends InobyModule {
  run() { 

  $(document).ajaxComplete(function(event, xhr, options) {
    if (options.url.includes('?rc-ajax=get_products')) {
      $('#categories').load(' #categories');
    }
  });
  }
}

new ProductArchiveModule().runOnReady();
