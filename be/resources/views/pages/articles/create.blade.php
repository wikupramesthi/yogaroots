@extends('layouts.app')
@section('title', 'Tambah Publikasi')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Tambah Publikasi" page="Publikasi" active="Tambah Publikasi" route="{{ route('articles.index') }}" />
@endsection

<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="title" class="mb-2">Judul Konten <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="excerpt" class="mb-2">Ringkasan</label>
                    <input type="text" name="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
                        value="{{ old('excerpt') }}">
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="category_uuid" class="mb-2">Kategori <span class="text-danger">*</span></label>
                    <select name="category_uuid" id="category_uuid"
                        class="form-control @error('category_uuid') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->uuid }}"
                                data-name="{{ strtolower(str_replace(' ', '-', $category->name)) }}"
                                {{ old('category_uuid', $article->category_uuid ?? '') == $category->uuid ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_uuid')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3" id="videoForm" style="display: none;">
                    <label for="video" class="mb-2">Link YouTube <span class="text-danger">*contoh :
                            PlNOD--gPQU</span></label>
                    <input type="text" name="video" id="video" class="form-control"
                        value="{{ old('video', $article->video ?? '') }}" placeholder="Masukkan link YouTube">
                </div>


                <div class="form-group mb-3">
                    <label for="content" class="mb-2">Isi Konten <span class="text-danger">*</span></label>
                    <textarea name="content" id="deskripsi" cols="30" rows="5"
                        class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="featured_image" class="mb-2">Gambar Konten <span class="text-danger">*Maksimal ukuran
                            1 mb</span></label>
                    <input type="file" name="featured_image" id="featured_image" accept="image/*"
                        class="form-control @error('featured_image') is-invalid @enderror">
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tagging">Tagging <span class="text-danger"> *Pisahkan dengan koma, misal: berita, kota
                            bekasi, distaru</span></label>
                    <input type="text" name="tagging" class="form-control"
                        value="{{ old('tagging', $article->tagging ?? '') }}"
                        placeholder="Pisahkan dengan koma, misal: slb patriot, berita, kota bekasi">
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="published"
                            {{ old('status', $article->status ?? '') == 'published' ? 'selected' : '' }}>Published
                        </option>
                        <option value="draft"
                            {{ old('status', $article->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled"
                            {{ old('status', $article->status ?? '') == 'scheduled' ? 'selected' : '' }}>Scheduled
                        </option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="search_engine">Search Engine <span class="text-danger">*</span></label>
                    <select name="search_engine" class="form-control" required>
                        <option value="index"
                            {{ old('search_engine', $article->search_engine ?? '') == 'index' ? 'selected' : '' }}>
                            Index</option>
                        <option value="noindex"
                            {{ old('search_engine', $article->search_engine ?? '') == 'noindex' ? 'selected' : '' }}>No
                            Index</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="scheduled_at" class="mb-2">Tanggal Publish <span class="text-danger">*</span></label>
                    <input type="date" name="scheduled_at"
                        class="form-control @error('scheduled_at') is-invalid @enderror"
                        value="{{ old('scheduled_at') }}" required>
                    @error('scheduled_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-right mt-4">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button class="btn btn-danger">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_uuid');
        const videoForm = document.getElementById('videoForm');
        const videoInput = document.getElementById('video');

        function toggleVideoForm() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const categoryName = selectedOption.getAttribute('data-name')?.toLowerCase();

            if (categoryName && categoryName.includes('video-galeri')) {
                videoForm.style.display = 'block';
            } else {
                videoForm.style.display = 'none';
                videoInput.value = '';
            }
        }

        categorySelect.addEventListener('change', toggleVideoForm);
        toggleVideoForm(); // Jalankan saat halaman dimuat (mode edit)
    });
</script>

@endsection
