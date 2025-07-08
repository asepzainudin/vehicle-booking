@php
if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
  $type = $attributes->get('type', 'text');
  $name = $attributes->get('name');
  $id = $attributes->get('id', str($name ?? uniqid('slc-'))->slug()->toString());
  $label = $attributes->get('label', 'Select');
  $labelAttributes = [];
  $labelClass = 'form-label '.$attributes->get('label-class');
  $labelAttributes[] = 'class="'.$labelClass.'"';

  $placeholder = $attributes->get('placeholder', '');
  $classDefault = ['form-select'];
  if ($name) {
    $name = str($name)->replace(['[', ']'], ['.', ''])->toString();
    $classDefault[] = feedbackClass($name);
    $feedbackInput = feedbackInput($name);
  }
  $class = explode(' ', $attributes->get('class', ''));

  $attributes->offsetSet('type', $type);
  $attributes->offsetSet('class', \Illuminate\Support\Arr::toCssClasses(array_merge($classDefault, $class)));
  $attributes->offsetSet('id', $id);
  $attributes->offsetSet('placeholder', $placeholder);

  $input = '<div class="form-floating">';
  $input .= '<select '.$attributes->except(['label']).'>'.$slot.'</select>';
  $input .= '<label for="'.$id.'" '.implode(' ', $labelAttributes).'>'.$label.'</label>';
  $input .= $feedbackInput ?? '';
  $input .= '</div>';

  echo $input;
}
@endphp
