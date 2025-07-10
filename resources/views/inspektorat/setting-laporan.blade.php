@extends('layouts.app')

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Setting Laporan</li>
                </ol>
            </nav>
            <h1 class="m-0">Setting Laporan</h1>
        </div>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="col-lg">
        <div class="card">
            <div class="card-header card-header-large bg-white d-flex align-items-center">
                <h4 class="card-header__title flex m-0">Recent Activity</h4>
            </div>
            <div class="card-header card-header-tabs-basic nav" role="tablist">
                {{-- <a href="#activity_all" data-toggle="tab" role="tab" aria-controls="activity_all"
                    aria-selected="true">All</a> --}}
                <a href="#kategori_laporan" class="active" data-toggle="tab" role="tab" aria-selected="false">Kategori
                    Laporan</a>
                <a href="#jenis_laporan" data-toggle="tab" role="tab" aria-selected="false">Jenis Laporan</a>
                <a href="#jenis_dokumen" data-toggle="tab" role="tab" aria-selected="false">Jenis Dokumen</a>
                <a href="#pertanyaan" data-toggle="tab" role="tab" aria-selected="false">Pertanyaan</a>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane active show fade" id="kategori_laporan">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('kategori-laporan.store') }}" method="POST"
                                    enctype="multipart/form-data }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>
                                                        <label for="kategori_laporan">Kategori Laporan :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nama_kategori_laporan"
                                                            id="kategori_laporan" class="form-control" required>
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
                                <h2>Kategori Laporan</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Laporan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategori as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_kategori_laporan }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a href="{{ route('kategori-laporan.destroy', $item->id) }}"
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
                <div class="tab-pane" id="jenis_laporan">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('jenis-laporan.store') }}" method="POST"
                                    enctype="multipart/form-data }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>
                                                        <label for="kategori_laporan">Kategori Laporan :</label>
                                                    </td>
                                                    <td>
                                                        <select name="kategori_id" id="jenis_laporan"
                                                            class="form-control" required>
                                                            <option value="">Pilih Kategori Laporan</option>
                                                            @foreach ($kategori as $kat)
                                                            <option value="{{ $kat->id }}">{{
                                                                $kat->nama_kategori_laporan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="nama_jenis_laporan">Jenis Laporan :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nama_jenis_laporan"
                                                            id="nama_jenis_laporan" class="form-control" required>
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
                                <h2>Jenis Laporan</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Laporan</th>
                                            <th>Jenis Laporan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jenis as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kategoriLaporan->nama_kategori_laporan }}</td>
                                            <td>{{ $item->jenis_laporan }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a href="{{ route('jenis-laporan.destroy', $item->id) }}"
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
                <div class="tab-pane" id="jenis_dokumen">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('jenis-dokumen.store') }}" method="POST"
                                    enctype="multipart/form-data }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>
                                                        <label for="nama_dokumen">Nama Dokumen :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nama_dokumen" id="nama_dokumen"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="dokumen_rujukan">Dokumen Rujukan :</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="dokumen_rujukan" id="dokumen_rujukan"
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
                                <h2>Daftar Jenis Dokumen</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                            <th>Dokumen Rujukan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jenisDokumen as $jenisDokumen)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jenisDokumen->nama_dokumen }}</td>
                                            <td>{{ $jenisDokumen->dokumen_rujukan }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a href="{{ route('jenis-dokumen.destroy', $item->id) }}"
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
                <div class="tab-pane" id="pertanyaan">
                    <span class="text-danger">Dalam Proses</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection