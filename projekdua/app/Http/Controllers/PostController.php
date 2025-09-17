<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('media')->latest()->get();
        return view('pages.post.index', compact('posts'));
    }

    public function create()
    {
        return view('pages.post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Edukasi,Penyuluhan',
            'status' => 'required|in:Draft,Published',
            'deskripsi' => 'required',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv|max:20480',
        ]);


        // Tidak ada auto-embed, admin wajib tempel link embed YouTube
        $post = Post::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'tanggal' => now()->toDateString(),
            'deskripsi' => $request->deskripsi,
            'admin_id' => auth()->id(),
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $tipe = Str::startsWith($file->getMimeType(), 'video') ? 'video' : 'foto';
                $path = $file->store('uploads/posts', 'public');
                PostMedia::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'tipe' => $tipe,
                ]);
            }
        }
        // Upload dokumen
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $tipe = 'dokumen';
                $path = $file->store('uploads/posts', 'public');
                PostMedia::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'tipe' => $tipe,
                ]);
            }
        }

        return redirect()->route('post.index')->with('success', 'Post berhasil ditambahkan!');
    }
}
