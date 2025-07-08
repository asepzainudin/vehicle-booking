<?php
$appLocale = app()->getLocale();
$appLang = str_replace('_', '-', $appLocale);
$currentTitle = ($pageTitle ?? 'Untitled') .' ~ '. config('app.title');
?><!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="{{ $appLang }}">
<head>
  <base href="/">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=yes">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:url" content="{{ url('/') }}">
  <meta property="og:locale" content="{{ $appLocale }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="@surabaya-pariwisata">
  <meta property="og:title" content="{{ $currentTitle }}">
  <meta property="og:description" content="">
  <meta property="og:image" content="{{ asset('media/app/og-image.png') }}">
  <title>{{ $currentTitle }}</title>
  <style>
    [x-cloak] {display: none !important;}
  </style>

  @vite(['resources/css/fonts.scss', 'resources/css/app.scss']){!! $pluginCss ?? '' !!}
  @stack('style')<style>@stack('css')</style>
</head>
@yield('mainContent', '')
</html>
