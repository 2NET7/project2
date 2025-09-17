@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Rekap Penanganan')
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Rekap Penanganan'])
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Filter Rekap Penanganan</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('rekap-penanganan.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="jenis_bencana" class="form-label">Jenis Bencana <span class="text-danger">*</span></label>
                            <select class="form-control" id="jenis_bencana" name="jenis_bencana" required>
                                <option value="">Pilih Jenis Bencana</option>
                                @foreach($jenisBencanaList as $jenis)
                                    <option value="{{ $jenis }}" {{ request('jenis_bencana') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" required>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="submit" class="btn btn-primary">Tampilkan Rekap</button>
                        </div>
                    </form>
                </div>
            </div>
            @if($rekap)
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Ringkasan Total Dampak</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-2 bg-light">Total Kejadian<br><b>{{ $rekap['total_kejadian'] }}</b></div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-2 bg-light">Total Korban Jiwa<br><b>{{ $rekap['total_korban_jiwa'] }}</b></div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-2 bg-light">Total Kerusakan Infrastruktur<br><b>{{ $rekap['total_kerusakan_infrastruktur'] }}</b></div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-2 bg-light">Total Kerugian Material<br><b>Rp {{ number_format($rekap['total_kerugian_material'],0,',','.') }}</b></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Daftar Rincian Laporan</h6>
                    <a href="#" onclick="window.print()" class="btn btn-success">Print Rekap</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Pelapor</th>
                                <th>Lokasi Terdampak</th>
                                <th>Korban Jiwa</th>
                                <th>Kerusakan Infrastruktur</th>
                                <th>Kerugian Material</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $i => $row)
                            <tr>
                                <td class="text-center">{{ $i+1 }}</td>
                                <td class="text-center">{{ $row->tanggal ? $row->tanggal->format('d-m-Y') : '' }}</td>
                                <td>{{ $row->nama_pelapor }}</td>
                                <td>{{ $row->alamat }}</td>
                                <td class="text-center">{{ $row->korban_jiwa }}</td>
                                <td class="text-center">{{ $row->kerusakan_infrastruktur }}</td>
                                <td>Rp {{ number_format($row->kerusakan_material,0,',','.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
