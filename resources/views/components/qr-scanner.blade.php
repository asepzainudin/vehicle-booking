@if($slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag)
  @php
    plugins('qr-scanner');

    $isAutoload = str($attributes->get('autoload'))->lower()->is(['1', 'true', 'on']);
  @endphp
  <div id="qr-wrapper" style="width:fit-content;">
    <select id="qr-camera" class="form-select d-none"></select>
    <div id="qr-container" class="position-relative overflow-hidden" style="width:fit-content; height:fit-content; border-radius:calc(.5rem + 5px); padding:5px 5px 0 5px; background-color:var(--bs-main);">
      <div id="qr-message" class="d-flex flex-column align-items-center justify-content-center gap-3 position-absolute top-0 start-0 w-100 h-100 p-5 text-white fs-2 pulse pulse-warning" style="padding:.5rem; z-index:99;">
        <button type="button" class="qr-start btn btn-light-primary d-flex flex-center gap-2"><i class="fad fa-camera-web fs-2"></i>Start</button>
      </div>
      <div id="qr-buttons" class="d-flex justify-content-between gap-3 position-absolute top-0 start-0 w-100 d-none" style="padding:.7rem; z-index:100;">
        <button class="qr-cameras btn btn-icon btn-circle btn-sm btn-light-primary" title="Daftar Kamera"><i class="fad fa-camera-web"></i></button>
        <button class="qr-stop btn btn-icon btn-circle btn-sm btn-light-danger" title="Stop"><i class="fad fa-stop"></i></button>
      </div>
      <video id="qr-video" class="w-100 mw-500px" style="border-radius:.5rem"></video>
    </div>
  </div>

  @pushonce('styles')
    <style>
      #qr-container .scan-region-highlight {
        border-radius: calc(.5rem + 5px);
        outline: rgba(0, 0, 0, .5) solid 50vmax;
      }
      #qr-container .scan-region-highlight-svg { display: none; }
      #qr-container .code-outline-highlight {
        stroke: rgba(255, 255, 255, .5) !important;
        stroke-width: 15 !important;
        stroke-dasharray: none !important;
      }
    </style>
  @endpushonce

  @pushonce('scripts')
    <script>
      const qr__icn_pulse = `<span class="pulse-ring border-5"></span>`
      const qr__icn_camera = `<i class="fad fa-camera-web fs-3x"></i>`
      const qr__btn_start = `<button type="button" class="qr-start btn btn-light-primary d-flex flex-center gap-2"><i class="fad fa-camera-web fs-2"></i>Start</button>`
      const qr__cnt = $('#qr-container')
      const qr__msg = $('#qr-message')
      const qr__vid = $('#qr-video')
      const qrScanner = new QrScanner(
        document.getElementById('qr-video'),
        result => {
          if (typeof setQrResult === 'function') {
            setQrResult(result, qrScanner)
            return;
          }
          console.log(result)
        },
        {
          highlightScanRegion: true,
          highlightCodeOutline: true,
        }
      )
      let qrInitiated = false
      let qrCamId = ''
      let qrCamStarted = false

      async function getQrCameras() {
        const camSelect = $('#qr-camera')
        camSelect.html('<option value="">~ Auto Detect ~</option>')
        QrScanner.listCameras(true).then(cams => {
          cams.forEach(cam => {
            if (! qrCamId) qrCamId = cam.id
            camSelect.append(`<option value="${cam.id}" ${cam.id === qrCamId ? 'selected' : ''}>${cam.label}</option>`)
          })
        })
      }

      function startScanner() {
        if (!qrInitiated) {
          initScanner()
          return;
        }

        qr__msg.html(`${qr__icn_camera}<span>Memuat Kamera...</span>${qr__icn_pulse}`)
        if (qrCamId) qrScanner.setCamera(qrCamId)
        qrScanner.start().then(() => {
          qrCamStarted = true
          qr__vid.css('transform', 'scaleX(-1)')
          qr__msg.html('')
          $('#qr-buttons').removeClass('d-none')
        })
      }

      function initScanner() {
        QrScanner.hasCamera().then(hasCamera => {
          if (hasCamera) {
            if (qrCamId === '' || qrCamId === null || qrCamId === undefined) {
              getQrCameras().then(() => startScanner())
              return;
            }
            qrInitiated = true
            startScanner()
            return;
          }
          qr__msg.html('Kamera tidak terdeteksi')
        })
      }

      $(document).on('click', '.qr-start', () => startScanner())
      $(document).on('click', '.qr-stop', () => {
        qrScanner.pause().then(() => {
          $('#qr-buttons').addClass('d-none')
          qrScanner.stop()
          qr__msg.html(qr__btn_start)
        })
      })
      $(document).on('click', '.qr-cameras', function () {
        const __icn = $(this).find('i.fad')
        const __lst = $('#qr-camera')
        if (! qrCamStarted) return;

        if (__icn.hasClass('fa-camera-web')) {
          __icn.removeClass('fa-camera-web').addClass('fa-camera-web-slash')
          __lst.removeClass('d-none')
        } else {
          __icn.removeClass('fa-camera-web-slash').addClass('fa-camera-web')
          __lst.addClass('d-none')
        }
      })
      $(document).on('change', '#qr-camera', function () {
        qrScanner.setCamera( $(this).find(':checked').val() ).then(() => qr__vid.css('transform', 'scaleX(-1)'))
      })
      {{ $isAutoload ? 'initScanner()' : '' }}
    </script>
  @endpushonce
@endif
