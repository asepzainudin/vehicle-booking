@extends('layouts.app')

@plugins('select2', 'flatpickr', 'inputmask')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>

    <form action="{{ routed('app.mine.update', $mine->hash) }}" method="post">
      @csrf
      @method('PUT')

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label ">Kantor Cabang</label>
              <select id="office_region_id" name="office_region_id" class="form-control" style="width: 100%">
                @if (isset($mine->officeRegion))
                  <option value="{{ $mine->officeRegion?->id }}" selected>
                    {{ $mine->officeRegion?->name }} ({{ $mine->officeRegion?->code }})
                  </option>
                @endif
              </select>
              {!! $errors->first('office_region_id', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Nama</label>
              <input type="text" class="form-control form-control-solid" name="name" placeholder="Nama"
                value="{{ $mine->name ?? '' }}" required />
              {!! $errors->first('name', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class=" form-label">Kode</label>
              <input type="text" class="form-control form-control-solid" name="code" placeholder="code"
                value="{{ $mine->code ?? '' }}"  />
              {!! $errors->first('code', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Status</label>
              <select class="form-select form-select-solid form-colon" name="is_active">
                <option value="1" {{ old('is_active', $mine->is_active) == true ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $mine->is_active) == null ? 'selected' : '' }}>Tidak Aktif
                </option>
              </select>
              {!! $errors->first('is_active', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Alamat</label>
              <textarea name="additional[address]" id="" cols="30" rows="10"
                class="form-control form-control-solid">{{ $mine->additional['address'] ?? '' }}</textarea>
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
    $(document).ready(function() {
      $('#office_region_id').select2({
        placeholder: 'Cari kantor cabang...',
        ajax: {
          url: "{{ route('app.office-region.office-region-search.search') }}",
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
    });
  </script>
@endpush
