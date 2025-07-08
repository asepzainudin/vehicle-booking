"use strict";

//
// Select2 Initialization
//

$.fn.select2.defaults.set("language", "select2/i18n/id");
$.fn.select2.defaults.set("theme", "bootstrap5");
$.fn.select2.defaults.set("width", "100%");
$.fn.select2.defaults.set("selectionCssClass", ":all:");

if ($('.select2').length > 0) {
  $('.select2').select2();
  $('.select2.infinite').select2({
    minimumResultsForSearch: Infinity
  });
}
