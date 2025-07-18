<!--begin::Step 1-->
<div class="current" data-kt-stepper-element="content">
  <div class="w-100">
    <!--begin::Input group-->
    <div class="fv-row mb-10">
      <!--begin::Label-->
      <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
        <span class="required">App Name</span>
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
           title="Specify your unique app name"></i>
      </label>
      <!--end::Label-->
      <!--begin::Input-->
      <input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="" value=""/>
      <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
      <!--begin::Label-->
      <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
        <span class="required">Category</span>
        <span class="ms-1" data-bs-toggle="tooltip" title="Select your app category"></span>
      </label>
      <!--end::Label-->
      <!--begin:Options-->
      <div class="fv-row">
        <!--begin:Option-->
        <label class="d-flex flex-stack mb-5 cursor-pointer">
          <!--begin:Label-->
          <span class="d-flex align-items-center me-2">
						<!--begin:Icon-->
						<span class="symbol symbol-50px me-6">
							<span class="symbol-label bg-light-primary">{!! getIcon('compass', 'fs-1 text-primary') !!}</span>
						</span>
            <!--end:Icon-->
            <!--begin:Info-->
						<span class="d-flex flex-column">
							<span class="fw-bold fs-6">Quick Online Courses</span>
							<span class="fs-7 text-muted">Creating a clear text structure is just one SEO</span>
						</span>
            <!--end:Info-->
					</span>
          <!--end:Label-->
          <!--begin:Input-->
          <span class="form-check form-check-custom form-check-solid">
						<input class="form-check-input" type="radio" name="category" value="1"/>
					</span>
          <!--end:Input-->
        </label>
        <!--end::Option-->
        <!--begin:Option-->
        <label class="d-flex flex-stack mb-5 cursor-pointer">
          <!--begin:Label-->
          <span class="d-flex align-items-center me-2">
						<!--begin:Icon-->
						<span class="symbol symbol-50px me-6">
							<span class="symbol-label bg-light-danger">{!! getIcon('element-11', 'fs-1 text-danger') !!}</span>
						</span>
            <!--end:Icon-->
            <!--begin:Info-->
						<span class="d-flex flex-column">
							<span class="fw-bold fs-6">Face to Face Discussions</span>
							<span class="fs-7 text-muted">Creating a clear text structure is just one aspect</span>
						</span>
            <!--end:Info-->
					</span>
          <!--end:Label-->
          <!--begin:Input-->
          <span class="form-check form-check-custom form-check-solid">
						<input class="form-check-input" type="radio" name="category" value="2"/>
					</span>
          <!--end:Input-->
        </label>
        <!--end::Option-->
        <!--begin:Option-->
        <label class="d-flex flex-stack cursor-pointer">
          <!--begin:Label-->
          <span class="d-flex align-items-center me-2">
						<!--begin:Icon-->
						<span class="symbol symbol-50px me-6">
							<span class="symbol-label bg-light-success">{!! getIcon('timer', 'fs-1 text-success') !!}</span>
						</span>
            <!--end:Icon-->
            <!--begin:Info-->
						<span class="d-flex flex-column">
							<span class="fw-bold fs-6">Full Intro Training</span>
							<span class="fs-7 text-muted">Creating a clear text structure copywriting</span>
						</span>
            <!--end:Info-->
					</span>
          <!--end:Label-->
          <!--begin:Input-->
          <span class="form-check form-check-custom form-check-solid">
						<input class="form-check-input" type="radio" name="category" value="3"/>
					</span>
          <!--end:Input-->
        </label>
        <!--end::Option-->
      </div>
      <!--end:Options-->
    </div>
    <!--end::Input group-->
  </div>
</div>
<!--end::Step 1-->
