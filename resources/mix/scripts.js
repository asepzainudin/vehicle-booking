const glob = require('glob');

// Keenthemes' plugins
var componentJs = glob.sync(`resources/metronic/src/js/components/*.js`) || [];
var coreLayoutJs = glob.sync(`resources/metronic/src/js/layout/*.js`) || [];

module.exports = [
  ...componentJs,
  ...coreLayoutJs,
  'resources/mix/common/app-init.js',
  'resources/mix/common/button-ajax.js',
  'resources/mix/clear.js',
];
