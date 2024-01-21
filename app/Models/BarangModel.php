<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangModel extends Model {
    use HasFactory;

    public function getListBarang() {
        try {

            $query = DB::table('barang as a')
                ->leftJoin('history_barang as b', 'a.id_barang', '=', 'b.id_barang')
                ->select(
                    'a.id_barang',
                    'a.nama_barang',
                    'a.harga_jual',
                    'a.harga_beli',
                    DB::raw('SUM(b.stok_masuk - COALESCE(b.stok_keluar, 0)) as persediaan_barang'),
                    'b.created_at',
                    'b.updated_at'
                )
                ->groupBy('a.nama_barang')->get();

            return $query;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }

    public function checkBarangExists($barang) {
        $query = DB::select('SELECT * FROM barang WHERE nama_barang LIKE ?', ['%' . $barang . '%']);
        $results = reset($query);
        return $results;
    }

    public function getDetailBarang($id) {
        $query = DB::table('barang')
            ->leftJoin('kategori', 'barang.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('history_barang', 'barang.id_barang', '=', 'history_barang.id_barang')
            ->where('barang.id_barang', '=', $id)
            ->first();

        return $query;
    }

    public function getHistoryBarang($id_barang) {
        $query = DB::select('SELECT * FROM history_barang WHERE id_barang = ? order by updated_at desc', [$id_barang]);

        return $query;
    }

    public function createBarang($barang, $historyBarang) {

        if (!empty($barang)) {
            $insertBarang = DB::table('barang')->insertGetId($barang);
        }

        if (!empty($historyBarang)) {
            $historyBarang['id_barang'] = isset($historyBarang['id_barang']) ? $historyBarang['id_barang'] : $insertBarang;
            $insertHistory = DB::table('history_barang')->insert($historyBarang);
        }

        return 1;
    }

    public function updateBarang($barang, $historyBarang) {
        $id_barang = $barang['id_barang'];

        if (!empty($barang)) {
            $updateBarang = DB::table('barang')->where('id_barang', $id_barang)->update($barang);
        }

        if (!empty($historyBarang)) {
            $historyBarang['id_barang'] = $id_barang;
            $updateHistoryBarang =  DB::table('history_barang')->insert($historyBarang);
        }
    }

    public function destroyBarang($id_barang) {
        $deleteBarang = DB::table('barang')->where('id_barang', $id_barang)->delete();
        $deleteHistoryBarang = DB::table('history_barang')->where('id_barang', $id_barang)->delete();
    }
}
