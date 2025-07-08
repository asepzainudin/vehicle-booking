@if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag)
  @props([
    'action' => null,
  ])
  @php
    $excludedAttributes = ['id', 'label', 'method', 'action', 'kfn-info-target', 'kfn-datatable'];
    $id = $attributes->get('id', 'filter-menu');
    $filterId = $id;
    $label = $attributes->get('label');
    $formMethod = $attributes->get('method', 'get');
    $formAction = $attributes->get('action', '');
    $dtTarget = $attributes->get('kfn-datatable');
    if ($dtTarget) {
      $dtTarget = " data-kfn-datatable='{$dtTarget}'";
    }
    $infoTarget = '';
    $kfnInfoTarget = $attributes->get('kfn-info-target');
    if ($kfnInfoTarget) {
      $infoTarget = " data-kfn-filter-info='{$kfnInfoTarget}'";
      $kfnInfoTarget = " data-kfn-filter-info-target='{$kfnInfoTarget}'";
    }
    $defaultAttributes = [
      'class' => 'btn btn-sm btn-flex btn-secondary fw-bold' . ($label ? '' : ' btn-icon'),
    ];
    if($slot->isEmpty()) {
      $content = '<div class="fst-italic text-gray-400 text-center">~ belum tersedia kriteria filter ~</div>';
    } else {
      $content = $slot;
    }
  @endphp
  <div class="m-0">
    <button type="button" id="{{ $id }}" {!! $attributes->merge($defaultAttributes)->except($excludedAttributes) !!}
            data-bs-toggle="modal"
            data-bs-target="#kfn-filter-{{ $filterId }}">
      <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
      {{ $label ?? '' }}
    </button>

    <div class="modal fade modal-filter" tabindex="-1" id="kfn-filter-{{ $filterId }}"
         data-bs-focus="false"
         data-bs-backdrop="static"
         data-kfn-dragablexx="true" {!! $kfnInfoTarget !!}>
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Kriteria Filter</h3>
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
          </div>
          <form method="{{ $formMethod }}" action="{{ $formAction }}" id="filter-form" {!! $infoTarget . $dtTarget !!}>
            <div id="filter-hidden" style="display:none"></div>
            <div class="modal-body min-h-10px mh-425px">
              {!! $content !!}
            </div>
            <div class="modal-footer">
              <div class="w-100 d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary filter-cancel" id="filterCancel-{{ $filterId }}" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <div>
                  @if(!$action)
                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2 filter-reset" id="filterReset-{{ $filterId }}">{{ __("Reset") }}</button>
                    <button type="submit" class="btn btn-sm btn-primary filter-apply" id="filterApply-{{ $filterId }}" data-bs-dismiss="modal">{{ __('Apply') }}</button>
                  @else
                    {{-- {{ $action }} --}}
                    <button type="submit" class="btn btn-sm btn-primary" form="filter-form">{{ __('Apply') }}</button>
                  @endif
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif
