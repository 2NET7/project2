<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapPenangananController extends Controller
{
    public function index(Request $request)
    {
        $jenisBencanaList = Pengaduan::distinct()->pluck('jenis_pengaduan');
        $rekap = null;
        $details = collect();

        if ($request->filled(['jenis_bencana', 'start_date', 'end_date'])) {
            $details = Pengaduan::where('jenis_pengaduan', $request->jenis_bencana)
                ->whereBetween('tanggal', [$request->start_date, $request->end_date])
                ->get();

            $rekap = [
                'total_kejadian' => $details->count(),
                'total_korban_jiwa' => $details->sum('korban_jiwa'),
                'total_kerusakan_infrastruktur' => $details->sum('kerusakan_infrastruktur'),
                'total_kerugian_material' => $details->sum('kerusakan_material'),
            ];
        }

        return view('pages.pengaduan.rekap', compact('jenisBencanaList', 'rekap', 'details', 'request'));
    }
}
