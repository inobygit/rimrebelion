const { AssetsHelper } = require("../inoby-theme/webpack/webpack-helpers");
const child = new AssetsHelper(__dirname);

const def_child = {
  core: [
    ...child.assets(["css/theme.scss"]),
    ...child.assets(["css/footer.scss"]),
    ...child.assets(["css/cart.scss"]),
    ...child.assets(["css/notifications.scss"]),
    ...child.assets(["js/mega-menu.js"]),
    ...child.entry("components"),
    ...child.plugin("topbar", "webpack.entry", "show_topbar"),
    ...child.plugin("header"),
    //
  ],

  config: child.assets(["config.json", "image-sizes.json", "plugins.json"], "config"),

  post_types: {
    product: child.post_type("product"),
    looks: child.post_type("looks"),
  },

  checkout: [
    ...child.assets(["css/checkout.scss"]),
    ...child.assets(["js/checkout.js"]),
    //
  ],

  my_account: [
    ...child.assets([
      "css/my-account.scss",
      //
    ]),
  ],

  page_templates: {
    // page_template: child.template("page-template")
    terms: child.template("terms"),
    landing: child.template("landing"),
    page404: child.assets(["css/404.scss"]),
  },

  gutenberg: [...child.entry("components")],
};

module.exports = def_child;
