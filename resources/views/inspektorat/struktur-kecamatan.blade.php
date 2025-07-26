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
            <h1 class="m-0">Struktur Kecamatan</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('struktur-kecamatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <label for="kecamatan">Kecamatan :</label>
                                </td>
                                <td>
                                    <select name="id_kecamatan" id="id_kecamatan" class="form-control" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatan as $kecamatan)
                                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nip">NIP :</label>
                                </td>
                                <td>
                                    <input type="text" name="nip" id="nip" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_pegawai">Nama Pegawai :</label>
                                </td>
                                <td>
                                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="alamat">Alamat Lengkap :</label>
                                </td>
                                <td>
                                    <textarea name="alamat" id="alamat" cols="30" rows="3"
                                        class="form-control"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telephone">Telephone :</label>
                                </td>
                                <td>
                                    <input type="telephone" name="telephone" id="telephone" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jabatan">Jabatan :</label>
                                </td>
                                <td>
                                    <select name="id_jabatan" id="" class="form-control" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jenisJabatan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jabatan">Tahun Menjabat :</label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="tahun_awal">Tahun Awal</label>
                                        <input type="date" name="tahun_awal" id="tahun_awal" required
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_akhir">Tahun Akhir</label>
                                        <input type="date" name="tahun_akhir" id="tahun_akhir" required
                                            class="form-control">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body"
                                style="text-align: center; min-height: 300px; width: 100%; background-color: #eee">
                                <img id="preview-image" src="{{ asset('assets/images/user.png') }}" alt="Preview Gambar"
                                    class="img-fluid" style="max-height: 280px;">
                            </div>
                        </div>
                        <div class="form-group mt-3 mb-3">
                            <label for="foto">Upload Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control mt-2" required
                                accept="image/*">
                        </div>
                        {{-- <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div> --}}
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Struktur Kecamatan</h2>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="filterKecamatan">Filter Kecamatan:</label>
                <select id="filterKecamatan" class="form-control" onchange="filterByKecamatan()">
                    <option value="">-- Semua Kecamatan --</option>
                    @foreach ($kecamatanFilter as $item)
                    <option value="{{ $item->nama_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Kecamatan</th>
                        <th>Jabatan</th>
                        <th>Tahun Menjabat</th>
                        <th>Alamat Lengkap</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($struktur as $item)
                    <tr data-kecamatan="{{ $item->kecamatan->nama_kecamatan }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $item->foto) }}" alt=""
                                style="width: 100px; height: 100px; object-fit: cover">
                        </td>
                        <td>{{ $item->nama_pegawai ?? '-' }}</td>
                        <td>{{ $item->nip ?? '-' }}</td>
                        <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td>{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                        <td>
                            {{ $item->tahun_awal ? \Carbon\Carbon::parse($item->tahun_awal)->format('Y') : '?' }}
                            -
                            {{ $item->tahun_akhir ? \Carbon\Carbon::parse($item->tahun_akhir)->format('Y') : '?' }}
                        </td>
                        <td>{{ $item->alamat ?? '-' }}</td>
                        <td>
                            <a href="{{ route('struktur-kecamatan.edit', $item->id) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('struktur-kecamatan.destroy', $item->id) }}"
                                class="btn btn-danger btn-sm">Delete</a>
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
    document.getElementById('foto').addEventListener('change', function(event) {
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
    function filterByKecamatan() {
    const filterValue = document.getElementById('filterKecamatan').value.toLowerCase();
    const rows = document.querySelectorAll('table.table-bordered tbody tr');

    rows.forEach(row => {
        const kecamatan = row.getAttribute('data-kecamatan').toLowerCase();
        if (!filterValue || kecamatan.includes(filterValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

</script>
@endsection