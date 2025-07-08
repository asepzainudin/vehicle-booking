@php
if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
  $type = $attributes->get('type', 'text');
  $name = $attributes->get('name');
  $id = $attributes->get('id', $name ?? uniqid('inp-'));
  $label = $attributes->get('label', 'Input');
  $labelAttributes = [];
  $labelClass = 'form-label '.$attributes->get('label-class');
  $labelAttributes[] = 'class="'.$labelClass.'"';

  $placeholder = $attributes->get('placeholder', '');
  $classDefault = ['form-control'];
  if ($name) {
    $classDefault[] = feedbackClass($name);
    $feedbackInput = feedbackInput($name);
  }
  $class = explode(' ', $attributes->get('class', ''));

  $attributes->offsetSet('type', $type);
  $attributes->offsetSet('class', \Illuminate\Support\Arr::toCssClasses(array_merge($classDefault, $class)));
  $attributes->offsetSet('id', $id);
  $attributes->offsetSet('placeholder', $placeholder);

  $input = '<div class="form-floating">';
  $input .= '<textarea '.$attributes->except(['label']).'>'.$slot.'</textarea>';
  $input .= '<label for="'.$id.'" '.implode(' ', $labelAttributes).'>'.$label.'</label>';
  $input .= $feedbackInput ?? '';
  $input .= '</div>';

  echo $input;
}
@endphp
