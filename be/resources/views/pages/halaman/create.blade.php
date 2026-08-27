@extends('layouts.app')
@section('title', 'Tambah Halaman')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Tambah Halaman" page="Halaman" active="Tambah Halaman" route="{{ route('pages.index') }}" />
@endsection

<section class="section">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="title" class="mb-2">Judul Halaman <span class="text-danger">*</span></label>
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
                    <label for="content" class="mb-2">Isi Halaman <span class="text-danger">*</span></label>
                    <textarea name="content" id="deskripsi" rows="5" class="form-control @error('content') is-invalid @enderror"
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="featured_image" class="mb-2">Gambar Halaman <span class="text-danger">*</span></label>
                    <input type="file" name="featured_image" id="featured_image"
                        class="form-control @error('featured_image') is-invalid @enderror" required>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="has_sidebar" class="mb-2">Tampilkan Sidebar <span
                            class="text-danger">*</span></label>
                    <select name="has_sidebar" class="form-control @error('has_sidebar') is-invalid @enderror" required>
                        <option value="0" {{ old('has_sidebar') == 0 ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ old('has_sidebar') == 1 ? 'selected' : '' }}>Ya</option>
                    </select>
                    @error('has_sidebar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="is_published" class="mb-2">Status Publish <span class="text-danger">*</span></label>
                    <select name="is_published" class="form-control @error('is_published') is-invalid @enderror"
                        required>
                        <option value="1" {{ old('is_published', 1) == 1 ? 'selected' : '' }}>Publish</option>
                        <option value="0" {{ old('is_published', 1) == 0 ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('is_published')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="published_at" class="mb-2">Tanggal Publish</label>
                    <input type="date" name="published_at"
                        class="form-control @error('published_at') is-invalid @enderror"
                        value="{{ old('published_at') }}">
                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-right mt-4">
                    <a href="{{ route('pages.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</section>

@endsection
