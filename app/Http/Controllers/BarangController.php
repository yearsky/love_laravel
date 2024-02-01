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

class BarangController extends Controller {
    public function __construct() {
        $this->kategoriModel = new KategoriModel();
        $this->barangModel = new BarangModel();
        $this->appHelper = new AppHelper();
    }

    public function index() {
        try {

            $category = $this->kategoriModel->getListCategory();

            $listBarang = $this->barangModel->getListBarang();

            return view('barang.list', compact('category', 'listBarang'));
        } catch (\Throwable $th) {
        }
    }

    public function edit($id) {
        $barang = $this->barangModel->getDetailBarang($id);
        // print_r($barang);
        // die;
        $historyBarang = $this->barangModel->getHistoryBarang($barang->id_barang);

        if (empty($barang)) {
            return Redirect::route('barang')->with('errors', 'Data Barang Tidak Tersedia!');
        }

        return view('barang.edit', compact('barang', 'historyBarang'));
    }

    public function show($id): View|RedirectResponse {

        $barang = $this->barangModel->getDetailBarang($id);

        $historyBarang = $this->barangModel->getHistoryBarang($barang->id_barang);

        if (empty($barang)) {
            return Redirect::route('barang')->with('errors', 'Data Barang Tidak Tersedia!');
        }

        return view('barang.detailBarang', compact('barang', 'historyBarang'));
    }

    public function createOrUpdate(Request $request): RedirectResponse {
        try {
            $postData = $request->except('_token');

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

            // Check if barang exists
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
                'stok_masuk' => $postData['stok_masuk'],
                'created_at' => $postData['tanggal_masuk'],
                'updated_at' => $postData['tanggal_masuk'],
            ];

            if (empty($checkBarang)) {
                // Insert new record
                $barang['created_at'] = $this->appHelper->currentDate();
                $this->barangModel->createBarang($barang, $historyBarang);
            } else {
                // Update existing record
                $barang['id_barang'] = $checkBarang->id_barang;
                $this->barangModel->updateBarang($barang, $historyBarang);
            }

            $text = $postData['action'] == 'update' ? 'update' : 'menambahkan';

            return Redirect::route('barang')->with('success', 'Sukses ' . $text . ' barang!');
        } catch (\Exception $ex) {
            return Redirect::route('barang')->with('error', 'Error: ' . $ex->getMessage());
        }
    }

    public function destroy($id_barang) {
        try {
            $deleteData = $this->barangModel->destroyBarang($id_barang);

            return Redirect::route('barang')->with('success', 'Sukses menghapus barang!');
        } catch (\Exception $ex) {
            return Redirect::route('barang')->with('error', 'Error: ' . $ex->getMessage());
        }
    }
}
