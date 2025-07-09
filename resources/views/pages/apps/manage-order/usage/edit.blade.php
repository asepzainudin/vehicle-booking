@extends('layouts.app')

@plugins('select2', 'flatpickr', 'inputmask')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>

    <form action="{{ routed('app.vehicle-usage.update', $vehicleUsage->hash) }}" method="post">
      @csrf
      @method('PUT')

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
                       <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label ">Tanggal Pemakaian</label>
              <div class="form-group">
                <div class="input-group date" id="filter-date">
                  <input type="hidden" name="additional[date_use]" class="form-control form-control-solid flatpickr-input"
                    value="{{  old('additional.date_use', $vehicleUsage->date_use)  }}" data-input="" data-kfn-filter="date"
                    data-kfn-filter-label="Tanggal Pemakaian" placeholder="Pilih tanggal">
                  <div class="input-group-text" data-toggle="">
                    <i class="ki-duotone ki-calendar"><span class="path1"></span><span class="path2"></span><span
                        class="path3"></span></i>
                  </div>
                </div>
                {!! $errors->first('additional.date_use', '<div class="small text-danger">:message</div>') !!}
              </div>
            </div>
            
             <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Keterangan</label>
              <textarea name="additional[noted]" id="" cols="30" rows="10" class="form-control form-control-solid">{{ $vehicleUsage->additional['noted'] ?? '' }}</textarea>
              {!! $errors->first('additional.noted', '<div class="small text-danger">:message</div>') !!}
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between">
        <x-button.back href="{{ $backLink }}">Kembali</x-button.back>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
     $(document).ready(function() {
      $('#vehicle_id').select2({
        placeholder: 'Cari kendaraan...',
        ajax: {
          url: "{{ route('app.vehicle.vehicle-search.search') }}",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              search: params.term
            };
          },
          processResults: function(data) {
            return {
              results: data.map(function(officeRegion) {
                return {
                  id: officeRegion.id,
                  text: officeRegion.name + ' (' + officeRegion.code + ')',
                };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });

     $('#driver_id').select2({
        placeholder: 'Cari driver...',
        ajax: {
          url: "{{ route('app.user.user-search.search') }}",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              search: params.term,
              type: 'driver'
            };
          },
          processResults: function(data) {
            return {
              results: data.map(function(user) {
                return {
                  id: user.id,
                  text: user.name + ' ( ' + user.email + ' )',
                };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });

      $('#reviewer_id').select2({
        placeholder: 'Cari reviewer...',
        ajax: {
          url: "{{ route('app.user.user-search.search') }}",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              search: params.term,
              type: 'staff',
              role: 'reviewer'
            };
          },
          processResults: function(data) {
            return {
              results: data.map(function(user) {
                return {
                  id: user.id,
                  text: user.name + ' ( ' + user.email + ' )',
                };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });

      $('#approver_id').select2({
        placeholder: 'Cari approval...',
        ajax: {
          url: "{{ route('app.user.user-search.search') }}",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              search: params.term,
              type: 'staff',
              role: 'approval'
            };
          },
          processResults: function(data) {
            return {
              results: data.map(function(user) {
                return {
                  id: user.id,
                  text: user.name + ' ( ' + user.email + ' )',
                };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });

    });
  </script>
@endpush
