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
            <h1 class="m-0">Edit Struktur Inspektorat</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('struktur-inspektorat.update', $data->id) }}') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-borderless">
                    <tr>
                        <td>
                            <label for="nip">NIP :</label>
                        </td>
                        <td>
                            <input type="text" name="nip" id="nip" class="form-control" required value="{{ $data->nip }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nama_pegawai">Nama Pegawai :</label>
                        </td>
                        <td>
                            <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" required value="{{ $data->nama_pegawai }}">
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
                            <input type="telephone" name="telephone" id="telephone" class="form-control" required value="{{ $data->telephone }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="id_jabatan">Jabatan :</label>
                        </td>
                        <td>
                           <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                               <option value="">-- Pilih Jabatan --</option>
                               @foreach ($jenisJabatan as $jab)
                               <option value="{{ $jab->id }}" {{ $data->id_jabatan == $jab->id ? 'selected' : '' }}>{{ $jab->nama_jabatan }}</option>
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
                                <input type="date" name="tahun_awal" id="tahun_awal" required class="form-control" value="{{ $data->tahun_awal }}">
                            </div>
                            <div class="form-group">
                                <label for="tahun_akhir">Tahun Akhir</label>
                                <input type="date" name="tahun_akhir" id="tahun_akhir" required class="form-control" value="{{ $data->tahun_akhir }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="foto">Photo :</label>
                        </td>
                        <td>
                            <input type="file" name="foto" id="foto" class="form-control" >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" class="btn btn-primary">Simpan</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

@endsection