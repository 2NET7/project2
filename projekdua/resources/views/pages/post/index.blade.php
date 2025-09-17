@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Daftar Post News')
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Daftar Post News'])
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Daftar Post News</h6>
                    <a href="{{ route('post.create') }}" class="btn btn-primary">+ Buat Post</a>
                </div>
                <div class="card-body">
                    @foreach($posts as $post)
                        <div class="mb-4 border-bottom pb-3">
                            <h5>{{ $post->judul }}</h5>
                            <span class="badge bg-info">{{ $post->kategori }}</span>
                            <span class="badge bg-secondary">{{ $post->status }}</span>
                            <span class="text-muted">{{ $post->tanggal }}</span>
                            <div class="mt-2 post-deskripsi">
                                {!! $post->deskripsi !!}
                            </div>
                            <div class="mt-2 d-flex flex-row flex-nowrap gap-2" style="overflow-x:auto; max-width:480px;">
                                @foreach($post->media as $media)
                                    @if($media->tipe == 'foto')
                                        <img src="{{ asset('storage/' . $media->file_path) }}" alt="foto" style="max-width:120px; max-height:120px; border-radius:8px; object-fit:cover;">
                                    @elseif($media->tipe == 'video')
                                        <video src="{{ asset('storage/' . $media->file_path) }}" controls style="max-width:180px; max-height:120px; border-radius:8px; object-fit:cover;"></video>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .post-deskripsi iframe {
        max-width: 100% !important;
        min-height: 280px;
        display: block;
        margin: 12px 0;
        border: none;
    }
    .post-deskripsi .media-embed {
        max-width: 100% !important;
    }
</style>
@endpush

@endsection
