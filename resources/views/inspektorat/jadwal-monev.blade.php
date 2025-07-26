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
            <form action="{{ route('waktu-monev.filter') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="filter_kecamatan">Kecamatan:</label>
                    <select name="filter_kecamatan" id="filter_kecamatan" class="form-control"
                        onchange="filterKecamatan()">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $item)
                        <option value="{{ $item->nama_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <table class="table table-bordered" id="jadwal-monev-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Kecamatan</th>
                        <th>Jenis Laporan</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $bulanList = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                    4 => 'April', 5 => 'Mei', 6 => 'Juni',
                    7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                    10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                    ];
                    @endphp

                    @foreach ($jadwalMonev as $item)
                    @php
                    $waktu = $item['waktu_monev'];
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $bulanList[$waktu->bulan ?? 0] ?? '-' }} - {{ $waktu->tahun ?? '-' }}
                        </td>
                        <td>
                            {{ $item['nama_kecamatan'] ?? '-' }}
                        </td>
                        <td>
                            {{ $waktu->kategori->nama_kategori_laporan ?? '-' }} -
                            {{ $waktu->jenis->nama_jenis_laporan ?? '-' }}
                        </td>
                        <td>{{ $waktu->tanggal_awal ?? '-' }}</td>
                        <td>{{ $waktu->tanggal_akhir ?? '-' }}</td>

                        <td>
                            @if (($waktu->status ?? null) === 'active')
                            <span class="text-success">Aktif</span>
                            @else
                            <span class="text-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('inspektorat.monitoring.detail', ['waktu' => $item['waktu_monev']->id, 'kecamatan' => $item['kecamatan_id']]) }}"
                                class="btn btn-sm btn-primary">Detail</a>
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
    function filterKecamatan() {
        const selectedKecamatan = document.getElementById('filter_kecamatan').value.toLowerCase();
        const rows = document.querySelectorAll('#jadwal-monev-table tbody tr');

        rows.forEach(row => {
            const cellKecamatan = row.children[2]?.textContent.trim().toLowerCase(); // kolom ke-3
            if (!selectedKecamatan || cellKecamatan === selectedKecamatan) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
   
</script>
@endsection