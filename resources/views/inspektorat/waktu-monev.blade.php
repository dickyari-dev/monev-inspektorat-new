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
            <h1 class="m-0">Struktur Desa</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('inspektorat.struktur-inspektorat.store') }}" method="POST"
                enctype="multipart/form-data }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <label for="kecamatan">Kecamatan :</label>
                                </td>
                                <td>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="desa">Desa :</label>
                                </td>
                                <td>
                                    <input type="text" name="desa" id="desa" class="form-control" required>
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
                                    <label for="alamat_lengkap">Alamat Lengkap :</label>
                                </td>
                                <td>
                                    <textarea name="alamat_lengkap" id="alamat_lengkap" cols="30" rows="3"
                                        class="form-control"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telephone">Telephone :</label>
                                </td>
                                <td>
                                    <input type="telephone" name="telephone" id="telephone" class="form-control"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jabatan">Jabatan :</label>
                                </td>
                                <td>
                                    <input type="jabatan" name="jabatan" id="jabatan" class="form-control" required>
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
                            <label for="photo">Upload Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control mt-2" required
                                accept="image/*">
                        </div>
                        <div class="form-group">
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
            <h2>Struktur Desa</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>Nama Pegawai</th>
                    <th>NIP</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Jabatan</th>
                    <th>Tahun Menjabat</th>
                    <th>Alamat Lengkap</th>
                </tr>
                @foreach ($struktur as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_pegawai }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->tahun_awal }} - {{ $item->tahun_akhir }}</td>
                    <td>{{ $item->alamat_lengkap }}</td>
                </tr>
                @endforeach
            </table>
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
</script>
@endsection