<!--begin::Modal - Create App-->
<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header">
        <!--begin::Modal title-->
        <h2>Create App</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-sm btn-icon btn-active-color-primary"
             data-bs-dismiss="modal">{!! getIcon('cross', 'fs-1') !!}</div>
        <!--end::Close-->
      </div>
      <!--end::Modal header-->
      <!--begin::Modal body-->
      <div class="modal-body py-lg-10 px-lg-10">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
             id="kt_modal_create_app_stepper">
          <!--begin::Aside-->
          <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
            <!--begin::Nav-->
            <div class="stepper-nav ps-lg-10">
              <!--begin::Step 1-->
              <div class="stepper-item current" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper">
                  <!--begin::Icon-->
                  <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">1</span>
                  </div>
                  <!--end::Icon-->
                  <!--begin::Label-->
                  <div class="stepper-label">
                    <h3 class="stepper-title">Details</h3>
                    <div class="stepper-desc">Name your App</div>
                  </div>
                  <!--end::Label-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
              </div>
              <!--end::Step 1-->
              <!--begin::Step 2-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper">
                  <!--begin::Icon-->
                  <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">2</span>
                  </div>
                  <!--begin::Icon-->
                  <!--begin::Label-->
                  <div class="stepper-label">
                    <h3 class="stepper-title">Frameworks</h3>
                    <div class="stepper-desc">Define your app framework</div>
                  </div>
                  <!--begin::Label-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
              </div>
              <!--end::Step 2-->
              <!--begin::Step 3-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper">
                  <!--begin::Icon-->
                  <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">3</span>
                  </div>
                  <!--end::Icon-->
                  <!--begin::Label-->
                  <div class="stepper-label">
                    <h3 class="stepper-title">Database</h3>
                    <div class="stepper-desc">Select the app database type</div>
                  </div>
                  <!--end::Label-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
              </div>
              <!--end::Step 3-->
              <!--begin::Step 4-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper">
                  <!--begin::Icon-->
                  <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">4</span>
                  </div>
                  <!--end::Icon-->
                  <!--begin::Label-->
                  <div class="stepper-label">
                    <h3 class="stepper-title">Billing</h3>
                    <div class="stepper-desc">Provide payment details</div>
                  </div>
                  <!--end::Label-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
              </div>
              <!--end::Step 4-->
              <!--begin::Step 5-->
              <div class="stepper-item mark-completed" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper">
                  <!--begin::Icon-->
                  <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">5</span>
                  </div>
                  <!--end::Icon-->
                  <!--begin::Label-->
                  <div class="stepper-label">
                    <h3 class="stepper-title">Completed</h3>
                    <div class="stepper-desc">Review and Submit</div>
                  </div>
                  <!--end::Label-->
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Step 5-->
            </div>
            <!--end::Nav-->
          </div>
          <!--begin::Aside-->
          <!--begin::Content-->
          <div class="flex-row-fluid py-lg-5 px-lg-15">
            <!--begin::Form-->
            <form class="form" novalidate="novalidate" id="kt_modal_create_app_form">
              @include('partials/modals/create-app/steps/_step-1')
              @include('partials/modals/create-app/steps/_step-2')
              @include('partials/modals/create-app/steps/_step-3')
              @include('partials/modals/create-app/steps/_step-4')
              @include('partials/modals/create-app/steps/_step-5')
              <!--begin::Actions-->
              <div class="d-flex flex-stack pt-10">
                <!--begin::Wrapper-->
                <div class="me-2">
                  <button type="button" class="btn btn-lg btn-light-primary me-3"
                          data-kt-stepper-action="previous">{!! getIcon('arrow-left', 'fs-3 me-1') !!} Back
                  </button>
                </div>
                <!--end::Wrapper-->
                <!--begin::Wrapper-->
                <div>
                  <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
                    <span class="indicator-label">Submit {!! getIcon('arrow-right', 'fs-3 ms-2 me-0') !!}</span>
                    <span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                  </button>
                  <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                    Continue {!! getIcon('arrow-right', 'fs-3 ms-1 me-0') !!}</button>
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Actions-->
            </form>
            <!--end::Form-->
          </div>
          <!--end::Content-->
        </div>
        <!--end::Stepper-->
      </div>
      <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->
