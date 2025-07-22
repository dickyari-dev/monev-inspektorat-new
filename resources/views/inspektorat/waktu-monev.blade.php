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
            <h1 class="m-0">Waktu Monev</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('waktu-monev.store') }}" method="POST" enctype="multipart/form-data }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
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
                                    <label for="bulan">Bulan :</label>
                                </td>
                                <td>
                                    <select name="bulan" id="bulan" class="form-control" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="id_kategori_laporan">Kategori Laporan :</label>
                                </td>
                                <td>
                                    <select name="id_kategori_laporan" id="id_kategori_laporan" class="form-control"
                                        required onchange="getKategori(this.value)">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kategori_laporan }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="id_jenis_laporan">Jenis Laporan :</label>
                                </td>
                                <td>
                                    <select name="id_jenis_laporan" id="id_jenis_laporan" class="form-control" required>
                                        <option value="">-- Pilih Jenis --</option>
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

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Struktur Desa</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Jenis Laporan</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($waktu_monev as $item)
                    @php
                    $namaBulan = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                    ];
                    @endphp

                    {{ $namaBulan[$item->bulan] ?? 'Tidak diketahui' }}

                    <tr>
                        <td>{{ $loop->iteration }} </td>
                        <td>{{ $namaBulan[$item->bulan] ?? 'Tidak diketahui' }}
                            - {{ $item->tahun }}</td>
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
                        <td>
                            <a href="{{ route('waktu-monev.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('waktu-monev.destroy', $item->id) }}"
                                class="btn btn-sm btn-danger">Hapus</a>
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
    document.getElementById('photo').addEventListener('change', function(event) {
        const img = document.getElementById('preview-image');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            // fallback jika user batal pilih file
            img.src = "{{ asset('assets/images/user.png') }}";
        }
    });

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