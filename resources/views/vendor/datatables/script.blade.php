@php
if(!empty($kfnTableNamespace)) {
  $ev = ".on('order.dt', function (x, y) {";
    $ev .= "const hh = '#filter-hidden';";
    $ev .= "if ($(hh).length > 0 && y.aaSorting.length > 0) {";
      $ev .= "$(hh + ' .filter-order').remove();";
      $ev .= "$.each(y.aaSorting, function (i, v) {";
        $ev .= "$(hh).append(`<input type='hidden' class='filter-order' name='kfn_order[\${i}][column]' value='\${v[0]}'>`)";
          $ev .= ".append(`<input type='hidden' class='filter-order' name='kfn_order[\${i}][dir]' value='\${v[1]}'>`);";
      $ev .= "});";
      $ev .= "makeUrlPersistence('#filter-form');";
    $ev .= "}";
  $ev .= "})";
  $ev .= ".on('search.dt', function (q) {";
    $ev .= "const hh = '#filter-hidden';";
    $ev .= "if ($(hh).length > 0) {";
      $ev .= "$(hh + ' .filter-search').remove();";
      $ev .= "$(hh).append(`<input type='hidden' class='filter-search' name='kfn_search' value='\${window.{$kfnTableNamespace}[\"%1\$s\"].search()}'>`);";
      $ev .= "makeUrlPersistence('#filter-form');";
    $ev .= "}";
  $ev .= "})";
  $ev .= ".on('length.dt', function (e, settings, len) {";
    $ev .= "const hh = '#filter-hidden';";
    $ev .= "if ($(hh).length > 0) {";
      $ev .= "$(hh + ' .filter-length').remove();";
      $ev .= "$(hh).append(`<input type='hidden' class='filter-length' name='kfn_length' value='\${len}'>`);";
      $ev .= "makeUrlPersistence('#filter-form');";
    $ev .= "}";
  $ev .= "})";

  echo "$(function(){window.{$kfnTableNamespace}=window.{$kfnTableNamespace}||{};window.{$kfnTableNamespace}[\"%1\$s\"]=$(\"#%1\$s\").DataTable(%2\$s);}){$ev};";
  foreach ($scripts ?? [] as $script) {
    includeIf($script);
  }
}
@endphp
