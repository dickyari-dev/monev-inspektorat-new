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
            <h1 class="m-0">Struktur Inspektorat</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('inspektorat.struktur-inspektorat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table table-borderless">
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
                            <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" required>
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
                            <input type="telephone" name="telephone" id="telephone" class="form-control" required>
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
                               <option value="{{ $jab->id }}">{{ $jab->nama_jabatan }}</option>
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
                                <input type="date" name="tahun_awal" id="tahun_awal" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tahun_akhir">Tahun Akhir</label>
                                <input type="date" name="tahun_akhir" id="tahun_akhir" required class="form-control">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="foto">Photo :</label>
                        </td>
                        <td>
                            <input type="file" name="foto" id="foto" class="form-control" required>
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

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Struktur Inspektorat</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>Nama Pegawai</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Tahun Menjabat</th>
                    <th>Alamat Lengkap</th>
                    <th>Aksi</th>
                </tr>
                @foreach ($struktur as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                     <td>
                        <img src="{{ asset('storage/' . $item->foto) }}" alt=""
                            style="width: 100px; height: 100px; object-fit: cover">
                    </td>
                    <td>{{ $item->nama_pegawai }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->jabatan->nama_jabatan }}</td>
                   <td>
                        {{ $item->tahun_awal ? \Carbon\Carbon::parse($item->tahun_awal)->format('Y') : '?' }}
                        -
                        {{ $item->tahun_akhir ? \Carbon\Carbon::parse($item->tahun_akhir)->format('Y') : '?' }}
                    </td>
                    <td>{{ $item->alamat }}</td>
                     <td>
                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection