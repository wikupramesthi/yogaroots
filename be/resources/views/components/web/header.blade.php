<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>

            {{-- Global search (DBMSDA-style): command palette trigger button --}}
            <button type="button" id="topbar-search-trigger" class="topbar-search-trigger d-none d-md-flex">
                <i class="bi bi-search"></i>
                <span>Search all...</span>
                <kbd>Ctrl K</kbd>
            </button>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="me-auto"></div>
                <ul class="navbar-nav ms-auto mb-lg-0 align-items-center">
                    <div class="theme-toggle d-flex gap-2 align-items-center me-3">
                        <div class="form-check form-switch fs-6 mb-0">
                            <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                style="cursor: pointer" />
                            <label class="form-check-label"></label>
                        </div>
                    </div>
                    <li class="nav-item dropdown me-2 me-lg-3">
                        <a class="nav-link text-gray-600 position-relative" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false" id="notifDropdown">

                            <i class="bi bi-bell bi-sub fs-4"></i>

                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                            @endphp

                            @if ($unreadCount > 0)
                                <span class="badge badge-notification bg-danger" id="notif-count">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown shadow-lg"
                            aria-labelledby="notifDropdown">

                            <li class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <h6 class="mb-0 fw-bold">Notifications</h6>
                                @if ($unreadCount > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unreadCount }} new</span>
                                @endif
                            </li>

                            <div class="notification-list">
                            @php
                                $notifications = auth()->user()->notifications()->latest()->take(5)->get();
                            @endphp

                            @forelse($notifications as $notification)
                                <li
                                    class="notification-item {{ $notification->read_at ? '' : 'unread' }}">

                                    <a href="javascript:void(0)"
                                        class="mark-as-read d-flex align-items-start gap-2 text-decoration-none p-2 px-3"
                                        data-id="{{ $notification->id }}">

                                        <span class="notif-dot {{ $notification->read_at ? 'read' : '' }}" aria-hidden="true"></span>

                                        <div class="notification-text flex-grow-1 min-w-0">

                                            <p class="notification-title fw-bold mb-0 text-dark">
                                                {{ $notification->data['judul_kegiatan'] ?? 'Program' }}
                                            </p>

                                            <p class="notification-subtitle text-muted small mb-1">
                                                {{ $notification->data['message'] ?? '-' }}
                                            </p>

                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-clock" style="font-size:10px;"></i> {{ $notification->created_at->diffForHumans() }}
                                            </small>

                                        </div>

                                    </a>
                                </li>

                            @empty
                                <li class="empty-notif">
                                    <div class="empty-notif-icon"><i class="bi bi-bell-slash"></i></div>
                                    <p class="mb-1 fw-semibold small text-muted">No notifications</p>
                                    <small class="text-muted" style="font-size:11px;">No recent activity yet</small>
                                </li>
                            @endforelse
                            </div>

                            <li class="border-top">
                                <a href="{{ route('notifications.index') }}"
                                    class="d-block text-center text-decoration-none small fw-bold py-2">
                                    View all notifications
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>
                <div class="dropdown user-dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false" id="userDropdown" class="d-flex align-items-center text-decoration-none">
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
                            <div class="user-name text-start">
                                <h6 class="mb-0 text-gray-600">{{ Auth::user()->name ?? '' }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ Auth::user()->getRoleNames()->first() ?? '' }}
                                </p>
                            </div>

                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu shadow-lg" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                    class="icon-mid bi bi-person me-2"></i> My Profile</a>
                        </li>

                        @role('super-admin|admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('account.index') }}">
                                    <i class="icon-mid bi bi-gear me-2"></i> Settings
                                </a>
                            </li>
                        @else
                        @endrole

                        <hr class="dropdown-divider">

                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i>Logout
                                </button>
                            </form>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trigger = document.getElementById('topbar-search-trigger');
        const modalEl = document.getElementById('globalSearchModal');
        const input = document.getElementById('global-search-input');
        const results = document.getElementById('global-search-results');
        const closeBtn = document.getElementById('global-search-close');
        if (!trigger || !modalEl || !input || !results) return;

        // Theme's built-in Bootstrap modal; manual fallback if Bootstrap hasn't loaded yet.
        function bsModal() {
            if (window.bootstrap && window.bootstrap.Modal) {
                return window.bootstrap.Modal.getOrCreateInstance(modalEl);
            }
            return null;
        }

        const SEARCH_URL = "{{ route('search') }}";
        let items = [];
        let activeIdx = -1;
        let timer = null;
        let closeTimer = null;

        function collectMenuItems(query) {
            const found = [];
            document.querySelectorAll('.sidebar-menu .menu a.sidebar-link, .sidebar-menu .menu a.submenu-link').forEach(function(a) {
                const label = (a.textContent || '').trim().replace(/\s+/g, ' ');
                if (label && label.toLowerCase().includes(query) && a.href && !a.href.endsWith('#')) {
                    found.push({ type: 'Menu', title: label, subtitle: null, url: a.href });
                }
            });
            return found.slice(0, 5);
        }

        function esc(s) {
            return String(s ?? '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[c]));
        }

        function render(list) {
            items = list;
            activeIdx = list.length ? 0 : -1;
            if (!list.length) {
                results.innerHTML = '<p class="gs-hint">No results. Try different keywords.</p>';
                return;
            }
            results.innerHTML = list.map(function(it, i) {
                return '<a href="' + esc(it.url) + '" class="gs-item' + (i === activeIdx ? ' active' : '') + '" data-idx="' + i + '">' +
                    '<span class="gs-badge">' + esc(it.type) + '</span>' +
                    '<span class="gs-text"><span class="gs-title">' + esc(it.title) + '</span>' +
                    (it.subtitle ? '<span class="gs-sub">' + esc(it.subtitle) + '</span>' : '') +
                    '</span><i class="bi bi-arrow-right gs-go"></i></a>';
            }).join('');
        }

        function highlight() {
            results.querySelectorAll('.gs-item').forEach(function(el) {
                el.classList.toggle('active', parseInt(el.dataset.idx, 10) === activeIdx);
            });
            results.querySelector('.gs-item.active')?.scrollIntoView({ block: 'nearest' });
        }

        async function runSearch(query) {
            if (query.length < 2) {
                render([]);
                results.innerHTML = '<p class="gs-hint">Type at least 2 characters to search.</p>';
                return;
            }
            results.innerHTML = '<p class="gs-hint">Searching...</p>';
            const menuHits = collectMenuItems(query);
            try {
                const res = await fetch(SEARCH_URL + '?q=' + encodeURIComponent(query), {
                    headers: { Accept: 'application/json' }
                });
                const data = await res.json();
                render(menuHits.concat(data.results || []).slice(0, 20));
            } catch (e) {
                render(menuHits);
            }
        }

        function open() {
            clearTimeout(closeTimer);
            const bs = bsModal();
            if (bs) { bs.show(); }
            else { modalEl.style.display = 'block'; modalEl.classList.add('show'); document.body.classList.add('modal-open'); }
            document.body.classList.add('gs-open');
            input.value = '';
            results.innerHTML = '<p class="gs-hint">Type to search across all modules.</p>';
            setTimeout(() => input.focus(), 60);
        }

        function close() {
            const bs = bsModal();
            if (bs) { bs.hide(); }
            else { modalEl.style.display = 'none'; modalEl.classList.remove('show'); document.body.classList.remove('modal-open'); }
            clearTimeout(closeTimer);
            closeTimer = setTimeout(() => document.body.classList.remove('gs-open'), 150);
        }

        trigger.addEventListener('click', open);
        closeBtn.addEventListener('click', close);

        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => runSearch(input.value.trim().toLowerCase()), 250);
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown') { e.preventDefault(); if (items.length) { activeIdx = (activeIdx + 1) % items.length; highlight(); } }
            else if (e.key === 'ArrowUp') { e.preventDefault(); if (items.length) { activeIdx = (activeIdx - 1 + items.length) % items.length; highlight(); } }
            else if (e.key === 'Enter' && activeIdx >= 0 && items[activeIdx]) { window.location.href = items[activeIdx].url; }
            else if (e.key === 'Escape') { close(); }
        });

        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); open(); }
        });
    });
</script>
