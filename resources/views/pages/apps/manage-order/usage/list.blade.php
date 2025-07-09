@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable', 'custom')

@section('pageTitle', $pageTitle)

@php
  $routeMap = [
      'app.vehicle-usage' => route('app.vehicle-usage.create', $vehicleOrder->hash_id),
      'app.vehicle-fuel' => route('app.vehicle-fuel.create', $vehicleOrder->hash_id),
      'app.vehicle-service' => route('app.vehicle-service.create', $vehicleOrder->hash_id),
  ];

  $currentRoute = collect($routeMap)->first(function ($url, $key) {
      return request()->routeIs($key . '*');
  });
@endphp

@section('content')
  <div class="card">
    <div class="card-header flex-nowrap gap-5">
      <div class="card-title"></div>
      <div class="card-toolbar  d-flex gap-2">
        <a href="{{ route('app.vehicle-usage.list', $vehicleOrder->hash_id) }}"
          class="btn btn-sm fw-bold btn-{{ request()->routeIs('app.vehicle-usage*') ? 'danger' : 'primary' }} me-2">
          Riwayat Pemakaian
        </a>

        <a href="{{ route('app.vehicle-fuel.list', $vehicleOrder->hash_id) }}"
          class="btn btn-sm fw-bold btn-{{ request()->routeIs('app.vehicle-fuel*') ? 'danger' : 'primary' }} me-2">
          Konsumsi BBM
        </a>

        <a href="{{ route('app.vehicle-service.list', $vehicleOrder->hash_id) }}"
          class="btn btn-sm fw-bold btn-{{ request()->routeIs('app.vehicle-service*') ? 'danger' : 'primary' }} me-2">
          Jadwal Service
        </a>
        <a href="{{ $currentRoute ?? '#' }}" class="btn btn-sm fw-bold btn-primary me-2">
            Tambah
        </a>
        {{-- <x-button href="{{ routed('app.plafon.list', request()->merge(['export-excel' => 1])->input()) }}" class="btn-light-success btn-sm" label="Export Excel" icon="fad fa-file-excel" /> --}}
        <x-input.filter kfn-info-target="#filterMain" kfn-datatable="vehicle-table" id="datatable"
          action="{{ routed('app.plafon.list') }}">
          <div class="d-flex flex-column gap-5">
            <div class="d-flex gap-5">
              {{-- <div class="form-group">
                <label class="form-label fw-semibold">Tahun :</label>
                <select name="year" id="yearSelect" class="form-select form-select-solid" data-kfn-filter
                  data-kfn-filter-label="Tahun" data-kt-select2="true" data-placeholder="Pilih Tahun"
                  data-hide-search="true" data-allow-clear="true" data-close-on-select="false"
                  data-input="{{ old('year') }}">
                  <option value="{{ old('year') }}" selected> {{ old('year') }}"</option>
                </select>
              </div> --}}
            </div>
          </div>

        </x-input.filter>

      </div>
    </div>
    <div class="card-table">
      <x-kfn-table />
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('.filter-reset').on('click', function(e) {
        e.preventDefault();
        $(this).closest('form').trigger('reset');
      });

    });

    function selectYear(request) {

      let startYear = 2020;
      let endYear = new Date().getFullYear();
      let options = '';

      for (let year = endYear; year >= startYear; year--) {
        options += `<option value="${year}" ${request == year ? 'selected' : ''}>${year}</option>`;
      }

      $('#yearSelect').html(options);
    }

    let modal = document.getElementById("kfn-filter-datatable");

    modal.addEventListener("shown.bs.modal", function() {
      selectYear({{ request()->input('year') }});
    });
  </script>
@endpush
