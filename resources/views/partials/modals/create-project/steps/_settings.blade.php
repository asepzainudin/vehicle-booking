<!--begin::Settings-->
<div data-kt-stepper-element="content">
  <!--begin::Wrapper-->
  <div class="w-100">
    <!--begin::Heading-->
    <div class="pb-12">
      <!--begin::Title-->
      <h1 class="fw-bold text-gray-900">Project Settings</h1>
      <!--end::Title-->
      <!--begin::Description-->
      <div class="text-muted fw-semibold fs-4">If you need more info, please check
        <a href="#" class="link-primary">Project Guidelines</a></div>
      <!--end::Description-->
    </div>
    <!--end::Heading-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <!--begin::Dropzone-->
      <div class="dropzone" id="kt_modal_create_project_settings_logo">
        <!--begin::Message-->
        <div class="dz-message needsclick">
          <!--begin::Icon-->
          {!! getSvgIcon('duotune/files/fil010.svg', 'svg-icon svg-icon-3hx svg-icon-primary') !!}
          <!--end::Icon-->
          <!--begin::Info-->
          <div class="ms-4">
            <h3 class="dfs-3 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
            <span class="fw-semibold fs-4 text-muted">Upload up to 10 files</span>
          </div>
          <!--end::Info--></div>
      </div>
      <!--end::Dropzone-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <!--begin::Label-->
      <label class="required fs-6 fw-semibold mb-2">Customer</label>
      <!--end::Label-->
      <!--begin::Input-->
      <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
              data-placeholder="Select..." name="settings_customer">
        <option></option>
        <option value="1">Keenthemes</option>
        <option value="2">CRM App</option>
      </select>
      <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <!--begin::Label-->
      <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
        <span class="required">Project Name</span>
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify project name"></i>
      </label>
      <!--end::Label-->
      <!--begin::Input-->
      <input type="text" class="form-control form-control-solid" placeholder="Enter Project Name"
             value="StockPro Mobile App" name="settings_name"/>
      <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <!--begin::Label-->
      <label class="required fs-6 fw-semibold mb-2">Project Description</label>
      <!--end::Label-->
      <!--begin::Input-->
      <textarea class="form-control form-control-solid" rows="3" placeholder="Enter Project Description"
                name="settings_description">Experience share market at your fingertips with TICK PRO stock investment mobile trading app</textarea>
      <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <!--begin::Label-->
      <label class="required fs-6 fw-semibold mb-2">Release Date</label>
      <!--end::Label-->
      <!--begin::Wrapper-->
      <div class="position-relative d-flex align-items-center">
        <!--begin::Icon-->
        {!! getSvgIcon('duotune/general/gen014.svg', 'svg-icon svg-icon-2 position-absolute mx-4') !!}
        <!--end::Icon-->
        <!--begin::Input-->
        <input class="form-control form-control-solid ps-12" placeholder="Pick date range"
               name="settings_release_date"/>
        <!--end::Input--></div>
      <!--end::Wrapper-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-15">
      <!--begin::Wrapper-->
      <div class="d-flex flex-stack">
        <!--begin::Label-->
        <div class="me-5">
          <label class="required fs-6 fw-semibold">Notifications</label>
          <div class="fs-7 fw-semibold text-muted">Allow Notifications by Phone or Email</div>
        </div>
        <!--end::Label-->
        <!--begin::Checkboxes-->
        <div class="d-flex">
          <!--begin::Checkbox-->
          <label class="form-check form-check-custom form-check-solid me-10">
            <!--begin::Input-->
            <input class="form-check-input h-20px w-20px" type="checkbox" value="email"
                   name="settings_notifications[]"/>
            <!--end::Input-->
            <!--begin::Label-->
            <span class="form-check-label fw-semibold">Email</span>
            <!--end::Label-->
          </label>
          <!--end::Checkbox-->
          <!--begin::Checkbox-->
          <label class="form-check form-check-custom form-check-solid">
            <!--begin::Input-->
            <input class="form-check-input h-20px w-20px" type="checkbox" value="phone" checked="checked"
                   name="settings_notifications[]"/>
            <!--end::Input-->
            <!--begin::Label-->
            <span class="form-check-label fw-semibold">Phone</span>
            <!--end::Label-->
          </label>
          <!--end::Checkbox-->
        </div>
        <!--end::Checkboxes-->
      </div>
      <!--begin::Wrapper-->
    </div>
    <!--end::Input group-->
    <!--begin::Actions-->
    <div class="d-flex flex-stack">
      <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="settings-previous">Project Type</button>
      <button type="button" class="btn btn-lg btn-primary" data-kt-element="settings-next">
        <span class="indicator-label">Budget</span>
        <span class="indicator-progress">Please wait...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
      </button>
    </div>
    <!--end::Actions-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Settings-->
