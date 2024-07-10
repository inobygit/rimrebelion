import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";
import KeenSlider, { KeenSliderPlugin } from "keen-slider";
import { dots } from "@lib/keen-slider-plugins";

class LastViewedComponent extends InobyModule {
  public run() {
      // create slider for each component on page
    $(".build-your-look").each((i, gallery) => {
      const $gallery = $(gallery);
      this.createSlider($gallery);
    });
  }

  private createSlider($gallery: JQuery<HTMLElement> ) {
    const container = $gallery.find(".slider-wrapper").get(0);
    let plugins: KeenSliderPlugin[] = [];

      plugins.push(dots);
    return new KeenSlider(
      container,
      {
        selector: ".post-card",
        loop: true,
            slides: {
                perView: 4,
                spacing: 30,
            },
            breakpoints: {
                "(max-width: 1280px)": {
                    slides: {
                        perView: 4,
                        spacing: 30,
                    },
                },
                "(max-width: 920px)": {
                    slides: {
                        perView: 3,
                        spacing: 10,
                    },
                },
                "(max-width: 768px)": {
                    slides: {
                        perView: 2,
                        spacing: 10,
                        origin: 'center',
                    },
                },
                "(max-width: 420px)": {
                    slides: {
                        origin: 'center',
                        perView: 1.5,
                        spacing: 10,
                    },
                },
            }
      },
      
      plugins
    );
  }
}

  


new LastViewedComponent().runOnReady();
