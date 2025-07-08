@php
  if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
    $id = $attributes->get('id', $name ?? uniqid('btn-'));
    $classDefault = ['btn'];
    $rawClass = $attributes->get('class', '');
    $class = explode(' ', $rawClass);
    if (! isButtonClass($rawClass)) {
      $classDefault[] = 'btn-primary';
    }
    $icon = '';
    if ($attributes->has('icon')) {
      $icon = '<i class="'.$attributes->get('icon').'"></i>';
    }
    if($slot->isNotEmpty() || $attributes->has('label')) {
      $label = $slot->isNotEmpty() ? $slot : $attributes->get('label', '');
      $label = empty($icon) ? $label : "{$icon}<span class='ms-2'>{$label}</span>";
      if ($attributes->has('indicator')) {
        $idcLabel = $label;
        $label = '<span class="indicator-label">'.$idcLabel.'</span>';
        $label .= '<span class="indicator-progress">';
        $label .= '<span>Sedang Proses...</span>';
        $label .= '<span class="spinner-border spinner-border-sm align-middle ms-2"></span>';
        $label .= '</span>';
      }
    } else {
      $label = '';
      if (! empty($icon)) {
        $classDefault[] = 'btn-icon';
      }
    }

    $attributes->offsetSet('class', \Illuminate\Support\Arr::toCssClasses(array_merge($classDefault, $class)));
    $attributes->offsetSet('id', $id);

    if ($attributes->has('href')) {
      echo '<a '.$attributes->except(['label', 'icon']).'>'.$label.'</a>';
    } else {
      if (!$attributes->has('type')) {
        $attributes->offsetSet('type', 'submit');
      }
      echo '<button '.$attributes->except(['label', 'icon']).'>'.$label.'</a>';
    }
  }
@endphp
