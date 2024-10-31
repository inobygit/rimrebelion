import { InobyModule } from "@lib/inoby-module";
import glightbox from "glightbox";
class VideoComponent extends InobyModule {
  run() {
    glightbox({
      selector: ".glightbox-item",
    });
  }
}

new VideoComponent().runOnReady();
