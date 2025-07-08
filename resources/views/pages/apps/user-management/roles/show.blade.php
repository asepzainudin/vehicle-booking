@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable')
@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>
  </div>

  <div class="row mb-3">

    <div class="col-md-3 mt-2">
      <div class="card card-flush ">
        <div class="card-header">
          <div class="card-title">
            <h2 class="mb-0">{{ $role->label ?? '' }}</h2>
          </div>
        </div>

        <div class="card-body pt-0">
          <div class="d-flex flex-column text-gray-600">
            @foreach ($role->permissions as $permission)
              <div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span> {{ $permission->label }}</div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-9 mt-2">
      <div class="card card-flush ">
        <div class="card-table">
          <div class="d-flex flex-column text-gray-600">
            <x-kfn-table />
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="card">
    <div class="card-footer d-flex justify-content-between">
      <x-button.back href="{{ $backLink }}">Kembali</x-button.back>
    </div>
  </div>
@endsection

@push('scripts')

  <script>
    $(function() {
      $('.filter-reset').on('click', function (e) {
        e.preventDefault();
        $(this).closest('form').trigger('reset');
      });
    });
  </script>
  @endpush
