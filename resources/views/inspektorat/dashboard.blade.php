@extends('layouts.app')

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <h1 class="m-0">Dashboard</h1>
        </div>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="row card-group-row">
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Total Desa
                        </div>
                        <div class="text-amount">{{ $desaCount }} Desa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Total Kecamatan
                        </div>
                        <div class="text-amount">{{ $kecamatanCount }} Kecamatan</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Belum Laporan
                            Tahun Sebelumnya</div>
                        <div class="text-amount">10 Desa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Belum Laporan
                            Tahun Berjalan</div>
                        <div class="text-amount">10 Desa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Belum laporan
                            Tahun Berikutnya</div>
                        <div class="text-amount">10 Desa</div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

@endsection