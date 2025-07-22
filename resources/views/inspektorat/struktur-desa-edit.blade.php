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
            <h1 class="m-0">Update Struktur Desa</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('struktur-desa.update', $data->id) }}') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><label for="kecamatan">Kecamatan :</label></td>
                                <td>
                                    <select name="id_kecamatan" id="id_kecamatan" class="form-control" required
                                        onchange="getDesa(this.value)">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatan as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><label for="desa">Desa :</label></td>
                                <td>
                                    <select name="id_desa" id="desa_id" class="form-control" required>
                                        <option value="">-- Pilih Desa --</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="nip">NIP :</label>
                                </td>
                                <td>
                                    <input type="text" name="nip" id="nip" class="form-control" required
                                        value="{{ $data->nip }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_pegawai">Nama Pegawai :</label>
                                </td>
                                <td>
                                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control"
                                        required value="{{ $data->nama_pegawai }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="alamat">Alamat Lengkap :</label>
                                </td>
                                <td>
                                    <textarea name="alamat" id="alamat" cols="30" rows="3"
                                        class="form-control">{{ $data->alamat }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telephone">Telephone :</label>
                                </td>
                                <td>
                                    <input type="telephone" name="telephone" id="telephone" class="form-control"
                                        required value="{{ $data->telephone }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jabatan">Jabatan :</label>
                                </td>
                                <td>
                                    <select name="id_jabatan" id="id_jabatan" required class="form-control">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jenisJabatan as $jab)
                                        <option value="{{ $jab->id }}" {{ $data->id_jabatan == $jab->id ? 'selected' :
                                            '' }}>{{ $jab->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jabatan">Tahun Menjabat :</label>
                                </td>
                                <td>
                                    <div class="form-group mb-3">
                                        <label for="tahun_awal" class="form-label">Tahun Awal</label>
                                        <input type="date" name="tahun_awal" id="tahun_awal" class="form-control"
                                            value="{{ $data->tahun_awal }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                                        <input type="date" name="tahun_akhir" id="tahun_akhir" class="form-control"
                                            value="{{ $data->tahun_akhir }}" required>
                                    </div>
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body"
                                style="text-align: center; min-height: 300px; width: 100%; background-color: #eee">
                                <img id="preview-image" src="{{ asset('assets/images/' . $data->foto) }}"
                                    alt="Preview Gambar" class="img-fluid" style="max-height: 280px;">

                            </div>
                        </div>
                        <div class="form-group mt-3 mb-3">
                            <label for="photo">Upload Photo</label>
                            <input type="file" name="foto" id="foto" class="form-control mt-2" required
                                accept="image/*">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Simpan</button>
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

    function getDesa(kecamatanId) {
        const desaSelect = document.getElementById('desa_id');

        desaSelect.innerHTML = '<option value="">Loading...</option>';

        if (kecamatanId) {
            fetch(`/api/desa-by-kecamatan/${kecamatanId}`)
                .then(response => response.json())
                .then(response => {
                    const desaList = response.data; // karena formatnya { status, data: [...] }
                    desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    desaList.forEach(desa => {
                        desaSelect.innerHTML += `<option value="${desa.id}">${desa.nama_desa}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Gagal ambil data desa:', error);
                    desaSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
        }
    }
</script>
@endsection