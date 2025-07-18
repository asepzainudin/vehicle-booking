<!--begin::Targets-->
<div data-kt-stepper-element="content">
  <!--begin::Wrapper-->
  <div class="w-100">
    <!--begin::Heading-->
    <div class="pb-12">
      <!--begin::Title-->
      <h1 class="fw-bold text-gray-900">Set First Target</h1>
      <!--end::Title-->
      <!--begin::Title-->
      <div class="text-muted fw-semibold fs-4">If you need more info, please check
        <a href="#" class="link-primary">Project Guidelines</a></div>
      <!--end::Title-->
    </div>
    <!--end::Heading-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <label class="fs-6 fw-semibold mb-2">Target Title</label>
      <input type="text" class="form-control form-control-solid" placeholder="Enter Target Title"
             name="Project Launch"/>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
      <!--begin::Col-->
      <div class="col-md-6 fv-row">
        <label class="required fs-6 fw-semibold mb-2">Assign</label>
        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                data-placeholder="Select a Team Member" name="target_assign">
          <option></option>
          <option value="1">Karina Clark</option>
          <option value="2" selected="selected">Robert Doe</option>
          <option value="3">Niel Owen</option>
          <option value="4">Olivia Wild</option>
          <option value="5">Sean Bean</option>
        </select>
      </div>
      <!--end::Col-->
      <!--begin::Col-->
      <div class="col-md-6 fv-row">
        <label class="required fs-6 fw-semibold mb-2">Due Date</label>
        <div class="position-relative d-flex align-items-center">
          <!--begin::Icon-->
          {!! getSvgIcon('duotune/general/gen014.svg', 'svg-icon svg-icon-2 position-absolute mx-4') !!}
          <!--end::Icon-->
          <!--begin::Datepicker-->
          <input class="form-control form-control-solid ps-12" placeholder="Pick date range" name="target_due_date"/>
          <!--end::Datepicker--></div>
      </div>
      <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <label class="fs-6 fw-semibold mb-2">Target Details</label>
      <textarea class="form-control form-control-solid" rows="2" name="target_details"
                placeholder="Type Target Details">Experience share market at your fingertips with TICK PRO stock investment mobile trading app</textarea>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <label class="required fs-6 fw-semibold mb-2">Tags</label>
      <input class="form-control form-control-solid" value="Important, Urgent" name="target_tags"/>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-8">
      <!--begin::Wrapper-->
      <div class="d-flex flex-stack">
        <!--begin::Label-->
        <div class="me-5">
          <label class="fs-6 fw-semibold">Allow Changes in Budget</label>
          <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
        </div>
        <!--end::Label-->
        <!--begin::Switch-->
        <label class="form-check form-switch form-check-custom form-check-solid">
          <input class="form-check-input" type="checkbox" value="1" name="target_allow" checked="checked"/>
          <span class="form-check-label fw-semibold text-muted">Allowed</span>
        </label>
        <!--end::Switch-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-15">
      <!--begin::Wrapper-->
      <div class="d-flex flex-stack">
        <!--begin::Label-->
        <div class="me-5">
          <label class="fs-6 fw-semibold">Notifications</label>
          <div class="fs-7 fw-semibold text-muted">Allow Notifications by Phone or Email</div>
        </div>
        <!--end::Label-->
        <!--begin::Checkboxes-->
        <div class="d-flex">
          <!--begin::Checkbox-->
          <label class="form-check form-check-custom form-check-solid me-10">
            <!--begin::Input-->
            <input class="form-check-input h-20px w-20px" type="checkbox" value="email" name="target_notifications[]"/>
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
                   name="target_notifications[]"/>
            <!--end::Input-->
            <!--begin::Label-->
            <span class="form-check-label fw-semibold">Phone</span>
            <!--end::Label-->
          </label>
          <!--end::Checkbox-->
        </div>
        <!--end::Checkboxes-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Input group-->
    <!--begin::Actions-->
    <div class="d-flex flex-stack">
      <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="targets-previous">Build a Team</button>
      <button type="button" class="btn btn-lg btn-primary" data-kt-element="targets-next">
        <span class="indicator-label">Upload Files</span>
        <span class="indicator-progress">Please wait...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
      </button>
    </div>
    <!--end::Actions-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Targets-->
