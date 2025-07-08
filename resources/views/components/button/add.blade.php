@php
  if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
    $id = $attributes->get('id', $name ?? uniqid('btn-'));
    $classDefault = ['btn'];
    $rawClass = $attributes->get('class', '');
    $class = explode(' ', $rawClass);
    if (! isButtonClass($rawClass)) {
      $classDefault[] = 'btn-primary';
    }
    $icon = $attributes->get('icon') ?? 'fad fa-plus';

    if($slot->isNotEmpty() || $attributes->has('label')) {
      $label = $slot->isNotEmpty() ? $slot : $attributes->get('label', '');
      $label = "<span class='ms-2'>{$label}</span>";
    } else {
      $label = '';
      $classDefault[] = 'btn-icon';
    }

    $attributes->offsetSet('class', \Illuminate\Support\Arr::toCssClasses(array_merge($classDefault, $class)));
    $attributes->offsetSet('id', $id);

    echo '<a '.$attributes->except(['label', 'icon']).'>';
    echo '<i class="'.$icon.'"></i>'. $label;
    echo '</a>';
  }
@endphp
