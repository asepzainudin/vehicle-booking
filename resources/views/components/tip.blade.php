@php
  if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag) {
    $id = $attributes->get('id', $name ?? uniqid('tip-'));
    $classDefault = ['alert', 'd-flex', 'flex-column', 'flex-sm-row'];
    $rawClass = $attributes->get('class', '');
    $class = explode(' ', $rawClass);
    if (! isThemeClass('bg-', $rawClass)) {
      $classDefault[] = 'bg-light-primary';
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

  <!--begin::Alert-->
<div class="alert bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10">
  <!--begin::Icon-->
  <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column pe-0 pe-sm-10">
    <!--begin::Title-->
    <h4 class="fw-semibold">This is an alert</h4>
    <!--end::Title-->

    <!--begin::Content-->
    <span>The alert component can be used to highlight certain parts of your page for higher content visibility.</span>
    <!--end::Content-->
  </div>
  <!--end::Wrapper-->

  <!--begin::Close-->
  <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
    <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
  </button>
  <!--end::Close-->
</div>
<!--end::Alert-->
