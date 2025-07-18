<!--begin::Modal - Create Project-->
<div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-fullscreen p-9">
    <!--begin::Modal content-->
    <div class="modal-content modal-rounded">
      <!--begin::Modal header-->
      <div class="modal-header">
        <!--begin::Modal title-->
        <h2>Create Project</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
          {!! getSvgIcon('duotune/arrows/arr061.svg', 'svg-icon svg-icon-1') !!}
        </div>
        <!--end::Close-->
      </div>
      <!--end::Modal header-->
      <!--begin::Modal body-->
      <div class="modal-body scroll-y m-5">
        <!--begin::Stepper-->
        <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
          <!--begin::Container-->
          <div class="container">
            <!--begin::Nav-->
            <div class="stepper-nav justify-content-center py-2">
              <!--begin::Step 1-->
              <div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Project Type</h3>
              </div>
              <!--end::Step 1-->
              <!--begin::Step 2-->
              <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Project Settings</h3>
              </div>
              <!--end::Step 2-->
              <!--begin::Step 3-->
              <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Budget</h3>
              </div>
              <!--end::Step 3-->
              <!--begin::Step 4-->
              <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Build A Team</h3>
              </div>
              <!--end::Step 4-->
              <!--begin::Step 5-->
              <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Set First Target</h3>
              </div>
              <!--end::Step 5-->
              <!--begin::Step 6-->
              <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Upload Files</h3>
              </div>
              <!--end::Step 6-->
              <!--begin::Step 7-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <h3 class="stepper-title">Completed</h3>
              </div>
              <!--end::Step 7-->
            </div>
            <!--end::Nav-->
            <!--begin::Form-->
            <form class="mx-auto w-100 mw-600px pt-15 pb-10" novalidate="novalidate" id="kt_modal_create_project_form"
                  method="post">
              @include('partials/modals/create-project/steps/_type')
              @include('partials/modals/create-project/steps/_settings')
              @include('partials/modals/create-project/steps/_budget')
              @include('partials/modals/create-project/steps/_team')
              @include('partials/modals/create-project/steps/_targets')
              @include('partials/modals/create-project/steps/_files')
              @include('partials/modals/create-project/steps/_complete')
            </form>
            <!--end::Form-->
          </div>
          <!--begin::Container-->
        </div>
        <!--end::Stepper-->
      </div>
      <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>
<!--end::Modal - Create Project-->
