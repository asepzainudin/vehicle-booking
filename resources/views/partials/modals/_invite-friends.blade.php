<!--begin::Modal - Invite Friends-->
<div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog mw-650px">
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
        <!--begin::Heading-->
        <div class="text-center mb-13">
          <!--begin::Title-->
          <h1 class="mb-3">Invite a Friend</h1>
          <!--end::Title-->
          <!--begin::Description-->
          <div class="text-muted fw-semibold fs-5">If you need more info, please check out
            <a href="#" class="link-primary fw-bold">FAQ Page</a>.
          </div>
          <!--end::Description-->
        </div>
        <!--end::Heading-->
        <!--begin::Google Contacts Invite-->
        <div class="btn btn-light-primary fw-bold w-100 mb-8">
          <img alt="Logo" src="{{ image('svg/brand-logos/google-icon.svg') }}" class="h-20px me-3"/>Invite Gmail
          Contacts
        </div>
        <!--end::Google Contacts Invite-->
        <!--begin::Separator-->
        <div class="separator d-flex flex-center mb-8">
          <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">or</span>
        </div>
        <!--end::Separator-->
        <!--begin::Textarea-->
        <textarea class="form-control form-control-solid mb-8" rows="3"
                  placeholder="Type or paste emails here"></textarea>
        <!--end::Textarea-->
        <!--begin::Users-->
        <div class="mb-10">
          <!--begin::Heading-->
          <div class="fs-6 fw-semibold mb-2">Your Invitations</div>
          <!--end::Heading-->
          <!--begin::List-->
          <div class="mh-300px scroll-y me-n7 pe-7">
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-6.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Smith</a>
                  <div class="fw-semibold text-muted">smith@kpmg.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2" selected="selected">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-danger text-danger fw-semibold">M</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Melody Macy</a>
                  <div class="fw-semibold text-muted">melody@altbox.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1" selected="selected">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-1.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Max Smith</a>
                  <div class="fw-semibold text-muted">max@kt.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-5.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Sean Bean</a>
                  <div class="fw-semibold text-muted">sean@dellito.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2" selected="selected">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-25.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Brian Cox</a>
                  <div class="fw-semibold text-muted">brian@exchange.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
                  <div class="fw-semibold text-muted">mik@pex.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2" selected="selected">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-9.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Francis Mitcham</a>
                  <div class="fw-semibold text-muted">f.mit@kpmg.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-danger text-danger fw-semibold">O</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
                  <div class="fw-semibold text-muted">olivia@corpmail.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2" selected="selected">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil Owen</a>
                  <div class="fw-semibold text-muted">owen.neil@gmail.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1" selected="selected">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-23.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
                  <div class="fw-semibold text-muted">dam@consilting.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-danger text-danger fw-semibold">E</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Bold</a>
                  <div class="fw-semibold text-muted">emma@intenso.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2" selected="selected">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-12.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ana Crown</a>
                  <div class="fw-semibold text-muted">ana.cf@limtel.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1" selected="selected">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-info text-info fw-semibold">A</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Robert Doe</a>
                  <div class="fw-semibold text-muted">robert@benko.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-13.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">John Miller</a>
                  <div class="fw-semibold text-muted">miller@mapple.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <span class="symbol-label bg-light-success text-success fw-semibold">L</span>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
                  <div class="fw-semibold text-muted">lucy.m@fentech.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2" selected="selected">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-21.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ethan Wilder</a>
                  <div class="fw-semibold text-muted">ethan@loop.com.au</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1" selected="selected">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
            <!--begin::User-->
            <div class="d-flex flex-stack py-4">
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-35px symbol-circle">
                  <img alt="Pic" src="{{ image('avatars/300-21.jpg') }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Sean Bean</a>
                  <div class="fw-semibold text-muted">sean@dellito.com</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->
              <!--begin::Access menu-->
              <div class="ms-2 w-100px">
                <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
                  <option value="1">Guest</option>
                  <option value="2">Owner</option>
                  <option value="3" selected="selected">Can Edit</option>
                </select>
              </div>
              <!--end::Access menu-->
            </div>
            <!--end::User-->
          </div>
          <!--end::List-->
        </div>
        <!--end::Users-->
        <!--begin::Notice-->
        <div class="d-flex flex-stack">
          <!--begin::Label-->
          <div class="me-5 fw-semibold">
            <label class="fs-6">Adding Users by Team Members</label>
            <div class="fs-7 text-muted">If you need more info, please check budget planning</div>
          </div>
          <!--end::Label-->
          <!--begin::Switch-->
          <label class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" value="1" checked="checked"/>
            <span class="form-check-label fw-semibold text-muted">Allowed</span>
          </label>
          <!--end::Switch-->
        </div>
        <!--end::Notice-->
      </div>
      <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>
<!--end::Modal - Invite Friend-->
