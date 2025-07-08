@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable')
@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
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
