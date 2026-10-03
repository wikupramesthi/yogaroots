@extends('layouts.app')
@section('title', 'Website Identity')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Website Identity" page="Settings" active="Website Identity" route="{{ route('website-identity.index') }}" />
@endsection

<section class="section">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <form action="{{ route('website-identity.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Left column --}}
            <div class="col-lg-8">
                {{-- General Information --}}
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle text-primary me-2"></i>General Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="site_name" class="form-label fw-semibold">Site Name <span class="text-danger">*</span></label>
                                <input type="text" name="site_name" id="site_name"
                                    class="form-control @error('site_name') is-invalid @enderror"
                                    value="{{ old('site_name', $identitas->site_name) }}" required>
                                @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="site_title" class="form-label fw-semibold">Site Title <span class="text-danger">*</span></label>
                                <input type="text" name="site_title" id="site_title"
                                    class="form-control @error('site_title') is-invalid @enderror"
                                    value="{{ old('site_title', $identitas->site_title) }}" required>
                                @error('site_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="tagline" class="form-label fw-semibold">Tagline</label>
                                <input type="text" name="tagline" id="tagline"
                                    class="form-control @error('tagline') is-invalid @enderror"
                                    value="{{ old('tagline', $identitas->tagline) }}"
                                    placeholder="e.g. Quality Yoga for Everyone">
                                @error('tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="short_description" class="form-label fw-semibold">Short Description</label>
                                <textarea name="short_description" id="short_description" rows="3"
                                    class="form-control @error('short_description') is-invalid @enderror"
                                    placeholder="Brief website description...">{{ old('short_description', $identitas->short_description) }}</textarea>
                                @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact & Social Media --}}
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-telephone text-primary me-2"></i>Contact &amp; Social Media</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $identitas->email) }}"
                                    placeholder="info@example.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone / WhatsApp No.</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $identitas->phone) }}"
                                    placeholder="+62...">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <textarea name="address" id="address" rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Street, city, postal code...">{{ old('address', $identitas->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="facebook_url" class="form-label fw-semibold"><i class="bi bi-facebook text-primary me-1"></i>Facebook URL</label>
                                <input type="url" name="facebook_url" id="facebook_url"
                                    class="form-control @error('facebook_url') is-invalid @enderror"
                                    value="{{ old('facebook_url', $identitas->facebook_url) }}"
                                    placeholder="https://www.facebook.com/...">
                                @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="instagram_url" class="form-label fw-semibold"><i class="bi bi-instagram text-danger me-1"></i>Instagram URL</label>
                                <input type="url" name="instagram_url" id="instagram_url"
                                    class="form-control @error('instagram_url') is-invalid @enderror"
                                    value="{{ old('instagram_url', $identitas->instagram_url) }}"
                                    placeholder="https://www.instagram.com/...">
                                @error('instagram_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="youtube_url" class="form-label fw-semibold"><i class="bi bi-youtube text-danger me-1"></i>Youtube URL</label>
                                <input type="url" name="youtube_url" id="youtube_url"
                                    class="form-control @error('youtube_url') is-invalid @enderror"
                                    value="{{ old('youtube_url', $identitas->youtube_url) }}"
                                    placeholder="https://youtube.com/...">
                                @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tiktok_url" class="form-label fw-semibold"><i class="bi bi-tiktok me-1"></i>Tiktok URL</label>
                                <input type="url" name="tiktok_url" id="tiktok_url"
                                    class="form-control @error('tiktok_url') is-invalid @enderror"
                                    value="{{ old('tiktok_url', $identitas->tiktok_url) }}"
                                    placeholder="https://www.tiktok.com/...">
                                @error('tiktok_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO & Meta --}}
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-search text-primary me-2"></i>SEO &amp; Meta</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title"
                                    class="form-control @error('meta_title') is-invalid @enderror"
                                    value="{{ old('meta_title', $identitas->meta_title) }}"
                                    placeholder="Page title shown in search results">
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    placeholder="Brief description for search engines...">{{ old('meta_description', $identitas->meta_description) }}</textarea>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="meta_keywords" class="form-label fw-semibold">Meta Keywords</label>
                                <textarea name="meta_keywords" id="meta_keywords" rows="2"
                                    class="form-control @error('meta_keywords') is-invalid @enderror"
                                    placeholder="keyword one, keyword two, keyword three...">{{ old('meta_keywords', $identitas->meta_keywords) }}</textarea>
                                <div class="form-text">Separate keywords with commas.</div>
                                @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="google_analytics_id" class="form-label fw-semibold">Google Analytics ID</label>
                                <input type="text" name="google_analytics_id" id="google_analytics_id"
                                    class="form-control @error('google_analytics_id') is-invalid @enderror"
                                    value="{{ old('google_analytics_id', $identitas->google_analytics_id) }}"
                                    placeholder="G-XXXXXXXXXX">
                                @error('google_analytics_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="google_site_verification" class="form-label fw-semibold">Google Site Verification</label>
                                <input type="text" name="google_site_verification" id="google_site_verification"
                                    class="form-control @error('google_site_verification') is-invalid @enderror"
                                    value="{{ old('google_site_verification', $identitas->google_site_verification) }}"
                                    placeholder="Verification code">
                                @error('google_site_verification')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="col-lg-4">
                {{-- Branding --}}
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-palette text-primary me-2"></i>Branding</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="logo" class="form-label fw-semibold">Logo</label>
                            <div class="form-text mt-0 mb-2">Transparent PNG, max 2MB.</div>
                            @if ($identitas->logoUrl())
                            <div class="d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-light">
                                <img src="{{ $identitas->logoUrl() }}" alt="Logo preview" class="rounded bg-white border" style="height:44px; width:44px; object-fit:contain; padding:4px;">
                                <span class="text-muted small text-truncate flex-grow-1" title="{{ basename($identitas->logo) }}">{{ \Illuminate\Support\Str::limit(basename($identitas->logo), 22) }}</span>
                                <div class="form-check mb-0 flex-shrink-0">
                                    <input class="form-check-input" type="checkbox" name="remove_logo" id="remove_logo" value="1">
                                    <label class="form-check-label small" for="remove_logo">Delete</label>
                                </div>
                            </div>
                            @endif
                            <input type="file" name="logo" id="logo"
                                class="form-control @error('logo') is-invalid @enderror" accept=".png,.jpg,.jpeg,.webp">
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="favicon" class="form-label fw-semibold">Favicon</label>
                            <div class="form-text mt-0 mb-2">ICO / PNG 32x32, max 1MB.</div>
                            @if ($identitas->faviconUrl())
                            <div class="d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-light">
                                <img src="{{ $identitas->faviconUrl() }}" alt="Favicon preview" class="rounded bg-white border" style="height:32px; width:32px; object-fit:contain; padding:2px;">
                                <span class="text-muted small text-truncate flex-grow-1" title="{{ basename($identitas->favicon) }}">{{ \Illuminate\Support\Str::limit(basename($identitas->favicon), 22) }}</span>
                                <div class="form-check mb-0 flex-shrink-0">
                                    <input class="form-check-input" type="checkbox" name="remove_favicon" id="remove_favicon" value="1">
                                    <label class="form-check-label small" for="remove_favicon">Delete</label>
                                </div>
                            </div>
                            @endif
                            <input type="file" name="favicon" id="favicon"
                                class="form-control @error('favicon') is-invalid @enderror" accept=".ico,.png,.jpg,.jpeg,.webp">
                            @error('favicon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="og_image" class="form-label fw-semibold">OG Image</label>
                            <div class="form-text mt-0 mb-2">1200x630 px, max 3MB.</div>
                            @if ($identitas->ogImageUrl())
                            <div class="d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-light">
                                <img src="{{ $identitas->ogImageUrl() }}" alt="OG image preview" class="rounded bg-white border" style="height:44px; width:76px; object-fit:cover;">
                                <span class="text-muted small text-truncate flex-grow-1" title="{{ basename($identitas->og_image) }}">{{ \Illuminate\Support\Str::limit(basename($identitas->og_image), 22) }}</span>
                                <div class="form-check mb-0 flex-shrink-0">
                                    <input class="form-check-input" type="checkbox" name="remove_og_image" id="remove_og_image" value="1">
                                    <label class="form-check-label small" for="remove_og_image">Delete</label>
                                </div>
                            </div>
                            @endif
                            <input type="file" name="og_image" id="og_image"
                                class="form-control @error('og_image') is-invalid @enderror" accept=".png,.jpg,.jpeg,.webp">
                            @error('og_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Actions + meta in one white card --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
                    <div class="card-body p-3">
                        @can('website-identity.update')
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm" style="border-radius:.75rem;">
                                <i class="bi bi-check-lg me-1"></i>Save Identity
                            </button>
                            <a href="{{ route('website-identity.index') }}" class="btn btn-light border fw-semibold py-2 shadow-sm" style="border-radius:.75rem;">Cancel</a>
                        </div>
                        <hr class="my-3">
                        @endcan
                        <div class="d-flex justify-content-between align-items-center small px-1 py-1">
                            <span class="text-muted">UUID</span>
                            <span class="text-dark fw-semibold" title="{{ $identitas->uuid }}">{{ \Illuminate\Support\Str::limit($identitas->uuid, 20) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small px-1 py-1">
                            <span class="text-muted">Updated</span>
                            <span class="text-dark fw-semibold">{{ optional($identitas->updated_at)->format('d/m/Y H:i') ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Important Information --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem; background: linear-gradient(135deg, #5b6cff 0%, #8b5cf6 100%);">
                    <div class="card-body text-white p-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width:44px; height:44px; border-radius:.8rem; background:rgba(255,255,255,.22); border:1px solid rgba(255,255,255,.35);">
                                <i class="bi bi-stars fs-5"></i>
                            </span>
                            <div>
                                <h6 class="mb-0 fw-bold">Important Information</h6>
                                <small style="color:rgba(255,255,255,.92);">Optimize your website identity</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2 p-2 mt-3" style="border-radius:.8rem; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.25);">
                            <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 bg-white text-primary" style="width:40px; height:40px; border-radius:.7rem;">
                                <i class="bi bi-palette fs-5"></i>
                            </span>
                            <div>
                                <div class="fw-bold">Logo &amp; Favicon</div>
                                <small style="color:rgba(255,255,255,.92);">Shown in the header &amp; frontend. Use a transparent PNG 512x512, max 2MB.</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2 p-2 mt-2" style="border-radius:.8rem; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.25);">
                            <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 bg-white text-primary" style="width:40px; height:40px; border-radius:.7rem;">
                                <i class="bi bi-share fs-5"></i>
                            </span>
                            <div>
                                <div class="fw-bold">OG Image</div>
                                <small style="color:rgba(255,255,255,.92);">Preview when sharing to WhatsApp / Facebook. Ideal 1200x630, max 3MB.</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2 p-2 mt-2" style="border-radius:.8rem; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.25);">
                            <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 bg-white text-primary" style="width:40px; height:40px; border-radius:.7rem;">
                                <i class="bi bi-graph-up fs-5"></i>
                            </span>
                            <div>
                                <div class="fw-bold">GA4 ID</div>
                                <small style="color:rgba(255,255,255,.92);">Format <span class="font-monospace">G-XXXXXXXXXX</span> — find it in Google Analytics &gt; Admin &gt; Data Streams.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
