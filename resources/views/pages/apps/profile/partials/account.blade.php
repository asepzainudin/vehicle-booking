@extends('pages.apps.profile.header')

@section('subcontent')
  <div class="card">
    <div class="card-header flex-nowrap gap-5">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar">
        {{-- <a href="javascript:void(0);" class="btn btn-sm fw-bold btn-primary me-2" data-bs-toggle="modal"
          data-bs-target="#airlineModal" href="{{ routed('app.profile.create') }}">Tambah</a> --}}
        <a href="{{ routed('app.profile.create') }}" class="btn btn-sm fw-bold btn-primary me-2">Tambah</a>
      </div>
    </div>
    <x-input.filter-info />
    <div class="card-table">
      <x-kfn-table />
    </div>
  </div>

  {{-- <div class="modal fade" id="airlineModal" tabindex="-1" aria-labelledby="airlineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="airlineModalLabel">Maskapai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="reason" class="form-label">Pilih Maskapai</label>
            @foreach ($partners as $partner)
              <a href="{{ routed('app.profile.create', $partner->hash) }}">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                  data-kt-button="true">
                  <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                    <input class="form-check-input" type="radio" name="discount_option" value="1"
                      data-gtm-form-interact-field-id="2">
                  </span>
                  <span class="ms-5">
                    <span class="fs-4 fw-bold text-gray-800 d-block">{{ $partner->name }}</span>
                  </span>
                </label>
              </a>
            @endforeach

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Kirim Reject</button>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
@endsection

@push('scripts')
  <script>
    $(function() {
      $('.filter-reset').on('click', function(e) {
        e.preventDefault();
        $(this).closest('form').trigger('reset');
      });
    });
  </script>
@endpush
