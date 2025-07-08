@if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag)
@props([
  'action' => null,
])
@php
  $id = $attributes->get('id', 'filter-menu');
  $label = $attributes->get('label');
  $formMethod = $attributes->get('method', 'get');
  $formAction = $attributes->get('action', '');
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
  <button type="button" id="{{ $id }}" {!! $attributes->merge($defaultAttributes)->except(['label']) !!} data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-offset="0,5">
    <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
    {{ $label ?? '' }}
  </button>
  <div class="menu menu-sub menu-sub-dropdown w-300px w-md-500px" data-kt-menu="true">
    <div class="px-7 py-5">
      <div class="fs-5 text-gray-900 fw-bold">Kriteria Filter</div>
    </div>
    <div class="separator border-gray-200"></div>
    <form method="{{ $formMethod }}" action="{{ $formAction }}" id="filter-form">
      <div id="filter-hidden" style="display:none"></div>
      <div class="px-7 py-5">
        <div class="scroll min-h-10px mh-425px">
          {!! $content !!}
        </div>
      </div>
      <div class="separator border-gray-200"></div>
      <div class="d-flex justify-content-end px-7 py-5">
        @if(!$action)
          <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2 filter-reset" id="filterFormReset" data-kt-menu-dismiss="true">Reset</button>
          <button type="submit" class="btn btn-sm btn-primary filter-apply" id="filterFormApply" data-kt-menu-dismiss="true">Terapkan</button>
        @else
          {{ $action }}
        @endif
      </div>
    </form>
  </div>
</div>
@endif
