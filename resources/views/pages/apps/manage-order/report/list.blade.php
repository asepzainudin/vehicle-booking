@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable', 'custom')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header flex-nowrap gap-5">
      <div class="card-title"></div>
      <div class="card-toolbar  d-flex gap-2">
        <a href="{{ route('app.vehicle-report.list', ['type' => 'usage']) }}"
          class="btn btn-sm fw-bold btn-{{ request()->input('type') == 'usage' ? 'danger' : 'primary' }} me-2">
          Riwayat Pemakaian
        </a>

        <a href="{{ route('app.vehicle-report.list', ['type' => 'fuel']) }}"
          class="btn btn-sm fw-bold btn-{{ request()->input('type') == 'fuel' ? 'danger' : 'primary' }} me-2">
          Konsumsi BBM
        </a>

        <a href="{{ route('app.vehicle-report.list', ['type' => 'service']) }}"
          class="btn btn-sm fw-bold btn-{{ request()->input('type') == 'service' ? 'danger' : 'primary' }} me-2">
          Jadwal Service
        </a>

        <x-button href="{{ routed('app.vehicle-report.list', request()->merge(['export-excel' => 1, 'type' => request()->input('type')])->input()) }}" class="btn-light-success btn-sm ms-4" label="Export Excel" icon="fad fa-file-excel" />
        <x-input.filter kfn-info-target="#filterMain" kfn-datatable="vehicle-table" id="datatable"
          action="{{ routed('app.vehicle-report.list') }}">
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
