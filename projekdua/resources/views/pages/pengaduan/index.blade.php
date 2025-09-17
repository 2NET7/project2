@section('title', 'Data Pengaduan')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Data Pengaduan'])
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

        @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @endpush
        <!-- Notifikasi Suara -->
        <audio id="notifSound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>
        <script>
        // Unlock audio agar bisa autoplay setelah interaksi user pertama
        document.addEventListener('click', function enableAudioOnce() {
            var audio = document.getElementById('notifSound');
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
                document.removeEventListener('click', enableAudioOnce);
            }).catch(()=>{});
        });
        let lastPengaduanId = {{ $pengaduans->first() ? $pengaduans->first()->id : 0 }};
        let isAlertShown = false;
        // Hanya polling notifikasi jika tidak ada filter aktif (tidak ada query string)
        if (window.location.search === '' || window.location.search === '?') {
            setInterval(function() {
                if (isAlertShown) return;
                fetch("{{ url('/api/pengaduan/latest') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.id && data.id > lastPengaduanId) {
                            isAlertShown = true;
                            document.getElementById('notifSound').play().then(() => {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Laporan Baru!',
                                    text: 'Ada laporan baru masuk.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            }).catch(() => {
                                // Jika gagal play, tetap tampilkan alert
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Laporan Baru!',
                                    text: 'Ada laporan baru masuk.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            });
                        }
                    });
            }, 5000);
        }
        </script>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Daftar Pengaduan</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Form Filter -->
                        <form action="{{ route('pengaduan.index') }}" method="GET" class="mb-4" id="filterForm">
        @push('js')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterForm = document.getElementById('filterForm');
            if (filterForm) {
                filterForm.addEventListener('keydown', function(e) {
                });
            }
        });
        </script>
        @endpush
                            <div class="row g-2 align-items-end">
                                <div class="col-lg-2 col-md-4 col-6">
                                    <label for="start_date" class="form-label mb-1">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-6">
                                    <label for="end_date" class="form-label mb-1">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-12">
                                    <label for="nama_pelapor" class="form-label mb-1">Nama Pelapor</label>
                                    <input type="text" name="nama_pelapor" id="nama_pelapor" class="form-control" value="{{ request('nama_pelapor') }}" placeholder="Cari nama pelapor...">
                                </div>
                                <div class="col-lg-2 col-md-4 col-6">
                                    <label for="jenis_pengaduan" class="form-label mb-1">Jenis Pengaduan</label>
                                    <select name="jenis_pengaduan" id="jenis_pengaduan" class="form-select">
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisPengaduan as $jenis)
                                            <option value="{{ $jenis }}" {{ request('jenis_pengaduan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-6">
                                    <label for="status" class="form-label mb-1">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-12 d-flex justify-content-lg-end justify-content-md-end justify-content-start mt-2 mt-lg-0">
                                    <button type="submit" class="btn btn-primary w-100 btn-filter-custom d-flex align-items-center justify-content-center" style="gap: 0.5rem;">
                                        <i class="fas fa-filter"></i> <span>Filter</span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Tombol Print -->
                        <div class="mb-3">
                            <a href="{{ route('pengaduan.print', request()->query()) }}" class="btn btn-success" target="_blank">
                                <i class="fas fa-print me-1"></i> Print Rekap
                            </a>
                        </div>

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">Nama Pelapor</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jenis Pengaduan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Korban Jiwa</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kerusakan Infrastruktur</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kerusakan Material</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduans as $pengaduan)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-center align-middle">{{ date('d/m/Y', strtotime($pengaduan->tanggal)) }}</td>
                                        <td class="text-start align-middle">{{ $pengaduan->nama_pelapor }}</td>
                                        <td class="text-start align-middle">{{ $pengaduan->jenis_pengaduan }}</td>
                                        <td class="text-center align-middle">{{ $pengaduan->korban_jiwa ?? '-' }}</td>
                                        <td class="text-center align-middle">{{ $pengaduan->kerusakan_infrastruktur ?? '-' }}</td>
                                        <td class="text-center align-middle">{{ $pengaduan->kerusakan_material ?? '-' }}</td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-{{ $pengaduan->status == 'Selesai' ? 'success' : ($pengaduan->status == 'Proses' ? 'warning' : 'danger') }}">
                                                {{ $pengaduan->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn btn-link text-dark px-3 mb-0">
                                                    <i class="fas fa-eye text-dark me-2"></i>Detail
                                                </a>
                                                <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" class="btn btn-link text-dark px-3 mb-0">
                                                    <i class="fas fa-pencil-alt text-dark me-2"></i>Edit
                                                </a>
                                            </div>
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
        @include('layouts.footers.auth.footer')
    </div>
@endsection

<style>
.btn-filter-custom {
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
    border-radius: 10px;
}
</style>
