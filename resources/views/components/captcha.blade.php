@php
  if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
    $captchaAttributes = [
      'data-theme' => $attributes->get('theme', 'light'),
    ];

    // echo NoCaptcha::display($captchaAttributes);
  }
@endphp
