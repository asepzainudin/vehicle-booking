<!--begin::Type-->
<div class="current" data-kt-stepper-element="content">
  <!--begin::Wrapper-->
  <div class="w-100">
    <!--begin::Heading-->
    <div class="pb-7 pb-lg-12">
      <!--begin::Title-->
      <h1 class="fw-bold text-gray-900">Project Type</h1>
      <!--end::Title-->
      <!--begin::Description-->
      <div class="text-muted fw-semibold fs-4">If you need more info, please check out
        <a href="#" class="link-primary fw-bold">FAQ Page</a></div>
      <!--end::Description-->
    </div>
    <!--end::Heading-->
    <!--begin::Input group-->
    <div class="fv-row mb-15" data-kt-buttons="true">
      <!--begin::Option-->
      <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
        <!--begin::Input-->
        <input class="btn-check" type="radio" checked="checked" name="project_type" value="1"/>
        <!--end::Input-->
        <!--begin::Label-->
        <span class="d-flex">
				<!--begin::Icon-->
				{!! getSvgIcon('duotune/communication/com006.svg', 'svg-icon svg-icon-3hx') !!}
          <!--end::Icon-->
				<!--begin::Info-->
				<span class="ms-4">
					<span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Personal Project</span>
					<span class="fw-semibold fs-4 text-muted">If you need more info, please check it out</span>
				</span>
          <!--end::Info--></span>
        <!--end::Label-->
      </label>
      <!--end::Option-->
      <!--begin::Option-->
      <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6">
        <!--begin::Input-->
        <input class="btn-check" type="radio" name="project_type" value="2"/>
        <!--end::Input-->
        <!--begin::Label-->
        <span class="d-flex">
				<!--begin::Icon-->
				{!! getSvgIcon('duotune/general/gen002.svg', 'svg-icon svg-icon-3hx') !!}
          <!--end::Icon-->
				<!--begin::Info-->
				<span class="ms-4">
					<span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Team Project</span>
					<span class="fw-semibold fs-4 text-muted">Create corporate account to manage users</span>
				</span>
          <!--end::Info--></span>
        <!--end::Label-->
      </label>
      <!--end::Option-->
    </div>
    <!--end::Input group-->
    <!--begin::Actions-->
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-lg btn-primary" data-kt-element="type-next">
        <span class="indicator-label">Project Settings</span>
        <span class="indicator-progress">Please wait...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
      </button>
    </div>
    <!--end::Actions-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Type-->
