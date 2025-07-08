@if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag)
  @php
    $excludedAttributes = [];
    $defaultAttributes = [
      'id' => 'filterMain',
      'class' => 'card-body d-none gap-5 flex-wrap',
    ];
  @endphp
  <div {!! $attributes->merge($defaultAttributes)->except($excludedAttributes) !!}></div>
@endif
