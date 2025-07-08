@if(
  $slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag &&
  !empty($kfnTable) && $kfnTable instanceof \Yajra\DataTables\Html\Builder
)
  @php
    $excludeAttributes = ['footer', 'add-class', 'content-valign', 'js-type'];

    $useFooter = $attributes->get('footer') ?? false;
    $class = config('datatables-html.table.class', '');
    if ($attributes->has('class')) {
      $class = $attributes->get('class');
    }
    if ($attributes->has('add-class')) {
      $class .= ' '.$attributes->get('add-class');
    }
    if ($attributes->has('content-valign')) {
      $class .= ' content-valign-'.$attributes->get('content-valign');
    }
    $attributes->offsetSet('class', $class);

    $jsAttributes = [];
    if ($attributes->has('js-type')) {
      $jsAttributes['type'] = $attributes->get('js-type');
    }

    echo $kfnTable->table($attributes->except(['footer'])->all(), $useFooter);
  @endphp
  @pushonce('scripts')
    {{ $kfnTable->scripts(attributes: $jsAttributes) }}
  @endpushonce
@endif
