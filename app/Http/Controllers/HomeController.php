<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class HomeController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->first();

        return view('home.index', compact('kegiatans'));
    }
}
