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
            <form action="{{ route('waktu-monev.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
                            <tr>
                                <td><label for="tahun">Tahun :</label></td>
                                <td>
                                    <input type="number" name="tahun" id="tahun" class="form-control" required
                                        value="{{ old('tahun', $data->tahun) }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="bulan">Bulan :</label></td>
                                <td>
                                    <select name="bulan" id="bulan" class="form-control" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach(range(1, 12) as $bln)
                                        <option value="{{ $bln }}" {{ $bln==old('bulan', $data->bulan) ? 'selected' : ''
                                            }}>
                                            {{ DateTime::createFromFormat('!m', $bln)->format('F') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="id_kategori_laporan">Kategori Laporan :</label></td>
                                <td>
                                    <select name="id_kategori_laporan" id="id_kategori_laporan" class="form-control"
                                        required onchange="getKategori(this.value)">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == old('id_kategori_laporan',
                                            $data->id_kategori_laporan) ? 'selected' : '' }}>
                                            {{ $item->nama_kategori_laporan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="id_jenis_laporan">Jenis Laporan :</label></td>
                                <td>
                                    <select name="id_jenis_laporan" id="id_jenis_laporan" class="form-control" required>
                                        <option value="{{ $data->jenis->id ?? '' }}" selected>
                                            {{ $data->jenis->nama_jenis_laporan ?? '-- Pilih Jenis --' }}
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="tanggal_awal">Tanggal :</label></td>
                                <td>
                                    <div class="form-group">
                                        <label for="tanggal_awal">Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" id="tanggal_awal" required
                                            value="{{ old('tanggal_awal', $data->tanggal_awal) }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_akhir">Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" required
                                            value="{{ old('tanggal_akhir', $data->tanggal_akhir) }}"
                                            class="form-control">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 d-flex justify-content-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </div>
            </form>
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