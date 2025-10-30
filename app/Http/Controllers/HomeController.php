<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class HomeController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->paginate(1);

        return view('home.index', compact('kegiatans'));
    }

    public function show(string $id)
    {
        $id = decrypt($id);
        $data['kegiatan'] = Kegiatan::where('id', $id)->first(); 
        
        return view('home.show', $data);
    }
}
