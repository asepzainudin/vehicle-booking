<?php
  $loadedCss = '';
  $loadedJs = '';
  $currentTitle = ($pageTitle ?? 'Untitled') .' ~ '. config('app.title');

  foreach(getGlobalAssets('css') as $path):
    $loadedCss .= sprintf('<link rel="stylesheet" href="%s">', cachedAsset($path));
  endforeach;
  /*foreach(getVendors('css') as $path):
    $loadedCss .= sprintf('<link rel="stylesheet" href="%s">', cachedAsset($path));
  endforeach;
  foreach(getCustomCss() as $path):
    $loadedCss .= sprintf('<link rel="stylesheet" href="%s">', cachedAsset($path));
  endforeach;*/
  foreach(getGlobalAssets() as $path):
    $loadedJs .= sprintf('<script src="%s"></script>', cachedAsset($path));
  endforeach;
  /*foreach(getVendors('js') as $path):
    $loadedJs .= sprintf('<script src="%s"></script>', cachedAsset($path));
  endforeach;
  foreach(getCustomJs() as $path):
    $loadedJs .= sprintf('<script src="%s"></script>', cachedAsset($path));
  endforeach;*/
?><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<head>
  <base href="">
  <title>{{ $currentTitle }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="article">
  <meta property="og:title" content="">
  <link rel="canonical" href="{{ url()->current() }}">
 
  {!! includeFavicon() . includeFonts() . $loadedCss !!}
  <style>
    * {
      --color-dark: #2e2e2e;
      --color-dark-invert: #ffffff;
      --color-grey: #999999;
      --color-grey-invert: #ffffff;
      --bs-app-sidebar-base-bg-color: #701988;
      --bs-app-sidebar-light-bg-color: var(--bs-app-sidebar-base-bg-color);
      --bs-app-sidebar-dark-bg-color: var(--bs-app-sidebar-base-bg-color);
      --bs-app-header-base-bg-color: var(--bs-app-sidebar-base-bg-color);
      --bs-app-header-minimize-bg-color: var(--bs-app-sidebar-base-bg-color);
    }
    .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active, .navbar-nav .nav-link.show {
      background-color: rgba(var(--bs-dark-rgb), .75) !important;
      color: var(--bs-white) !important;
      padding-left: 1rem !important;
      padding-right: 1rem !important;
    }
    .text-white{ color: #ffffff; }
    .bg-muamalat{ color: #ffffff; background-color: #701988; }
    .border-muamalat{ border-style: solid; border-color: #701988; border-width: 3px; }
    .w-7{width:7%;}
    .w-9{width:9%;}
  </style>
  {!! $pluginCss ?? '' !!}@stack('styles')@if(hasStack('css'))<style>@stack('css')</style>@endif
  @if(config('app.livewire', false)) @livewireStyles @endif
</head>

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

  @include('partials/theme-mode/_init')

  @yield('baseContent')
  <div id="dynForm"></div>
  @stack('modal')

  {!! $loadedJs . ($pluginJs ?? '') !!}@stack('scripts')
  @if(hasStack('js'))<script>@stack('js')</script>@endif
  @if(config('app.livewire', false))
    <script>
      document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
          toastr.success(message);
        });
        Livewire.on('error', (message) => {
          toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
          if (typeof icon === 'undefined') {
            icon = 'success';
          }
          if (typeof confirmButtonText === 'undefined') {
            confirmButtonText = 'Ok, got it!';
          }
          Swal.fire({
            text: message,
            icon: icon,
            buttonsStyling: false,
            confirmButtonText: confirmButtonText,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        });
      });
    </script>
    @livewireScripts
  @endif
</body>
</html>