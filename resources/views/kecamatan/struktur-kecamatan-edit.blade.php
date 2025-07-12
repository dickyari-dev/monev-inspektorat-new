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
            <h1 class="m-0">Struktur Kecamatan Edit</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('struktur-kecamatan.update', $item->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><label for="kecamatan">Kecamatan :</label></td>
                                <td>
                                    <select name="id_kecamatan" id="id_kecamatan" class="form-control" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatan as $kec)
                                        <option value="{{ $kec->id }}" {{ $item->id_kecamatan == $kec->id ? 'selected' :
                                            '' }}>
                                            {{ $kec->nama_kecamatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="nip">NIP :</label></td>
                                <td>
                                    <input type="text" name="nip" id="nip" class="form-control"
                                        value="{{ old('nip', $item->nip) }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="nama_pegawai">Nama Pegawai :</label></td>
                                <td>
                                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control"
                                        value="{{ old('nama_pegawai', $item->nama_pegawai) }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="alamat">Alamat Lengkap :</label></td>
                                <td>
                                    <textarea name="alamat" id="alamat" cols="30" rows="3"
                                        class="form-control">{{ old('alamat', $item->alamat) }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="telephone">Telephone :</label></td>
                                <td>
                                    <input type="text" name="telephone" id="telephone" class="form-control"
                                        value="{{ old('telephone', $item->telephone) }}">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="jabatan">Jabatan :</label></td>
                                <td>
                                    <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jenisJabatan as $jab)
                                        <option value="{{ $jab->id }}" {{ $item->id_jabatan == $jab->id ? 'selected' :
                                            '' }}>
                                            {{ $jab->nama_jabatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="tahun_awal">Tahun Menjabat :</label></td>
                                <td>
                                    <div class="form-group">
                                        <label for="tahun_awal">Tahun Awal</label>
                                        <input type="date" name="tahun_awal" id="tahun_awal" class="form-control"
                                            value="{{ old('tahun_awal', $item->tahun_awal ? \Carbon\Carbon::parse($item->tahun_awal)->format('Y-m-d') : '') }}"
                                            required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="tahun_akhir">Tahun Akhir</label>
                                        <input type="date" name="tahun_akhir" id="tahun_akhir" class="form-control"
                                            value="{{ old('tahun_akhir', $item->tahun_akhir ? \Carbon\Carbon::parse($item->tahun_akhir)->format('Y-m-d') : '') }}"
                                            required>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body"
                                style="text-align: center; min-height: 300px; width: 100%; background-color: #eee">
                                <img id="preview-image"
                                    src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/images/user.png') }}"
                                    alt="Preview Gambar" class="img-fluid" style="max-height: 280px;">
                            </div>
                        </div>

                        <div class="form-group mt-3 mb-3">
                            <label for="foto">Upload Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control mt-2" accept="image/*">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            @if (Auth::user()->role == 'kecamatan')
                            <a href="{{ route('kecamatan.struktur-kecamatan') }}" class="btn btn-default">Kembali</a>
                            @elseif (Auth::user()->role == 'inspektorat')
                            <a href="{{ route('inspektorat.struktur-kecamatan') }}" class="btn btn-default">Kembali</a>

                            @endif
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
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('foto');
        const img = document.getElementById('preview-image');
        const defaultImg = @json($item->foto ? asset('storage/' . $item->foto) : asset('assets/images/user.png'));

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                // fallback ke default image dari database
                img.src = defaultImg;
            }
        });
    });
</script>

@endsection