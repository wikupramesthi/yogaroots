<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        td {
            vertical-align: top;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center; margin-bottom: 5px;">📊 User Data Report</h3>
    <p style="text-align: center; margin: 0;">
        Printed on: {{ now()->translatedFormat('d F Y') }}
    </p>

    {{-- Info filter --}}
    @if (! empty($filters['start_date']) || ! empty($filters['end_date']) || ! empty($filters['tahun']))
        <p style="margin-top: 10px; font-size: 11px;">
            <strong>Filter:</strong>
            @if (! empty($filters['tahun']))
                Year <u>{{ $filters['tahun'] }}</u>
            @endif
            @if (! empty($filters['start_date']))
                | From <u>{{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}</u>
            @endif
            @if (! empty($filters['end_date']))
                | To <u>{{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}</u>
            @endif
        </p>
    @endif


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengguna as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->telp ?? '-' }}</td>
                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
