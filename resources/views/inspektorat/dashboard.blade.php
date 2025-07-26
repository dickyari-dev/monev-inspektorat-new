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
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Laporan Desa Yang Belum Lengkap
                        </div>
                        <div class="text-amount">{{ $jumlahDesaBelumLengkap }} Desa</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body d-flex flex-row align-items-start flex-0 border-bottom">
                    <div class="flex">
                        <div class="card-header__title mb-2" style="font-size: 12px">Laporan Desa Lengkap</div>
                        <div class="text-amount">{{ $desaLengkap }} Desa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="https://dinpmd.bojonegorokab.go.id/uploads/artikel/ARTIKEL20230726161315pm.jpeg" alt=""
                        class="img-fluid w-100" style="width: 100%; height:100%; object-fit: cover">
                </div>
                 <div class="col-md-6">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Desa</th>
                            <th>Laporan Tersetujui</th>
                            <th>Jumlah Seharusnya</th>
                            <th>Persentase</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rankingDesa as $index => $desa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $desa->nama_desa }}</td>
                            <td>{{ $desa->total_laporan_terima }}</td>
                            <td>{{ $desa->jumlah_seharusnya }}</td>
                            <td>{{ $desa->persentase }}%</td>
                            <td>
                                <span class="badge {{ $desa->status === 'Lengkap' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $desa->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
           

        </div>
    </div>
</div>

@endsection