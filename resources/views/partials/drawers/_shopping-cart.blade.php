<!--begin::Chat drawer-->
<div id="kt_shopping_cart" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="cart"
     data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end"
     data-kt-drawer-toggle="#kt_drawer_shopping_cart_toggle" data-kt-drawer-close="#kt_drawer_shopping_cart_close">
  <!--begin::Messenger-->
  <div class="card card-flush w-100 rounded-0">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Title-->
      <h3 class="card-title text-gray-900 fw-bold">Shopping Cart</h3>
      <!--end::Title-->
      <!--begin::Card toolbar-->
      <div class="card-toolbar">
        <!--begin::Close-->
        <div class="btn btn-sm btn-icon btn-active-light-primary"
             id="kt_drawer_shopping_cart_close">{!! getIcon('cross', 'fs-2') !!}</div>
        <!--end::Close-->
      </div>
      <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body hover-scroll-overlay-y h-400px pt-5">
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">Iblender</a>
            <span class="text-gray-500 fw-semibold d-block">The best kitchen gadget in 2022</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 350</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">5</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-1.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-6"></div>
      <!--end::Separator-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">SmartCleaner</a>
            <span class="text-gray-500 fw-semibold d-block">Smart tool for cooking</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 650</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">4</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-3.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-6"></div>
      <!--end::Separator-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">CameraMaxr</a>
            <span class="text-gray-500 fw-semibold d-block">Professional camera for edge</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 150</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">3</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-8.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-6"></div>
      <!--end::Separator-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">$D Printer</a>
            <span class="text-gray-500 fw-semibold d-block">Manfactoring unique objekts</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 1450</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">7</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-26.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-6"></div>
      <!--end::Separator-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">MotionWire</a>
            <span class="text-gray-500 fw-semibold d-block">Perfect animation tool</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 650</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">7</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-21.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-6"></div>
      <!--end::Separator-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">Samsung</a>
            <span class="text-gray-500 fw-semibold d-block">Profile info,Timeline etc</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 720</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">6</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-34.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-6"></div>
      <!--end::Separator-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column me-3">
          <!--begin::Section-->
          <div class="mb-3">
            <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">$D Printer</a>
            <span class="text-gray-500 fw-semibold d-block">Manfactoring unique objekts</span>
          </div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="d-flex align-items-center">
            <span class="fw-bold text-gray-800 fs-5">$ 430</span>
            <span class="text-muted mx-2">for</span>
            <span class="fw-bold text-gray-800 fs-5 me-3">8</span>
            <a href="#"
               class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">{!! getIcon('minus', 'fs-4') !!}</a>
            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">{!! getIcon('plus', 'fs-4') !!}</a>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Pic-->
        <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
          <img src="{{ image('stock/600x400/img-27.jpg') }}" alt=""/>
        </div>
        <!--end::Pic-->
      </div>
      <!--end::Item-->
    </div>
    <!--end::Card body-->
    <!--begin::Card footer-->
    <div class="card-footer">
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <span class="fw-bold text-gray-600">Total</span>
        <span class="text-gray-800 fw-bolder fs-5">$ 1840.00</span>
      </div>
      <!--end::Item-->
      <!--begin::Item-->
      <div class="d-flex flex-stack">
        <span class="fw-bold text-gray-600">Sub total</span>
        <span class="text-primary fw-bolder fs-5">$ 246.35</span>
      </div>
      <!--end::Item-->
      <!--end::Action-->
      <div class="d-flex justify-content-end mt-9">
        <a href="#" class="btn btn-primary d-flex justify-content-end">Pleace Order</a>
      </div>
      <!--end::Action-->
    </div>
    <!--end::Card footer-->
  </div>
  <!--end::Messenger-->
</div>
<!--end::Chat drawer-->
