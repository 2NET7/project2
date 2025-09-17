@section('title', 'Detail Pengaduan')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Detail Pengaduan'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Detail Pengaduan</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('pengaduan.print.detail', $pengaduan->id) }}" class="btn bg-gradient-info mb-0" target="_blank">
                                    Print
                                </a>
                                <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" class="btn bg-gradient-dark mb-0">
                                    Edit
                                </a>
                                <a href="{{ route('pengaduan.index') }}" class="btn bg-gradient-secondary mb-0">
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Data Laporan -->
                            <div class="col-md-6 mb-3">
                                <h5 class="mb-3">Data Laporan</h5>
                                <div class="border rounded p-3 mb-4 bg-light">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Tanggal</label>
                                            <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($pengaduan->tanggal)) }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Nama Pelapor</label>
                                            <input type="text" class="form-control" value="{{ $pengaduan->nama_pelapor }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Jenis Pengaduan</label>
                                            <input type="text" class="form-control" value="{{ $pengaduan->jenis_pengaduan }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Alamat</label>
                                            @if($pengaduan->alamat)
                                                <a href="https://www.google.com/maps/search/{{ urlencode($pengaduan->alamat) }}" target="_blank" class="form-control bg-transparent text-primary" style="border:none; padding-left:0;">{{ $pengaduan->alamat }}</a>
                                            @else
                                                <input type="text" class="form-control" value="-" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label fw-bold">Deskripsi</label>
                                        <textarea class="form-control" rows="3" readonly>{{ $pengaduan->deskripsi }}</textarea>
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
                                    <label class="form-label fw-bold">Verifikasi Laporan</label>
                                    <div class="mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verifikasi" id="verifikasi_terima" value="diterima" {{ $pengaduan->verifikasi == 'diterima' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="verifikasi_terima">Diterima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verifikasi" id="verifikasi_tolak" value="ditolak" {{ $pengaduan->verifikasi == 'ditolak' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="verifikasi_tolak">Ditolak</label>
                                        </div>
                                    </div>
                                    <!-- Jika diterima, tampilkan tindak lanjut -->
                                    @if($pengaduan->verifikasi == 'diterima')
                                    <div id="tindak-lanjut-section">
                                        <label class="form-label fw-bold">Status Tindak Lanjut</label>
                                        <select class="form-control mb-2" name="tindak_lanjut_status" disabled>
                                            <option value="Menunggu" {{ $pengaduan->tindak_lanjut_status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Proses" {{ $pengaduan->tindak_lanjut_status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Selesai" {{ $pengaduan->tindak_lanjut_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                    @endif
                                </div>
                                <!-- Bagian Bawah: Tindak Lanjut Admin -->
                                <div class="border rounded p-3 mb-4">
                                    <label class="form-label fw-bold">Tindak Lanjut Admin</label>
                                    <div class="mb-2">
                                        <label>Bukti Penanganan (Foto/Video)</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $buktiAdmin = json_decode($pengaduan->bukti, true) ?? [];
                                            @endphp
                                            @if(count($buktiAdmin) > 0)
                                                @foreach($buktiAdmin as $bukti)
                                                    @if(Str::endsWith(strtolower($bukti), ['.jpg', '.jpeg', '.png', '.gif']))
                                                        <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Admin" class="img-fluid mb-2 me-2" style="max-height: 120px;">
                                                    @elseif(Str::endsWith(strtolower($bukti), ['.mp4', '.mov', '.avi']))
                                                        <video controls class="img-fluid mb-2 me-2" style="max-height: 120px;">
                                                            <source src="{{ asset('storage/' . $bukti) }}">
                                                        </video>
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="text-muted">Tidak ada bukti penanganan</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label>Keterangan Korban Jiwa</label>
                                        <input type="number" class="form-control" value="{{ $pengaduan->korban_jiwa }}" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label>Kerusakan Infrastruktur</label>
                                        <input type="text" class="form-control" value="{{ $pengaduan->kerusakan_infrastruktur }}" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label>Kerusakan Material</label>
                                        <input type="text" class="form-control" value="{{ $pengaduan->kerusakan_material }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- Kolom Data Pelapor -->
                            <div class="col-md-6 mb-3">
                                <h5 class="mb-3">Data Pelapor</h5>
                                @if($pengaduan->user)
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th class="ps-0" style="width: 120px;">Nama</th>
                                            <td>: {{ $pengaduan->user->nama_user }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Email</th>
                                            <td>: {{ $pengaduan->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">No Telepon</th>
                                            <td>: {{ $pengaduan->user->no_telepon }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Username</th>
                                            <td>: {{ $pengaduan->user->username }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Role</th>
                                            <td>: {{ $pengaduan->user->role }}</td>
                                        </tr>
                                    </table>
                                @else
                                    <span class="text-danger">Data user tidak ditemukan.</span>
                                @endif
                            </div>
                        </div>
                        {{-- Section Feedback Admin dihilangkan sesuai permintaan --}}
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    <!-- Modal untuk Zoom Media dengan Carousel -->
    <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center p-0">
                    <div id="zoomModalCarouselWrapper"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .bukti-hover {
        transition: transform 0.3s;
        cursor: pointer;
    }
    .bukti-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        z-index: 2;
    }
    /* Panah carousel hitam untuk modal zoom */
    #zoomModal .carousel-control-prev-icon,
    #zoomModal .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='black' viewBox='0 0 8 8'%3E%3Cpath d='M4.854 1.146a.5.5 0 0 0-.708.708L6.293 4H1.5a.5.5 0 0 0 0 1h4.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3z'/%3E%3C/svg%3E");
        filter: none;
        box-shadow: 0 0 0 2px #fff, 0 0 6px 2px rgba(0,0,0,0.3);
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
    }
    #zoomModal .carousel-control-prev-icon.invert,
    #zoomModal .carousel-control-next-icon.invert {
        filter: invert(1);
        box-shadow: 0 0 0 2px #000, 0 0 6px 2px rgba(255,255,255,0.3);
    }
    #zoomModal .carousel-control-prev,
    #zoomModal .carousel-control-next {
        background: rgba(255,255,255,0.7);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: background 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    #zoomModal .carousel-control-prev.invert,
    #zoomModal .carousel-control-next.invert {
        background: rgba(0,0,0,0.7);
    }
    #zoomModal .carousel-control-prev:hover,
    #zoomModal .carousel-control-next:hover {
        background: rgba(0,0,0,0.15);
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.8/dist/medium-zoom.min.js"></script>
<script>
// Fungsi untuk menampilkan carousel di modal zoom
function showZoomCarousel(mediaArr, idx, isAdmin = false) {
    let carouselId = isAdmin ? 'zoomCarouselAdmin' : 'zoomCarouselUser';
    let carouselInner = '';
    let indicators = '';
    for(let i=0; i<mediaArr.length; i++) {
        let media = mediaArr[i];
        let ext = media.split('.').pop().toLowerCase();
        let active = (i === idx) ? 'active' : '';
        let src = media;
        if(isAdmin) {
            src = '/storage/' + media;
        }
        carouselInner += `<div class='carousel-item ${active}'>`;
        if(['jpg','jpeg','png','gif','webp'].includes(ext)) {
            carouselInner += `<img src='${src}' class='d-block w-100 zoomable-img' style='max-height:80vh;object-fit:contain;'>`;
        } else if(['mp4','webm','ogg'].includes(ext)) {
            carouselInner += `<video controls class='d-block w-100' style='max-height:80vh;'><source src='${src}' type='video/${ext}'></video>`;
        }
        carouselInner += `</div>`;
        indicators += `<button type='button' data-bs-target='#${carouselId}' data-bs-slide-to='${i}' class='${active}' aria-current='${active ? 'true' : 'false'}' aria-label='Slide ${i+1}'></button>`;
    }
    let controls = '';
    if(mediaArr.length > 1) {
        controls = `
            <button class='carousel-control-prev' type='button' data-bs-target='#${carouselId}' data-bs-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Previous</span>
            </button>
            <button class='carousel-control-next' type='button' data-bs-target='#${carouselId}' data-bs-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Next</span>
            </button>`;
    }
    let html = `
        <div id='${carouselId}' class='carousel slide' data-bs-ride='carousel' data-bs-interval='false'>
            <div class='carousel-indicators'>${indicators}</div>
            <div class='carousel-inner'>${carouselInner}</div>
            ${controls}
        </div>
    `;
    document.getElementById('zoomModalCarouselWrapper').innerHTML = html;
    var myModal = new bootstrap.Modal(document.getElementById('zoomModal'));
    myModal.show();
    // Set slide ke index yang diklik (Bootstrap 5)
    var carousel = document.getElementById(carouselId);
    var bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);
    bsCarousel.to(idx);
    // Aktifkan medium-zoom pada gambar di dalam modal
    setTimeout(function() {
        mediumZoom('.zoomable-img', {
            margin: 24,
            background: '#000'
        });
    }, 300);
}

// Tambahkan observer untuk invert panah jika background modal gelap
function setCarouselArrowColor() {
    var modal = document.getElementById('zoomModal');
    if (!modal) return;
    var bg = window.getComputedStyle(modal.querySelector('.modal-content')).backgroundColor;
    // Cek jika background gelap (pakai luminance)
    function isDark(rgb) {
        if (!rgb) return false;
        var c = rgb.match(/\d+/g);
        if (!c) return false;
        var luminance = (0.299 * c[0] + 0.587 * c[1] + 0.114 * c[2]);
        return luminance < 128;
    }
    var invert = isDark(bg);
    var prev = modal.querySelector('.carousel-control-prev-icon');
    var next = modal.querySelector('.carousel-control-next-icon');
    if (prev && next) {
        if (invert) {
            prev.classList.add('invert');
            next.classList.add('invert');
        } else {
            prev.classList.remove('invert');
            next.classList.remove('invert');
        }
    }
}
// Panggil fungsi ini setiap kali modal carousel muncul
const origShowZoomCarousel = showZoomCarousel;
showZoomCarousel = function() {
    origShowZoomCarousel.apply(this, arguments);
    setTimeout(setCarouselArrowColor, 400);
}
</script>
@endpush
