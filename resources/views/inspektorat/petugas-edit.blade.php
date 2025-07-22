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
            <h1 class="m-0">Data Petugas</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('data-petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <label for="nama_pegawai">Nama Pegawai :</label>
                                </td>
                                <td>
                                    <select name="id_pegawai" id="id_pegawai" class="form-control" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach ($inspektorat as $p)
                                        <option value="{{ $p->id }}" {{ $petugas->struktur_inspektorat_id == $p->id ? 'selected' : ''
                                            }}>
                                            {{ $p->nama_pegawai }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nip">NIP :</label>
                                </td>
                                <td>
                                    <input type="text" name="nip" id="nip" class="form-control"
                                        value="{{ old('nip', $petugas->nip) }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="status">Status</label>
                                </td>
                                <td>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="kepala" {{ $petugas->status == 'kepala' ? 'selected' : ''
                                            }}>Kepala</option>
                                        <option value="petugas" {{ $petugas->status == 'petugas' ? 'selected' : ''
                                            }}>Petugas</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="email">Email :</label>
                                </td>
                                <td>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $petugas->user->email }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">Password :</label>
                                </td>
                                <td>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Kosongkan jika tidak ingin mengubah">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body"
                                style="text-align: center; min-height: 300px; width: 100%; background-color: #eee">
                                <img id="preview-image"
                                    src="{{ $petugas->photo ? asset('storage/' . $petugas->photo) : asset('assets/images/user.png') }}"
                                    alt="Preview Gambar" class="img-fluid" style="max-height: 280px;">
                            </div>
                        </div>
                        <div class="form-group mt-3 mb-3">
                            <label for="photo">Upload Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control mt-2" accept="image/*">
                        </div>
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
</script>
@endsection