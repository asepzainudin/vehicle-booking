@if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag)
  @php
    $excludedAttributes = ['label', 'required', 'row-col'];
    $label = $attributes->get('label');
    $required = $attributes->has('required') ? ' required' : '';
    switch ($attributes->get('row-col')) {
      case 2:
        $colLabel = 'col-sm-4';
        $colInput = 'col-sm-8';
        break;
      default:
        $colLabel = 'col-sm-2';
        $colInput = 'col-sm-10';
    }

    $defaultAttributes = [
      'class' => 'row',
    ];
  @endphp
  <div {!! $attributes->merge($defaultAttributes)->except($excludedAttributes) !!}>
    <div class="col-12 {{ $colLabel }}">
      <label class="col-form-label{{ $required }}">{!! $label !!}</label>
    </div>
    <div class="col-12 {{ $colInput }}">
      {{ $slot }}
    </div>
  </div>
@endif
