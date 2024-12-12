import { InobyComponentModule } from "@lib/inoby-module";
import GLightbox, { GLighboxInstance } from "glightbox";
import KeenSlider, { KeenSliderPlugin } from "keen-slider";
import * as $ from "jquery";
import { arrows, dots } from "@lib/keen-slider-plugins";

class ReferencesSliderComponent extends InobyComponentModule {
  public metaboxId: string = "inoby-references-slider";
  // private spacing: number = 16;
  private lightbox: GLighboxInstance = null;

  public run() {
    // create slider for each component on page
    $(".inoby-references-slider").each((i, gallery) => {
      const $gallery = $(gallery);
      const numSlides = $gallery.data('number-items');
      if(numSlides > 2) {
        this.createSlider($gallery);
      }
      else if($(window).width() < 768 && numSlides > 1){
        this.createSlider($gallery);
      }
    });
  }
  
  

  private createSlider(
    $gallery: JQuery<HTMLElement>
  ) {
    const container = $gallery.find(".references").get(0);
    let plugins: KeenSliderPlugin[] = [];


      plugins.push(dots);

    return new KeenSlider(
      container,
      {
        loop: true,
        selector: ".references-slide",
        slides: {
          perView: 2,
          spacing: 30,
        },
        breakpoints: {
          "(min-width: 0px)": {
            slides: {
              perView: 1,
              spacing: 30,
            },
          },
          "(min-width: 768px)": {
            slides: {
              perView: 2,
              spacing: 30,
            },
          },
          "(min-width: 1200px)": {
            slides: {
              perView: 2,
              spacing: 30,
            },
          },
          "(min-width: 1440px)": {
            slides: {
              perView: 2,
              spacing: 30,
            },
          },
        },
      },
      plugins
    );
  }


  public runAdmin() {
  }
}

new ReferencesSliderComponent().runOnReady();
