@extends('pages.apps.profile.header')

@section('subcontent')
  <!--begin::details View-->
  <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
      <!--begin::Card title-->
      <div class="card-title m-0">
        <h3 class="fw-bold m-0">
          <profil></profil>
        </h3>
      </div>
      <!--end::Card title-->

      <!--begin::Action-->
      <a href="{{ routed('app.profile.edit', $user->hash) }}"
        class="btn btn-sm btn-primary align-self-center">Ubah Data</a>
      <!--end::Action-->
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
      <!--begin::Row-->
      <div class="row mb-7">
        <!--begin::Label-->
        <label class="col-lg-4 fw-semibold text-muted">Nama</label>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-8">
          <span class="fw-bold fs-6 text-gray-800">{{ $user->name ?? '' }}</span>
        </div>
        <!--end::Col-->
      </div>
      <!--end::Row-->

      <!--begin::Input group-->
      <div class="row mb-7">
        <!--begin::Label-->
        <label class="col-lg-4 fw-semibold text-muted">
          Telepon

          <span class="ms-1"></span>
        </label>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-8 d-flex align-items-center">
          <span class="fw-bold fs-6 text-gray-800 me-2">
            <span class="text-muted">+62</span> {{ $user->phone ?? "" }}
          </span>
          <span class="badge badge-success">Verified</span>
        </div>
        <!--end::Col-->
      </div>
      <!--end::Input group-->

      <!--begin::Input group-->
      <div class="row mb-7">
        <!--begin::Label-->
        <label class="col-lg-4 fw-semibold text-muted">Email</label>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-8">
          {{ $user->email ?? '' }}
        </div>
        <!--end::Col-->
      </div>
      <!--end::Input group-->

    </div>
    <!--end::Card body-->
  </div>
  <!--end::details View-->
@endsection
