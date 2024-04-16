const { AssetsHelper } = require("../inoby-theme/webpack/webpack-helpers");
const child = new AssetsHelper(__dirname);

const def_child = {
  core: [
    ...child.assets(["css/theme.scss"]),
    ...child.assets(["css/footer.scss"]),
    ...child.assets(["css/cart.scss"]),
    ...child.assets(["css/notifications.scss"]),
    ...child.entry("components"),
    //
  ],

  config: child.assets(["config.json", "image-sizes.json", "plugins.json"], "config"),

  post_types: {
    product: child.post_type("product"),
  },

  checkout: [
    ...child.assets(["css/checkout.scss"]),
    ...child.assets(["js/checkout.js"]),
    //
  ],

  page_templates: {
    // page_template: child.template("page-template")
  },

  gutenberg: [...child.entry("components")],
};

module.exports = def_child;
