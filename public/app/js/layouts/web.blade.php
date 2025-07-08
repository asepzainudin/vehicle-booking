@extends('layouts.base')

@section('mainContent')
  <div class="wrapper flex grow flex-col">
    @includeIf('layouts.partial.app._header')
    <main class="grow content pt-5" id="content" role="content">
      <div class="container-fixed"></div>

      <div class="container-fixed" id="content_container">
        @yield('content', '')
      </div>
    </main>
    @includeIf('layouts.partial.app._footer')
  </div>
@endsection
