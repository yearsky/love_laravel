<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $getListStok = $this->barangModel->getStokBarang();

        return view('dashboard', compact('getListStok'));
    }
}
