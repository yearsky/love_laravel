<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KategoriModel extends Model {
    use HasFactory;

    public function getListCategory() {
        $query = DB::select('SELECT * FROM kategori');

        return $query;
    }

    public function checkCategory($category) {
        $query = DB::select('select * from kategori where nama_kategori = ? LIMIT 1', [$category]);

        return $query;
    }

    public function insertCategory($category) {
        $query = DB::table('kategori')->insertGetId($category);

        return $query;
    }
}
