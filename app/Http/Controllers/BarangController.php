<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->barangModel = new BarangModel();
        $this->appHelper = new AppHelper();
    }

    public function index()
    {
        try {
            $params = [];
            if (!empty(request())) {
                $namaBarang = !request('nama_barang') ? '' : request('nama_barang');
                $kategori = !request('kategori') ? '' : request('kategori');
                $tanggalMasuk = !request('tanggal_masuk') ? '' : request('tanggal_masuk');

                $params['nama_barang'] = $namaBarang;
                $params['kategori'] = $kategori;
                $params['tanggal_masuk'] = $tanggalMasuk;
            }

            $category = $this->kategoriModel->getListCategory();

            $listBarang = $this->barangModel->getListBarang($params);

            $barangMasuk = $this->barangModel->getStokMasuk();
            $barangKeluar = $this->barangModel->getStokKeluar();

            return view('barang.list', compact('category', 'listBarang', 'barangMasuk', 'barangKeluar'));
        } catch (\Throwable $th) {
        }
    }

    public function edit($id)
    {
        $barang = $this->barangModel->getDetailBarang($id);
        // print_r($barang);
        // die;
        $historyBarang = $this->barangModel->getHistoryBarang($barang->id_barang);

        if (empty($barang)) {
            return Redirect::route('barang')->with('errors', 'Data Barang Tidak Tersedia!');
        }

        return view('barang.edit', compact('barang', 'historyBarang'));
    }

    public function show($id)
    {

        $barang = $this->barangModel->getDetailBarang($id);

        $historyBarang = $this->barangModel->getHistoryBarang($barang->id_barang);

        if (empty($barang)) {
            return Redirect::route('barang')->with('errors', 'Data Barang Tidak Tersedia!');
        }

        return view('barang.detailBarang', compact('barang', 'historyBarang'));
    }

    public function createOrUpdate(Request $request): RedirectResponse
    {
        try {
            $postData = $request->except('_token');

            $historyBarang = [];

            if (empty($postData)) {
                // No data to process
                return Redirect::route('barang')->with('error', 'No data provided.');
            }

            $namaBarang = $postData['nama_barang'];
            $partCategory = explode("-", $namaBarang);
            $categoryName = isset($postData['kategori']) ? $postData['kategori'] : strtoupper(trim($partCategory[0]));

            // Check category exists
            $getCategory = $this->kategoriModel->checkCategory($categoryName);
            $categoryId = '';

            if (empty($getCategory)) {
                // Insert new category
                $kategori['nama_kategori'] = $categoryName;
                $categoryId = $this->kategoriModel->insertCategory($kategori);
            }
            $checkBarang = $this->barangModel->checkBarangExists($namaBarang);

            $barang = [
                'harga_beli' => (float) $postData['harga_beli'],
                'harga_jual' => (float) $postData['harga_jual'],
                'nama_barang' => implode(" ", $partCategory),
                'id_kategori' => empty($categoryId) ? $getCategory[0]->id_kategori : $categoryId,
                'deskripsi' => $postData['deskripsi'],
                'updated_at' => $this->appHelper->currentDate(),
            ];
            $historyBarang = [
                'stok_masuk' => $postData['stok_masuk'] ?? '',
                'created_at' => $postData['tanggal_masuk'] ?? $this->appHelper->currentDate(),
                'updated_at' => $this->appHelper->currentDate(),
            ];

            if (empty($checkBarang)) {
                // Insert new record
                $barang['created_at'] = $this->appHelper->currentDate();
                $this->barangModel->createBarang($barang, $historyBarang);
            } else {
                // Update existing record
                $barang['id_barang'] = $checkBarang->id_barang;
                $historyBarang['id_barang'] = $barang['id_barang'];
                $this->barangModel->updateBarang($barang);

                if ($postData['action'] == 'create') {
                    $this->barangModel->insertStok($historyBarang);
                }

                $stok = [];
                if (isset($postData['stok'])) {

                    foreach ($postData['stok'] as $value) {
                        $itemStok = json_decode(urldecode($value), true);
                        if (is_array($itemStok)) {
                            if ($itemStok['stok_keluar'] > 0) {
                                array_push($stok, $itemStok);
                            }
                        }
                    }
                }

                foreach ($stok as $value) {
                    $getCurrentStok = $this->barangModel->getHistoryBarangById($value['id_history'])[0];

                    if ($getCurrentStok->stok_keluar > 0) {
                        $items['stok_keluar'] =  $getCurrentStok->stok_keluar + $value['stok_keluar'];
                    } else {
                        $items['stok_keluar'] = $value['stok_keluar'];
                    }
                    $items['updated_at'] = $this->appHelper->currentDate();

                    $updateStok = $this->barangModel->updateStok($value['id_history'], $items);
                    if (!$updateStok) {
                        return Redirect::route('barang')->with('error', 'Error: Gagal Update Data');
                    }
                }
            }

            $text = $postData['action'] == 'update' ? 'update' : 'menambahkan';

            return Redirect::route('barang')->with('success', 'Sukses ' . $text . ' barang!');
        } catch (\Exception $ex) {
            return Redirect::route('barang')->with('error', 'Error: ' . $ex->getMessage());
        }
    }

    public function destroy($id_barang)
    {
        try {
            $deleteData = $this->barangModel->destroyBarang($id_barang);

            return Redirect::route('barang')->with('success', 'Sukses menghapus barang!');
        } catch (\Exception $ex) {
            return Redirect::route('barang')->with('error', 'Error: ' . $ex->getMessage());
        }
    }
}
