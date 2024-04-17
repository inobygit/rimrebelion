import { InobyModule } from "@lib/inoby-module";

class PtTerms extends InobyModule {

  public run() {
    // this.initFunction();
    const url = window.location.href;
    const buttons = document.querySelectorAll('a');
    buttons.forEach(button => {
      if (url.includes(button.getAttribute('href'))) {
        button.classList.add('active');
      }
    });
  }

  public runAdmin() {
    //
  }


}

new PtTerms().runOnReady();
