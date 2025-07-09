@extends('layouts.app')

@plugins('select2', 'flatpickr', 'inputmask')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>

    <form action="{{ routed('app.vehicle-order.update', $vehicleOrder->hash) }}" method="post">
      @csrf
      @method('PUT')

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Kode</label>
              <input type="text" class="form-control form-control-solid" name="code" placeholder="Kode"  value="{{ $vehicleOrder->code }}" required />
              {!! $errors->first('code', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label ">Kendaraan</label>
              <select id="vehicle_id" name="vehicle_id" class="form-control" style="width: 100%">
                @if ($vehicleOrder->vehicle_id)
                  <option value="{{ old('vehicle_id', $vehicleOrder->vehicle_id) }}">{{ $vehicleOrder->vehicle->name }}</option>
                @endif
              </select>
              {!! $errors->first('vehicle_id', '<div class="small text-danger">:message</div>') !!}
            </div>

             <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label required">Driver</label>
              <select id="driver_id" name="driver_id" class="form-control" style="width: 100%">
                @if ($vehicleOrder->driver_id)
                  <option value="{{ old('driver_id', $vehicleOrder->driver_id) }}">{{ $vehicleOrder->driver->name }}</option>
                @endif
              </select>
              {!! $errors->first('driver_id', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label required">Reviewer</label>
              <select id="reviewer_id" name="reviewer_id" class="form-control" style="width: 100%">
                @if ($vehicleOrder->reviewer_id)
                  <option value="{{ old('reviewer_id', $vehicleOrder->reviewer_id) }}">{{ $vehicleOrder->reviewer->name }}</option>
                @endif
              </select>
              {!! $errors->first('reviewer_id', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label required">Approver</label>
              <select id="approver_id" name="approver_id" class="form-control" style="width: 100%">
                @if ($vehicleOrder->approver_id)
                  <option value="{{ old('approver_id', $vehicleOrder->approver_id) }}">{{ $vehicleOrder->approver->name }}</option>
                @endif
              </select>
              {!! $errors->first('approver_id', '<div class="small text-danger">:message</div>') !!}
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
