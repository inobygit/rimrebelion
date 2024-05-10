import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";
import KeenSlider, { KeenSliderPlugin } from "keen-slider";
import { SliderGallerySettings } from "./slider-gallery.d";
import { arrows, dots } from "@lib/keen-slider-plugins";

class ProductSingleModule extends InobyModule {

  run() { 
    // create slider for each component on page
    $(".inoby-slider-gallery").each((i, gallery) => {
      const $gallery = $(gallery);
      const settings = $gallery.data("settings") as SliderGallerySettings;
      settings.spacing = Number.parseInt(
        getComputedStyle(gallery).getPropertyValue("--slider-spacing")
      );
      this.createSlider($gallery, settings);
    });
  }

  private createSlider(
    $gallery: JQuery<HTMLElement>,
    settings: SliderGallerySettings
  ) {
    const container = $gallery.find(".gallery").get(0);
    let plugins: KeenSliderPlugin[] = [
    ];

      plugins.push(arrows);
      plugins.push(dots);
    return new KeenSlider(
      container,
      {
        selector: ".gallery-slide",
        loop: true,
        slides: { origin: "center", perView: 1, spacing: 0 },
        
      },
      plugins
    );
  }

}

new ProductSingleModule().runOnReady();
