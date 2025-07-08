function selectYear(request) {

  let startYear = 2020;
  let endYear = new Date().getFullYear();
  let options = '';

  for (let year = endYear; year >= startYear; year--) {
      options += `<option value="${year}" ${request == year ? 'selected' : ''}>${year}</option>`;
  }

  $('#yearSelect').html(options);
}
