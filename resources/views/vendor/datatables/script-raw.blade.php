$(function(){window.{{ $KfnTableNamespace }}=window.{{ $KfnTableNamespace }}||{};window.{{ $KfnTableNamespace }}["%1$s"]=$("#%1$s").DataTable(%2$s);});
@foreach($scripts as $script)@includeIf($script)@endforeach

<script>
  xxx
    .on('order.dt', function (x, y) {
      const hh = '#filter-hidden';
      if ($(hh).length > 0 && y.aaSorting.length > 0) {
        $(hh + ' .filter-order').remove();
        $.each(y.aaSorting, function (i, v) {
          $(hh).append(`<input type="hidden" class="filter-order" name="wow_order[${i}][column]" value="${v[0]}">`)
            .append(`<input type="hidden" class="filter-order" name="wow_order[${i}][dir]" value="${v[1]}">`);
        });
        makeUrlPersistence('#filter-form');
      }
    })
    .on('search.dt', function (q) {
      const hh = '#filter-hidden';
      if ($(hh).length > 0) {
        $(hh + ' .filter-search').remove();
        $(hh).append(`<input type="hidden" class="filter-search" name="wow_search" value="${window.{{ $KfnTableNamespace }}["%1$s"].search()}">`);
        makeUrlPersistence('#filter-form');
      }
    })
    .on('length.dt', function (e, settings, len) {
      const hh = '#filter-hidden';
      if ($(hh).length > 0) {
        $(hh + ' .filter-length').remove();
        $(hh).append(`<input type="hidden" class="filter-length" name="wow_length" value="${len}">`);
        makeUrlPersistence('#filter-form');
      }
    });
</script>
