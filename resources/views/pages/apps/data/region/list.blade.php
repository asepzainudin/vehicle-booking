@extends('layouts.app')

@plugins('select2', 'flatpickr', 'dataTable', 'custom')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header flex-nowrap gap-5">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar  d-flex gap-2">
        @can('office-region.create')
          <a href="{{  routed('app.office-region.create') }}" class="btn btn-sm fw-bold btn-primary me-2" >Tambah</a>
        @endcan
        {{-- <x-button href="{{ routed('app.plafon.list', request()->merge(['export-excel' => 1])->input()) }}" class="btn-light-success btn-sm" label="Export Excel" icon="fad fa-file-excel" /> --}}
        <x-input.filter kfn-info-target="#filterMain" kfn-datatable="transfer-table" id="datatable"
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