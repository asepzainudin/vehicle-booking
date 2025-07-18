<!--begin::Chart widget 36-->
<div class="card card-flush overflow-hidden h-lg-100">
  <!--begin::Header-->
  <div class="card-header pt-5">
    <!--begin::Title-->
    <h3 class="card-title align-items-start flex-column">
      <span class="card-label fw-bold text-gray-900">Performance</span>
      <span class="text-gray-500 mt-1 fw-semibold fs-6">1,046 Inbound Calls today</span>
    </h3>
    <!--end::Title-->
    <!--begin::Toolbar-->
    <div class="card-toolbar">
      <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
      <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" data-kt-daterangepicker-range="today"
           class="btn btn-sm btn-light d-flex align-items-center px-4">
        <!--begin::Display range-->
        <div class="text-gray-600 fw-bold">Loading date range...</div>
        <!--end::Display range-->
        {!! getIcon('calendar-8', 'fs-1 ms-2 me-0') !!}</div>
      <!--end::Daterangepicker-->
    </div>
    <!--end::Toolbar-->
  </div>
  <!--end::Header-->
  <!--begin::Card body-->
  <div class="card-body d-flex align-items-end p-0">
    <!--begin::Chart-->
    <div id="kt_charts_widget_36" class="min-h-auto w-100 ps-4 pe-6" style="height: 300px"></div>
    <!--end::Chart-->
  </div>
  <!--end::Card body-->
</div>
<!--end::Chart widget 36-->
