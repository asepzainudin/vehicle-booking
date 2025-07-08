@php
if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
  $type = $attributes->get('type', 'text');
  $name = $attributes->get('name');
  $id = $attributes->get('id', str($name ?? uniqid('inp-'))->slug()->toString());
  $label = $attributes->get('label', 'Input');
  $labelAttributes = [];
  $labelClass = 'form-label '.$attributes->get('label-class');
  $labelAttributes[] = 'class="'.$labelClass.'"';

  $placeholder = $attributes->get('placeholder', '');
  $classDefault = ['form-control'];
  if ($name) {
    $name = str($name)->replace(['[', ']'], ['.', ''])->toString();
    $value = $attributes->get('value') ?? old($name);
    $classDefault[] = feedbackClass($name);
    $feedbackInput = feedbackInput($name);
  } else {
    $value = $slot ?? $attributes->get('value');
  }
  $class = explode(' ', $attributes->get('class', ''));

  $attributes->offsetSet('type', $type);
  $attributes->offsetSet('class', \Illuminate\Support\Arr::toCssClasses(array_merge($classDefault, $class)));
  $attributes->offsetSet('id', $id);
  if (!is_null($value)) {
    $attributes->offsetSet('value', $value);
  }
  $attributes->offsetSet('placeholder', $placeholder);
  // $attributes->offsetSet('placeholder-shown', 'false');

  $input = '<div class="form-floating form-floating-active">';
  $input .= '<input '.$attributes->except(['label']).'/>';
  $input .= '<label for="'.$id.'" '.implode(' ', $labelAttributes).'>'.$label.'</label>';
  $input .= $feedbackInput ?? '';
  $input .= '</div>';

  echo $input;
}
@endphp
