@extends('layouts.app')

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Inspektorat</li>
                </ol>
            </nav>
            <h1 class="m-0">Jadwal Monev</h1>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Data Jadwal Monitoring Kecamatan</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('waktu-monev.filter') }}" method="POST" enctype="multipart/form-data }}">
                @csrf
                <div class="form-group">
                    <label for="tahun">Kecamatan:</label>
                    <select name="tahun" id="tahun" class="form-control">
                        @foreach ($kecamatan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Jenis Laporan</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($waktu_monev as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @php
                        $bulanList = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                        ];
                        @endphp

                        <td>{{ $bulanList[$item->bulan] ?? '-' }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->kategori->nama_kategori_laporan }} - {{ $item->jenis->nama_jenis_laporan }}</td>
                        <td>{{ $item->tanggal_awal }}</td>
                        <td>{{ $item->tanggal_akhir }}</td>
                        <td>
                            @if ($item->status == 'active')
                            <span class="text-success">Aktif</span>
                            @else
                            <span class="text-danger">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function getKategori(kategoriId) {
        const jenisSelect = document.getElementById('id_jenis_laporan');

        jenisSelect.innerHTML = '<option value="">Loading...</option>';

        if (kategoriId) {
            fetch(`/api/jenis-by-kategori/${kategoriId}`)
                .then(response => response.json())
                .then(response => {
                    const jenisList = response.data; // karena formatnya { status: ..., data: [...] }

                    jenisSelect.innerHTML = '<option value="">-- Pilih Jenis Laporan --</option>';

                    jenisList.forEach(jenis => {
                        jenisSelect.innerHTML += `<option value="${jenis.id}">${jenis.nama_jenis_laporan}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Gagal ambil data jenis:', error);
                    jenisSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            jenisSelect.innerHTML = '<option value="">-- Pilih Jenis Laporan --</option>';
        }
    }
</script>
@endsection