@extends('layouts.base')

@section('mainContent')
<body class="antialiased flex h-full text-base text-gray-700 dark:bg-coal-500">
  <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
    @yield('content', '')
  </div>
  @stack('modal')
  @vite('resources/js/app.js'){!! $pluginJs ?? '' !!}
  @stack('script')<script type="module">@stack('js')</script>
</body>
@endsection
