@extends('layouts.app')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="row gx-4 gx-xl-6">
    @foreach (\App\Enums\Qurban\QurbanMenu::cases() as $menu)
    <div class="col-lg-4 col-xxl-2 mt-2">
      <!--begin::Card-->
      <a href="{{ routed($menu->route()) }}">
        <div class="card h-100 border-muamalat">
          <!--begin::Card body-->
          <div class="card-body p-9">
            <!--begin::Heading-->
            <div class="fs-3 fw-bold">{{ $menu->label() }}</div>
            <div class="fs-7 fw-semibold text-gray-500 mb-7">{{ $menu->desc() }}</div>
            <!--end::Heading-->
          </div>
          <!--end::Card body-->
        </div>
      </a>
      <!--end::Card-->
    </div>
    @endforeach
  </div>
@endsection

@push('scripts')
@endpush