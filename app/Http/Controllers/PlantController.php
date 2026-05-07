<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of plants.
     */
    public function index()
    {
        return view('plants.index');
    }
}
