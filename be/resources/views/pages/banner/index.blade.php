@extends('layouts.app')
@section('title', 'Media Library')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Media Library" page="Media Library" active="All Media" route="{{ route('banner.index') }}" />
@endsection

@php
    $perPage = 6;
    $fotoRemain = ($counts['foto'] ?? $fotos->count()) - $perPage;
    $videoRemain = ($counts['video'] ?? $videos->count()) - $perPage;
    $albumRemain = ($counts['album'] ?? $albums->count()) - $perPage;
@endphp

<section class="section">
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-xl-3">
            <div class="card shadow-sm"><div class="card-body py-2 px-3"><div class="ml-stat">
                <div class="ml-stat-icon ic-primary"><i class="bx bx-image-alt"></i></div>
                <div><div class="ml-stat-value">{{ number_format($counts['foto'] ?? $fotos->count()) }}</div><div class="ml-stat-label">Total Photos</div></div>
            </div></div></div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card shadow-sm"><div class="card-body py-2 px-3"><div class="ml-stat">
                <div class="ml-stat-icon ic-danger"><i class="bx bx-video-recording"></i></div>
                <div><div class="ml-stat-value">{{ number_format($counts['video'] ?? $videos->count()) }}</div><div class="ml-stat-label">Total Videos</div></div>
            </div></div></div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card shadow-sm"><div class="card-body py-2 px-3"><div class="ml-stat">
                <div class="ml-stat-icon ic-violet"><i class="bx bx-collection"></i></div>
                <div><div class="ml-stat-value">{{ number_format($counts['album'] ?? $albums->count()) }}</div><div class="ml-stat-label">Total Albums</div></div>
            </div></div></div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card shadow-sm"><div class="card-body py-2 px-3"><div class="ml-stat">
                <div class="ml-stat-icon ic-success"><i class="bx bx-check-shield"></i></div>
                <div><div class="ml-stat-value">{{ number_format($counts['foto_active'] ?? $fotos->where('status','active')->count()) }}</div><div class="ml-stat-label">Active Photos</div></div>
            </div></div></div>
        </div>
    </div>

    <div class="card ml-toolbar mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <ul class="nav nav-pills media-tabs" id="mediaTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-all-link" data-bs-toggle="pill" href="#tab-all" role="tab">
                            <i class="bi bi-grid"></i> All
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-foto-link" data-bs-toggle="pill" href="#tab-foto" role="tab">
                            <i class="bx bx-image-alt"></i> Photos
                            <span class="count-pill">{{ $fotos->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-video-link" data-bs-toggle="pill" href="#tab-video" role="tab">
                            <i class="bx bx-video"></i> Videos
                            <span class="count-pill">{{ $videos->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-album-link" data-bs-toggle="pill" href="#tab-album" role="tab">
                            <i class="bx bx-photo-album"></i> Albums
                            <span class="count-pill">{{ $albums->count() }}</span>
                        </a>
                    </li>
                </ul>

                <div class="media-search">
                    <input type="text" id="mediaSearch" class="form-control" placeholder="Search media..." autocomplete="off">
                </div>
                @can('banner.store')
                <div class="d-flex flex-wrap gap-2 ms-add-btns">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-add-album">
                        <i class="bi bi-folder-plus"></i> Album
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-add-video">
                        <i class="bi bi-camera-video"></i> Video
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-foto">
                        <i class="bi bi-plus-lg"></i> Photo
                    </button>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="tab-content" id="mediaTabsContent">
        {{-- ==================== ALL ==================== --}}
        <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
            <div class="media-section-title">
                <span class="ms-label"><i class="bx bx-image-alt text-primary"></i> Photos</span>
                <span class="ms-bar"></span>
                @if ($fotoRemain > 0)<span class="badge bg-primary ms-count-hint">{{ $fotoRemain }} more</span>@endif
            </div>
            <div class="media-grid" id="grid-foto-all">
                @forelse ($fotos->take($perPage) as $item)
                @include('pages.banner.partials.card-foto')
                @empty
                <div class="media-empty">
                    <i class="bi bi-inbox"></i>
                    <h6>No photos yet</h6>
                    <p class="mb-0">Click the <strong>Photo</strong> button to upload your first photo.</p>
                </div>
                @endforelse
            </div>
            @if ($fotoRemain > 0)
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light btn-load-more" data-type="foto" data-offset="{{ $perPage }}" data-target="#grid-foto-all">
                    <i class="bx bx-plus-circle"></i> <span class="lbl">Load More Photos</span>
                    <span class="badge bg-primary ms-1 count">{{ $fotoRemain }}</span>
                </button>
            </div>
            @endif

            <div class="media-section-title">
                <span class="ms-label"><i class="bx bx-video text-danger"></i> Videos</span>
                <span class="ms-bar"></span>
                @if ($videoRemain > 0)<span class="badge bg-primary ms-count-hint">{{ $videoRemain }} more</span>@endif
            </div>
            <div class="media-grid" id="grid-video-all">
                @forelse ($videos->take($perPage) as $item)
                @include('pages.banner.partials.card-video')
                @empty
                <div class="media-empty">
                    <i class="bx bx-video-recording"></i>
                    <h6>No videos yet</h6>
                    <p class="mb-0">Click the <strong>Video</strong> button to add videos from YouTube / Vimeo links.</p>
                </div>
                @endforelse
            </div>
            @if ($videoRemain > 0)
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light btn-load-more" data-type="video" data-offset="{{ $perPage }}" data-target="#grid-video-all">
                    <i class="bx bx-plus-circle"></i> <span class="lbl">Load More Videos</span>
                    <span class="badge bg-primary ms-1 count">{{ $videoRemain }}</span>
                </button>
            </div>
            @endif

            <div class="media-section-title">
                <span class="ms-label"><i class="bx bx-photo-album text-success"></i> Albums</span>
                <span class="ms-bar"></span>
                @if ($albumRemain > 0)<span class="badge bg-primary ms-count-hint">{{ $albumRemain }} more</span>@endif
            </div>
            <div class="media-grid" id="grid-album-all">
                @forelse ($albums->take($perPage) as $album)
                @include('pages.banner.partials.card-album')
                @empty
                <div class="media-empty">
                    <i class="bx bx-photo-album"></i>
                    <h6>No albums yet</h6>
                    <p class="mb-0">Click the <strong>Album</strong> button to create an album from existing photos.</p>
                </div>
                @endforelse
            </div>
            @if ($albumRemain > 0)
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light btn-load-more" data-type="album" data-offset="{{ $perPage }}" data-target="#grid-album-all">
                    <i class="bx bx-plus-circle"></i> <span class="lbl">Load More Albums</span>
                    <span class="badge bg-primary ms-1 count">{{ $albumRemain }}</span>
                </button>
            </div>
            @endif
        </div>

        {{-- ==================== PHOTOS ==================== --}}
        <div class="tab-pane fade" id="tab-foto" role="tabpanel">
            <div class="media-grid" id="grid-foto-tab">
                @forelse ($fotos->take($perPage) as $item)
                @include('pages.banner.partials.card-foto')
                @empty
                <div class="media-empty">
                    <i class="bi bi-inbox"></i>
                    <h6>No photos yet</h6>
                    <p class="mb-0">Click the <strong>Photo</strong> button to upload your first photo.</p>
                </div>
                @endforelse
            </div>
            @if ($fotoRemain > 0)
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light btn-load-more" data-type="foto" data-offset="{{ $perPage }}" data-target="#grid-foto-tab">
                    <i class="bx bx-plus-circle"></i> <span class="lbl">Load More Photos</span>
                    <span class="badge bg-primary ms-1 count">{{ $fotoRemain }}</span>
                </button>
            </div>
            @endif
        </div>

        {{-- ==================== VIDEOS ==================== --}}
        <div class="tab-pane fade" id="tab-video" role="tabpanel">
            <div class="media-grid" id="grid-video-tab">
                @forelse ($videos->take($perPage) as $item)
                @include('pages.banner.partials.card-video')
                @empty
                <div class="media-empty">
                    <i class="bx bx-video-recording"></i>
                    <h6>No videos yet</h6>
                    <p class="mb-0">Click the <strong>Video</strong> button to add videos from YouTube / Vimeo links.</p>
                </div>
                @endforelse
            </div>
            @if ($videoRemain > 0)
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light btn-load-more" data-type="video" data-offset="{{ $perPage }}" data-target="#grid-video-tab">
                    <i class="bx bx-plus-circle"></i> <span class="lbl">Load More Videos</span>
                    <span class="badge bg-primary ms-1 count">{{ $videoRemain }}</span>
                </button>
            </div>
            @endif
        </div>

        {{-- ==================== ALBUMS ==================== --}}
        <div class="tab-pane fade" id="tab-album" role="tabpanel">
            <div class="media-grid" id="grid-album-tab">
                @forelse ($albums->take($perPage) as $album)
                @include('pages.banner.partials.card-album')
                @empty
                <div class="media-empty">
                    <i class="bx bx-photo-album"></i>
                    <h6>No albums yet</h6>
                    <p class="mb-0">Click the <strong>Album</strong> button to create an album from existing photos.</p>
                </div>
                @endforelse
            </div>
            @if ($albumRemain > 0)
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light btn-load-more" data-type="album" data-offset="{{ $perPage }}" data-target="#grid-album-tab">
                    <i class="bx bx-plus-circle"></i> <span class="lbl">Load More Albums</span>
                    <span class="badge bg-primary ms-1 count">{{ $albumRemain }}</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Lightweight: 1 generic delete form + dynamic modal container (edit/view fetched on-demand via AJAX) --}}
<form id="deleteFotoForm" action="" method="POST" class="d-none">
    @method('DELETE') @csrf
</form>
<form id="deleteAlbumForm" action="" method="POST" class="d-none">
    @method('DELETE') @csrf
</form>
<div id="dynamicModals"></div>

{{-- ============ ADD MODALS (lightweight, photo picker via AJAX) ============ --}}
@include('pages.banner.modal-add-foto')
@include('pages.banner.modal-add-video')
@include('pages.banner.modal-add-album')

{{-- Video preview --}}
<div id="modal-video-preview" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-video-preview-title">Video Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <iframe id="modal-video-preview-frame" class="video-preview show" src="" title="Preview" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

@push('after-script')
<script>
    var MIL_LOADMORE_URL = "{{ route('banner.loadMore') }}";
    var MIL_PICKER_URL = "{{ route('banner.fotoPicker') }}";
    var MIL_MODAL_BASE = "{{ url('backend/banner/modal') }}";
    if (window.jQuery) { try { jQuery._milBound = true; } catch (err) {} }

    function mil_modalUrl(tipe, uuid) {
        return MIL_MODAL_BASE + '/' + tipe + '/' + uuid;
    }

    function showSweetAlert(uuid, name) {
        Swal.fire({
            title: 'Delete this media?',
            text: (name ? '"' + name + '" ' : '') + 'The media will be permanently deleted and cannot be recovered.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#f43f5e'
        }).then((result) => {
            if (result.isConfirmed) {
                var $f = $('#deleteFotoForm');
                $f.attr('action', "{{ url('backend/banner') }}/" + uuid);
                $f.submit();
            }
        });
    }

    function showSweetAlertAlbum(uuid, name) {
        Swal.fire({
            title: 'Delete this album?',
            text: (name ? '"' + name + '" ' : '') + 'The album will be permanently deleted. Photos inside it will not be deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#f43f5e'
        }).then((result) => {
            if (result.isConfirmed) {
                var $f = $('#deleteAlbumForm');
                $f.attr('action', "{{ url('backend/banner/album') }}/" + uuid);
                $f.submit();
            }
        });
    }

    $(document).on('click', '.js-delete-foto', function () {
        showSweetAlert($(this).data('uuid'), $(this).data('name'));
    });
    $(document).on('click', '.js-delete-album', function () {
        showSweetAlertAlbum($(this).data('uuid'), $(this).data('name'));
    });

    // Open the edit modal on-demand (lightweight)
    function mil_openModal(tipe, uuid, $btn) {
        if ($btn) $btn.prop('disabled', true);
        $.ajax({ url: mil_modalUrl(tipe, uuid), dataType: 'html' })
            .done(function (html) {
                $('#dynamicModals').append(html);
                var $modal = $('#dynamicModals').children().last();
                mil_initAlbumSelects($modal);
                if (tipe === 'album') mil_loadPicker($modal, '');
                var el = $modal.get(0);
                (bootstrap.Modal.getOrCreateInstance(el)).show();
                el.addEventListener('hidden.bs.modal', function () { $modal.remove(); }, { once: true });
            })
            .fail(function () {
                Swal.fire({ icon: 'error', title: 'Failed', text: 'Failed to load the form. Please try again.' });
            })
            .always(function () { if ($btn) $btn.prop('disabled', false); });
    }

    $(document).on('click', '.js-edit-foto', function () { mil_openModal('foto', $(this).data('uuid'), $(this)); });
    $(document).on('click', '.js-edit-video', function () { mil_openModal('video', $(this).data('uuid'), $(this)); });
    $(document).on('click', '.js-edit-album', function (e) { e.stopPropagation(); mil_openModal('album', $(this).data('uuid'), $(this)); });

    // View album contents: fetch the view modal on-demand
    $(document).on('click', '.js-view-album', function (e) {
        if ($(e.target).closest('.js-edit-album, .js-delete-album').length) return;
        var uuid = $(this).data('uuid');
        $.ajax({ url: mil_modalUrl('view-album', uuid), dataType: 'html' })
            .done(function (html) {
                $('#dynamicModals').append(html);
                var $modal = $('#dynamicModals').children().last();
                var el = $modal.get(0);
                (bootstrap.Modal.getOrCreateInstance(el)).show();
                el.addEventListener('hidden.bs.modal', function () { $modal.remove(); }, { once: true });
            })
            .fail(function () {
                Swal.fire({ icon: 'error', title: 'Failed', text: 'Failed to load the album contents.' });
            });
    });

    // From the view modal -> open the edit album modal
    $(document).on('click', '.js-edit-album-from-view', function () {
        var uuid = $(this).data('uuid');
        var $viewModal = $(this).closest('.modal');
        $viewModal.modal('hide');
        setTimeout(function () { mil_openModal('album', uuid, null); }, 300);
    });

    // Album photo picker via AJAX (used by the add & edit modals)
    function mil_renderPicker($grid, fotos, selected) {
        selected = selected || [];
        var selSet = {};
        selected.forEach(function (id) { selSet[id] = true; });
        if (!fotos.length) {
            $grid.html('<p class="text-muted small mb-0">No matching photos.</p>');
            $grid.closest('.modal').find('.media-picker-count').text('0 photos selected');
            return;
        }
        var html = fotos.map(function (f) {
            var checked = selSet[f.uuid] ? ' checked' : '';
            var cls = selSet[f.uuid] ? ' checked' : '';
            var escName = $('<div>').text(f.nama).html();
            return '<label class="media-photo-pick' + cls + '" title="' + escName + '" data-name="' + escName.toLowerCase() + '">'
                + '<img src="' + f.thumb + '" alt="' + escName + '" loading="lazy">'
                + '<span class="pick-check"><i class="bi bi-check"></i></span>'
                + '<input type="checkbox" name="foto_ids[]" value="' + f.uuid + '"' + checked + '>'
                + '</label>';
        }).join('');
        $grid.html(html);
        $grid.closest('.modal').find('.media-picker-count').text(selected.length + ' photos selected');
    }

    function mil_loadPicker($modal, search) {
        var $grid = $modal.find('.media-modal-photos').first();
        if (!$grid.length) return;
        var selected = [];
        var raw = $grid.data('selected');
        if (raw) selected = String(raw).split(',').filter(Boolean);
        var checkedNow = $grid.find('input:checked').map(function () { return this.value; }).get();
        if (checkedNow.length) selected = checkedNow;
        $grid.html('<p class="text-muted small mb-0">Loading photos...</p>');
        $.ajax({ url: MIL_PICKER_URL, data: { search: search || '', limit: 30 }, dataType: 'json' })
            .done(function (res) {
                var fotos = (res.data || []).map(function (f) { return { uuid: f.uuid, nama: f.nama, thumb: f.thumb }; });
                mil_renderPicker($grid, fotos, selected);
            })
            .fail(function () {
                $grid.html('<p class="text-danger small mb-0">Failed to load photos.</p>');
            });
    }

    // When the add/edit album modal opens -> load the picker
    $(document).on('shown.bs.modal', '#modal-add-album', function () {
        mil_loadPicker($(this), '');
        $(this).find('.media-picker-search').val('');
    });
    $(document).on('shown.bs.modal', '[id^="modal-edit-album-"]', function () {
        var $grid = $(this).find('.media-modal-photos').first();
        if ($grid.length && $grid.text().indexOf('Loading photos') > -1) mil_loadPicker($(this), '');
        mil_initAlbumSelects($(this));
    });

    // Picker search with debounce -> fetch from server (can find old photos, not just visible ones)
    var mil_searchTimer = null;
    $(document).on('input', '.media-picker-search', function () {
        var $input = $(this);
        var $modal = $input.closest('.modal');
        var q = $.trim($input.val());
        var target = $input.data('target');
        var $grid = $(target);
        if ($grid.length && $grid.find('.media-photo-pick').length) {
            var ql = q.toLowerCase();
            $grid.find('.media-photo-pick').each(function () {
                var name = ($(this).data('name') || '').toLowerCase();
                $(this).toggle(name.indexOf(ql) > -1 || q === '');
            });
        }
        clearTimeout(mil_searchTimer);
        mil_searchTimer = setTimeout(function () {
            if (q.length >= 2) mil_loadPicker($modal, q);
            else if (q.length === 0) mil_loadPicker($modal, '');
        }, 500);
    });

    // Video preview
    $(document).on('click', '.media-play', function (e) {
        var embed = $(this).data('embed');
        if (!embed) return;
        $('#modal-video-preview-title').text($(this).data('title') || 'Video Preview');
        $('#modal-video-preview-frame').attr('src', embed);
        new bootstrap.Modal(document.getElementById('modal-video-preview')).show();
    });

    $('#modal-video-preview').on('hidden.bs.modal', function () {
        $('#modal-video-preview-frame').attr('src', '');
    });

    // Media search
    $('#mediaSearch').on('input', function () {
        var q = $.trim($(this).val()).toLowerCase();
        $('.media-grid .media-card').each(function () {
            var name = ($(this).data('name') || '').toLowerCase();
            $(this).toggle(name.indexOf(q) > -1 || q === '');
        });
    });

    // Load more — lightweight, cards only (modals are fetched on-demand)
    $(document).on('click', '.btn-load-more', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if ($btn.prop('disabled')) return;
        $btn.prop('disabled', true);
        var type = $btn.data('type');
        var offset = parseInt($btn.data('offset'), 10) || 0;
        var $grid = $($btn.data('target'));
        if (!$grid.length) { $btn.prop('disabled', false); return; }

        var $icon = $btn.find('> i');
        var iconClass = $icon.attr('class');
        $icon.attr('class', 'bx bx-loader-circle bx-spin');

        $.ajax({ url: MIL_LOADMORE_URL, data: { tipe: type, offset: offset }, dataType: 'json' })
            .done(function (res) {
                if (res.html) $grid.append(res.html);
                var q = $.trim($('#mediaSearch').val()).toLowerCase();
                if (q) {
                    $grid.find('.media-card').each(function () {
                        var name = ($(this).data('name') || '').toLowerCase();
                        $(this).toggle(name.indexOf(q) > -1);
                    });
                }
                if (res.hasMore && res.remaining > 0) {
                    $btn.data('offset', res.offset);
                    $btn.find('.count').text(res.remaining);
                    $btn.prop('disabled', false);
                } else {
                    $btn.closest('.text-center').fadeOut(150, function () { $(this).remove(); });
                }
                $icon.attr('class', iconClass);
            })
            .fail(function (xhr) {
                $icon.attr('class', iconClass);
                $btn.prop('disabled', false);
                var msg = 'Failed to load more media. Please try again.';
                if (xhr.status === 419) msg = 'Session expired. Reload the page and try again.';
                Swal.fire({ icon: 'error', title: 'Failed', text: msg });
            });
    });

    // Upload photo preview (delegated so it works in dynamic modals)
    $(document).on('click', '.upload-preview', function () {
        $(this).next('input[type=file]').trigger('click');
    });

    $(document).on('change', '.media-image-input', function () {
        var file = this.files && this.files[0];
        if (!file) return;
        var $preview = $($(this).data('preview'));
        var reader = new FileReader();
        reader.onload = function (e) {
            $preview.find('img').attr('src', e.target.result);
            $preview.addClass('has-img');
        };
        reader.readAsDataURL(file);
    });

    // Video link preview in the form
    $(document).on('input', '.media-video-input', function () {
        var embed = mil_getEmbed($(this).val());
        var $preview = $($(this).data('preview'));
        var $empty = $($(this).data('empty'));

        if (embed) {
            $preview.attr('src', embed).addClass('show');
            $empty.hide();
        } else {
            $preview.removeClass('show').attr('src', '');
            $empty.show();
        }
    });

    // Photo picker in the album form (delegated)
    $(document).on('change', '.media-photo-pick input', function () {
        var $grid = $(this).closest('.media-modal-photos');
        $grid.find('.media-photo-pick').each(function () {
            var inp = this.querySelector('input');
            if (inp) $(this).toggleClass('checked', inp.checked);
        });
        var count = $grid.find('input:checked').length;
        $grid.closest('.modal').find('.media-picker-count').text(count + ' photos selected');
        var vals = $grid.find('input:checked').map(function () { return this.value; }).get();
        $grid.data('selected', vals.join(','));
    });

    // Select2 for the album select in the photo form
    function mil_initAlbumSelects($root) {
        if (typeof $.fn.select2 !== 'function') return;
        $root.find('.media-album-select').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) return;
            $(this).select2({
                multiple: true,
                width: '100%',
                placeholder: 'Select albums (optional)',
                dropdownParent: $(this).closest('.modal-content')
            });
        });
    }

    $(document).ready(function () {
        mil_initAlbumSelects($(document));
        window.setTimeout(function () { mil_initAlbumSelects($(document)); }, 800);
    });

    function mil_getEmbed(url) {
        if (!url) return null;
        var m;
        m = url.match(/(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/|live\/|v\/)|youtu\.be\/)([\w-]{6,})/);
        if (m) return 'https://www.youtube.com/embed/' + m[1];
        m = url.match(/vimeo\.com\/(?:video\/)?(\d+)/);
        if (m) return 'https://player.vimeo.com/video/' + m[1];
        return null;
    }

    // Vanilla fallback (no jQuery) so the load-more button still works
    // even if jQuery is reloaded by the layout.
    document.addEventListener('click', function (e) {
        var btn = e.target.closest ? e.target.closest('.btn-load-more') : null;
        if (!btn || btn.disabled) return;
        // if the jQuery handler is still alive, let jQuery handle it (avoid double)
        if (window.jQuery && jQuery._milBound) return;
        e.preventDefault();
        btn.disabled = true;
        var type = btn.getAttribute('data-type');
        var offset = parseInt(btn.getAttribute('data-offset'), 10) || 0;
        var grid = document.querySelector(btn.getAttribute('data-target'));
        if (!grid) { btn.disabled = false; return; }
        var icon = btn.querySelector(':scope > i');
        var iconClass = icon ? icon.getAttribute('class') : '';
        if (icon) icon.setAttribute('class', 'bx bx-loader-circle bx-spin');
        fetch(MIL_LOADMORE_URL + '?tipe=' + encodeURIComponent(type) + '&offset=' + offset, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        }).then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        }).then(function (res) {
            if (res.html) grid.insertAdjacentHTML('beforeend', res.html);
            if (res.hasMore && res.remaining > 0) {
                btn.setAttribute('data-offset', res.offset);
                var c = btn.querySelector('.count');
                if (c) c.textContent = res.remaining;
                btn.disabled = false;
            } else if (btn.parentElement) {
                btn.parentElement.remove();
            }
            if (icon) icon.setAttribute('class', iconClass);
        }).catch(function () {
            if (icon) icon.setAttribute('class', iconClass);
            btn.disabled = false;
            if (window.Swal) Swal.fire({ icon: 'error', title: 'Failed', text: 'Failed to load more media.' });
        });
    });
</script>
@endpush

@endsection
