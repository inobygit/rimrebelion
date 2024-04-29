const path = require("path");
const { AssetsHelper } = require("../../inoby-theme/webpack/webpack-helpers.js");
const theme = new AssetsHelper(path.resolve(__dirname, "./../"));

const components = [
  ...theme.component("newsletter"),
  ...theme.component("payment"),
  ...theme.component("landing-hero"),
  ...theme.component("hero"),
  ...theme.component("cta-grid"),
  ...theme.component("article-boxes"),
];

module.exports = components;
