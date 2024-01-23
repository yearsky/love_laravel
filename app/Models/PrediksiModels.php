<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrediksiModels extends Model {
    use HasFactory;

    public function getDataPrediksi($id_barang = null) {

        $query = DB::table('history_barang')
            ->select(DB::raw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, SUM(stok_masuk - stok_keluar) as persediaan_barang'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan');

        if (!empty($id_barang)) {
            $query->where('id_barang', $id_barang);
        }
        $result = $query->get();

        return $result;
    }
}
