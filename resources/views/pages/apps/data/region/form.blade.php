@extends('layouts.app')

@plugins('select2', 'flatpickr', 'inputmask')

@section('pageTitle', $pageTitle)
{{-- @section('pageSubtitle', 'Wonderful yang singkat') --}}

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>

    <form action="{{ routed('app.office-region.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Nama</label>
              <input type="text" class="form-control form-control-solid" name="name" placeholder="Nama" required />
              {!! $errors->first('name', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Kode</label>
              <input type="text" class="form-control form-control-solid" name="code" placeholder="code" />
              {!! $errors->first('code', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Status</label>
              <select class="form-select form-select-solid form-colon" name="is_active">
                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }} >Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
              {!! $errors->first('status', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Alamat</label>
              <textarea name="additional[address]" id="" cols="30" rows="10" class="form-control form-control-solid"></textarea>
              {!! $errors->first('additional.address', '<div class="small text-danger">:message</div>') !!}
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
    $(document).ready(function() {});
  </script>
@endpush