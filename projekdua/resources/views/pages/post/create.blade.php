@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Buat Post News')
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Buat Post News'])
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Buat Post News</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="media" class="form-label">Upload Foto/Video</label>
                            <input class="form-control" type="file" id="media" name="media[]" multiple accept="image/*,video/*" onchange="previewMedia(event)">
                            <div id="media-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen" class="form-label">Upload Dokumen (PDF, DOC, Excel)</label>
                            <input class="form-control" type="file" id="dokumen" name="dokumen[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.csv">
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Edukasi">Edukasi</option>
                                <option value="Penyuluhan">Penyuluhan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Draft">Draft</option>
                                <option value="Published">Published</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="7"></textarea>
                            <small class="text-muted">Catatan: Untuk embed YouTube, klik tombol <b>Insert media</b> (ikon play/film) di toolbar editor, lalu tempel link YouTube biasa (misal: https://www.youtube.com/watch?v=xxxx).</small>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Posting</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#deskripsi'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                'undo', 'redo', 'alignment', 'outdent', 'indent', 'imageUpload', 'mediaEmbed', 'insertTable', 'codeBlock'
            ],
            mediaEmbed: {
                previewsInData: true,
                providers: [
                    {
                        name: 'youtube',
                        // Support /watch?v=xxxx, youtu.be/xxxx, and /live/xxxx
                        url: /^(?:https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=([\w-]+)|live\/([\w-]+)).*|https?:\/\/(?:www\.)?youtu\.be\/([\w-]+).*)$/,
                        html: match => {
                            // match[1]: watch?v=xxxx, match[2]: live/xxxx, match[3]: youtu.be/xxxx
                            const id = match[1] || match[2] || match[3];
                            return (
                                '<div class="media-embed media-embed-youtube">' +
                                `<iframe width="560" height="315" src="https://www.youtube.com/embed/${id}" frameborder="0" allowfullscreen></iframe>` +
                                '</div>'
                            );
                        }
                    }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });

    function previewMedia(event) {
        const files = event.target.files;
        const preview = document.getElementById('media-preview');
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
</script>
@endsection
