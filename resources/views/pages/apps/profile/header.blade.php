@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable')
@section('pageTitle', $pageTitle)

@section('content')
    <!--begin::Navbar-->
    <div class="card mb-6 mb-xl-9">
      <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
          <!--begin::Image-->
          <div
            class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
            <img class="mw-50px mw-lg-75px"
              src="{{ cachedAsset('assets/media/svg/files/blank-image.svg') }}"
              alt="image">
          </div>
          <!--end::Image-->

          <!--begin::Wrapper-->
          <div class="flex-grow-1">
            <!--begin::Head-->
            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
              <!--begin::Details-->
              <div class="d-flex flex-column">
                <!--begin::Status-->
                <div class="d-flex align-items-center mb-1">
                  <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $user->name }}</a>
                  <span class="badge badge-light-success me-auto"></span>
                </div>
                <!--end::Status-->

                <!--begin::Description-->
                <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                </div>
                <!--end::Description-->
              </div>
              <!--end::Details-->
            </div>
            <!--end::Head-->

            <!--begin::Info-->
            <div class="d-flex flex-wrap justify-content-start">
              <!--begin::Stats-->
              <div class="d-flex flex-wrap">
                <!--begin::Stat-->
                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                  <!--begin::Number-->
                  <div class="d-flex align-items-center">
                    <div class="fs-4 fw-bold">{{ $user->created_at->format('F d, Y') }}</div>
                  </div>
                  <!--end::Number-->

                  <!--begin::Label-->
                  <div class="fw-semibold fs-6 text-gray-400">Tanggal Dibuat</div>
                  <!--end::Label-->
                </div>
                <!--end::Stat-->
              </div>
              <!--end::Stats-->

            </div>
            <!--end::Info-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Details-->

        <div class="separator"></div>

        <!--begin::Nav-->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">

          <!--begin::Nav item-->
          <li class="nav-item mt-2">
            <a class="nav-link text-active-primary ms-0 me-10 py-5"
              href="#">
              Ringkasan </a>
          </li>
          <!--end::Nav item-->

          <!--begin::Nav item-->
          <li class="nav-item mt-2">
            <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ set_active('app.profile.user') }}"
              href="{{ routed('app.profile.user', $user->hash) }}">
              Profil </a>
          </li>
          <!--end::Nav item-->

          {{-- <!--begin::Nav item-->
          <li class="nav-item mt-2">
            <a class="nav-link text-active-primary ms-0 me-10 py-5 "
              href="https://donation.class.id/admin/company/contributor/zaPJ51Kr">
              Donatur </a>
          </li>
          <!--end::Nav item--> --}}

          @if (auth()->user()?->hasAnyRole(['fop_approval']) || auth()->user()?->hasAnyRole(['fop_maker']) || auth()->user()?->hasAnyRole(['admin']) )
            <!--begin::Nav item-->
            <li class="nav-item mt-2">
              <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ set_active('app.profile.accounts') }}"
                href="{{ routed('app.profile.accounts', $user->hash) }}">
                Akun User</a>
            </li>
            <!--end::Nav item-->
          @endif

        </ul>
        <!--end::Nav-->
      </div>
    </div>
    <!--end::Navbar-->
    @yield('subcontent')
@endsection

@push('styles')
  <style>
    .image-input-placeholder {
      background-image: url({{ old('wall_path') ?? cachedAsset('assets/media/svg/files/blank-image.svg') }});
      background-size: cover;
      background-position: center;
    }
    [data-theme="dark"] .image-input-placeholder {
      background-image: url({{ old('wall_path') ?? cachedAsset('assets/media/svg/files/blank-image-dark.svg') }});
    }
  </style>
@endpush

@push('scripts')
  <script>
    $(function() {
      $('.filter-reset').on('click', function(e) {
        e.preventDefault();
        $(this).closest('form').trigger('reset');
      });
    });
  </script>
@endpush
