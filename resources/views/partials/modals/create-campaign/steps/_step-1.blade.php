<!--begin::Step 1-->
<div class="current" data-kt-stepper-element="content">
  <!--begin::Wrapper-->
  <div class="w-100">
    <!--begin::Heading-->
    <div class="pb-10 pb-lg-15">
      <!--begin::Title-->
      <h2 class="fw-bold d-flex align-items-center text-gray-900">Setup Campaign Details
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
           title="Campaign name will be used as reference within your campaign reports"></i></h2>
      <!--end::Title-->
      <!--begin::Notice-->
      <div class="text-muted fw-semibold fs-6">If you need more info, please check out
        <a href="#" class="link-primary fw-bold">Help Page</a>.
      </div>
      <!--end::Notice-->
    </div>
    <!--end::Heading-->
    <!--begin::Input group-->
    <div class="mb-10 fv-row">
      <!--begin::Label-->
      <label class="required form-label mb-3">Campaign Name</label>
      <!--end::Label-->
      <!--begin::Input-->
      <input type="text" class="form-control form-control-lg form-control-solid" name="campaign_name" placeholder=""
             value=""/>
      <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
      <!--begin::Label-->
      <label class="d-block fw-semibold fs-6 mb-5">
        <span class="required">Company Logo</span>
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
           title="E.g. Select a logo to represent the company that's running the campaign."></i>
      </label>
      <!--end::Label-->
      <!--begin::Image input placeholder-->
      <style>.image-input-placeholder {
          background-image: url('{% static "media/svg/files/blank-image.svg" %}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
          background-image: url('{% static "media/svg/files/blank-image-dark.svg" %}');
        }</style>
      <!--end::Image input placeholder-->
      <!--begin::Image input-->
      <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
        <!--begin::Preview existing avatar-->
        <div class="image-input-wrapper w-125px h-125px"></div>
        <!--end::Preview existing avatar-->
        <!--begin::Label-->
        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
               data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
          <i class="bi bi-pencil-fill fs-7"></i>
          <!--begin::Inputs-->
          <input type="file" name="avatar" accept=".png, .jpg, .jpeg"/>
          <input type="hidden" name="avatar_remove"/>
          <!--end::Inputs-->
        </label>
        <!--end::Label-->
        <!--begin::Cancel-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
					<i class="bi bi-x fs-2"></i>
				</span>
        <!--end::Cancel-->
        <!--begin::Remove-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
					<i class="bi bi-x fs-2"></i>
				</span>
        <!--end::Remove-->
      </div>
      <!--end::Image input-->
      <!--begin::Hint-->
      <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
      <!--end::Hint-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="mb-10">
      <!--begin::Label-->
      <label class="required fw-semibold fs-6 mb-5">Campaign Goal</label>
      <!--end::Label-->
      <!--begin::Roles-->
      <!--begin::Input row-->
      <div class="d-flex fv-row">
        <!--begin::Radio-->
        <div class="form-check form-check-custom form-check-solid">
          <!--begin::Input-->
          <input class="form-check-input me-3" name="user_role" type="radio" value="0"
                 id="kt_modal_update_role_option_0" checked='checked'/>
          <!--end::Input-->
          <!--begin::Label-->
          <label class="form-check-label" for="kt_modal_update_role_option_0">
            <div class="fw-bold text-gray-800">Get more visitors</div>
            <div class="text-gray-600">Increase impression traffic onto the platform</div>
          </label>
          <!--end::Label-->
        </div>
        <!--end::Radio-->
      </div>
      <!--end::Input row-->
      <div class='separator separator-dashed my-5'></div>
      <!--begin::Input row-->
      <div class="d-flex fv-row">
        <!--begin::Radio-->
        <div class="form-check form-check-custom form-check-solid">
          <!--begin::Input-->
          <input class="form-check-input me-3" name="user_role" type="radio" value="1"
                 id="kt_modal_update_role_option_1"/>
          <!--end::Input-->
          <!--begin::Label-->
          <label class="form-check-label" for="kt_modal_update_role_option_1">
            <div class="fw-bold text-gray-800">Get more messages on chat</div>
            <div class="text-gray-600">Increase community interaction and communication</div>
          </label>
          <!--end::Label-->
        </div>
        <!--end::Radio-->
      </div>
      <!--end::Input row-->
      <div class='separator separator-dashed my-5'></div>
      <!--begin::Input row-->
      <div class="d-flex fv-row">
        <!--begin::Radio-->
        <div class="form-check form-check-custom form-check-solid">
          <!--begin::Input-->
          <input class="form-check-input me-3" name="user_role" type="radio" value="2"
                 id="kt_modal_update_role_option_2"/>
          <!--end::Input-->
          <!--begin::Label-->
          <label class="form-check-label" for="kt_modal_update_role_option_2">
            <div class="fw-bold text-gray-800">Get more calls</div>
            <div class="text-gray-600">Boost telecommunication feedback to provide precise and accurate information
            </div>
          </label>
          <!--end::Label-->
        </div>
        <!--end::Radio-->
      </div>
      <!--end::Input row-->
      <div class='separator separator-dashed my-5'></div>
      <!--begin::Input row-->
      <div class="d-flex fv-row">
        <!--begin::Radio-->
        <div class="form-check form-check-custom form-check-solid">
          <!--begin::Input-->
          <input class="form-check-input me-3" name="user_role" type="radio" value="3"
                 id="kt_modal_update_role_option_3"/>
          <!--end::Input-->
          <!--begin::Label-->
          <label class="form-check-label" for="kt_modal_update_role_option_3">
            <div class="fw-bold text-gray-800">Get more likes</div>
            <div class="text-gray-600">Increase positive interactivity on social media platforms</div>
          </label>
          <!--end::Label-->
        </div>
        <!--end::Radio-->
      </div>
      <!--end::Input row-->
      <div class='separator separator-dashed my-5'></div>
      <!--begin::Input row-->
      <div class="d-flex fv-row">
        <!--begin::Radio-->
        <div class="form-check form-check-custom form-check-solid">
          <!--begin::Input-->
          <input class="form-check-input me-3" name="user_role" type="radio" value="4"
                 id="kt_modal_update_role_option_4"/>
          <!--end::Input-->
          <!--begin::Label-->
          <label class="form-check-label" for="kt_modal_update_role_option_4">
            <div class="fw-bold text-gray-800">Lead generation</div>
            <div class="text-gray-600">Collect contact information for potential customers</div>
          </label>
          <!--end::Label-->
        </div>
        <!--end::Radio-->
      </div>
      <!--end::Input row-->
      <!--end::Roles-->
    </div>
    <!--end::Input group-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Step 1-->
