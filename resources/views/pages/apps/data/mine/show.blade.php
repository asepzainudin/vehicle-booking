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
            <x-input.grid label="Nama Kantor Cabang">
              <div class="form-control form-control-underline form-colon">
                {{ $mine->officeRegion?->name ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Nama">
              <div class="form-control form-control-underline form-colon">
                {{ $mine->name ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Kode">
              <div class="form-control form-control-underline form-colon">
                {{ $mine->code ?? '' }}
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Status">
              <div class="form-control form-control-underline form-colon">
                @if ($mine->is_active)
                    <span class=" badge-light-success">Aktif</span>
                @else
                    <span class=" badge-light-danger">Non Aktif</span>
                @endif
              </div>
            </x-input.grid>
          </div>
          <div class="mb-5">
            <x-input.grid label="Alamat">
              <div class="form-control form-control-underline form-colon">
                {{ $mine->additional['address'] ?? '' }}
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