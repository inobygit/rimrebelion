const path = require("path");
const { MergeHelper, AssetsHelper, BuildHelper } = require("../inoby-theme/webpack/webpack-helpers");
const parent_config = require("../inoby-theme/webpack.config");
const entry = require("./webpack.entry");
const assets = new AssetsHelper(__dirname);

const config = {
  entry: new BuildHelper(entry).build(),
  output: {
    path: path.resolve(__dirname, "build"),
  },
};

module.exports = MergeHelper.merge([parent_config, config]);
