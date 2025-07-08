@extends('layouts.app')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-9 mt-2">
          <!-- Initial Input Field -->
          <div class="mb-5">
            <x-input.grid label="Nama">
              <div class="form-control form-control-underline form-colon">
                {{ $user->name ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Username">
              <div class="form-control form-control-underline form-colon">
                {{ $user->username ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Handphone">
              <div class="form-control form-control-underline form-colon">
                {{ $user->phone ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Email">
              <div class="form-control form-control-underline form-colon">
                {{ $user->email ?? '' }}
              </div>
            </x-input.grid>
          </div>

          {{-- <div class="mb-5">
            <x-input.grid label="Identitas">
              <div class="form-control form-control-underline form-colon">
                @foreach (\App\Enums\UserType::cases() as $type)
                <option value="{{ $type->value }}"
                  {{ old('identity_type', $user->identity_type ?? '') == $type->value ? 'selected' : '' }}>
                  {{ $type->label() }}</option>
              @endforeach
              </div>
            </x-input.grid>
          </div>

          <div class="mb-5">
            <x-input.grid label="Nomor Identitas">
              <div class="form-control form-control-underline form-colon">
                {{ $user->identity_number ?? '' }}
              </div>
            </x-input.grid>
          </div> --}}
               <div class="mb-5">
            <x-input.grid label="Tipe">
              <div class="form-control form-control-underline form-colon">
                {{ $user->type ? \App\Enums\UserType::from($user->type->value)->label() : '' }}
              </div>
            </x-input.grid>
          </div>

          <div class="mb-5">
            <x-input.grid label="Status">
              <div class="form-control form-control-underline form-colon">
                {{ $user->status ?? '' }}
              </div>
            </x-input.grid>
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
            <div class="form-control form-control-underline form-colon">
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
    </div>

    <div class="card-footer d-flex justify-content-between">
      <x-button.back href="{{ $backLink }}">Kembali</x-button.back>
    </div>
  </div>
@endsection
