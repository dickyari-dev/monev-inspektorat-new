@extends('layouts.app')

@section('content')
<div class="container-fluid page__heading-container mt-2">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Inspektorat</li>
                </ol>
            </nav>
            <h1 class="m-0">Data Monitoring Desa</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="kecamatan_id">Pilih Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-control">
                                <option value="{{ $kecamatanAuth->id }}" selected>{{ $kecamatanAuth->nama_kecamatan }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="kecamatan_id">Pilih tahun</label>
                            <input type="text" name="tahun" id="tahun" class="form-control" value="{{ date('Y') }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="kategori_id">Pilih Kategori Laporan</label>
                            <select name="kategori_id" id="kategori_id" class="form-control"
                                onchange="changeKategori()">
                                <option value="">Pilih Kategori Laporan</option>
                                @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori_laporan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenis_id">Pilih Jenis Laporan</label>
                            <select name="jenis_id" id="jenis_id" class="form-control" onchange="changeJenis()">
                                <option value="">Pilih Jenis Laporan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 d-none" id="desa-container">
                    <h5>Data Desa</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($desa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_desa }}</td>
                                <td>
                                    {{-- Form Radio --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{ $item->id }}"
                                            id="desaRadio{{ $item->id }}" name="desa_id" onchange="changeDesa()">
                                        <label class="form-check-label" for="desaRadio{{ $item->id }}">
                                            Pilih
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 d-none" id="pertanyaan-container">
                    <h5>Data Pertanyaan</h5>
                    <table class="table table-bordered" id="pertanyaan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Diisi oleh JS -->
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 d-none" id="dokumen-container">
                    <h5>Upload Dokumen</h5>
                    <table class="table table-bordered" id="dokumen-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dokumen</th>
                                <th>Dokumen Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Diisi oleh JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeKategori() {
    const kategoriId = document.getElementById('kategori_id').value;
    const jenisSelect = document.getElementById('jenis_id');

    jenisSelect.innerHTML = '<option value="">Pilih Jenis Laporan</option>';

    if (kategoriId) {
        fetch(`/api/jenis-by-kategori/${kategoriId}`)
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    result.data.forEach(jenis => {
                        const option = document.createElement('option');
                        option.value = jenis.id;
                        option.text = jenis.nama_jenis_laporan;
                        jenisSelect.appendChild(option);
                    });
                } else {
                    console.error('Respon tidak valid:', result);
                }
            })
            .catch(error => {
                console.error('Gagal memuat data jenis laporan:', error);
            });
    }
    }

function changeJenis() {
    const jenisId = document.getElementById('jenis_id').value;
    const desaId = document.getElementById('desa_id')?.value;
    const tbody = document.querySelector('#pertanyaan-table tbody');
    const desaContainer = document.getElementById('desa-container');
    const pertanyaanContainer = document.getElementById('pertanyaan-container');

    if (desaContainer) desaContainer.classList.remove('d-none');
    if (pertanyaanContainer) pertanyaanContainer.classList.remove('d-none');
    tbody.innerHTML = '';

    if (!jenisId || !desaId) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-center text-warning">Silakan pilih jenis dan desa</td></tr>';
        return;
    }
}

function kirimPertanyaan(checkbox) {
    const desaRadio = document.querySelector('input[name="desa_id"]:checked');
    if (!desaRadio) {
        alert('Silakan pilih desa terlebih dahulu.');
        checkbox.checked = false;
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token tidak ditemukan!');
        return;
    }

    const desaId = desaRadio.value;

    fetch('/kirim-pertanyaan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            pertanyaan_id: checkbox.value,
            desa_id: desaId,
            checked: checkbox.checked
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data);
    })
    .catch(error => {
        console.error('Gagal kirim:', error);
    });
}

function pilihPertanyaan(pertanyaanId) {
    const desaRadio = document.querySelector('input[name="desa_id"]:checked');
    if (!desaRadio) {
        alert('Silakan pilih desa terlebih dahulu.');
        return;
    }

    const desaId = desaRadio.value;

    fetch(`/api/dokumen-pertanyaan/${desaId}`)
        .then(response => response.json())
        .then(result => {
            console.log('Hasil Dokumen:', result.data);
            console.log('Jenis Dokumen Pertama:', result.data[0]?.jenis_dokumen ?? 'Tidak tersedia');
            console.log('Nama Desa:', result.desa?.nama ?? 'Desa tidak ditemukan');
            // tampilkanDokumen(result.data);
        })
        .catch(error => {
            console.error('Gagal mengambil dokumen pertanyaan:', error);
            alert('Gagal mengambil data dari server.');
        });
}

function changeDesa() {
    const desaRadio = document.querySelector('input[name="desa_id"]:checked');
    const desaId = desaRadio ? desaRadio.value : null;
    const jenisId = document.getElementById('jenis_id').value;


    fetch(`/api/pertanyaan-by-jenis/${jenisId}/${desaId}`)
        .then(response => response.json())
        .then(result => {
            tampilkanPertanyaan(result.data);
            tampilkanDokumen();
        })
        .catch(error => {
            console.error('Gagal mengambil dokumen pertanyaan:', error);
            alert('Gagal mengambil data dari server.');
    });
}

function tampilkanPertanyaan(data) {
    const tbody = document.querySelector('#pertanyaan-table tbody');
    const desaRadio = document.querySelector('input[name="desa_id"]:checked');
    const desaId = desaRadio ? desaRadio.value : null;

    tbody.innerHTML = ''; // Kosongkan isi tabel

    if (!data || !data.length) {
        tbody.innerHTML = `<tr><td colspan="3" class="text-center">Tidak ada pertanyaan ditemukan.</td></tr>`;
        return;
    }

    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>
                ${item.pertanyaan}
            </td>
            <td>
                <div class="form-check d-flex justify-content-center align-items-center">
                    <input class="form-check-input" type="checkbox"
                        value="${item.id}"
                        id="pertanyaanCheckbox${item.id}"
                        onchange="kirimPertanyaan(this, ${desaId})"
                        ${item.terjawab ? 'checked' : ''}>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}


function kirimPertanyaan(checkbox, desaId) {
    const pertanyaanId = checkbox.value;
    const isChecked = checkbox.checked;

    // Debug log (boleh hapus nanti)
    console.log('Mengirim ke server:', {
        pertanyaan_id: pertanyaanId,
        desa_id: desaId,
        checked: isChecked
    });

    fetch('/kirim-pertanyaan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            pertanyaan_id: pertanyaanId,
            desa_id: desaId,
            checked: isChecked
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal menyimpan jawaban');
        return response.json();
    })
    .then(data => {
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: data.message,
        timer: 2000,
        showConfirmButton: false
    });
    })
    .catch(error => {
        console.error('Terjadi kesalahan saat menyimpan jawaban:', error);
        alert('Gagal menyimpan jawaban ke server.');
    });
}

function tampilkanDokumen() {
    const desaRadio = document.querySelector('input[name="desa_id"]:checked');
    const desaId = desaRadio ? desaRadio.value : null;

    if (!desaId) {
        console.warn('Belum ada desa yang dipilih.');
        return;
    }

    fetch(`/api/ambil-jenis-dokumen-all/${desaId}`)
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil dokumen.');
            return response.json();
        })
        .then(result => {
            console.log('Dokumen untuk desa ID:', desaId);
            console.table(result.data);

            const tbody = document.querySelector('#dokumen-table tbody');
            const container = document.getElementById('dokumen-container');
            tbody.innerHTML = ''; // Kosongkan isi lama

            if (!result.data.length) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center">Tidak ada dokumen ditemukan.</td></tr>`;
                return;
            }

            result.data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
    <td>${index + 1}</td>
    <td>${item.nama_dokumen}</td>
    <td>${item.dokumen_rujukan ?? '-'}</td>
    <td class="text-center">
        ${item.dokumen 
            ? `<a href="/storage/${item.dokumen}" target="_blank" title="Lihat dokumen">
                    <i class="fas fa-file-alt text-success"></i>
               </a>` 
            : `<i class="fas fa-times text-danger" title="Belum ada dokumen"></i>`}
    </td>
    <td>
        <form onsubmit="uploadDokumen(event, ${item.id}, ${desaId})" enctype="multipart/form-data">
            <input type="file" name="dokumen" class="form-control form-control-sm mb-1" required>
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-upload"></i> Upload
            </button>
        </form>
    </td>
`;
                tbody.appendChild(row);
            });

            // Tampilkan container jika tersembunyi
            container.classList.remove('d-none');
        })
        .catch(error => {
            console.error('Gagal mengambil data dokumen:', error);
            alert('Gagal mengambil data dokumen.');
        });
}

function uploadDokumen(event, jenisDokumenId, desaId) {
    event.preventDefault();

    const form = event.target;
    const fileInput = form.querySelector('input[name="dokumen"]');
    const file = fileInput.files[0];

    if (!file) {
        alert('Pilih dokumen terlebih dahulu.');
        return;
    }

    const formData = new FormData();
    formData.append('dokumen', file);
    formData.append('jenis_dokumen_id', jenisDokumenId);
    formData.append('desa_id', desaId);

    fetch('/api/upload-dokumen-jawaban', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Dokumen berhasil diunggah',
            timer: 1500,
            showConfirmButton: false
        });
        tampilkanDokumen(); // refresh tabel
    })
    .catch(error => {
        console.error('Upload gagal:', error);
        Swal.fire('Gagal', 'Gagal mengupload dokumen', 'error');
    });
}







</script>
@endsection