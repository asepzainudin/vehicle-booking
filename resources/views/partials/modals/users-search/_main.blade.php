<!--begin::Modal - Users Search-->
<div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <!--begin::Modal content-->
    <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header pb-0 border-0 justify-content-end">
        <!--begin::Close-->
        <div class="btn btn-sm btn-icon btn-active-color-primary"
             data-bs-dismiss="modal">{!! getIcon('cross', 'fs-1') !!}</div>
        <!--end::Close-->
      </div>
      <!--begin::Modal header-->
      <!--begin::Modal body-->
      <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
        <!--begin::Content-->
        <div class="text-center mb-13">
          <h1 class="mb-3">Search Users</h1>
          <div class="text-muted fw-semibold fs-5">Invite Collaborators To Your Project</div>
        </div>
        <!--end::Content-->
        <!--begin::Search-->
        <div id="kt_modal_users_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2"
             data-kt-search-enter="enter" data-kt-search-layout="inline">
          <!--begin::Form-->
          <form data-kt-search-element="form" class="w-100 position-relative mb-5" autocomplete="off">
            <!--begin::Hidden input(Added to disable form autocomplete)-->
            <input type="hidden"/>
            <!--end::Hidden input-->
            <!--begin::Icon-->
            {!! getIcon('magnifier', 'fs-2 fs-lg-1 text-gray-500 position-absolute top-50 ms-5 translate-middle-y') !!}
            <!--end::Icon-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value=""
                   placeholder="Search by username, full name or email..." data-kt-search-element="input"/>
            <!--end::Input-->
            <!--begin::Spinner-->
            <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                  data-kt-search-element="spinner">
						<span class="spinner-border h-15px w-15px align-middle text-muted"></span>
					</span>
            <!--end::Spinner-->
            <!--begin::Reset-->
            <span
              class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
              data-kt-search-element="clear">{!! getIcon('cross', 'fs-2 fs-lg-1 me-0') !!}</span>
            <!--end::Reset--></form>
          <!--end::Form-->
          <!--begin::Wrapper-->
          <div class="py-5">
            @include('partials/modals/users-search/partials/_suggestions')
            @include('partials/modals/users-search/partials/_results')
            @include('partials/modals/users-search/partials/_empty')
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Search-->
      </div>
      <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>
<!--end::Modal - Users Search-->
