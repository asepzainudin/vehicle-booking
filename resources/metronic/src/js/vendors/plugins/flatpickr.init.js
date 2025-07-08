"use strict";

//
// Flatpickr Initialization
//

// import $ from 'jquery';
// import flatpickr from 'flatpickr';
// window.monthSelectPlugin = require("flatpickr/dist/plugins/monthSelect");
// const Indonesian = require("flatpickr/dist/l10n/id.js");

flatpickr.localize(flatpickr.l10ns.id);

window.flatpickrConfigs = {
  date: {
    input: {altInput: true, altFormat: "d F Y"},
    inputGroup: {altInput: true, altFormat: "d F Y", wrap: true}
  },
  time: {
    input: {enableTime: true, noCalendar: true, time_24hr: true, format: "H:i"},
    inputGroup: {enableTime: true, noCalendar: true, time_24hr: true, format: "H:i", wrap: true}
  },
  datetime: {
    input: {altInput: true, enableTime: true, time_24hr: true, altFormat: "d F Y H:i", format: "Y-m-d H:i:s"},
    inputGroup: {altInput: true, enableTime: true, time_24hr: true, altFormat: "d F Y H:i", format: "Y-m-d H:i:s", wrap: true}
  },
  month: {
    input: {altInput: true, plugins: [new monthSelectPlugin({shorthand: true, dateFormat: "Y-m", altFormat: "F Y"})]},
    inputGroup: {altInput: true, wrap: true, plugins: [new monthSelectPlugin({shorthand: true, dateFormat: "Y-m", altFormat: "F Y"})]}
  }
};

$.each(flatpickrConfigs, (_k, _v) => {
  flatpickr(`input.${_k}`, _v.input);
  flatpickr(`.input-group.${_k}`, _v.inputGroup);
});
