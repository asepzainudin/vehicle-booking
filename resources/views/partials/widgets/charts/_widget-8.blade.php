<!--begin::Chart widget 8-->
<div class="card card-flush h-xl-100">
  <!--begin::Header-->
  <div class="card-header pt-5">
    <!--begin::Title-->
    <h3 class="card-title align-items-start flex-column">
      <span class="card-label fw-bold text-gray-900">Performance Overview</span>
      <span class="text-gray-500 mt-1 fw-semibold fs-6">Users from all channels</span>
    </h3>
    <!--end::Title-->
    <!--begin::Toolbar-->
    <div class="card-toolbar">
      <ul class="nav" id="kt_chart_widget_8_tabs">
        <li class="nav-item">
          <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
             data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle" href="#kt_chart_widget_8_week_tab">Month</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active"
             data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle" href="#kt_chart_widget_8_month_tab">Week</a>
        </li>
      </ul>
    </div>
    <!--end::Toolbar-->
  </div>
  <!--end::Header-->
  <!--begin::Body-->
  <div class="card-body pt-6">
    <!--begin::Tab content-->
    <div class="tab-content">
      <!--begin::Tab pane-->
      <div class="tab-pane fade" id="kt_chart_widget_8_week_tab" role="tabpanel">
        <!--begin::Statistics-->
        <div class="mb-5">
          <!--begin::Statistics-->
          <div class="d-flex align-items-center mb-2">
            <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">$</span>
            <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">18,89</span>
            <span
              class="badge badge-light-success fs-base">{!! getIcon('arrow-up', 'fs-5 text-success ms-n1') !!} 4,8%</span>
          </div>
          <!--end::Statistics-->
          <!--begin::Description-->
          <span class="fs-6 fw-semibold text-gray-500">Avarage cost per interaction</span>
          <!--end::Description-->
        </div>
        <!--end::Statistics-->
        <!--begin::Chart-->
        <div id="kt_chart_widget_8_week_chart" class="ms-n5 min-h-auto" style="height: 275px"></div>
        <!--end::Chart-->
        <!--begin::Items-->
        <div class="d-flex flex-wrap pt-5">
          <!--begin::Item-->
          <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-3 mb-sm-6">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
            <!--begin::Item-->
            <div class="d-flex align-items-center">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-&lt;gray-600 fs-6">Google Ads</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
          </div>
          <!--ed::Item-->
          <!--begin::Item-->
          <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-3 mb-sm-6">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
            <!--begin::Item-->
            <div class="d-flex align-items-center">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Courses</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
          </div>
          <!--ed::Item-->
          <!--begin::Item-->
          <div class="d-flex flex-column pt-sm-3 pt-6">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-3 mb-sm-6">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
            <!--begin::Item-->
            <div class="d-flex align-items-center">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Radio</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
          </div>
          <!--ed::Item-->
        </div>
        <!--ed::Items-->
      </div>
      <!--end::Tab pane-->
      <!--begin::Tab pane-->
      <div class="tab-pane fade active show" id="kt_chart_widget_8_month_tab" role="tabpanel">
        <!--begin::Statistics-->
        <div class="mb-5">
          <!--begin::Statistics-->
          <div class="d-flex align-items-center mb-2">
            <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">$</span>
            <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">8,55</span>
            <span
              class="badge badge-light-success fs-base">{!! getIcon('arrow-up', 'fs-5 text-success ms-n1') !!} 2.2%</span>
          </div>
          <!--end::Statistics-->
          <!--begin::Description-->
          <span class="fs-6 fw-semibold text-gray-500">Avarage cost per interaction</span>
          <!--end::Description-->
        </div>
        <!--end::Statistics-->
        <!--begin::Chart-->
        <div id="kt_chart_widget_8_month_chart" class="ms-n5 min-h-auto" style="height: 275px"></div>
        <!--end::Chart-->
        <!--begin::Items-->
        <div class="d-flex flex-wrap pt-5">
          <!--begin::Item-->
          <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-3 mb-sm-6">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
            <!--begin::Item-->
            <div class="d-flex align-items-center">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Google Ads</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
          </div>
          <!--ed::Item-->
          <!--begin::Item-->
          <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-3 mb-sm-6">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
            <!--begin::Item-->
            <div class="d-flex align-items-center">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Courses</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
          </div>
          <!--ed::Item-->
          <!--begin::Item-->
          <div class="d-flex flex-column pt-sm-3 pt-6">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-3 mb-sm-6">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
            <!--begin::Item-->
            <div class="d-flex align-items-center">
              <!--begin::Bullet-->
              <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
              <!--end::Bullet-->
              <!--begin::Label-->
              <span class="fw-bold text-gray-600 fs-6">Radio</span>
              <!--end::Label-->
            </div>
            <!--ed::Item-->
          </div>
          <!--ed::Item-->
        </div>
        <!--ed::Items-->
      </div>
      <!--end::Tab pane-->
    </div>
    <!--end::Tab content-->
  </div>
  <!--end::Body-->
</div>
<!--end::Chart widget 8-->
