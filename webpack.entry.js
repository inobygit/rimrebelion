const { AssetsHelper } = require("../inoby-theme/webpack/webpack-helpers");
const child = new AssetsHelper(__dirname);

const def_child = {
  core: [
    ...child.assets(["css/theme.scss"]),
    ...child.assets(["css/footer.scss"]),
    ...child.entry("components"),
    //
  ],

  config: child.assets(["config.json", "image-sizes.json", "plugins.json"], "config"),

  post_types: {
    // post_type: child.post_type("post-type")
  },

  page_templates: {
    // page_template: child.template("page-template")
  },

  gutenberg: [...child.entry("components")],
};

module.exports = def_child;
