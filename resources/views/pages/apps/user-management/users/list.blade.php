@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable')
@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header flex-nowrap gap-5">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar">
        <a href="{{ routed('app.user.create') }}" class="btn btn-sm fw-bold btn-primary me-2">Tambah</a>
      </div>
    </div>
    <x-input.filter-info />
    <div class="card-table">
      <x-kfn-table />
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
