const path = require("path");
const { AssetsHelper } = require("../../inoby-theme/webpack/webpack-helpers.js");
const theme = new AssetsHelper(path.resolve(__dirname, "./../"));

const components = [
  ...theme.component("newsletter"),
  ...theme.component("payment"),
];

module.exports = components;
