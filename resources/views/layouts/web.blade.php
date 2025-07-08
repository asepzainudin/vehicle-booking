@extends('layouts.base')

@php
  app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();

  $loadedJs = '';
  foreach(getGlobalAssets() as $path):
    $loadedJs .= sprintf('<script src="%s"></script>', cachedAsset($path));
  endforeach;

  $htmlBody = printHtmlClasses('body').' '.printHtmlAttributes('body');
  $navHeaderHeight = '75px';
@endphp

@section('baseContent')
<body {!! $htmlBody !!}>
  <div class="d-flex flex-column flex-root mb-10" id="kt_app_root">
    <div class="mb-0" id="home">
      <div class="">
        {{--<div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">--}}
        <div class="landing-header fixed-top bg-main border-bottom border-bottom-3 border-light shadow" style="height:{{ $navHeaderHeight }};">
          <div class="container">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center flex-equal">
                {{--begin::Mobile menu toggle--}}
                <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
                  <i class="ki-duotone ki-abstract-14 fs-2hx"><span class="path1"></span><span class="path2"></span></i>
                </button>
                {{--end::Mobile menu toggle--}}
                {{--begin::Logo image--}}
                <a href="{{ routed('home') }}">
                  <img alt="Logo" src="{{ cachedAsset('assets/web/logo-white-sm.webp') }}" class="logo-default h-50px" />
                  {{--<img alt="Logo" src="{{ cachedAsset('assets/media/logos/landing-dark.svg') }}" class="logo-sticky h-20px h-lg-25px" />--}}
                </a>
                {{--end::Logo image--}}
              </div>
              <div class="d-flex gap-5">
                {{--begin::Menu wrapper--}}
                <div class="d-lg-block" id="kt_header_nav_wrapper">
                  <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                    @includeIf('layouts.partials.web._menus')
                  </div>
                </div>
                {{--end::Menu wrapper--}}
                {{--begin::Toolbar--}}
                {{--<div class="flex-equal text-end ms-1">
                  <a href="authentication/layouts/corporate/sign-in.html" class="btn btn-success">Sign In</a>
                </div>--}}
                {{--end::Toolbar--}}
              </div>
            </div>
            {{--end::Wrapper--}}
          </div>
        </div>
        <div style="margin-top:{{ $navHeaderHeight }};">@yield('hero', '')</div>
      </div>
      {{--end::Wrapper--}}
    </div>
    <div class="mt-10 mb-n10 mb-lg-n20 z-index-2">
      <div class="container">
        @yield('content', '')
      </div>
    </div>
  </div>
  <div class="mt-20 mb-0">
    @includeIf('layouts.partials.web.footer')
  </div>
  <div id="dynForm"></div>
  <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
  </div>
  @stack('modal')
  {!! $loadedJs . ($pluginJs ?? '') !!}@stack('scripts')
  @if(hasStack('js'))<script>@stack('js')</script>@endif
</body>
@endsection
