@php
if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
  echo '<i '.$attributes.'>'.$slot.'</i>';
}
@endphp
