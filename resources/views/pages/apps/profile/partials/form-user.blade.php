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

    <form action="{{ routed('app.profile.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            @if (auth()->user()
                    ?->hasAnyRole(['super-admin', 'admin', 'fop_maker', 'fop_approval']) ?? false)
              <div class="mb-5">
                <label for="exampleFormControlInput1" class=" form-label">Maskapai</label>
                <select class="form-select form-select-solid form-colon" name="select_partner_id" onchange="updateSession()">
                  <option value="0">Pilih</option>
                  @foreach ($partner as $_partner)
                    <option value="{{ $_partner->id }}" {{ old('select_partner_id') == $_partner->id ? 'selected' : '' }}>
                      {{ $_partner->name }}</option>
                  @endforeach
                </select>
                {!! $errors->first('select_partner_id', '<div class="small text-danger">:message</div>') !!}
              </div>
            @endif

            @if (auth()->user()
                    ?->hasAnyRole(['super-admin', 'admin', 'fop_maker', 'fop_approval']) ?? false)
              <div class="mb-5">
                <label for="exampleFormControlInput1" class=" form-label">Travel</label>
              <select id="search_travel" name="travel_id"  class="form-control" style="width: 100%"></select>
                {!! $errors->first('travel_id', '<div class="small text-danger">:message</div>') !!}
              </div>
            @endif

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Nama</label>
              <input type="text" class="form-control form-control-solid" name="name" placeholder="Nama" required />
              {!! $errors->first('name', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Username</label>
              <input type="text" class="form-control form-control-solid" name="username" placeholder="Username"
                required />
              {!! $errors->first('username', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Handphone</label>
              <input type="text" class="form-control form-control-solid" name="phone" placeholder="Handphone" />
              {!! $errors->first('phone', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Email</label>
              <input type="text" class="form-control form-control-solid" name="email" placeholder="Email" required />
              {!! $errors->first('email', '<div class="small text-danger">:message</div>') !!}
            </div>

            {{-- <div class="mb-5">
              <label for="exampleFormControlInput1" class=" form-label">Identitas</label>
              <select class="form-select form-select-solid form-colon" name="identity_type">
                <option>Pilih</option>
                @foreach (\App\Enums\UserType::cases() as $type)
                  <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}</option>
                @endforeach
              </select>
              {!! $errors->first('identity_type', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Nomor Identitas</label>
              <input type="text" class="form-control form-control-solid" name="identity_number"
                placeholder="Nomor Identitas" />
              {!! $errors->first('identity_number', '<div class="small text-danger">:message</div>') !!}
            </div> --}}

            <div class="mb-10">
              <label for="exampleFormControlInput1" class="form-label required">Tipe</label>
              {{-- buat select2 di bawah --}}
              <select id="search_type" name="type" class="form-control" style="width: 100%">
                <option value="">Pilih</option>
                @foreach (\App\Enums\UserType::cases() as $type)
                  @if (!in_array($type->value, ['rm', 'specialist', 'fop']))
                    <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                      {{ $type->label() }}</option>
                  @endif
                @endforeach
              </select>
              {!! $errors->first('type', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Status</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" value="active" id="flexSwitchDefault"
                  checked />
                <label class="form-check-label" for="flexSwitchDefault">
                  Aktif
                </label>
              </div>
            </div>

          </div>
          <div class="col-md-3 mt-2">
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">
                <h3>Role</h3>
              </label>
              @foreach ($role_partner as $role)
                <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input me-3" name="role[]" type="checkbox" value="{{ $role->name }}"
                    id="kt_docs_formvalidation_checkbox_option_1" />

                  <label class="form-check-label" for="kt_modal_update_role_option_3">
                    <div class="fw-bold text-gray-800">{{ $role->label }}</div>
                    <div class="text-gray-600">{{ $role->note ?? '' }}
                    </div>
                  </label>
                </div>
                <div class="separator separator-dashed my-5"></div>
              @endforeach
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
    $(function() {
      $('#search_type').select2({
        placeholder: 'Pilih Tipe',
        allowClear: true,
        width: '100%',
        minimumResultsForSearch: -1 // Disable search box
      });
      // Update session when select_partner_id changes

      $('#search_travel').select2({
        placeholder: 'Cari travel...',
        ajax: {
          url: "{{ route('app.travel.travel-search.search') }}",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              search: params.term
            };
          },
          processResults: function(data) {
            return {
              results: data.map(function(travel) {
                return {
                  id: travel.id,
                  text: travel.name + ' (' + travel.code + ')',
                  travel: travel // ← penting
                };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });
    });
   
    function updateSession() {
        let partnerId = $('select[name="select_partner_id"]').val();
        console.log('Session updated'); 
        $.ajax({
          url: '{{ route("app.partner.set.session") }}', // pastikan ini ada
          type: 'POST',
          data: {
            select_partner_id: partnerId,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            console.log('Session updated');
          },
          error: function(xhr) {
            console.error('Error updating session');
          }
        });
    }
      
  </script>
@endpush
