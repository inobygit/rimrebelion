(()=>{"use strict";class n{constructor(){this.runned=!1}runOnReady(){t.runOnReady(this)}}class o extends n{constructor(){super(...arguments),this.runnedAdmin=!1}}class t{constructor(){this.isReady=!1}static addModule(n){window.inobyModules||(window.inobyModules=[]),window.inobyModules.push(n)}static getInstance(){return t.instance||(t.instance=new t),t.instance}static runOnReady(n){t.addModule(n),window.wasReady&&t.runModule(n)}static onReady(){var n;window.wasReady=!0,null===(n=window.inobyModules)||void 0===n||n.forEach((n=>{t.runModule(n)}))}static runModule(n){n instanceof o&&(null===window||void 0===window?void 0:window.adminpage)&&!n.runnedAdmin?document.addEventListener("mb_blocks_preview/"+n.metaboxId,(()=>{n.runnedAdmin=!0,n.runAdmin()})):n.runned||(n.runned=!0,n.run(),"function"==typeof n.runAsync&&setTimeout((()=>{n.runAsync()}),200))}}"loading"!==document.readyState?t.onReady():document.addEventListener("DOMContentLoaded",(()=>t.onReady()));const e=jQuery;class i extends n{run(){this.disableRcAnchorScroll()}runAsync(){this.initAnchorScroll(),this.scrollToUrlAnchor()}disableRcAnchorScroll(){var n;(null===(n=window.rootcommerce)||void 0===n?void 0:n.App)&&(Object.getPrototypeOf(window.rootcommerce.App).initAnchorScroll=function(){})}static scrollTo(n,o=500){const t="string"==typeof n?e(n):n;t.length>0&&e("html,body").animate({scrollTop:t.offset().top-(window.pageScrollOffset||e("#header").height())},o)}static disableAnchorScrolling(){window.disableAnchorScroll=!0}static enableAnchorScrolling(){window.disableAnchorScroll=!1}initAnchorScroll(){window.anchorScrollInitialized||e('a[href*="#"]').on("click",(function(n){if("#"!==e(this).attr("href")&&!e(this).hasClass("no-scroll")){var o="#"+e(this).attr("href").split("#")[1],t=e(o);!window.disableAnchorScroll&&t.length&&"tabpanel"!==t.attr("role")&&(n.preventDefault(),i.scrollTo(t),window.location=o)}}))}scrollToUrlAnchor(){location.hash&&i.scrollTo(location.hash)}}(new class extends n{run(){i.disableAnchorScrolling();const n=$(location.hash);n.length>0&&i.scrollTo(n)}}).runOnReady()})();