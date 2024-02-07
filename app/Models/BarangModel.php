<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangModel extends Model
{
    use HasFactory;

    public function getListBarang($params = [])
    {
        try {

            $query = DB::table('barang as a')
                ->leftJoin('history_barang as b', 'a.id_barang', '=', 'b.id_barang')
                ->leftJoin('kategori as c', 'a.id_kategori', '=', 'c.id_kategori')
                ->select(
                    'a.id_barang',
                    'a.nama_barang',
                    'a.harga_jual',
                    'a.harga_beli',
                    DB::raw('SUM(b.stok_masuk - COALESCE(b.stok_keluar, 0)) as persediaan_barang'),
                    'b.created_at',
                    'b.updated_at'
                )->groupBy('a.nama_barang');
            if (!empty($params)) {
                if (!empty($params['nama_barang'])) {
                    $query->where('nama_barang', 'like', '%' . $params['nama_barang'] . '%');
                }

                if (!empty($params['kategori'])) {
                    $query->where('a.id_kategori', '=', $params['kategori']);
                }

                if (!empty($params['tanggal_masuk'])) {
                    $query->whereRaw('DATE(b.created_at) = DATE("' . $params["tanggal_masuk"] . '")');
                }
            }
            $result = $query->get();

            return $result;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }

    public function getStokMasuk()
    {
        $query = DB::table('barang as a')
            ->leftJoin('history_barang as b', 'a.id_barang', '=', 'b.id_barang')
            ->leftJoin('kategori as c', 'a.id_kategori', '=', 'c.id_kategori')
            ->select(
                'a.nama_barang',
                'a.harga_jual',
                'a.harga_beli',
                'b.stok_masuk',
                'b.stok_keluar',
                'b.created_at',
                'b.updated_at'
            )->where('stok_masuk', '>', '0');

        $result = $query->get();

        return $result;
    }

    public function getStokKeluar()
    {
        $query = DB::table('barang as a')
            ->leftJoin('history_barang as b', 'a.id_barang', '=', 'b.id_barang')
            ->leftJoin('kategori as c', 'a.id_kategori', '=', 'c.id_kategori')
            ->select(
                'a.nama_barang',
                'a.harga_jual',
                'a.harga_beli',
                'b.stok_masuk',
                'b.stok_keluar',
                'b.created_at',
                'b.updated_at'
            )->where('stok_keluar', '>', '0')
            ->orderBy('b.updated_at', 'desc');

        $result = $query->get();

        return $result;
    }

    public function checkBarangExists($barang)
    {
        $query = DB::select('SELECT * FROM barang WHERE nama_barang LIKE ?', ['%' . $barang . '%']);
        $results = reset($query);
        return $results;
    }

    public function getHistoryBarangById($id)
    {
        $query = DB::select('SELECT * FROM history_barang WHERE id_history = ? ', [$id]);

        return $query;
    }

    public function getDetailBarang($id)
    {
        $query = DB::table('barang')
            ->leftJoin('kategori', 'barang.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('history_barang', 'barang.id_barang', '=', 'history_barang.id_barang')
            ->where('barang.id_barang', '=', $id)
            ->first();

        return $query;
    }

    public function getHistoryBarang($id_barang)
    {
        $query = DB::select('SELECT * FROM history_barang WHERE id_barang = ? order by updated_at desc', [$id_barang]);

        return $query;
    }

    public function createBarang($barang, $historyBarang)
    {

        if (!empty($barang)) {
            $insertBarang = DB::table('barang')->insertGetId($barang);
        }

        if (!empty($historyBarang)) {
            $historyBarang['id_barang'] = isset($historyBarang['id_barang']) ? $historyBarang['id_barang'] : $insertBarang;
            $insertHistory = DB::table('history_barang')->insert($historyBarang);
        }

        return 1;
    }

    public function updateBarang($barang)
    {
        $id_barang = $barang['id_barang'];

        if (!empty($barang)) {
            $updateBarang = DB::table('barang')->where('id_barang', $id_barang)->update($barang);
        }
    }

    public function insertStok($stok)
    {
        if (!empty($stok)) {
            $insertStok = DB::table('history_barang')->insertGetId($stok);
        }
    }

    public function updateStok($stokId, $stok)
    {
        $updateStok = DB::table('history_barang')->where('id_history', $stokId)->update($stok);

        return $updateStok;
    }

    public function destroyBarang($id_barang)
    {
        $deleteBarang = DB::table('barang')->where('id_barang', $id_barang)->delete();
        $deleteHistoryBarang = DB::table('history_barang')->where('id_barang', $id_barang)->delete();
    }

    public function getStokBarang()
    {
        $query = DB::select('SELECT b.nama_barang, YEAR(a.created_at) AS tahun_masuk, SUM(stok_masuk) AS stok_masuk, SUM(stok_keluar) AS stok_keluar
        FROM history_barang a
        LEFT JOIN barang b ON a.id_barang = b.id_barang
        GROUP BY YEAR(a.created_at), a.id_barang ORDER BY tahun_masuk');

        return $query;
    }
}
