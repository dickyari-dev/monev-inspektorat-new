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
        <div class="flatpickr-wrapper ml-3">
            <div id="recent_orders_date" data-toggle="flatpickr" data-flatpickr-wrap="true" data-flatpickr-mode="range"
                data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                <a href="javascript:void(0)" class="link-date" data-toggle>13/03/2018 to
                    20/03/2018</a>
                <input class="flatpickr-hidden-input" type="hidden" value="13/03/2018 to 20/03/2018" data-input>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="row card-group-row">
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Belum Laporan
                        </div>
                        <div class="text-amount">10 Desa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Belum Tuntas
                        </div>
                        <div class="text-amount">2 Kecamatan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
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
        </div>
    </div>
</div>

@endsection