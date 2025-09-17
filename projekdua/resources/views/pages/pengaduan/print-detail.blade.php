@extends('layouts.app-print')

@section('title', 'Print Detail Pengaduan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="mb-0">Detail Laporan Pengaduan</h5>
                        <p class="text-sm mb-0">Badan Penanggulangan Bencana Daerah (BPBD)</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px;">Tanggal</th>
                                            <td>: {{ $pengaduan->tanggal->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                                                <tr>
                                                                    <th style="width: 150px;">Nama Pelapor</th>
                                                                    <td>: {{ $pengaduan->nama_pelapor }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal</th>
                                                                    <td>: {{ $pengaduan->tanggal instanceof \Carbon\Carbon ? $pengaduan->tanggal->format('d F Y') : date('d F Y', strtotime($pengaduan->tanggal)) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Jenis Pengaduan</th>
                                                                    <td>: {{ $pengaduan->jenis_pengaduan }}</td>
                                                                </tr>
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px;">Kecamatan</th>
                                            <td>: {{ $pengaduan->kecamatan }}</td>
                                        </tr>
                                        <tr>
                                                                <tr>
                                                                    <th>Deskripsi</th>
                                                                    <td>: {{ $pengaduan->deskripsi }}</td>
                                                                </tr>
                        <hr>

                        <h6>Deskripsi Laporan</h6>
                        <p>{{ $pengaduan->deskripsi }}</p>

                        @if($pengaduan->feedback)
                            <h6>Feedback dari Petugas</h6>
                            <p>{{ $pengaduan->feedback }}</p>
                        @endif

                        <h6>Bukti Laporan</h6>
                        <div class="row">
                            @php
                                $mediaUris = json_decode($pengaduan->media_uri, true) ?? [];
                                $mediaTypes = json_decode($pengaduan->media_type, true) ?? [];
                            @endphp
                            @forelse($mediaUris as $index => $uri)
                                <div class="col-md-4 mb-3">
                                    @if(Str::contains($mediaTypes[$index], 'image'))
                                        <img src="{{ url($uri) }}" class="img-fluid rounded" alt="Bukti Laporan">
                                    @elseif(Str::contains($mediaTypes[$index], 'video'))
                                        <video controls class="img-fluid rounded">
                                            <source src="{{ url($uri) }}" type="{{ $mediaTypes[$index] }}">
                                            Browser Anda tidak mendukung tag video.
                                        </video>
                                    @endif
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>Tidak ada bukti media.</p>
                                </div>
                                                <hr>
                                                <h6>Data Penanganan & Verifikasi (Admin)</h6>
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th style="width:200px;">Status Verifikasi</th>
                                                        <td>: {{ $pengaduan->verifikasi ? ucfirst($pengaduan->verifikasi) : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Tindak Lanjut</th>
                                                        <td>: {{ $pengaduan->tindak_lanjut_status ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Keterangan Korban Jiwa</th>
                                                        <td>: {{ $pengaduan->korban_jiwa ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kerusakan Infrastruktur</th>
                                                        <td>: {{ $pengaduan->kerusakan_infrastruktur ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kerusakan Material</th>
                                                        <td>: {{ $pengaduan->kerusakan_material ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                                <h6>Bukti Penanganan</h6>
                                                <div class="row">
                                                    @php
                                                        $buktiPenanganan = json_decode($pengaduan->bukti, true) ?? [];
                                                    @endphp
                                                    @forelse($buktiPenanganan as $bukti)
                                                        <div class="col-md-4 mb-3">
                                                            <img src="{{ asset('storage/' . $bukti) }}" class="img-fluid rounded" alt="Bukti Penanganan">
                                                        </div>
                                                    @empty
                                                        <div class="col-12">
                                                            <p>Belum ada bukti penanganan.</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                            @endforelse
                        </div>

                        @if($pengaduan->bukti)
                            <h6>Bukti Penanganan</h6>
                            <div class="row">
                                @php
                                    $buktiPenanganan = json_decode($pengaduan->bukti, true) ?? [];
                                @endphp
                                @forelse($buktiPenanganan as $bukti)
                                    <div class="col-md-4 mb-3">
                                        <img src="{{ asset('storage/' . $bukti) }}" class="img-fluid rounded" alt="Bukti Penanganan">
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p>Belum ada bukti penanganan.</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
