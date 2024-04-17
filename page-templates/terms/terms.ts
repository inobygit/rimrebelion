import { InobyModule } from "@lib/inoby-module";

class PtTerms extends InobyModule {

  public run() {
    // this.initFunction();
    const url = window.location.href;
    const buttons = document.querySelectorAll('a');
    buttons.forEach(button => {
      const buttonHref = button.getAttribute('href').split('#')[0];
      if(url.includes(buttonHref)) {
        button.classList.add('active');
      }
    });
  }

  public runAdmin() {
    //
  }


}

new PtTerms().runOnReady();
