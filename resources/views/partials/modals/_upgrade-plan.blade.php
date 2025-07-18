<!--begin::Modal - Upgrade plan-->
<div class="modal fade" id="kt_modal_upgrade_plan" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-xl">
    <!--begin::Modal content-->
    <div class="modal-content rounded">
      <!--begin::Modal header-->
      <div class="modal-header justify-content-end border-0 pb-0">
        <!--begin::Close-->
        <div class="btn btn-sm btn-icon btn-active-color-primary"
             data-bs-dismiss="modal">{!! getIcon('cross', 'fs-1') !!}</div>
        <!--end::Close-->
      </div>
      <!--end::Modal header-->
      <!--begin::Modal body-->
      <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
        <!--begin::Heading-->
        <div class="mb-13 text-center">
          <h1 class="mb-3">Upgrade a Plan</h1>
          <div class="text-muted fw-semibold fs-5">If you need more info, please check
            <a href="#" class="link-primary fw-bold">Pricing Guidelines</a>.
          </div>
        </div>
        <!--end::Heading-->
        <!--begin::Plans-->
        <div class="d-flex flex-column">
          <!--begin::Nav group-->
          <div class="nav-group nav-group-outline mx-auto" data-kt-buttons="true">
            <button class="btn btn-color-gray-500 btn-active btn-active-secondary px-6 py-3 me-2 active"
                    data-kt-plan="month">Monthly
            </button>
            <button class="btn btn-color-gray-500 btn-active btn-active-secondary px-6 py-3" data-kt-plan="annual">
              Annual
            </button>
          </div>
          <!--end::Nav group-->
          <!--begin::Row-->
          <div class="row mt-10">
            <!--begin::Col-->
            <div class="col-lg-6 mb-10 mb-lg-0">
              <!--begin::Tabs-->
              <div class="nav flex-column">
                <!--begin::Tab link-->
                <label
                  class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 active mb-6"
                  data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_startup">
                  <!--end::Description-->
                  <div class="d-flex align-items-center me-2">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                      <input class="form-check-input" type="radio" name="plan" checked="checked" value="startup"/>
                    </div>
                    <!--end::Radio-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                      <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Startup</div>
                      <div class="fw-semibold opacity-75">Best for startups</div>
                    </div>
                    <!--end::Info-->
                  </div>
                  <!--end::Description-->
                  <!--begin::Price-->
                  <div class="ms-5">
                    <span class="mb-2">$</span>
                    <span class="fs-3x fw-bold" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">39</span>
                    <span class="fs-7 opacity-50">/
										<span data-kt-element="period">Mon</span></span>
                  </div>
                  <!--end::Price-->
                </label>
                <!--end::Tab link-->
                <!--begin::Tab link-->
                <label
                  class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6"
                  data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_advanced">
                  <!--end::Description-->
                  <div class="d-flex align-items-center me-2">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                      <input class="form-check-input" type="radio" name="plan" value="advanced"/>
                    </div>
                    <!--end::Radio-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                      <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Advanced</div>
                      <div class="fw-semibold opacity-75">Best for 100+ team size</div>
                    </div>
                    <!--end::Info-->
                  </div>
                  <!--end::Description-->
                  <!--begin::Price-->
                  <div class="ms-5">
                    <span class="mb-2">$</span>
                    <span class="fs-3x fw-bold" data-kt-plan-price-month="339"
                          data-kt-plan-price-annual="3399">339</span>
                    <span class="fs-7 opacity-50">/
										<span data-kt-element="period">Mon</span></span>
                  </div>
                  <!--end::Price-->
                </label>
                <!--end::Tab link-->
                <!--begin::Tab link-->
                <label
                  class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6"
                  data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_enterprise">
                  <!--end::Description-->
                  <div class="d-flex align-items-center me-2">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                      <input class="form-check-input" type="radio" name="plan" value="enterprise"/>
                    </div>
                    <!--end::Radio-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                      <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Enterprise
                        <span class="badge badge-light-success ms-2 py-2 px-3 fs-7">Popular</span></div>
                      <div class="fw-semibold opacity-75">Best value for 1000+ team</div>
                    </div>
                    <!--end::Info-->
                  </div>
                  <!--end::Description-->
                  <!--begin::Price-->
                  <div class="ms-5">
                    <span class="mb-2">$</span>
                    <span class="fs-3x fw-bold" data-kt-plan-price-month="999"
                          data-kt-plan-price-annual="9999">999</span>
                    <span class="fs-7 opacity-50">/
										<span data-kt-element="period">Mon</span></span>
                  </div>
                  <!--end::Price-->
                </label>
                <!--end::Tab link-->
                <!--begin::Tab link-->
                <label
                  class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6"
                  data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_custom">
                  <!--end::Description-->
                  <div class="d-flex align-items-center me-2">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                      <input class="form-check-input" type="radio" name="plan" value="custom"/>
                    </div>
                    <!--end::Radio-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                      <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Custom</div>
                      <div class="fw-semibold opacity-75">Requet a custom license</div>
                    </div>
                    <!--end::Info-->
                  </div>
                  <!--end::Description-->
                  <!--begin::Price-->
                  <div class="ms-5">
                    <a href="#" class="btn btn-sm btn-success">Contact Us</a>
                  </div>
                  <!--end::Price-->
                </label>
                <!--end::Tab link-->
              </div>
              <!--end::Tabs-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-lg-6">
              <!--begin::Tab content-->
              <div class="tab-content rounded h-100 bg-light p-10">
                <!--begin::Tab Pane-->
                <div class="tab-pane fade show active" id="kt_upgrade_plan_startup">
                  <!--begin::Heading-->
                  <div class="pb-5">
                    <h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
                    <div class="text-muted fw-semibold">Optimal for 10+ team size and new startup</div>
                  </div>
                  <!--end::Heading-->
                  <!--begin::Body-->
                  <div class="pt-1">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-muted flex-grow-1">Finance Module</span>{!! getIcon('cross-circle', 'fs-1') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-muted flex-grow-1">Accounting Module</span>{!! getIcon('cross-circle', 'fs-1') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-muted flex-grow-1">Network Platform</span>{!! getIcon('cross-circle', 'fs-1') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                      <span
                        class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud Space</span>{!! getIcon('cross-circle', 'fs-1') !!}
                    </div>
                    <!--end::Item-->
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Tab Pane-->
                <!--begin::Tab Pane-->
                <div class="tab-pane fade" id="kt_upgrade_plan_advanced">
                  <!--begin::Heading-->
                  <div class="pb-5">
                    <h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
                    <div class="text-muted fw-semibold">Optimal for 100+ team size and grown company</div>
                  </div>
                  <!--end::Heading-->
                  <!--begin::Body-->
                  <div class="pt-1">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-muted flex-grow-1">Network Platform</span>{!! getIcon('cross-circle', 'fs-1') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                      <span
                        class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud Space</span>{!! getIcon('cross-circle', 'fs-1') !!}
                    </div>
                    <!--end::Item-->
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Tab Pane-->
                <!--begin::Tab Pane-->
                <div class="tab-pane fade" id="kt_upgrade_plan_enterprise">
                  <!--begin::Heading-->
                  <div class="pb-5">
                    <h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
                    <div class="text-muted fw-semibold">Optimal for 1000+ team and enterpise</div>
                  </div>
                  <!--end::Heading-->
                  <!--begin::Body-->
                  <div class="pt-1">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Network Platform</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Cloud Space</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Tab Pane-->
                <!--begin::Tab Pane-->
                <div class="tab-pane fade" id="kt_upgrade_plan_custom">
                  <!--begin::Heading-->
                  <div class="pb-5">
                    <h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
                    <div class="text-muted fw-semibold">Optimal for corporations</div>
                  </div>
                  <!--end::Heading-->
                  <!--begin::Body-->
                  <div class="pt-1">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Users</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Project Integrations</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting Module</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Network Platform</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                      <span
                        class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Cloud Space</span>{!! getIcon('check-circle', 'fs-1 text-success') !!}
                    </div>
                    <!--end::Item-->
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Tab Pane-->
              </div>
              <!--end::Tab content-->
            </div>
            <!--end::Col-->
          </div>
          <!--end::Row-->
        </div>
        <!--end::Plans-->
        <!--begin::Actions-->
        <div class="d-flex flex-center flex-row-fluid pt-12">
          <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="kt_modal_upgrade_plan_btn">
            @include('partials/general/_button-indicator')
          </button>
        </div>
        <!--end::Actions-->
      </div>
      <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>
<!--end::Modal - Upgrade plan-->
