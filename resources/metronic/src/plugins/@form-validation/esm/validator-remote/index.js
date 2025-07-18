import {utils} from '../core/index.js';

/**
 * FormValidation (https://formvalidation.io)
 * The best validation library for JavaScript
 * (c) 2013 - 2023 Nguyen Huu Phuoc <me@phuoc.ng>
 */
var fetch = utils.fetch, removeUndefined = utils.removeUndefined;

function remote() {
  var DEFAULT_OPTIONS = {
    crossDomain: false,
    data: {},
    headers: {},
    method: 'GET',
    validKey: 'valid',
  };
  return {
    validate: function (input) {
      if (input.value === '') {
        return Promise.resolve({
          valid: true,
        });
      }
      var opts = Object.assign({}, DEFAULT_OPTIONS, removeUndefined(input.options));
      var data = opts.data;
      // Support dynamic data
      if ('function' === typeof opts.data) {
        data = opts.data.call(this, input);
      }
      // Parse string data from HTML5 attribute
      if ('string' === typeof data) {
        data = JSON.parse(data);
      }
      data[opts.name || input.field] = input.value;
      // Support dynamic url
      var url = 'function' === typeof opts.url
        ? opts.url.call(this, input)
        : opts.url;
      return fetch(url, {
        crossDomain: opts.crossDomain,
        headers: opts.headers,
        method: opts.method,
        params: data,
      })
        .then(function (response) {
          return Promise.resolve({
            message: response['message'],
            meta: response,
            valid: "".concat(response[opts.validKey]) === 'true',
          });
        })
        .catch(function (_reason) {
          return Promise.reject({
            valid: false,
          });
        });
    },
  };
}

export {remote};
