<x-auth-layout>

  <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" data-kt-redirect-url="{{ routed('dashboard') }}" action="{{ routed('auth.login') }}">
    @csrf
    <div class="text-center mb-11">
      <h1 class="text-dark fw-bold display-3">
        {{-- Hijrah Maskapai --}}
      </h1>
      {{-- <div class="text-gray-500 fw-semibold fs-6">
        Maskapai Berdaya, Jamaah Bahagia
      </div> --}}
    </div>

    <div class="text-center mb-11">
      <h1 class="text-gray-900 fw-bolder">
        Sign In
      </h1>
    </div>

    <div class="fv-row mb-8">
      <input type="text" name="email" class="form-control bg-transparent @feedbackClass('email')" value="{{ old('email') }}" placeholder="Email" autocomplete="new-password" autofocus>
      @feedback('email')
    </div>

    <div class="fv-row mb-3">
      <input type="password" name="password" class="form-control bg-transparent @feedbackClass('password')" value="" placeholder="Password" autocomplete="new-password">
      @feedback('password')
    </div>

    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
      {{-- <div></div> --}}
      {{--<a href="{{ routed('auth.password.request') }}" class="link-primary">
        Forgot Password ?
      </a>--}}
    </div>

    <div class="d-grid mb-10">
      <button type="submit" id="kt_sign_in_submit" class="btn btn-primary" style="background-color: #701988">
        @include('partials/general/_button-indicator', ['label' => 'Sign In'])
      </button>
    </div>
  </form>

</x-auth-layout>
