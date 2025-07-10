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
                <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- penting agar Laravel mengenali sebagai update --}}
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless">
                                <tr>
                                    <td><label for="kode_kecamatan">Kode Kecamatan :</label></td>
                                    <td>
                                        <input type="text" name="kode_kecamatan" id="kode_kecamatan"
                                            class="form-control" required value="{{ $kecamatan->kode_kecamatan }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nama_kecamatan">Nama Kecamatan :</label></td>
                                    <td>
                                        <input type="text" name="nama_kecamatan" id="nama_kecamatan"
                                            class="form-control" required value="{{ $kecamatan->nama_kecamatan }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="alamat_kecamatan">Alamat Kecamatan :</label></td>
                                    <td>
                                        <textarea name="alamat_kecamatan" id="alamat_kecamatan" cols="30" rows="3"
                                            class="form-control">{{ $kecamatan->alamat }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="kode_pos">Kode Pos :</label></td>
                                    <td>
                                        <input type="text" name="kode_pos" id="kode_pos" class="form-control" required
                                            value="{{ $kecamatan->kode_pos }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="telephone">Telephone :</label></td>
                                    <td>
                                        <input type="text" name="telephone" id="telephone" class="form-control" required
                                            value="{{ $kecamatan->telepon }}">
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection