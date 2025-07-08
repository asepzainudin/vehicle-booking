const dragPosDefault = {pos1: 0, pos2: 0, pos3: 0, pos4: 0};
let dragPos = {};
const indoNumber = Intl.NumberFormat('id-ID');

function dragElement(elId) {
  if (typeof elId === 'string') {
    const elKey = elId.replace('#', '');
    const el = document.querySelector('#' + elKey);
    dragPos[elKey] = dragPos[elKey] || dragPosDefault;

    if (el.querySelector('.modal-content')) {
      // if present, the header is where you move the DIV from:
      el.querySelector('.modal-content').onmousedown = dragMouseDown;
    } else {
      // otherwise, move the DIV from anywhere inside the DIV:
      el.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
      e = e || window.event;
      // get the mouse cursor position at startup:
      dragPos[elKey].pos3 = e.clientX;
      dragPos[elKey].pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      // call a function whenever the cursor moves:
      document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
      e = e || window.event;
      // calculate the new cursor position:
      dragPos[elKey].pos1 = dragPos[elKey].pos3 - e.clientX;
      dragPos[elKey].pos2 = dragPos[elKey].pos4 - e.clientY;
      dragPos[elKey].pos3 = e.clientX;
      dragPos[elKey].pos4 = e.clientY;
      // set the element's new position:
      el.style.top = (el.offsetTop - dragPos[elKey].pos2) + "px";
      el.style.left = (el.offsetLeft - dragPos[elKey].pos1) + "px";
    }

    function closeDragElement() {
      // stop moving when mouse button is released:
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }
}

function makeUrlPersistence(formId) {
  const f = $(formId);
  if (f.is('form')) {
    let q = $.param(f.serializeArray());
    q = q.trim() === '' ? '' : `?${q}`;
    window.history.replaceState(null, null, `${window.location.pathname}${q}`);
  }
}

function applyFilterInfo(infoTargets) {
  if (infoTargets === undefined || infoTargets === null) {
    infoTargets = '[data-kfn-filter-info-target]';
  }
  $(infoTargets).each(function (mdi, mdEl) {
    const filterMdl = $(mdEl);
    const infoTarget = $(filterMdl.attr('data-kfn-filter-info-target'));

    if (infoTarget.length > 0) {
      infoTarget.html('');
      applyInfo(filterMdl, infoTarget);
    }
  });

  function applyInfo(component, infoTarget) {
    let targetHasFilter = false;
    component.find('[data-kfn-filter]').each(function (fti, ft) {
      const el = $(ft);
      const elLabel = el.attr('data-kfn-filter-label');
      let elContent = '';
      let elHasFilter = false;

      if (el.is('select')) {
        el.children('option:selected').each((i, el) => {
          elContent += setInfoContent(el.text);
          elHasFilter = true;
        });
      }
      if (el.is('input') && (
        ['date', 'datetime', 'month', 'year'].includes(el.attr('type')) ||
        ['date', 'datetime', 'date-month', 'month', 'date-year', 'year'].includes(el.attr('data-kfn-filter'))
      )) {
        const dateData = moment(el.val());
        let dateFormat = getDateFormat(el);

        if (dateData.isValid()) {
          elContent += setInfoContent(dateData.format(dateFormat));
          elHasFilter = true;
        }
      }
      if (el.is('input') && ['text', 'phone', 'email', 'number'].includes(el.attr('type'))) {
        let val = (el.val()).trim();

        if (el.attr('type') === 'number' && el.attr('data-kfn-filter') === 'range') {
          const valEnd = $(el.attr('data-kfn-filter-end')).val();
          if (val && valEnd) {
            val = `${val} - ${valEnd}`;
          } else if (val && ! valEnd) {
            val = `&#8805; ${val}`;
          } else if (! val && valEnd) {
            val = `&#8804; ${valEnd}`;
          }
        }
        if (val !== '') {
          elContent += setInfoContent(val);
          elHasFilter = true;
        }
      }

      if (elHasFilter) {
        infoTarget.append(setInfoElement(el.attr('name'), elContent, elLabel));
        targetHasFilter = true;
      }
    });

    infoTarget
      .removeClass('d-flex d-none')
      .addClass(targetHasFilter ? 'd-flex' : 'd-none');
  }

  function getDateFormat(el) {
    const type = el.attr('type');
    const filterType = el.attr('data-kfn-filter');

    if (type === 'datetime' || filterType === 'datetime') {
      return 'DD-MM-YYYY HH:mm:ss';
    }
    if (type === 'month' || filterType === 'date-month' || filterType === 'month') {
      return 'MM-YYYY';
    }
    if (type === 'year' || filterType === 'date-year' || filterType === 'year') {
      return 'YYYY';
    }
    return 'DD-MM-YYYY';
  }

  function setInfoElement(id, content, label) {
    return `<div id="filter-info-${id}" class="filter-info-item align-items-center gap-2 border rounded px-2 py-1 small d-flex">` +
      (label === undefined || label === null ? '' : `<b>${label}:</b>`) +
      `<div class="filter-content d-flex gap-1">${content}</div>` +
      `</div>`;
  }

  function setInfoContent(content) {
    return `<span class="badge badge-light-primary">${content}</span>`;
  }
}

$(function () {
  $('[data-kfn-dragable="true"]').each(function (i, el  ) {
    dragElement($(el).attr('id'));
  });

  applyFilterInfo();

  const gBtnSaves = $('.btn-save');
  const gBtnCancels = $('.btn-cancel');
  const gBtnUploads = $('.btn-upload');

  if (gBtnSaves.length > 0) {
    gBtnSaves.removeClass('btn')
      .addClass('btn btn-primary')
      .prepend('<i class="ki-duotone ki-send fs-1 me-2"><span class="path1"></span><span class="path2"></span></i>');
  }
  if (gBtnCancels.length > 0) {
    gBtnCancels.removeClass('btn')
      .addClass('btn btn-outline-dark')
      .prepend('<i class="ki-duotone ki-abstract-11 fs-1 me-2"><span class="path1"></span><span class="path2"></span></i>');
  }
  if (gBtnUploads.length > 0) {
    gBtnUploads.removeClass('btn')
      .addClass('btn btn-info')
      .prepend('<i class="ki-duotone ki-file-up fs-1 me-2"><span class="path1"></span><span class="path2"></span></i>');
  }

  $(document).on('click', '.btn-edit', function () {
    location.href = $(this).data('href');
  });

  $(document).on('click', '.btn-delete', function () {
    const confirmUrl = $(this).is('[data-href]') ? $(this).data('href') : '#';
    const redirectUrl = $(this).attr('data-redirect');
    const successAction = $(this).attr('data-action');

    let confirmText = $(this).is('[data-confirm-text]')
      ? $(this).data('confirmText')
      : 'Apakah yakin akan menghapus data ini ?';
    if ($(this).is('[data-confirm]')) {
      confirmText = 'Apakah yakin akan menghapus data <b>' + $(this).data('confirm') + '</b> ini ?';
    }

    swal.fire({
      title: 'Konfirmasi Hapus',
      html: confirmText,
      icon: 'warning',
      confirmButtonText: 'Ya, hapus!',
      showCancelButton: true,
      cancelButtonText: 'Tidak',
      focusCancel: true,
      customClass: {
        confirmButton: 'btn btn-danger mx-1',
        cancelButton: 'btn btn-secondary mx-1',
      },
      buttonsStyling: false,
      showLoaderOnConfirm: true,
      preConfirm: function () {
        return $.ajax(confirmUrl, {type: 'delete'}).done(function (rs) {return rs;});
      }
    })
    .then(function (result) {
      let msg = result.value?.message;

      if (result.value === true || result.value.success === true) {
        if (!msg || msg === undefined) {
          msg = 'Data berhasil dihapus';
        }
        swal.fire('', msg, 'success')
          .then(function () {
            if (successAction !== null && successAction !== undefined) {
              eval(successAction);
              return;
            }
            if (redirectUrl !== null && redirectUrl !== undefined) {
              location.href = redirectUrl;
              return;
            }
            location.reload(true);
          });
      } else {
        if (!msg || msg === undefined) {
          msg = 'Data gagal dihapus';
        }
        swal.fire('', msg, 'error');
      }
    })
    .catch(function (e) {
      const rs = JSON.parse(e.responseText);
      let msg = rs.message;
      if (!msg || msg === undefined) {
          msg = 'Data gagal dihapus';
        }
        swal.fire('', msg, 'error');
    });
  });

  $(document).on('click', '.btn-logout, .button-logout', function () {
    let targetUrl = $(this).is('[data-href]') ? $(this).data('href') : undefined;
    if (! targetUrl) {
      targetUrl = $(this).is('[data-action]') ? $(this).data('action') : '/auth/logout';
    }
    let frmMethod = $(this).is('[data-method]') ? $(this).data('method') : 'post';
    let frmCsrf = $(this).is('[data-csrf]') ? $(this).data('csrf') : $('meta[name="csrf-token"]').attr('content');
    let confirmText = $(this).is('[data-confirm-text]')
      ? $(this).data('confirmText')
      : 'Anda yakin ingin keluar ?';

    swal.fire({
      title: 'Konfirmasi',
      html: confirmText,
      icon: 'question',
      confirmButtonText: 'Logout',
      showCancelButton: true,
      cancelButtonText: 'Batal',
      focusCancel: true,
      customClass: {
        confirmButton: 'btn btn-primary mx-1',
        cancelButton: 'btn btn-secondary mx-1',
      },
      buttonsStyling: false,
      showLoaderOnConfirm: true,
      preConfirm: function () {
        if (frmMethod.toLowerCase() === 'get') {
          window.location.href = targetUrl;
        } else {
          let frm = $('form').attr('method', 'post').attr('action', targetUrl);
          frm.append(
            `<input type="hidden" name="_token" value="${frmCsrf}"><button type="submit" id="sendLogout">x</button>`
          );
          frm.submit();
        }
      }
    });
  });

  $(document).on('click', '.filter-apply', function (e) {
    e.preventDefault();
    const frm = $(this).closest('form');
    // const infoTarget = frm.attr('data-kfn-filter-info');
    const dtTarget = frm.attr('data-kfn-datatable');

    makeUrlPersistence( frm.attr('id') );
    // applyFilterInfo( infoTarget );
    applyFilterInfo();
    if (window.KfnTables && dtTarget) {
      window.KfnTables[dtTarget].ajax.reload();
    }
  });
});
