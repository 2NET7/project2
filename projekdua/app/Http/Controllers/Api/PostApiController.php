<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index()
    {
        // Ambil semua post beserta media (foto, video, dokumen)
        $posts = Post::with('media')->latest()->get();
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::with('media')->findOrFail($id);
        return response()->json($post);
    }
}
