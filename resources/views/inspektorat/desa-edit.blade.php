@extends('layouts.app')

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Setting Wilayah</li>
                </ol>
            </nav>
            <h1 class="m-0">Edit Data Kecamatan</h1>
        </div>
    </div>
</div>




<div class="container-fluid page__container">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('desa.update', $desa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- penting agar Laravel tahu ini adalah method update --}}
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless">
                                <tr>
                                    <td><label for="kecamatan">Kecamatan :</label></td>
                                    <td>
                                        <select name="kecamatan_id" id="kecamatan" class="form-control" required>
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($kecamatan as $item)
                                            <option value="{{ $item->id }}" {{ $desa->kecamatan_id == $item->id ?
                                                'selected' : '' }}>
                                                {{ $item->nama_kecamatan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="kode_desa">Kode Desa :</label></td>
                                    <td>
                                        <input type="text" name="kode_desa" id="kode_desa" class="form-control" required
                                            value="{{ $desa->kode_desa }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nama_desa">Nama Desa :</label></td>
                                    <td>
                                        <input type="text" name="nama_desa" id="nama_desa" class="form-control" required
                                            value="{{ $desa->nama_desa }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="alamat_desa">Alamat Desa :</label></td>
                                    <td>
                                        <textarea name="alamat_desa" id="alamat_desa" cols="30" rows="3"
                                            class="form-control">{{ $desa->alamat }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="telephone">Telephone :</label></td>
                                    <td>
                                        <input type="text" name="telephone" id="telephone" class="form-control" required
                                            value="{{ $desa->telepon }}">
                                    </td>
                                </tr>
                                {{-- Email dan PAssword --}}
                                <tr>
                                    <td><label for="email">Email :</label></td>
                                    <td>
                                        <input type="email" name="email" id="email" class="form-control" required
                                            value="{{ $desa->user->email }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="password">Password :</label></td>
                                    <td>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection