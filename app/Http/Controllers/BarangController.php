<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return View('barang.list');
    }
}
