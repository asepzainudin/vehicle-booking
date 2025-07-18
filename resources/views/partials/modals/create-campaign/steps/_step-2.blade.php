<!--begin::Step 2-->
<div data-kt-stepper-element="content">
  <!--begin::Wrapper-->
  <div class="w-100">
    <!--begin::Heading-->
    <div class="pb-10 pb-lg-12">
      <!--begin::Title-->
      <h1 class="fw-bold text-gray-900">Upload Files</h1>
      <!--end::Title-->
      <!--begin::Description-->
      <div class="text-muted fw-semibold fs-4">If you need more info, please check
        <a href="#" class="link-primary">Campaign Guidelines</a></div>
      <!--end::Description-->
    </div>
    <!--end::Heading-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
      <!--begin::Dropzone-->
      <div class="dropzone" id="kt_modal_create_campaign_files_upload">
        <!--begin::Message-->
        <div class="dz-message needsclick">
          <!--begin::Icon-->
          {!! getSvgIcon('duotune/files/fil010.svg', 'svg-icon svg-icon-3hx svg-icon-primary') !!}
          <!--end::Icon-->
          <!--begin::Info-->
          <div class="ms-4">
            <h3 class="dfs-3 fw-bold text-gray-900 mb-1">Drop campaign files here or click to upload.</h3>
            <span class="fw-semibold fs-4 text-muted">Upload up to 10 files</span>
          </div>
          <!--end::Info--></div>
      </div>
      <!--end::Dropzone-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="mb-10">
      <!--begin::Label-->
      <label class="fs-6 fw-semibold mb-2">Uploaded File</label>
      <!--End::Label-->
      <!--begin::Files-->
      <div class="mh-300px scroll-y me-n7 pe-7">
        <!--begin::File-->
        <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
          <div class="d-flex align-items-center">
            <!--begin::Avatar-->
            <div class="symbol symbol-35px">
              <img src="{{ image('svg/files/pdf.svg') }}" alt="icon"/>
            </div>
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-6">
              <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Product Specifications</a>
              <div class="fw-semibold text-muted">230kb</div>
            </div>
            <!--end::Details-->
          </div>
          <!--begin::Menu-->
          <div class="min-w-100px">
            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true"
                    data-placeholder="Edit">
              <option></option>
              <option value="1">Remove</option>
              <option value="2">Modify</option>
              <option value="3">Select</option>
            </select>
          </div>
          <!--end::Menu-->
        </div>
        <!--end::File-->
        <!--begin::File-->
        <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
          <div class="d-flex align-items-center">
            <!--begin::Avatar-->
            <div class="symbol symbol-35px">
              <img src="{{ image('svg/files/tif.svg') }}" alt="icon"/>
            </div>
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-6">
              <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Campaign Creative Poster</a>
              <div class="fw-semibold text-muted">2.4mb</div>
            </div>
            <!--end::Details-->
          </div>
          <!--begin::Menu-->
          <div class="min-w-100px">
            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true"
                    data-placeholder="Edit">
              <option></option>
              <option value="1">Remove</option>
              <option value="2">Modify</option>
              <option value="3">Select</option>
            </select>
          </div>
          <!--end::Menu-->
        </div>
        <!--end::File-->
        <!--begin::File-->
        <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
          <div class="d-flex align-items-center">
            <!--begin::Avatar-->
            <div class="symbol symbol-35px">
              <img src="{{ image('svg/files/folder-document.svg') }}" alt="icon"/>
            </div>
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-6">
              <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Campaign Landing Page Source</a>
              <div class="fw-semibold text-muted">1.12mb</div>
            </div>
            <!--end::Details-->
          </div>
          <!--begin::Menu-->
          <div class="min-w-100px">
            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true"
                    data-placeholder="Edit">
              <option></option>
              <option value="1">Remove</option>
              <option value="2">Modify</option>
              <option value="3">Select</option>
            </select>
          </div>
          <!--end::Menu-->
        </div>
        <!--end::File-->
        <!--begin::File-->
        <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
          <div class="d-flex align-items-center">
            <!--begin::Avatar-->
            <div class="symbol symbol-35px">
              <img src="{{ image('svg/files/css.svg') }}" alt="icon"/>
            </div>
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-6">
              <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Landing Page Styling</a>
              <div class="fw-semibold text-muted">85kb</div>
            </div>
            <!--end::Details-->
          </div>
          <!--begin::Menu-->
          <div class="min-w-100px">
            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true"
                    data-placeholder="Edit">
              <option></option>
              <option value="1">Remove</option>
              <option value="2">Modify</option>
              <option value="3">Select</option>
            </select>
          </div>
          <!--end::Menu-->
        </div>
        <!--end::File-->
        <!--begin::File-->
        <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
          <div class="d-flex align-items-center">
            <!--begin::Avatar-->
            <div class="symbol symbol-35px">
              <img src="{{ image('svg/files/ai.svg') }}" alt="icon"/>
            </div>
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-6">
              <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Design Source Files</a>
              <div class="fw-semibold text-muted">48mb</div>
            </div>
            <!--end::Details-->
          </div>
          <!--begin::Menu-->
          <div class="min-w-100px">
            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true"
                    data-placeholder="Edit">
              <option></option>
              <option value="1">Remove</option>
              <option value="2">Modify</option>
              <option value="3">Select</option>
            </select>
          </div>
          <!--end::Menu-->
        </div>
        <!--end::File-->
        <!--begin::File-->
        <div class="d-flex flex-stack py-4">
          <div class="d-flex align-items-center">
            <!--begin::Avatar-->
            <div class="symbol symbol-35px">
              <img src="{{ image('svg/files/doc.svg') }}" alt="icon"/>
            </div>
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-6">
              <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Campaign Plan Document</a>
              <div class="fw-semibold text-muted">27kb</div>
            </div>
            <!--end::Details-->
          </div>
          <!--begin::Menu-->
          <div class="min-w-100px">
            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true"
                    data-placeholder="Edit">
              <option></option>
              <option value="1">Remove</option>
              <option value="2">Modify</option>
              <option value="3">Select</option>
            </select>
          </div>
          <!--end::Menu-->
        </div>
        <!--end::File-->
      </div>
      <!--end::Files-->
    </div>
    <!--end::Input group-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Step 2-->
