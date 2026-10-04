<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Menampilkan halaman default / landing page
     */
    public function index()
    {
         if (auth()->check()) {
        return redirect('/backend/dashboard');
    }

        // Halaman publik ada di aplikasi frontend, backend hanya melayani
        // admin panel & auth. Jadi arahkan tamu ke form login.
        return redirect()->route('login');
    }

}
