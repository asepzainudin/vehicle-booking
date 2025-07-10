@extends('layouts.app')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
      <div class="card-toolbar"></div>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-8 mt-2">
          <!-- Initial Input Field -->

          <div class="mb-5">
            <x-input.grid label="Kode">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicleOrder->code ?? '' }}
              </div>
            </x-input.grid>
          </div>

          <div class="mb-5">
            <x-input.grid label="Kendaraan">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicleOrder->vehicle?->name ?? '' }}
              </div>
            </x-input.grid>
          </div>

          <div class="mb-5">
            <x-input.grid label="Driver">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicleOrder->driver?->name ?? '' }} ( {{ $vehicleOrder->driver?->email ?? '' }} )
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Reviewer">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicleOrder->reviewer?->name ?? '' }} ( {{ $vehicleOrder->reviewer?->email ?? '' }} )
              </div>
            </x-input.grid>
          </div>

          <div class="mb-5">
            <x-input.grid label="Approver">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicleOrder->approver?->name ?? '' }} ( {{ $vehicleOrder->approver?->email ?? '' }} )
              </div>
            </x-input.grid>
          </div>

        </div>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
      <x-button.back href="{{ $backLink }}">Kembali</x-button.back>
      <div class="d-flex">
        @if (auth()->user()->hasRole('reviewer'))
          @can('vehicle-order.status')
            <div class="dropdown">
              <button class="btn btn-warning dropdown-toggle me-2" type="button" id="dropdownMenuButton5"
                data-bs-toggle="dropdown" aria-expanded="false">
                UPDATE STATUS
              </button>
              <ul class="dropdown-menu dropdown-menu-dark animate__animated animate__fadeIn"
                aria-labelledby="dropdownMenuButton5">
                <li><a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reviewModal"
                    data-hash="{{ $vehicleOrder->hash }}"
                    href="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'review']) }}">REVIEW</a>
                  </li>
                <li>
                  <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#rejectModal"
                    data-hash="{{ $vehicleOrder->hash }}"
                    href="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'rejected']) }}">REJECT
                  </a>
                </li>
              </ul>
            </div>
          @endcan
        @endif

        @if (auth()->user()->hasRole('approval'))
          @can('vehicle-order.status')
            <div class="dropdown">
              <button class="btn btn-warning dropdown-toggle me-2" type="button" id="dropdownMenuButton5"
                data-bs-toggle="dropdown" aria-expanded="false">
                UPDATE STATUS
              </button>
              <ul class="dropdown-menu dropdown-menu-dark animate__animated animate__fadeIn"
                aria-labelledby="dropdownMenuButton5">
                <li><a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#approvedModal" data-hash="{{ $vehicleOrder->hash }}"
                    href="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'approved']) }}">APPROVED</a>
                </li>
                <li>
                  <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#rejectModal"
                    data-hash="{{ $vehicleOrder->hash }}"
                    href="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'rejected']) }}">REJECT
                  </a>
                </li>
              </ul>
            </div>
          @endcan
        @endif

        @if (auth()->user()->hasRole('driver') && $vehicleOrder->status->value == App\Enums\StatusType::APPROVED->value)
          @can('vehicle-order.status')
            <div class="dropdown">
              <button class="btn btn-warning dropdown-toggle me-2" type="button" id="dropdownMenuButton5"
                data-bs-toggle="dropdown" aria-expanded="false">
                UPDATE STATUS
              </button>
              <ul class="dropdown-menu dropdown-menu-dark animate__animated animate__fadeIn"
                aria-labelledby="dropdownMenuButton5">
                <li>
                  <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#returnModal"
                    data-hash="{{ $vehicleOrder->hash }}"
                    href="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'return']) }}">RETURN
                  </a>
                </li>
              </ul>
            </div>
          @endcan
        @endif
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="reviewForm" method="GET" action="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'review']) }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="reviewModalLabel">Keterangan review (review)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="reason" class="form-label">Alasan atau Keterangan</label>
                <textarea class="form-control" name="reason" id="reason" rows="4" required
                  placeholder="Tulis alasan pengembalian..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Kirim review</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="modal fade" id="approvedModal" tabindex="-1" aria-labelledby="approvedModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <form id="approvedForm" method="GET"
          action="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'approved']) }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="approvedModalLabel">Keterangan Approved (approved)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="reason" class="form-label">Alasan atau Keterangan</label>
                <textarea class="form-control" name="reason" id="reason" rows="4" required
                  placeholder="Tulis alasan pengembalian..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Kirim approved</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="returnForm" method="GET" action="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'return']) }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="returnModalLabel">Keterangan Pengembalian (return)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="reason" class="form-label">Alasan atau Keterangan</label>
                <textarea class="form-control" name="reason" id="reason" rows="4" required
                  placeholder="Tulis alasan pengembalian..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Kirim return</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="rejectedForm" method="GET"
          action="{{ routed('app.vehicle-order.status', [$vehicleOrder->hash, 'rejected']) }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="rejectModalLabel">Keterangan pembatalan (Reject)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="reason" class="form-label">Alasan atau Keterangan</label>
                <textarea class="form-control" name="reason" id="reason" rows="4" required
                  placeholder="Tulis alasan pembatalan..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Kirim Reject</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>

  <div class="card mt-3 mb-5">
    <table class="table table-bordered">
      <thead>
        <tr class="bg-muamalat">
          <th class="text-white">#</th>
          <th class="text-white">Status Awal</th>
          <th class="text-white">Transfer Status</th>
          <th class="text-white">Keterangan</th>
          <th class="text-white">Staff</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($vehicleOrder->statusHistories()->with('changer')->orderBy('created_at', 'desc')->get() as $key => $history)
          <tr>
            <td width="1" class="p-2">{{ $key + 1 }}</td>
            <td><b> {{ $history->from_status ? App\Enums\StatusType::from($history->from_status->value)->label() : '' }}
              </b></td>
            <td><b> {{ $history->to_status ? App\Enums\StatusType::from($history->to_status->value)->label() : '' }}
              </b></td>
            <td>{{ $history->note ?? '' }}</td>
            <td>{{ $history->changer?->name ?? "" }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
