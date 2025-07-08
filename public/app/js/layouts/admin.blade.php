@extends('layouts.base')

@section('mainContent')
<body class="flex h-full theme1 sidebar-fixed header-fixed bg-[#fefefe] dark:bg-coal-500">
  <script type="module">
    const defaultThemeMode = 'light'; // light|dark|system
    let themeMode;
    if (document.documentElement) {
      if (localStorage.getItem('theme')) {
        themeMode = localStorage.getItem('theme');
      } else if (document.documentElement.hasAttribute('data-theme-mode')) {
        themeMode = document.documentElement.getAttribute('data-theme-mode');
      } else {
        themeMode = defaultThemeMode;
      }
      if (themeMode === 'system') {
        themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }
      document.documentElement.classList.add(themeMode);
    }
  </script>
  <div class="flex grow">
    @includeIf('layouts.partial.app._sidebar')
    <div class="wrapper flex grow flex-col">
      @includeIf('layouts.partial.app._header')
      <main class="grow content pt-5" id="content" role="content">
        <div class="container-fixed"></div>

        @if(hasSections('pageTitle', 'pageSubtitle', 'pageToolbar'))
          <div class="container-fixed">
            <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
              <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-semibold leading-none text-gray-900">
                  @yield('pageTitle', '')
                </h1>
                <div class="flex items-center gap-2 text-sm font-medium text-gray-600">
                  @yield('pageSubtitle', '')
                </div>
              </div>
              <div class="flex items-center gap-2.5">
                @yield('pageToolbar', '')
              </div>
            </div>
          </div>
        @endif

        <div class="container-fixed" id="content_container">
          @yield('content', '')
        </div>
      </main>
      @includeIf('layouts.partial.app._footer')
    </div>
  </div>
  @stack('modal')

  @vite('resources/js/app.js'){!! $pluginJs ?? '' !!}
  @stack('script')<script type="module">@stack('js')</script>
</body>
@endsection
