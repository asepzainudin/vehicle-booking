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

    <form action="{{ routed('app.user.update', $user->hash) }}" method="post">
      @csrf
      @method('PUT')

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <!-- Initial Input Field -->
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Nama</label>
              <input type="text" class="form-control form-control-solid" name="name" placeholder="Nama"
                value="{{ $user->name ?? '' }}" required/>
              {!! $errors->first('name', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Username</label>
              <input type="text" class="form-control form-control-solid" name="username" placeholder="Username"
                value="{{ $user->username ?? '' }}" required />
              {!! $errors->first('username', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Handphone</label>
              <input type="text" class="form-control form-control-solid" name="phone" placeholder="Handphone"
                value="{{ $user->phone ?? '' }}" />
              {!! $errors->first('phone', '<div class="small text-danger">:message</div>') !!}
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Email</label>
              <input type="text" class="form-control form-control-solid" name="email" placeholder="Email"
                value="{{ $user->email ?? '' }}" required />
              {!! $errors->first('email', '<div class="small text-danger">:message</div>') !!}
            </div>

             <div class="mb-5">
              <label for="exampleFormControlInput1" class=" form-label">Tipe</label>
              <select class="form-select form-select-solid form-colon" name="type">
                <option>Pilih</option>
                @foreach (\App\Enums\UserType::cases() as $type)
                  @if (in_array($type->value, ['rm', 'specialist', 'fop']))
                    <option value="{{ $type->value }}" {{ old('type', $user->type->value) == $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}</option>  
                  @endif
                @endforeach
              </select>
              {!! $errors->first('identity_type', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Status</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" value="{{ $user->status }}"
                  {{ $user->status == 'active' ? 'checked' : '' }} id="flexSwitchDefault" />
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
                @php
                $userRoleNames = $user->roles->pluck('name');
            @endphp
              @foreach ($roles as $role)
                <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input me-3" name="role[]" type="checkbox" {{ $userRoleNames->contains($role->name) ? "checked" : ""}} value="{{ $role->name }}"
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
    $(document).ready(function() {});
  </script>
@endpush
