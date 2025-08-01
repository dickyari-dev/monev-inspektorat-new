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
                            <select name="kecamatan_id" id="kecamatan_id" class="form-control"
                                onchange="changeKecamatan()">
                                <option value="">Pilih kecamatan</option>
                                @foreach ($kecamatan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                @endforeach
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
                            <!-- Diisi oleh JS -->
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
                                <th>File Upload</th>
                                <th>Status</th>
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
    function changeKecamatan() {
    const kecamatanId = document.getElementById('kecamatan_id').value;
    const tbody = document.querySelector('table tbody');

    if (!kecamatanId) {
        tbody.innerHTML = `<tr><td colspan="3" class="text-center">Pilih kecamatan terlebih dahulu.</td></tr>`;
        return;
    }

    // Fetch desa berdasarkan kecamatan
    fetch(`/api/desa-by-kecamatan/${kecamatanId}`)
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data desa.');
            return response.json();
        })
        .then(result => {
            const desaList = result.data;
            if (!desaList.length) {
                tbody.innerHTML = `<tr><td colspan="3" class="text-center">Tidak ada desa di kecamatan ini.</td></tr>`;
                return;
            }

            tbody.innerHTML = ''; // Kosongkan isi tabel
            desaList.forEach((desa, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${desa.nama_desa}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                value="${desa.id}" id="desaRadio${desa.id}"
                                name="desa_id" onchange="changeDesa()">
                            <label class="form-check-label" for="desaRadio${desa.id}">
                                Pilih
                            </label>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Gagal mengambil data desa:', error);
            tbody.innerHTML = `<tr><td colspan="3" class="text-danger text-center">Terjadi kesalahan saat memuat desa.</td></tr>`;
        });
}


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
                        ${item.terjawab ? 'checked' : ''} readonly>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}


function kirimPertanyaan(checkbox, desaId) {
    const pertanyaanId = checkbox.value;
    const isChecked = checkbox.checked;

    // Asumsikan kamu punya cara mengetahui role user
    const userRole = document.querySelector('meta[name="user-role"]')?.content || 'tamu';

    if (userRole !== 'kecamatan') {
        // Tampilkan alert jika bukan role kecamatan
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: 'Hanya Kecamatan yang bisa mengubah Data',
            timer: 2500,
            showConfirmButton: false
        });
        checkbox.checked = !isChecked; // Balik lagi checkbox ke sebelumnya
        return;
    }

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
<td class="text-center">
    ${
        !item.status 
            ? `<span class="text-muted">-</span>` 
            : item.status === 'terima' 
                ? `<span class="badge bg-success text-white">Di-approve oleh Inspektorat</span>` 
                : item.status === 'revisi' 
                    ? `<span class="badge bg-warning text-white">Perlu Revisi</span>` 
                    : item.status === 'pending' 
                        ? `<span class="badge bg-secondary text-white">Menunggu Verifikasi Inspektorat</span>` 
                        : `<span class="badge bg-dark text-white">Status Tidak Dikenal</span>`
    }

    ${
        item.keterangan_pengirim 
            ? `<div class="small text-muted mt-1 fst-italic">"${item.keterangan_pengirim}"</div>` 
            : ''
    }
</td>

                <td>
    ${
        item.dokumen 
        ? `
        <form onsubmit="uploadDokumen(event, ${item.id}, ${desaId})">
            <div class="mb-3">
                <select name="status" class="form-control form-select-sm" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="revisi">Perlu Revisi</option>
                    <option value="terima">Di-approve oleh Inspektorat</option>
                </select>
            </div>
            <div class="mb-3">
                <input 
                    type="text" 
                    name="keterangan" 
                    class="form-control" 
                    placeholder="Keterangan (opsional)"
                >
            </div>
            <button type="submit" class="btn btn-sm btn-primary w-100">
                <i class="fas fa-paper-plane me-1"></i> Submit
            </button>
        </form>
        `
        : `<span class="text-danger"><i class="fas fa-times me-1"></i> Belum ada dokumen</span>`
    }
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
    const status = form.querySelector('select[name="status"]').value;
    const keterangan = form.querySelector('input[name="keterangan"]').value;

    if (!status) {
        alert('Silakan pilih status terlebih dahulu.');
        return;
    }

    const data = {
        jenis_dokumen_id: jenisDokumenId,
        desa_id: desaId,
        status: status,
        keterangan: keterangan || null
    };

    fetch('/api/upload-dokumen-jawaban-inspektorat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Status berhasil dikirim',
            timer: 1500,
            showConfirmButton: false
        });
        tampilkanDokumen(); // Refresh tabel atau data
    })
    .catch(error => {
        console.error('Gagal mengirim:', error);
        Swal.fire('Gagal', 'Terjadi kesalahan saat mengirim data', 'error');
    });
}


</script>
@endsection