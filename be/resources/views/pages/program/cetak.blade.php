<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Document - {{ $program->judul_kegiatan }}</title>
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
            <h1>Activity Program Document</h1>
            <small>Bekasi City Smart Ecosystem Competency Activity 2025</small>
        </div>

        <div class="logo-center">
            @if ($program->logo_komunitas)
                <img src="{{ storage_path('app/public/' . $program->logo_komunitas) }}" alt="Community Logo" class="logo">
            @endif
        </div>

        <div class="section">
            <div class="section-title">Community Profile</div>
            <table class="info-table">
                <tr><td class="label">Name</td><td>: {{ $program->user->name ?? '-' }}</td></tr>
                <tr><td class="label">Email</td><td>: {{ $program->user->email ?? '-' }}</td></tr>
                <tr><td class="label">Phone No.</td><td>: {{ $program->user->telp ?? '-' }}</td></tr>
                <tr><td class="label">Community Name</td><td>: {{ $program->user->nama_komunitas ?? '-' }}</td></tr>
                <tr><td class="label">Social Media</td><td>: {{ $program->user->medsos ?? '-' }}</td></tr>
                <tr><td class="label">Address</td><td>: {{ $program->user->alamat ?? '-' }}</td></tr>
                <tr><td class="label">District</td><td>: {{ optional($program->user->kecamatan)->nama ?? '-' }}</td></tr>
                <tr><td class="label">Subdistrict</td><td>: {{ optional($program->user->kelurahan)->nama ?? '-' }}</td></tr>
            </table>
        </div>

         <div class="section">
            <div class="section-title">Program Dimension</div>
            <table class="info-table">
                 <div class="content">{{ $program->portofolio->nama ?? '-' }}</div>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Supporting Documents</div>
            <table class="info-table">
                <tr><td class="label">Person-in-Charge ID Card</td><td>: {{ $program->user->foto_pj ? 'Available' : 'Not available' }}</td></tr>
                <tr><td class="label">Statement Letter</td><td>: {{ $program->user->surat_pernyataan ? 'Available' : 'Not available' }}</td></tr>
                <tr><td class="label">Community Profile</td><td>: {{ $program->user->profil_komunitas ? 'Available' : 'Not available' }}</td></tr>
                <tr><td class="label">PowerPoint Document </td><td>: {{ $program->presentasi ? 'Available' : 'Not available' }}</td></tr>
                <tr><td class="label">Competition Video </td><td>: {{ $program->video ? 'Available' : 'Not available' }}</td></tr>
            </table>
        </div>

        {{-- Program Information --}}
        <div class="section">
            <div class="section-title">Activity Title</div>
            <div class="content">{{ $program->judul_kegiatan }}</div>
        </div>

        <div class="section">
            <div class="section-title">Activity Type</div>
            <div class="content">{{ ucfirst($program->jenis_kegiatan) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Background</div>
            <div class="content">{{ strip_tags($program->latar_belakang) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Activity Description</div>
            <div class="content">{{ strip_tags($program->deskripsi_kegiatan) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Activity Outcome</div>
            <div class="content">{{ strip_tags($program->hasil) }}</div>
        </div>

        <div class="section">
            <div class="section-title">Activity Photos</div>
            <div class="grid-photos">
                @for ($i = 1; $i <= 5; $i++)
                    @php $foto = $program->{'foto_kegiatan_'.$i}; @endphp
                    @if ($foto)
                        <div class="photo">
                            <img src="{{ storage_path('app/' . $foto) }}" alt="Activity Photo {{ $i }}">
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        <div class="section">
            <div class="section-title">PowerPoint Material</div>
            <div class="content video-link">
                @if ($program->presentasi)
                    <a href="{{ $program->presentasi }}">{{ $program->presentasi }}</a>
                @else
                    <p style="text-align: left">Not available.</p>
                @endif
            </div>
        </div>


        <div class="section">
            <div class="section-title">Documentation Video</div>
            <div class="content video-link">
                @if ($program->video)
                    <a href="{{ $program->video }}">{{ $program->video }}</a>
                @else
                    <p style="text-align: left">Not available.</p>
                @endif
            </div>
        </div>

        <div class="signature">
            <p>Bekasi, {{ \Carbon\Carbon::parse($program->created_at)->translatedFormat('d F Y') }}</p>
            <p><strong>{{ $program->user->name ?? 'Participant Name' }}</strong></p>
        </div>
    </div>
</body>
</html>
