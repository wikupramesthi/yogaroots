<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenggunaExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $request;

    /**
     * Constructor to receive filters.
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Data to be exported to Excel.
     */
    public function view(): View
    {
        $query = User::with([
            'userPackages.package'
        ])
        ->role('user');

        // Year filter
        if ($this->request->filled('tahun')) {
            $query->whereYear(
                'created_at',
                $this->request->tahun
            );
        }

        // Start Date filter
        if ($this->request->filled('start_date')) {
            $query->whereDate(
                'created_at',
                '>=',
                $this->request->start_date
            );
        }

        // End Date filter
        if ($this->request->filled('end_date')) {
            $query->whereDate(
                'created_at',
                '<=',
                $this->request->end_date
            );
        }

        $pengguna = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.dashboard.exports', [
            'pengguna' => $pengguna,

            'filters' => [
                'tahun'      => $this->request->tahun,
                'start_date' => $this->request->start_date,
                'end_date'   => $this->request->end_date,
            ],
        ]);
    }

    /**
     * Excel sheet name.
     */
    public function title(): string
    {
        return 'User Data';
    }
}