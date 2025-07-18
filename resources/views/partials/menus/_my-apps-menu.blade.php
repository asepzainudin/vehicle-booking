<!--begin::My apps-->
<div class="menu menu-sub menu-sub-dropdown menu-column w-100 w-sm-350px" data-kt-menu="true">
  <!--begin::Card-->
  <div class="card">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Card title-->
      <div class="card-title">My Apps</div>
      <!--end::Card title-->
      <!--begin::Card toolbar-->
      <div class="card-toolbar">
        <!--begin::Menu-->
        <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n3"
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="bottom-end">{!! getIcon('setting-3', 'fs-2') !!}</button>
        @include('partials/menus/_menu-3')
        <!--end::Menu-->
      </div>
      <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body py-5">
      <!--begin::Scroll-->
      <div class="mh-450px scroll-y me-n5 pe-5">
        <!--begin::Row-->
        <div class="row g-2">
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/amazon.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">AWS</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/angular-icon-1.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">AngularJS</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/atica.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Atica</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/beats-electronics.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Music</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/codeigniter.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Codeigniter</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/bootstrap-4.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Bootstrap</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/google-tag-manager.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">GTM</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/disqus.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Disqus</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/dribbble-icon-1.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Dribble</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/google-play-store.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Play Store</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/google-podcasts.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Podcasts</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/figma-1.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Figma</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/github.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Github</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/gitlab.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Gitlab</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/instagram-2-1.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Instagram</span>
            </a>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-4">
            <a href="#"
               class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
              <img src="{{ image('svg/brand-logos/pinterest-p.svg') }}" class="w-25px h-25px mb-2" alt=""/>
              <span class="fw-semibold">Pinterest</span>
            </a>
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Scroll-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->
</div>
<!--end::My apps-->
