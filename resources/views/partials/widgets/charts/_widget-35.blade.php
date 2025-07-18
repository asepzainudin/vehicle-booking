<!--begin::Chart Widget 35-->
<div class="card card-flush h-md-100">
  <!--begin::Header-->
  <div class="card-header pt-5 mb-6">
    <!--begin::Title-->
    <h3 class="card-title align-items-start flex-column">
      <!--begin::Statistics-->
      <div class="d-flex align-items-center mb-2">
        <!--begin::Currency-->
        <span class="fs-3 fw-semibold text-gray-500 align-self-start me-1">$</span>
        <!--end::Currency-->
        <!--begin::Value-->
        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">3,274.94</span>
        <!--end::Value-->
        <!--begin::Label-->
        <span
          class="badge badge-light-success fs-base">{!! getIcon('arrow-up', 'fs-5 text-success ms-n1') !!} 9.2%</span>
        <!--end::Label-->
      </div>
      <!--end::Statistics-->
      <!--begin::Description-->
      <span class="fs-6 fw-semibold text-gray-500">Avg. Agent Earnings</span>
      <!--end::Description-->
    </h3>
    <!--end::Title-->
    <!--begin::Toolbar-->
    <div class="card-toolbar">
      <!--begin::Menu-->
      <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
              data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
              data-kt-menu-overflow="true">{!! getIcon('dots-square', 'fs-1 text-gray-300 me-n1') !!}</button>
      <!--begin::Menu 2-->
      <div
        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
        data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
          <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator mb-3 opacity-75"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
          <a href="#" class="menu-link px-3">New Ticket</a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
          <a href="#" class="menu-link px-3">New Customer</a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
          <!--begin::Menu item-->
          <a href="#" class="menu-link px-3">
            <span class="menu-title">New Group</span>
            <span class="menu-arrow"></span>
          </a>
          <!--end::Menu item-->
          <!--begin::Menu sub-->
          <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
              <a href="#" class="menu-link px-3">Admin Group</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
              <a href="#" class="menu-link px-3">Staff Group</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
              <a href="#" class="menu-link px-3">Member Group</a>
            </div>
            <!--end::Menu item-->
          </div>
          <!--end::Menu sub-->
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
          <a href="#" class="menu-link px-3">New Contact</a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator mt-3 opacity-75"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
          <div class="menu-content px-3 py-3">
            <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
          </div>
        </div>
        <!--end::Menu item-->
      </div>
      <!--end::Menu 2-->
      <!--end::Menu-->
    </div>
    <!--end::Toolbar-->
  </div>
  <!--end::Header-->
  <!--begin::Body-->
  <div class="card-body py-0 px-0">
    <!--begin::Nav-->
    <ul class="nav d-flex justify-content-between mb-3 mx-9">
      <!--begin::Item-->
      <li class="nav-item mb-3">
        <!--begin::Link-->
        <a
          class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px active"
          data-bs-toggle="tab" id="kt_charts_widget_35_tab_1" href="#kt_charts_widget_35_tab_content_1">1d</a>
        <!--end::Link-->
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="nav-item mb-3">
        <!--begin::Link-->
        <a
          class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
          data-bs-toggle="tab" id="kt_charts_widget_35_tab_2" href="#kt_charts_widget_35_tab_content_2">5d</a>
        <!--end::Link-->
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="nav-item mb-3">
        <!--begin::Link-->
        <a
          class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
          data-bs-toggle="tab" id="kt_charts_widget_35_tab_3" href="#kt_charts_widget_35_tab_content_3">1m</a>
        <!--end::Link-->
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="nav-item mb-3">
        <!--begin::Link-->
        <a
          class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
          data-bs-toggle="tab" id="kt_charts_widget_35_tab_4" href="#kt_charts_widget_35_tab_content_4">6m</a>
        <!--end::Link-->
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="nav-item mb-3">
        <!--begin::Link-->
        <a
          class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
          data-bs-toggle="tab" id="kt_charts_widget_35_tab_5" href="#kt_charts_widget_35_tab_content_5">1y</a>
        <!--end::Link-->
      </li>
      <!--end::Item-->
    </ul>
    <!--end::Nav-->
    <!--begin::Tab Content-->
    <div class="tab-content mt-n6">
      <!--begin::Tap pane-->
      <div class="tab-pane fade active show" id="kt_charts_widget_35_tab_content_1">
        <!--begin::Chart-->
        <div id="kt_charts_widget_35_chart_1" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
        <!--end::Chart-->
        <!--begin::Table container-->
        <div class="table-responsive mx-9 mt-n6">
          <!--begin::Table-->
          <table class="table align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
            <tr>
              <th class="min-w-100px"></th>
              <th class="min-w-100px text-end pe-0"></th>
              <th class="text-end min-w-50px"></th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-danger">-139.34</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">3:10 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$3,207.03</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-success">+576.24</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">3:55 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$3,274.94</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-success">+124.03</span>
              </td>
            </tr>
            </tbody>
            <!--end::Table body-->
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->
      </div>
      <!--end::Tap pane-->
      <!--begin::Tap pane-->
      <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_2">
        <!--begin::Chart-->
        <div id="kt_charts_widget_35_chart_2" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
        <!--end::Chart-->
        <!--begin::Table container-->
        <div class="table-responsive mx-9 mt-n6">
          <!--begin::Table-->
          <table class="table align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
            <tr>
              <th class="min-w-100px"></th>
              <th class="min-w-100px text-end pe-0"></th>
              <th class="text-end min-w-50px"></th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">4:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$2,345.45</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-success">+134.02</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">11:35 AM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-primary">-124.03</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">3:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$1,756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-danger">+144.04</span>
              </td>
            </tr>
            </tbody>
            <!--end::Table body-->
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->
      </div>
      <!--end::Tap pane-->
      <!--begin::Tap pane-->
      <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_3">
        <!--begin::Chart-->
        <div id="kt_charts_widget_35_chart_3" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
        <!--end::Chart-->
        <!--begin::Table container-->
        <div class="table-responsive mx-9 mt-n6">
          <!--begin::Table-->
          <table class="table align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
            <tr>
              <th class="min-w-100px"></th>
              <th class="min-w-100px text-end pe-0"></th>
              <th class="text-end min-w-50px"></th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">3:20 AM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$3,756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-primary">+185.03</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">12:30 AM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-danger">+124.03</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">4:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-success">-154.03</span>
              </td>
            </tr>
            </tbody>
            <!--end::Table body-->
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->
      </div>
      <!--end::Tap pane-->
      <!--begin::Tap pane-->
      <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_4">
        <!--begin::Chart-->
        <div id="kt_charts_widget_35_chart_4" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
        <!--end::Chart-->
        <!--begin::Table container-->
        <div class="table-responsive mx-9 mt-n6">
          <!--begin::Table-->
          <table class="table align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
            <tr>
              <th class="min-w-100px"></th>
              <th class="min-w-100px text-end pe-0"></th>
              <th class="text-end min-w-50px"></th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-warning">+124.03</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">5:30 AM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$1,756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-info">+144.65</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">4:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$2,085.25</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-primary">+154.06</span>
              </td>
            </tr>
            </tbody>
            <!--end::Table body-->
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->
      </div>
      <!--end::Tap pane-->
      <!--begin::Tap pane-->
      <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_5">
        <!--begin::Chart-->
        <div id="kt_charts_widget_35_chart_5" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
        <!--end::Chart-->
        <!--begin::Table container-->
        <div class="table-responsive mx-9 mt-n6">
          <!--begin::Table-->
          <table class="table align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
            <tr>
              <th class="min-w-100px"></th>
              <th class="min-w-100px text-end pe-0"></th>
              <th class="text-end min-w-50px"></th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$2,045.04</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-warning">+114.03</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">3:30 AM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-primary">-124.03</span>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="text-gray-600 fw-bold fs-6">10:30 PM</a>
              </td>
              <td class="pe-0 text-end">
                <span class="text-gray-800 fw-bold fs-6 me-1">$1.756.26</span>
              </td>
              <td class="pe-0 text-end">
                <span class="fw-bold fs-6 text-info">+165.86</span>
              </td>
            </tr>
            </tbody>
            <!--end::Table body-->
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->
      </div>
      <!--end::Tap pane-->
    </div>
    <!--end::Tab Content-->
  </div>
  <!--end::Body-->
</div>
<!--end::Chart Widget 35-->
