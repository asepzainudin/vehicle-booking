@extends('layouts.base')

@php
  app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
@endphp

@section('baseContent')
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/_header')
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/_sidebar')
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/_toolbar')
            <div id="kt_app_content" class="app-content flex-column-fluid">
              <div id="kt_app_content_container" class="app-container container-fluid">
                @yield('content', $slot ?? '')
              </div>
            </div>
          </div>
          @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/_footer')
        </div>
      </div>
    </div>
  </div>

  @include('partials/_drawers')

  @include('partials/_scrolltop')
@endsection

@prependonce('styles')
  <style>
    .table thead,
    .table tfoot,
    .dataTable thead {background:rgba(97, 41, 138, .9) !important;}
    .table thead th,
    .table tfoot th,
    .dataTable .dt-column-title {color:#fff !important;}
  </style>
@endprependonce