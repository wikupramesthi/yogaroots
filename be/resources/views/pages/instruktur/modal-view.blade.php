<div class="modal fade" id="modal-form-view-faq-{{ $user->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header">
                <h5 class="modal-title">Detail Intstrutur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center">
                        @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto {{ $user->name }}"
                            class="img-fluid rounded-circle shadow" style="max-width: 150px;">
                        @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width:150px; height:150px; margin:auto;">
                            <i class="bi bi-person fs-1 text-muted"></i>
                        </div>
                        @endif
                        <h5 class="mt-3 mb-0">{{ $user->name }}</h5>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="text-muted" style="width: 35%;">Spesialisasi</th>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse ($user->specializations as $specialization)
                                        <span class="badge bg-primary">
                                            {{ $specialization->name }}
                                        </span>
                                        @empty
                                        <span class="text-muted">-</span>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Jenis Kelamin</th>
                                <td>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tempat, Tgl Lahir</th>
                                <td>
                                    {{ $user->tempat_lahir }},
                                    {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">No. Handphone</th>
                                <td>{{ $user->no_hp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Pengalaman</th>
                                <td>
                                    {{ $user->pengalaman ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>