@extends('layouts.app')

@section('content')
<div class="container-fluid page__heading-container mt-2">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Inspektorat</li>
                </ol>
            </nav>
            <h1 class="m-0">Jadwal Monitoring Desa (Kecamatan {{ $kecamatanAuth->nama_kecamatan }})</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-0 text-center">Data Jadwal Monev</h5>
            @php
            $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            @endphp

            <table class="table table-borderless">
                <tr>
                    <td><strong>Bulan / Tahun</strong></td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $bulanIndo[(int) $waktu_monev->bulan] ?? 'Bulan Tidak Diketahui' }} / {{ $waktu_monev->tahun
                        }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Laporan</strong></td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $waktu_monev->kategori->nama_kategori_laporan ?? 'Kategori Tidak Diketahui'}} -</td>
                </tr>
                <tr>
                    <td><strong>Jenis Laporan</strong></td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $waktu_monev->jenis->nama_jenis_laporan ?? 'Jenis Tidak Diketahui'}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>



<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Data Jadwal Monitoring Laporan Desa</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Desa</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalMonev as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->desa->nama_desa }}</td>
                        <td>{{ $item->tanggal_awal }}</td>
                        <td>{{ $item->tanggal_akhir }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak Ada Data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection