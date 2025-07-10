@extends('layouts.app')

@plugins('select2', 'flatpickr', 'inputmask')

@section('pageTitle', $pageTitle)
{{-- @section('pageSubtitle', 'Wonderful yang singkat') --}}

@section('content')
  <div class="card">
    <form action="{{ routed('app.vehicle-fuel.store', $vehicleOrder->hash_id) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label ">Tanggal Isi BBM</label>
              <div class="form-group">
                <div class="input-group datetime" id="filter-date">
                  <input type="hidden" name="date_fuel_consumption"
                    class="form-control form-control-solid flatpickr-input"
                    value="{{ old('date_fuel_consumption', now()->toDateTimeString()) }}" data-input=""
                    data-kfn-filter="date" data-kfn-filter-label="Tanggal Pemakaian" placeholder="Pilih tanggal">
                  <div class="input-group-text" data-toggle="">
                    <i class="ki-duotone ki-calendar"><span class="path1"></span><span class="path2"></span><span
                        class="path3"></span></i>
                  </div>
                </div>
                {!! $errors->first('date_fuel_consumption', '<div class="small text-danger">:message</div>') !!}
              </div>
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Keterangan</label>
              <textarea name="additional[noted]" id="" cols="30" rows="10" class="form-control form-control-solid"></textarea>
              {!! $errors->first('additional.noted', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class=" form-label">Jumlah Bensin</label>
              <input type="text" class="form-control form-control-solid" name="fuel_consumption"
                placeholder="Jumlah Bensin" />
              {!! $errors->first('fuel_consumption', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class=" form-label">Harga</label>
              <input type="number" class="form-control form-control-solid" name="fuel_cost" placeholder="Harga" />
              {!! $errors->first('fuel_cost', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Jenis Bensin</label>
              <select class="form-control" name="fuel_type" id="fuel_type">
                @foreach (\App\Enums\FuelType::cases() as $type)
                  <option value="{{ $type->value }}" {{ old('fuel_type') == $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}</option>
                @endforeach
              </select>
              {!! $errors->first('fuel_type', '<div class="small text-danger">:message</div>') !!}
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
