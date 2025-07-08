@extends('layouts.app')

@plugins('select2', 'flatpickr')
@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>

    <form action="{{ routed('app.profile.update', $user->hash) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-9 mt-2">
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Avatar</label>
              <div class="form-control form-control-solid">
                <div class=" image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                data-kt-image-input="true">
                <div class="image-input-wrapper w-150px h-150px"></div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                  data-bs-original-title="Change avatar" data-kt-initialized="1">
                  <i class="ki-duotone ki-pencil">
                    <span class="path1"></span>
                    <span class="path2"></span>
                  </i>
                  <input type="file" name="logo" accept=".png, .jpg, .jpeg">
                  <input type="hidden" name="logo_remove">
                </label>
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                  data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                  <i class="ki-duotone ki-trash">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                  </i>
                </span>
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                  data-bs-original-title="Remove avatar" data-kt-initialized="1">
                  <i class="ki-duotone ki-trash">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                  </i>
                </span>
              </div>
              <div class="text-muted fs-7">Only *.png, *.jpg and *.jpeg
                image files are accepted
              </div>
              </div>

            </div>

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
              <div class="mb-10 fv-row">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password"
                  value="">
                {!! $errors->first('password', '<div class="small text-danger">:message</div>') !!}
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

            {{-- <div class="mb-5">
              <label for="exampleFormControlInput1" class=" form-label">Identitas</label>
              <select class="form-select form-select-solid form-colon" name="identity_type">
                <option>Pilih</option>
                @foreach (\App\Enums\UserType::cases() as $type)
                  <option value="{{ $type->value }}"
                    {{ old('identity_type', $user->identity_type ?? '') == $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}</option>
                @endforeach
              </select>
              {!! $errors->first('identity_type', '<div class="small text-danger">:message</div>') !!}
            </div>

            <div class="mb-5">
              <label for="exampleFormControlInput1" class="form-label">Nomor Identitas</label>
              <input type="text" class="form-control form-control-solid" name="identity_number"
                placeholder="Nomor Identitas" value="{{ $user->identity_number ?? '' }}" />
              {!! $errors->first('identity_number', '<div class="small text-danger">:message</div>') !!}
            </div> --}}

                 <div class="mb-10">
              <label for="exampleFormControlInput1" class="form-label required">Tipe</label>
              {{-- buat select2 di bawah --}}
              <select id="search_type" name="type" class="form-control" style="width: 100%">
                <option value="">Pilih</option>
                @foreach (\App\Enums\UserType::cases() as $type)
                  <option value="{{ $type->value }}" {{ old('type', $user->type->value) == $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}</option>
                @endforeach
              </select>
              {!! $errors->first('type', '<div class="small text-danger">:message</div>') !!}
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

@push('styles')
  <style>
    .image-input-placeholder {
      background-image: url({{ old('wall_path') ?? cachedAsset('assets/media/svg/files/blank-image.svg') }});
      background-size: cover;
      background-position: center;
    }
    [data-theme="dark"] .image-input-placeholder {
      background-image: url({{ old('wall_path') ?? cachedAsset('assets/media/svg/files/blank-image-dark.svg') }});
    }
  </style>
@endpush

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
