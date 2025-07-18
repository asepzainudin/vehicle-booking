<!--begin::Step 3-->
<div data-kt-stepper-element="content">
  <!--begin::Wrapper-->
  <div class="w-100">
    <!--begin::Heading-->
    <div class="pb-10 pb-lg-12">
      <!--begin::Title-->
      <h1 class="fw-bold text-gray-900">Configure Audiences</h1>
      <!--end::Title-->
      <!--begin::Description-->
      <div class="text-muted fw-semibold fs-4">If you need more info, please check
        <a href="#" class="link-primary">Campaign Guidelines</a></div>
      <!--end::Description-->
    </div>
    <!--end::Heading-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
      <!--begin::Label-->
      <label class="fs-6 fw-semibold mb-2">Gender
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
           title="Show your ads to either men or women, or select 'All' for both"></i></label>
      <!--End::Label-->
      <!--begin::Row-->
      <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
        <!--begin::Col-->
        <div class="col">
          <!--begin::Option-->
          <label class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6"
                 data-kt-button="true">
            <!--begin::Radio-->
            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
							<input class="form-check-input" type="radio" name="campaign_gender" value="1" checked="checked"/>
						</span>
            <!--end::Radio-->
            <!--begin::Info-->
            <span class="ms-5">
							<span class="fs-4 fw-bold text-gray-800 d-block">All</span>
						</span>
            <!--end::Info-->
          </label>
          <!--end::Option-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col">
          <!--begin::Option-->
          <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                 data-kt-button="true">
            <!--begin::Radio-->
            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
							<input class="form-check-input" type="radio" name="campaign_gender" value="2"/>
						</span>
            <!--end::Radio-->
            <!--begin::Info-->
            <span class="ms-5">
							<span class="fs-4 fw-bold text-gray-800 d-block">Male</span>
						</span>
            <!--end::Info-->
          </label>
          <!--end::Option-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col">
          <!--begin::Option-->
          <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                 data-kt-button="true">
            <!--begin::Radio-->
            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
							<input class="form-check-input" type="radio" name="campaign_gender" value="3"/>
						</span>
            <!--end::Radio-->
            <!--begin::Info-->
            <span class="ms-5">
							<span class="fs-4 fw-bold text-gray-800 d-block">Female</span>
						</span>
            <!--end::Info-->
          </label>
          <!--end::Option-->
        </div>
        <!--end::Col-->
      </div>
      <!--end::Row-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
      <!--begin::Label-->
      <label class="fs-6 fw-semibold mb-2">Age
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
           title="Select the minimum and maximum age of the people who will find your ad relevant."></i></label>
      <!--End::Label-->
      <!--begin::Slider-->
      <div class="d-flex flex-stack">
        <div id="kt_modal_create_campaign_age_min" class="fs-7 fw-semibold text-muted"></div>
        <div id="kt_modal_create_campaign_age_slider" class="noUi-sm w-100 ms-5 me-8"></div>
        <div id="kt_modal_create_campaign_age_max" class="fs-7 fw-semibold text-muted"></div>
      </div>
      <!--end::Slider-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
      <!--begin::Label-->
      <label class="fs-6 fw-semibold mb-2">Location
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
           title="Enter one or more location points for more specific targeting."></i></label>
      <!--End::Label-->
      <!--begin::Tagify-->
      <input class="form-control d-flex align-items-center" value="" id="kt_modal_create_campaign_location"
             data-kt-flags-path="media/flags/"/>
      <!--end::Tagify-->
    </div>
    <!--end::Input group-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Step 3-->
