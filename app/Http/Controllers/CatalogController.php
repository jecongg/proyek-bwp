<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function catalog()
    {
        return view('catalog');
    }

    public function about()
    {
        return view('about');
    }
}
