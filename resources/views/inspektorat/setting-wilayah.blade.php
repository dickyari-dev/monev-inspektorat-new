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
            <h1 class="m-0">Setting Wilayah</h1>
        </div>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="col-lg">
        <div class="card">
            <div class="card-header card-header-large bg-white d-flex align-items-center">
            </div>
            <div class="card-header card-header-tabs-basic nav" role="tablist">
                {{-- <a href="#activity_all" data-toggle="tab" role="tab" aria-controls="activity_all"
                    aria-selected="true">All</a> --}}
                <a href="#data_kecamatan" class="active" data-toggle="tab" role="tab" aria-selected="false">Data
                    Kecamatan</a>
                <a href="#data_desa" data-toggle="tab" role="tab" aria-selected="false">Data Desa</a>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane active show fade" id="data_kecamatan">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('kecamatan.store') }}" method="POST"
                                    enctype="multipart/form-data }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>
                                                        <label for="kode_kecamatan">Kode Kecamatan :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="kode_kecamatan" id="kode_kecamatan"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="nama_kecamatan">Nama Kecamatan :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nama_kecamatan" id="nama_kecamatan"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="alamat_kecamatan">Alamat Kecamatan :</label>
                                                    </td>
                                                    <td>
                                                        <textarea name="alamat_kecamatan" id="alamat_kecamatan"
                                                            cols="30" rows="3" class="form-control"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="kode_pos">Kode Pos :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="kode_pos" id="kode_pos"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="telephone">Telephone :</label>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="telephone" id="telephone"
                                                            class="form-control" required>
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

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h2>Data Kecamatan</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Kecamatan</th>
                                            <th>Nama Kecamatan</th>
                                            <th>Kode Pos</th>
                                            <th>Kabupaten</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kecamatan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_kecamatan ? $item->kode_kecamatan : '-' }}</td>
                                            <td>{{ $item->nama_kecamatan ? $item->nama_kecamatan : '-' }}</td>
                                            <td>{{ $item->kode_pos ? $item->kode_pos : '-' }}</td>
                                            <td>{{ $item->nama_kabupaten ? $item->nama_kabupaten : '-' }}</td>
                                            <td>
                                                <a href="{{ route('kecamatan.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm">Update</a>
                                                <a href="{{ route('kecamatan.destroy', $item->id) }}"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="data_desa">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('desa.store') }}" method="POST" enctype="multipart/form-data }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>
                                                        <label for="kode_desa">Kecamatan :</label>
                                                    </td>
                                                    <td>
                                                        <select name="kecamatan" id="kecamatan" class="form-control">
                                                            <option value="">Pilih Kecamatan</option>
                                                            @foreach ($kecamatan as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="kode_desa">Kode Desa :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="kode_desa" id="kode_desa"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="nama_desa">Nama Desa :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nama_desa" id="nama_desa"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="alamat_desa">Alamat Desa :</label>
                                                    </td>
                                                    <td>
                                                        <textarea name="alamat_desa" id="alamat_desa" cols="30" rows="3"
                                                            class="form-control"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="telephone">Telephone :</label>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="telephone" id="telephone"
                                                            class="form-control" required>
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

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h2>Data Desa</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Desa</th>
                                            <th>Nama Desa</th>
                                            <th>Nama Kecamatan</th>
                                            <th>Kabupaten</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($desa as $desa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $desa->kode_desa ? $desa->kode_desa : '-' }}</td>
                                            <td>{{ $desa->nama_desa ? $desa->nama_desa : '-' }}</td>
                                            <td>{{ $desa->kecamatan->nama_kecamatan ? $desa->kecamatan->nama_kecamatan : '-' }}
                                            </td>
                                            <td>{{ $desa->kecamatan->nama_kabupaten ? $desa->kecamatan->nama_kabupaten : '-' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('desa.edit', $desa->id) }}"
                                                    class="btn btn-primary btn-sm">Update</a>
                                                <a href="{{ route('desa.destroy', $desa->id) }}"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection