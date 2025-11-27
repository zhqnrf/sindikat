<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function mahasiswa_index(Request $request)
    {
        return view('progres.mahasiswa.index');
    }

    public function penelitian_index(Request $request)
    {
        return view('progres.penelitian.index');
    }
}