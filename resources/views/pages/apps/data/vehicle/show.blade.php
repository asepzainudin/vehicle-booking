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
        <div class="col-md-9 mt-2">
          <!-- Initial Input Field -->
          <div class="mb-5">
            <x-input.grid label="Nama">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->name ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Kode">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->code ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Total Kendaraan">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->vechicleOrders->count() ? $vehicle->total_vehicles + $vehicle->vechicleOrders->count() : $vehicle->total_vehicles }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Kendaraan Tersedia">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->total_vehicles ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Kendaraan Terpakai">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->vechicleOrders->count() ? $vehicle->total_vehicles + $vehicle->vechicleOrders->count() : 0 }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Jenis Kendaraan">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->type ? \App\Enums\VehicleType::from($vehicle->type->value)->label() : '-' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Status Kepemilikan">
              <div class="form-control form-control-underline form-colon">
                {{ $vehicle->status == 'owned' ? 'Milik Perusahaan' : 'Rental' }}
              </div>
            </x-input.grid>
          </div>
          @if ($vehicle->status == 'rental')
            <div class="mb-5">
              <x-input.grid label="Perusahaan Sewa">
                <div class="form-control form-control-underline form-colon">
                  {{ $vehicle->additional['rental_company_name'] ?? '' }}
                </div>
              </x-input.grid>
            </div>
            <div class="mb-5">
              <x-input.grid label="Nomor Hp Perusahaan Sewa">
                <div class="form-control form-control-underline form-colon">
                  {{ $vehicle->additional['rental_company_phone'] ?? '' }}
                </div>
              </x-input.grid>
            </div>
          @endif
          <div class="mb-5">
            <x-input.grid label="Status">
              <div class="form-control form-control-underline form-colon">
                @if ($vehicle->is_active)
                    <span class=" badge-light-success">Aktif</span>
                @else
                    <span class=" badge-light-danger">Non Aktif</span>
                @endif
              </div>
            </x-input.grid>
          </div>
        </div>

      </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
      <x-button.back href="{{ $backLink }}">Kembali</x-button.back>
    </div>
  </div>
@endsection