@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Dashboard" page="Dashboard" active="" route="{{ route('dashboard.index') }}" />
@endsection

<div class="page-content">
    <section class="row">
        <div class="col-12">
            @include('pages.dashboard.card')

            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Berita per Kategori</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Dokumen Sekolah</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="sumberInformasiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</div>

@endsection

@push('after-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('categoryChart').getContext('2d');

        const labels = {!! json_encode($categoryLabels) !!};
        const data = {!! json_encode($categoryCounts) !!};

        function randomColor() {
            const r = Math.floor(Math.random() * 156) + 100; // 100–255 (lebih soft)
            const g = Math.floor(Math.random() * 156) + 100;
            const b = Math.floor(Math.random() * 156) + 100;
            return `rgba(${r}, ${g}, ${b}, 0.7)`;
        }

        const colors = labels.map(() => randomColor());

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Berita',
                    data: data,
                    backgroundColor: colors,
                    borderColor: colors.map(c => c.replace('0.7', '1')), // border lebih solid
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
