<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                        <div class="form-check form-switch fs-6">
                            <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                style="cursor: pointer" />
                            <label class="form-check-label"></label>
                        </div>
                    </div>

                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                            data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4'></i>

                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if ($unreadCount > 0)
                                <span class="badge badge-notification bg-danger" id="notif-count">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                            aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">
                                <h6>Notifikasi</h6>
                            </li>

                            @php
                                $notifications = auth()->user()->notifications()->latest()->take(5)->get();
                            @endphp

                            @forelse($notifications as $notification)
                                <li
                                    class="dropdown-item notification-item {{ $notification->read_at ? '' : 'bg-light-secondary' }}">
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center mark-as-read border-bottom pb-3"
                                        data-id="{{ $notification->id }}">
                                        <div class="notification-text text-wrap"
                                            style="white-space: normal; word-break: break-word; max-width: 250px;">
                                            <p class="notification-title fw-bold mb-0">
                                                {{ $notification->data['judul_kegiatan'] ?? 'Program' }}
                                            </p>
                                            <p class="notification-subtitle text-muted small mb-0">
                                                {{ $notification->data['message'] ?? '-' }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="dropdown-item text-center text-muted">
                                    Tidak ada notifikasi baru
                                </li>
                            @endforelse
                        </ul>
                    </li>

                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ Auth::user()->avatar
                                        ? (Str::startsWith(Auth::user()->avatar, 'http')
                                            ? Auth::user()->avatar
                                            : asset('storage/' . Auth::user()->avatar))
                                        : asset('dist/assets/images/avatar.jpg') }}"
                                        alt="{{ auth()->user()->name }}" class="img-thumbnail rounded-circle">
                                </div>
                            </div>
                            <div class="user-name text-start me-3">
                                <h6 class="mb-0 text-gray-600">{{ Auth::user()->name ?? '' }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ Auth::user()->getRoleNames()->first() ?? '' }}
                                </p>
                            </div>

                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem;">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                    class="icon-mid bi bi-person me-2"></i> Profil Saya</a>
                        </li>

                        @role('super-admin|admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('account.index') }}">
                                    <i class="icon-mid bi bi-gear me-2"></i> Pengaturan
                                </a>
                            </li>
                        @else
                        @endrole

                        <hr class="dropdown-divider">

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
