$(document).on('click', '.button-ajax', function (e) {
  e.preventDefault();
  const action = $(this).data('action');
  const method = $(this).data('method');
  const csrf = $(this).data('csrf');
  const reload = $(this).data('reload');

  axios.request({
    url: action,
    method: method,
    data: {
      _token: csrf
    },
  })
    .then(function (response) {
      // console.log(response);
    })
    .catch(function (error) {
      // console.log(error);
    })
    .then(function () {
      if (reload) {
        window.location.reload();
      }
    });
});
