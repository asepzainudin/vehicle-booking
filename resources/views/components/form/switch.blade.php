@php
if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
  $type = $attributes->get('type', 'text');
  $name = $attributes->get('name');
  $nameStr = str($name)->replace(['[', ']'], ['.', ''])->toString();
  $id = $attributes->get('id', str(uniqid($name.'-'))->slug()->toString() );
  $label = $attributes->get('label', 'Input');
  $labelAttributes = [];
  $labelClass = 'form-check-label '.$attributes->get('label-class');
  $labelAttributes[] = 'class="'.$labelClass.'"';

  $placeholder = $attributes->get('placeholder', '');
  $classDefault = ['form-check', 'form-switch'];
  if ($name) {
    $value = old($name);
    $classDefault[] = feedbackClass($name);
    $feedbackInput = feedbackInput($name);
  } else {
    $value = $slot ?? $attributes->get('value');
  }
  $class = \Illuminate\Support\Arr::toCssClasses(
      array_merge($classDefault,
      explode(' ', $attributes->get('class', '')))
    );

  $attributes->offsetSet('type', $type == 'radio' ? 'radio' : 'checkbox');
  // $attributes->offsetSet('class', \Illuminate\Support\Arr::toCssClasses(array_merge($classDefault, $class)));
  $attributes->offsetSet('class', 'form-check-input');
  $attributes->offsetSet('id', $id);
  if ($value) {
    $attributes->offsetSet('value', $value);
  }
  if ($attributes->has('checked')) {
    $checked = $attributes->get('checked');
    $attributes->offsetUnset('checked');
    if (in_array($checked, ['true', '1'])) {
      $attributes->offsetSet('checked', 'checked');
    }
  }
  $attributes->offsetSet('placeholder', $placeholder);

  $input = '<div class="'.$class.'">';
  $input .= '<input '.$attributes->except(['label']).'/>';
  $input .= '<label for="'.$id.'" '.implode(' ', $labelAttributes).'>'.$label.'</label>';
  $input .= $feedbackInput ?? '';
  $input .= '</div>';

  echo $input;
}
@endphp
