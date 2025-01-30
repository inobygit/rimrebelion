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
  ...theme.component("category-slider"),
  ...theme.component("last-viewed"),
  ...theme.component("video-background"),
  ...theme.component("build-your-look"),
  ...theme.component("img-with-text"),
  ...theme.component("video"),
  ...theme.component("icon-boxes"),
  ...theme.component("quotes"),
  ...theme.component("references-slider"),
  ...theme.component("video-section"),
  ...theme.component("social-feed"),
];

module.exports = components;
