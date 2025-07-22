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
        <div class="card-body">
            <form action="{{ route('jadwal-monev.store') }}" method="POST" enctype="multipart/form-data }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
                            <input type="hidden" name="waktu_id" value="{{ $waktu_monev->id }}">
                            <tr>
                                <td>
                                    <label for="tahun">Tahun :</label>
                                </td>
                                <td>
                                    <input type="number" name="tahun" id="tahun" class="form-control" required
                                        value="{{ date('Y') }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="kecamatan_id">Kecamatan :</label>
                                </td>
                                <td>
                                    <select name="kecamatan_id" id="kecamatan_id" class="form-control" required
                                        readonly>
                                        <option value="{{ $kecamatanAuth->id }}" selected>{{
                                            $kecamatanAuth->nama_kecamatan }}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="kecamatan_id">Petugas :</label>
                                </td>
                                <td>
                                    <select name="kecamatan_id" id="kecamatan_id" class="form-control" required
                                        readonly>
                                        <option value="{{ $kecamatanAuth->id }}" selected>{{
                                            $kecamatanAuth->nama_kecamatan }}</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="id_kategori_laporan">Kategori Laporan :</label>
                                </td>
                                <td>
                                    <select name="id_kategori_laporan" id="id_kategori_laporan" class="form-control"
                                        required readonly>
                                        <option value="{{ $waktu_monev->kategori->id }}" selected>-- {{
                                            $waktu_monev->kategori->nama_kategori_laporan }} --</option>
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="id_jenis_laporan">Jenis Laporan :</label>
                                </td>
                                <td>
                                    <select name="id_jenis_laporan" id="id_jenis_laporan" class="form-control" required
                                        readonly>
                                        <option value="{{ $waktu_monev->jenis->id }}">{{
                                            $waktu_monev->jenis->nama_jenis_laporan }}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="bulan">Bulan :</label>
                                </td>
                                <td>
                                    <select name="bulan" id="bulan" class="form-control" required readonly>
                                        <option value="">-- Pilih Bulan --</option>
                                        @php
                                        $bulanIndo = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        ];
                                        @endphp

                                        @foreach ($bulanIndo as $key => $value)
                                        <option value="{{ $key }}" @selected(old('bulan', $waktu_monev->bulan ?? '') ==
                                            $key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="id_jenis_laporan">Desa :</label>
                                </td>
                                <td>
                                    <select name="desa_id" id="desa_id" class="form-control" required>
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach ($desa as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_desa }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jabatan">Tanggal :</label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="tanggal_awal">Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" id="tanggal_awal" required
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_akhir">Tanggal Awal</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" required
                                            class="form-control">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalMonev as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->desa->nama_desa }}</td>
                        <td>{{ $item->tanggal_awal }}</td>
                        <td>{{ $item->tanggal_akhir }}</td>
                        <td>
                             <a href="{{ route('jadwal-monev.destroy', $item->id) }}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection