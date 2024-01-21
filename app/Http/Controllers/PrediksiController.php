<?php

namespace App\Http\Controllers;

use App\Models\PrediksiModels;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PrediksiController extends Controller {
    public function __construct() {
        $this->model = new PrediksiModels();
    }

    public function index() {
        $months = [];
        $months = array_map(
            function ($month) {
                return Carbon::create(null, $month)->translatedFormat('F');
            },
            array_combine(range(1, 12), range(1, 12))
        );

        return View('prediksi.list', compact('months'));
    }

    public function olah(Request $request) {
        try {
            $postData = $request->post();

            $tahun = intval($postData['tahun']);
            $bulan = intval($postData['bulan']);

            $dataPrediksi = $this->model->getDataPrediksi();

            $tahun = intval($postData['tahun']);
            $bulan = intval($postData['bulan']);

            $x = array_filter(range(-4, 4), function ($value) {
                return $value !== 0;
            });
            $lastX = end($x); //get last value of x

            $jumlahy = 0;
            $jumlahx = 0;
            $jumlahxy = 0;
            $jumlahx2 = 0;

            foreach ($dataPrediksi as $key => $value) :

                $x_values = array_shift($x);

                $jumlahxy += ($value->persediaan_barang) * $x_values;
                $jumlahy += $value->persediaan_barang;
                $jumlahx += $x_values;
                $jumlahx2 += pow($x_values, 2);

            endforeach;

            echo "jumlah y: " . $jumlahy . "</br>";
            echo "jumlah x: " . $jumlahx . "</br>";
            echo "jumlah xy: " . $jumlahxy . "</br>";
            echo "jumlah x2: " . $jumlahx2 . "</br>";

            $tahun_lama = $value->tahun;
            $bulan_lama = $value->bulan;
            $jarak = (($tahun - $tahun_lama) * 12) + ($bulan - $bulan_lama);
            $waktu_x = $jarak + $lastX;

            echo "tahun lama: " . $tahun_lama . "</br>";
            echo "bulan lama: " . $bulan_lama . "</br>";
            echo "tahun baru: " . $tahun . "</br>";
            echo "bulan baru: " . $bulan . "</br>";

            echo "jarak: " . $jarak . "</br>";
            echo "waktu(X): " . $waktu_x . "</br>";

            $b = ($waktu_x * ($jumlahxy) - ($jumlahx) * ($jumlahy)) / ($waktu_x * ($jumlahx2) - pow($jumlahx, 2));
            echo "nilai b: " . $b . "</br>";

            $a = $jumlahy / 8;
            echo "nilai a: " . $a . "</br>";

            $Y = $a + ($b * $waktu_x);
            echo "nilai y: " . $Y . "</br>";
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }
}
