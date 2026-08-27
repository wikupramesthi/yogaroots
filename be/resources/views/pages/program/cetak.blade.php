<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumen Program - {{ $program->judul_kegiatan }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: bold;
        }

        .header small {
            font-size: 13px;
        }

        .logo {
            position: relative;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 15px auto;
            object-fit: cover;
            border: 1px solid #999;
        }

        .logo-center {
            display: block;
            margin: 0 auto 30px auto;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #999;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 5px;
            border-bottom: 1px solid #666;
            padding-bottom: 3px;
        }

        .content {
            margin-top: 5px;
            text-align: justify;
            white-space: pre-line;
        }

        .grid-photos {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .grid-photos .photo {
            width: calc(50% - 5px);
            border: 1px solid #ccc;
            padding: 5px;
            box-sizing: border-box;
        }

        .grid-photos .photo img {
            width: 100%;
            height: auto;
        }

        .video-link {
            word-wrap: break-word;
            font-size: 12px;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .header .logo-center {
    display: block;
    margin: 0 auto 15px auto;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #999;
}

.centered-table {
    margin: 0 auto;
    text-align: left;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dokumen Program Kegiatan</h1>
            <small>Kegiatan Kompetensi Ekosistem Cerdas Kota Bekasi 2025</small>
        </div>

        <div class="logo-center">
            @if ($program->logo_komunitas)
                <img src="{{ storage_path('app/public/' . $program->logo_komunitas) }}" alt="Logo Komunitas" class="logo">
            @endif
        </div>

        <div class="section">
            <div class="section-title">Profil Komunitas</div>
            <table class="info-table">
                <tr><td class="label">Nama</td><td>: {{ $program->user->name ?? '-' }}</td></tr>
                <tr><td class="label">Email</td><td>: {{ $program->user->email ?? '-' }}</td></tr>
                <tr><td class="label">No. Telepon</td><td>: {{ $program->user->telp ?? '-' }}</td></tr>
                <tr><td class="label">Nama Komunitas</td><td>: {{ $program->user->nama_komunitas ?? '-' }}</td></tr>
                <tr><td class="label">Media Sosial</td><td>: {{ $program->user->medsos ?? '-' }}</td></tr>
                <tr><td class="label">Alamat</td><td>: {{ $program->user->alamat ?? '-' }}</td></tr>
                <tr><td class="label">Kecamatan</td><td>: {{ optional($program->user->kecamatan)->nama ?? '-' }}</td></tr>
                <tr><td class="label">Kelurahan</td><td>: {{ optional($program->user->kelurahan)->nama ?? '-' }}</td></tr>
            </table>
        </div>

         <div class="section">
            <div class="section-title">Dimensi Program</div>
            <table class="info-table">
                 <div class="content">{{ $program->portofolio->nama ?? '-' }}</div>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Dokumen Pendukung</div>
            <table class="info-table">
                <tr><td class="label">KTP Penanggung Jawab</td><td>: {{ $program->user->foto_pj ? 'Tersedia' : 'Tidak tersedia' }}</td></tr>
                <tr><td class="label">Surat Pernyataan</td><td>: {{ $program->user->surat_pernyataan ? 'Tersedia' : 'Tidak tersedia' }}</td></tr>
                <tr><td class="label">Profil Komunitas</td><td>: {{ $program->user->profil_komunitas ? 'Tersedia' : 'Tidak tersedia' }}</td></tr>
                <tr><td class="label">Dokumen Power Point </td><td>: {{ $program->presentasi ? 'Tersedia' : 'Tidak tersedia' }}</td></tr>
                <tr><td class="label">Video Kompetisi </td><td>: {{ $program->video ? 'Tersedia' : 'Tidak tersedia' }}</td></tr>
            </table>
        </div>

        {{-- Informasi Program --}}
        <div class="section">
            <div class="section-title">Judul Kegiatan</div>
            <div class="content">{{ $program->judul_kegiatan }}</div>
        </div>

        <div class="section">
            <div class="section-title">Jenis Kegiatan</div>
            <div class="content">{{ ucfirst($program->jenis_kegiatan) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Latar Belakang</div>
            <div class="content">{{ strip_tags($program->latar_belakang) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Deskripsi Kegiatan</div>
            <div class="content">{{ strip_tags($program->deskripsi_kegiatan) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Hasil Kegiatan</div>
            <div class="content">{{ strip_tags($program->hasil) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Foto Kegiatan</div>
            <div class="grid-photos">
                @for ($i = 1; $i <= 5; $i++)
                    @php $foto = $program->{'foto_kegiatan_'.$i}; @endphp
                    @if ($foto)
                        <div class="photo">
                            <img src="{{ storage_path('app/' . $foto) }}" alt="Foto Kegiatan {{ $i }}">
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        <div class="section">
            <div class="section-title">Materi Power Point</div>
            <div class="content video-link">
                @if ($program->presentasi)
                    <a href="{{ $program->presentasi }}">{{ $program->presentasi }}</a>
                @else
                    <p style="text-align: left">Tidak tersedia.</p>
                @endif
            </div>
        </div>


        <div class="section">
            <div class="section-title">Video Dokumentasi</div>
            <div class="content video-link">
                @if ($program->video)
                    <a href="{{ $program->video }}">{{ $program->video }}</a>
                @else
                    <p style="text-align: left">Tidak tersedia.</p>
                @endif
            </div>
        </div>

        <div class="signature">
            <p>Bekasi, {{ \Carbon\Carbon::parse($program->created_at)->translatedFormat('d F Y') }}</p>
            <p><strong>{{ $program->user->name ?? 'Nama Peserta' }}</strong></p>
        </div>
    </div>
</body>
</html>
