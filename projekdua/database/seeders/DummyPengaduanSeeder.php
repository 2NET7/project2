<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class DummyPengaduanSeeder extends Seeder
{
    public function run()
    {
        Pengaduan::create([
            'user_id' => 1,
            'nama_pelapor' => 'Budi Santoso',
            'tanggal' => '2025-09-12',
            'waktu' => '14:30',
            'jenis_pengaduan' => 'Banjir',
            'kecamatan' => 'Kecamatan A',
            'desa' => 'Desa B',
            'alamat' => 'Jl. Mawar No. 10',
            'media_uri' => json_encode(['/storage/bukti/dummyfoto.jpg']),
            'media_type' => json_encode(['image/jpeg']),
            'deskripsi' => 'Air meluap ke jalan dan rumah warga.',
            'status' => 'Menunggu',
            'feedback' => null,
            'bukti' => json_encode(['bukti/dummyfoto.jpg']),
            'korban_jiwa' => 0,
            'kerusakan_infrastruktur' => 1,
            'kerusakan_material' => 2,
            'verifikasi' => null,
            'tindak_lanjut_status' => null
        ]);
    }
}
