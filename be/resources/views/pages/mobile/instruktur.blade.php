@extends('layouts.mobile')

@section('title', 'Instructor')

@section('content')

<section class="screen {{ request()->routeIs('instruktur.mobile') ? 'active' : '' }}" id="instructors">

    <div class="px-4 pt-4">

        {{-- Header --}}
        <p class="eyebrow mb-1">Our Team</p>

        <h1 class="fw-semibold" style="font-size: 28px">
            Meet Our Instructors
        </h1>


        {{-- Search --}}
        <div class="app-card d-flex align-items-center gap-2 px-3 py-2">
            <i class="bi bi-search text-muted2"></i>

            <input
                id="search"
                class="border-0 bg-transparent w-100 small"
                style="outline: none"
                placeholder="Find Your Instructor"
                autocomplete="off">
        </div>


        {{-- Filters --}}
        <div class="d-flex gap-2 no-scrollbar mt-3" id="filters">

            <button
                type="button"
                class="filter active"
                data-f="Semua">
                Semua
            </button>

            @foreach($specializations as $specialization)

            <button
                type="button"
                class="filter"
                data-f="{{ $specialization->name }}">
                {{ $specialization->name }}
            </button>

            @endforeach

        </div>


        {{-- Instructor List --}}
        <div class="d-grid gap-3 mt-3" id="instructorList">

            @forelse ($instructors as $instructor)

            @php
            $avatar = $instructor->avatar;

            if ($avatar) {
            $avatar = Str::startsWith(
            $avatar,
            ['http://', 'https://']
            )
            ? $avatar
            : asset('storage/' . $avatar);
            } else {
            $avatar = asset('dist/assets/images/avatar.jpg');
            }

            $specializationNames = $instructor
            ->specializations
            ->pluck('name')
            ->implode(',');
            @endphp


            <article
                class="app-card overflow-hidden instructor-item"
                data-uuid="{{ $instructor->uuid }}"
                data-name="{{ strtolower($instructor->name) }}"
                data-instructor-name="{{ $instructor->name }}"
                data-avatar="{{ $avatar }}"
                data-bio="{{ $instructor->biografi ?? 'Yoga instructor at Yogaroots.' }}"
                data-experience="{{ $instructor->pengalaman ?? 'Experienced Yoga Instructor' }}"
                data-specializations="{{ strtolower($specializationNames) }}">

                <img
                    class="img-teacher"
                    src="{{ $avatar }}"
                    alt="{{ $instructor->name }}"
                    loading="lazy">


                <div class="p-3">

                    {{-- Specializations --}}
                    <div class="d-flex flex-wrap gap-2">

                        @forelse ($instructor->specializations as $specialization)

                        <span
                            class="chip bg-sage-soft text-sage"
                            style="font-size:10px">
                            {{ $specialization->name }}
                        </span>

                        @empty

                        <span
                            class="chip bg-sage-soft text-sage"
                            style="font-size:10px">
                            Yoga Instructor
                        </span>

                        @endforelse

                    </div>


                    {{-- Name --}}
                    <h2 class="h5 fw-semibold mt-2 mb-1">
                        {{ $instructor->name }}
                    </h2>


                    {{-- Bio --}}
                    <p class="small text-muted2 mb-2 instructor-bio">
                        {{ Str::limit(
                                $instructor->biografi ?? 'Yoga instructor at Yogaroots.',
                                120
                            ) }}
                    </p>


                    {{-- Experience --}}
                    <p
                        class="mb-0 text-muted2"
                        style="font-size:12px">

                        <i class="bi bi-award"></i>

                        {{ $instructor->pengalaman ?? 'Experienced Yoga Instructor' }}

                    </p>


                    {{-- Button --}}
                    <button
                        type="button"
                        class="btn btn-warm w-100 py-2 mt-3"
                        onclick="showInstructor('{{ $instructor->uuid }}')">

                        View Profile

                    </button>

                </div>

            </article>

            @empty

            <div class="app-card p-4 text-center">

                <p class="mb-1 fw-semibold">
                    No Instructors Available
                </p>

                <p class="small text-muted2 mb-0">
                    There are no instructors available at the moment.
                </p>

            </div>

            @endforelse


            {{-- No Search Result --}}
            @if($instructors->count())

            <div
                id="noInstructorResult"
                class="app-card p-4 text-center d-none">

                <i class="bi bi-person-x fs-2 text-muted2"></i>

                <p class="mb-1 mt-2 fw-semibold">
                    No Instructors Found
                </p>

                <p class="small text-muted2 mb-0">
                    Try another name or specialization.
                </p>

            </div>

            @endif

        </div>

    </div>

</section>

<div
    class="modal fade"
    id="instructorModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 overflow-hidden">

            {{-- Image --}}
            <div class="position-relative flex-shrink-0">

                <img
                    id="modalInstructorAvatar"
                    src=""
                    alt=""
                    class="w-100"
                    style="
                        height:260px;
                        object-fit:contain;
                        background:#f5f3ed;
                    ">

                <button
                    type="button"
                    class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            {{-- Scrollable Content --}}
            <div
                class="modal-body p-4"
                style="overflow-y:auto;">

                <div
                    id="modalInstructorSpecializations"
                    class="d-flex flex-wrap gap-2 mb-2">
                </div>

                <h2
                    id="modalInstructorName"
                    class="h4 fw-semibold mb-2">
                </h2>

                <p
                    id="modalInstructorExperience"
                    class="small text-muted2 mb-3">
                </p>

                <div>
                    <h6 class="fw-semibold mb-2">
                        About
                    </h6>

                    <p
                        id="modalInstructorBio"
                        class="small text-muted2 mb-0"
                        style="line-height:1.8;">
                    </p>
                </div>

            </div>

            {{-- Bottom Close --}}
            <div class="px-4 pb-4 pt-2 flex-shrink-0">
                <button
                    type="button"
                    class="btn btn-warm border w-100 py-2"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const searchInput =
            document.getElementById('search');

        const filterButtons =
            document.querySelectorAll('#filters .filter');

        const instructors =
            document.querySelectorAll('.instructor-item');

        const noResult =
            document.getElementById('noInstructorResult');

        let activeFilter = 'Semua';


        // =========================
        // SEARCH + FILTER
        // =========================

        function filterInstructors() {

            const keyword =
                searchInput.value
                .toLowerCase()
                .trim();

            let visibleCount = 0;


            instructors.forEach(function(instructor) {

                const name =
                    instructor.dataset.name || '';

                const specializations =
                    instructor.dataset.specializations || '';


                // Search nama atau specialization
                const searchMatch =
                    keyword === '' ||
                    name.includes(keyword) ||
                    specializations.includes(keyword);


                // Filter specialization
                const filterMatch =
                    activeFilter === 'Semua' ||
                    specializations
                    .split(',')
                    .map(item => item.trim())
                    .includes(
                        activeFilter.toLowerCase()
                    );


                if (searchMatch && filterMatch) {

                    instructor.classList.remove('d-none');

                    visibleCount++;

                } else {

                    instructor.classList.add('d-none');

                }

            });


            // Empty state
            if (noResult) {

                if (visibleCount === 0) {
                    noResult.classList.remove('d-none');
                } else {
                    noResult.classList.add('d-none');
                }

            }

        }


        // Search
        if (searchInput) {

            searchInput.addEventListener(
                'input',
                filterInstructors
            );

        }


        // Filter
        filterButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });

                this.classList.add('active');

                activeFilter =
                    this.dataset.f;

                filterInstructors();

            });

        });

    });


    // =========================
    // SHOW INSTRUCTOR MODAL
    // =========================

    function showInstructor(uuid) {

        const instructor =
            document.querySelector(
                '.instructor-item[data-uuid="' + uuid + '"]'
            );


        if (!instructor) {
            return;
        }


        const name =
            instructor.dataset.instructorName || '';

        const avatar =
            instructor.dataset.avatar || '';

        const bio =
            instructor.dataset.bio ||
            'Yoga instructor at Yogaroots.';

        const experience =
            instructor.dataset.experience ||
            'Experienced Yoga Instructor';

        const specializations =
            instructor.dataset.specializations || '';


        // Avatar
        const modalAvatar =
            document.getElementById(
                'modalInstructorAvatar'
            );

        modalAvatar.src = avatar;
        modalAvatar.alt = name;


        // Name
        document.getElementById(
            'modalInstructorName'
        ).textContent = name;


        // Experience
        document.getElementById(
                'modalInstructorExperience'
            ).innerHTML =
            '<i class="bi bi-award me-1"></i>' +
            experience;


        // Bio
        document.getElementById(
            'modalInstructorBio'
        ).textContent = bio;


        // Specializations
        const specializationContainer =
            document.getElementById(
                'modalInstructorSpecializations'
            );

        specializationContainer.innerHTML = '';


        if (specializations.trim()) {

            specializations
                .split(',')
                .forEach(function(specialization) {

                    specialization =
                        specialization.trim();

                    if (!specialization) {
                        return;
                    }

                    const chip =
                        document.createElement('span');

                    chip.className =
                        'chip bg-sage-soft text-sage';

                    chip.style.fontSize = '10px';

                    chip.textContent =
                        specialization;

                    specializationContainer
                        .appendChild(chip);

                });

        } else {

            specializationContainer.innerHTML = `
            <span
                class="chip bg-sage-soft text-sage"
                style="font-size:10px">
                Yoga Instructor
            </span>
        `;

        }


        // Open modal
        const modalElement =
            document.getElementById(
                'instructorModal'
            );

        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );

        modal.show();

    }
</script>

@endsection