@section('title', 'Edit Pengaduan')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Pengaduan'])
    <div class="container-fluid py-4">
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit Pengaduan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Bagian Atas: Data Masyarakat & Bukti (readonly) -->
                            <div class="border rounded p-3 mb-4 bg-light">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal</label>
                                        <input type="date" class="form-control" value="{{ $pengaduan->tanggal }}" readonly disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nama Pelapor</label>
                                        <input type="text" class="form-control" value="{{ $pengaduan->nama_pelapor }}" readonly disabled>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Jenis Pengaduan</label>
                                        <input type="text" class="form-control" value="{{ $pengaduan->jenis_pengaduan }}" readonly disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Alamat</label>
                                        @if($pengaduan->alamat)
                                            <a href="https://www.google.com/maps/search/{{ urlencode($pengaduan->alamat) }}" target="_blank" class="form-control bg-transparent text-primary" style="border:none; padding-left:0;">{{ $pengaduan->alamat }}</a>
                                        @else
                                            <input type="text" class="form-control" value="-" readonly disabled>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Deskripsi</label>
                                    <textarea class="form-control" rows="3" readonly disabled>{{ $pengaduan->deskripsi }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Bukti (Foto/Video) dari Masyarakat</label>
                                    <div>
                                        @if($pengaduan->bukti)
                                            @foreach(json_decode($pengaduan->bukti, true) ?? [] as $bukti)
                                                @if(Str::endsWith(strtolower($bukti), ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti" class="img-fluid mb-2 me-2" style="max-height: 120px;">
                                                @elseif(Str::endsWith(strtolower($bukti), ['.mp4', '.mov', '.avi']))
                                                    <video controls class="img-fluid mb-2 me-2" style="max-height: 120px;">
                                                        <source src="{{ asset('storage/' . $bukti) }}">
                                                    </video>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-muted">Tidak ada bukti</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Tengah: Verifikasi Admin -->
                                <div class="border rounded p-3 mb-4">
                                    {{-- <label class="form-label fw-bold">Status</label>
                                    <select class="form-control mb-2" name="status">
                                        <option value="Menunggu" {{ old('status', $pengaduan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Proses" {{ old('status', $pengaduan->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ old('status', $pengaduan->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select> --}}
                                    <label class="form-label fw-bold">Verifikasi Laporan</label>
                                    <div class="mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verifikasi" id="verifikasi_terima" value="diterima" {{ old('verifikasi', $pengaduan->verifikasi ?? '') == 'diterima' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="verifikasi_terima">Diterima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verifikasi" id="verifikasi_tolak" value="ditolak" {{ old('verifikasi', $pengaduan->verifikasi ?? '') == 'ditolak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="verifikasi_tolak">Ditolak</label>
                                        </div>
                                    </div>
                                    <!-- Jika diterima, tampilkan tindak lanjut -->
                                    <div id="tindak-lanjut-section" style="display: none;">
                                        <label class="form-label fw-bold">Status Tindak Lanjut</label>
                                        <select class="form-control mb-2" name="tindak_lanjut_status">
                                            <option value="Menunggu" {{ old('tindak_lanjut_status', $pengaduan->tindak_lanjut_status ?? '') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Proses" {{ old('tindak_lanjut_status', $pengaduan->tindak_lanjut_status ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Selesai" {{ old('tindak_lanjut_status', $pengaduan->tindak_lanjut_status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                </div>

                            <!-- Bagian Bawah: Tindak Lanjut Admin -->
                            <div class="border rounded p-3 mb-4">
                                <label class="form-label fw-bold">Tindak Lanjut Admin</label>
                                <div class="mb-2">
                                    <label>Bukti Penanganan (Foto/Video)</label>
                                    <input type="file" class="form-control mb-2" name="bukti_penanganan[]" accept="image/*,video/*" multiple onchange="previewBuktiPenanganan(event)">
                                    <div id="preview-bukti-penanganan" class="d-flex flex-wrap gap-2"></div>
                                </div>
                                <div class="mb-2">
                                    <label>Keterangan Korban Jiwa</label>
                                    <input type="number" class="form-control" name="korban_jiwa" value="{{ old('korban_jiwa', $pengaduan->korban_jiwa) }}">
                                </div>
                                <div class="mb-2">
                                    <label>Kerusakan Infrastruktur</label>
                                    <input type="text" class="form-control" name="kerusakan_infrastruktur" value="{{ old('kerusakan_infrastruktur', $pengaduan->kerusakan_infrastruktur) }}">
                                </div>
                                <div class="mb-2">
                                    <label>Kerusakan Material</label>
                                    <input type="text" class="form-control" name="kerusakan_material" value="{{ old('kerusakan_material', $pengaduan->kerusakan_material) }}">
                                </div>
                                <button type="button" class="btn btn-success mt-2" onclick="terimaSemuaLaporan()">Terima Semua</button>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn bg-gradient-dark">Simpan Perubahan</button>
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn bg-gradient-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Tampilkan/hidden form tindak lanjut sesuai verifikasi
function updateTindakLanjutSection() {
    var diterima = document.getElementById('verifikasi_terima').checked;
    document.getElementById('tindak-lanjut-section').style.display = diterima ? '' : 'none';
}
document.getElementById('verifikasi_terima').addEventListener('change', updateTindakLanjutSection);
document.getElementById('verifikasi_tolak').addEventListener('change', updateTindakLanjutSection);
window.onload = updateTindakLanjutSection;

// Preview bukti penanganan
function previewBuktiPenanganan(event) {
    const files = event.target.files;
    const preview = document.getElementById('preview-bukti-penanganan');
    preview.innerHTML = '';
    Array.from(files).forEach(file => {
        const fileType = file.type;
        const url = URL.createObjectURL(file);
        let el;
        if (fileType.startsWith('image/')) {
            el = document.createElement('img');
            el.src = url;
            el.style.maxWidth = '120px';
            el.style.maxHeight = '120px';
            el.style.marginRight = '8px';
        } else if (fileType.startsWith('video/')) {
            el = document.createElement('video');
            el.src = url;
            el.controls = true;
            el.style.maxWidth = '180px';
            el.style.maxHeight = '120px';
            el.style.marginRight = '8px';
        }
        if (el) preview.appendChild(el);
    });
}
// Shortcut: Terima Semua
function terimaSemuaLaporan() {
    document.getElementById('verifikasi_terima').checked = true;
    updateTindakLanjutSection();
    document.querySelector('select[name="tindak_lanjut_status"]').value = 'Selesai';
}
</script>
@endpush
