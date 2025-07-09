@extends('layouts.app')

@plugins('select2', 'flatpickr', 'inputmask')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>

    <form action="{{ routed('app.vehicle.update', $vehicle->hash) }}" method="post">
      @csrf
      @method('PUT')

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Nama</label>
              <input type="text" class="form-control form-control-solid" name="name" placeholder="Nama"
                value="{{ $vehicle->name ?? '' }}" required />
              {!! $errors->first('name', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Kode</label>
              <input type="text" class="form-control form-control-solid" name="code" placeholder="code"
                value="{{ $vehicle->code ?? '' }}"  />
              {!! $errors->first('code', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Jumlah kendaraan</label>
              <input type="text" class="form-control form-control-solid" value="{{ old('total_vehicles',  $vehicle->vechicleOrders->count() ? $vehicle->total_vehicles + $vehicle->vechicleOrders->count() : $vehicle->total_vehicles) }}" name="total_vehicles" placeholder="Jumlah Kendaraan" oninput="formatNumber(this)"  />
              {!! $errors->first('total_vehicles', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Jenis kendaraan</label>
              <select class="form-control" name="type" id="type">
                @foreach (\App\Enums\VehicleType::cases() as $type)
                    <option value="{{ $type->value }}" {{ old('type', $vehicle->type) == $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}</option>  
                @endforeach
              </select>
              {!! $errors->first('type', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Status Kepemilikan</label>
              <select class="form-control" name="status" id="status">
                <option value="owned" {{ old('status', $vehicle->status) == 'owned' ? 'selected' : '' }} >Milik Perusahaan</option>
                <option value="rental" {{ old('status', $vehicle->status) == 'rental' ? 'selected' : '' }} >Menyewa</option>
              </select>
              {!! $errors->first('status', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div id="rentalFields" class="{{ old('status', $vehicle->status) == 'rental' ? '' : 'd-none' }}">
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="form-label">Perusahaan Sewa</label>
                <input type="text" class="form-control form-control-solid" name="additional[rental_company_name]"
                  placeholder="Nama Perusahaan Sewa" value="{{ old('additional[rental_company_name]', $vehicle->additional['rental_company_name'] ?? '') }}" />
                {!! $errors->first('additional.rental_company_name', '<div class="small text-danger">:message</div>') !!}
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="form-label">Nomor Hp</label>
                <input type="text" class="form-control form-control-solid" name="additional[rental_company_phone]"
                  placeholder="Nomor Hp Perusahaan Sewa" value="{{ old('additional[rental_company_phone]', $vehicle->additional['rental_company_phone'] ?? '') }}" />
                {!! $errors->first('additional.rental_company_phone', '<div class="small text-danger">:message</div>') !!}
              </div>
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Status</label>
              <select class="form-select form-select-solid form-colon" name="is_active">
                <option value="1" {{ old('is_active', $vehicle->is_active) == true ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $vehicle->is_active) == null ? 'selected' : '' }}>Tidak Aktif
                </option>
              </select>
              {!! $errors->first('is_active', '<div class="small text-danger">:message</div>') !!}
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
    $('#type').select2();
      $('#status').select2().on('change', function() {
        if ($(this).val() === 'rental') {
          // Show additional fields for rental vehicles
          $('#rentalFields').removeClass('d-none');
        } else {
          // Hide additional fields for rental vehicles
          $('#rentalFields').addClass('d-none');
        }
      });
    });
    
    function formatNumber(el) {
      let value = el.value.replace(/\D/g, ''); // Hanya angka
      el.value = value;
    }
  </script>
@endpush
