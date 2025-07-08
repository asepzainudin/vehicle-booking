@extends('layouts.base')

@section('baseContent')

  <!--begin::App-->
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Body-->
      <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
          <div class="w-lg-500px p-10">
            {{ $slot }}
          </div>
          {{-- <div class="text-dark d-flex gap-2 flex-center">
            <img src="{{ cachedAsset('app/logo-bank-muamalat.png') }}" alt="" height="25">
            Powered by Bank Muamalat Indonesia
          </div> --}}
        </div>
        <!--end::Form-->

        <!--begin::Footer-->
        <div class="d-flex flex-center flex-wrap px-5">
          <div class="d-flex fw-semibold text-primary fs-base">
            {{--<a href="#" class="px-5" target="_blank">Terms</a>
            <a href="#" class="px-5" target="_blank">Plans</a>
            <a href="#" class="px-5" target="_blank">Contact Us</a>--}}
          </div>
        </div>
        <!--end::Footer-->
      </div>
      <!--end::Body-->

      <!--begin::Aside-->
      <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
           style="background-image: url({{ cachedAsset('assets/media/auth/bg1-dark.jpg') }})">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
          {{-- <div class="text-light fs-1" style="width: 50%">
            Dengan HijrahMasjid , mari bersama-sama menjadikan masjid sebagai rumah yang tidak hanya mendekatkan kita kepada Allah, tetapi juga menghadirkan kebahagiaan bagi seluruh jamaah. Karena ketika masjid berdaya, kebahagiaan jamaah pun akan terpancar.
            Masjid Berdaya, Jamaah Bahagia
            <br><br>
            – Bersama HijrahMasjid, Bangun Peradaban Umat!
          </div> --}}
          {{--<!--begin::Logo-->
          <a href="{{ routed('dashboard') }}" class="mb-12">
            <img alt="Logo" src="{{ image('logos/custom-1.png') }}" class="h-60px h-lg-75px"/>
          </a>
          <!--end::Logo-->

          <!--begin::Image-->
          <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
               src="{{ image('misc/auth-screens.png') }}" alt=""/>
          <!--end::Image-->

          <!--begin::Title-->
          <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
            Fast, Efficient and Productive
          </h1>
          <!--end::Title-->

          <!--begin::Text-->
          <div class="d-none d-lg-block text-white fs-base text-center">
            In this kind of post, <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>

            introduces a person they’ve interviewed <br/> and provides some background information about

            <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>
            and their <br/> work following this is a transcript of the interview.
          </div>
          <!--end::Text-->--}}
        </div>
        <!--end::Content-->
      </div>
      <!--end::Aside-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::App-->

@endsection
