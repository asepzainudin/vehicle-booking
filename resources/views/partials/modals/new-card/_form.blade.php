<!--begin::Input group-->
<div class="d-flex flex-column mb-7 fv-row">
  <!--begin::Label-->
  <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
    <span class="required">Name On Card</span>
    <span class="ms-1" data-bs-toggle="tooltip" title="Specify a card holder's name"></span>
  </label>
  <!--end::Label-->
  <input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe"/>
</div>
<!--end::Input group-->
<!--begin::Input group-->
<div class="d-flex flex-column mb-7 fv-row">
  <!--begin::Label-->
  <label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
  <!--end::Label-->
  <!--begin::Input wrapper-->
  <div class="position-relative">
    <!--begin::Input-->
    <input type="text" class="form-control form-control-solid" placeholder="Enter card number" name="card_number"
           value="4111 1111 1111 1111"/>
    <!--end::Input-->
    <!--begin::Card logos-->
    <div class="position-absolute translate-middle-y top-50 end-0 me-5">
      <img src="{{ image('svg/card-logos/visa.svg') }}" alt="" class="h-25px"/>
      <img src="{{ image('svg/card-logos/mastercard.svg') }}" alt="" class="h-25px"/>
      <img src="{{ image('svg/card-logos/american-express.svg') }}" alt="" class="h-25px"/>
    </div>
    <!--end::Card logos-->
  </div>
  <!--end::Input wrapper-->
</div>
<!--end::Input group-->
<!--begin::Input group-->
<div class="row mb-10">
  <!--begin::Col-->
  <div class="col-md-8 fv-row">
    <!--begin::Label-->
    <label class="required fs-6 fw-semibold form-label mb-2">Expiration Date</label>
    <!--end::Label-->
    <!--begin::Row-->
    <div class="row fv-row">
      <!--begin::Col-->
      <div class="col-6">
        <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2"
                data-hide-search="true" data-placeholder="Month">
          <option></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
        </select>
      </div>
      <!--end::Col-->
      <!--begin::Col-->
      <div class="col-6">
        <select name="card_expiry_year" class="form-select form-select-solid" data-control="select2"
                data-hide-search="true" data-placeholder="Year">
          <option></option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
          <option value="2027">2027</option>
          <option value="2028">2028</option>
          <option value="2029">2029</option>
          <option value="2030">2030</option>
          <option value="2031">2031</option>
          <option value="2032">2032</option>
          <option value="2033">2033</option>
        </select>
      </div>
      <!--end::Col-->
    </div>
    <!--end::Row-->
  </div>
  <!--end::Col-->
  <!--begin::Col-->
  <div class="col-md-4 fv-row">
    <!--begin::Label-->
    <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
      <span class="required">CVV</span>
      <span class="ms-1" data-bs-toggle="tooltip" title="Enter a card CVV code"></span>
    </label>
    <!--end::Label-->
    <!--begin::Input wrapper-->
    <div class="position-relative">
      <!--begin::Input-->
      <input type="text" class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV"
             name="card_cvv"/>
      <!--end::Input-->
      <!--begin::CVV icon-->
      <div class="position-absolute translate-middle-y top-50 end-0 me-3">{!! getIcon('credit-cart', 'fs-2hx') !!}</div>
      <!--end::CVV icon-->
    </div>
    <!--end::Input wrapper-->
  </div>
  <!--end::Col-->
</div>
<!--end::Input group-->
<!--begin::Input group-->
<div class="d-flex flex-stack">
  <!--begin::Label-->
  <div class="me-5">
    <label class="fs-6 fw-semibold form-label">Save Card for further billing?</label>
    <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
  </div>
  <!--end::Label-->
  <!--begin::Switch-->
  <label class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input" type="checkbox" value="1" checked="checked"/>
    <span class="form-check-label fw-semibold text-muted">Save Card</span>
  </label>
  <!--end::Switch-->
</div>
<!--end::Input group-->
