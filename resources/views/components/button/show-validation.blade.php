@if(
  $slot instanceof \Illuminate\View\ComponentSlot && $attributes instanceof \Illuminate\View\ComponentAttributeBag &&
  ($errors ?? null) instanceof \Illuminate\Support\ViewErrorBag && $errors->any()
)
  @php
    $defaultAttributes = [
      'class' => 'btn btn-sm btn-light-danger',
    ];
    if ($slot->isEmpty()) {
      $slot = new \Illuminate\Support\HtmlString("<i class='fad fa-eye me-1'></i> Detil Validasi");
    }
  @endphp
  <button type="button" {!! $attributes->merge($defaultAttributes) !!} data-bs-toggle="modal" data-bs-target="#modalDetailValidation">
    {{ $slot }}
  </button>

  @prependonce('modal')
    <div class="modal fade" data-bs-focus="false" tabindex="-1" id="modalDetailValidation">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title text-danger">Eror Validasi</h3>
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
              <i class="fad fa-times fs-1"></i>
            </div>
          </div>
          <div class="list-group list-group-flush list-group-alt list-group-numbered" style="list-style: circle">
            @forelse($errors->all() as $error)
              <div class="list-group-item list-group-item-action list-group-item-danger">{{ $error }}</div>
            @empty
            @endforelse
          </div>
          <div class="modal-footer py-3">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
  @endprependonce
@endif
