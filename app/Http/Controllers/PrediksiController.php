<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PrediksiModels;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class PrediksiController extends Controller {
    public function __construct() {
        $this->model = new PrediksiModels();
        $this->barangModel = new BarangModel();
    }

    public function index(Request $request) {

        $months = [];
        $months = array_map(
            function ($month) {
                return Carbon::create(null, $month)->translatedFormat('F');
            },
            array_combine(range(1, 12), range(1, 12))
        );

        $listBarang = $this->barangModel->getListBarang();

        $getRequestData = $request->except('_token');

        if (!empty($getRequestData)) {
            $tahun = $getRequestData['tahun'];
            $barang = $getRequestData['produk'];
            $bulan = $getRequestData['bulan'];

            $results = $this->doProcess($barang, $tahun, $bulan);
            $results = array_merge($getRequestData, $results);
            // print_r($results);
            // die;
            return Redirect::route('prediksi')->with(['success' => 'Berhasil Generate Data Prediksi', 'data' => $results]);
        }


        return View('prediksi.list', compact('months', 'listBarang'));
    }

    public function doProcess($barang, $tahun, $bulan) {
        try {
            $tahun = intval($tahun);
            $bulan = intval($bulan);

            $dataPrediksi = $this->model->getDataPrediksi($barang);

            $rangeX = array_filter(range(-4, 4), fn ($value) => $value !== 0);
            $lastX = end($rangeX);

            $jumlahy = $jumlahx = $jumlahxy = $jumlahx2 = 0;

            $currentData = [];
            $lastData = end($dataPrediksi);

            foreach ($dataPrediksi as $key => $value) {
                $xValue = array_shift($rangeX);

                $jumlahxy += ($value->persediaan_barang) * $xValue;
                $jumlahy += $value->persediaan_barang;
                $jumlahx += $xValue;
                $jumlahx2 += pow($xValue, 2);


                $existingData = [
                    'currentYear' => $value->tahun,
                    'currentMonth' => $value->bulan,
                    'jumlahxy' => $jumlahxy,
                    'jumlahy' => $jumlahy,
                    'jumlahx' => $jumlahx,
                    'jumlahx2' => $jumlahx2,
                    'x' => $xValue
                ];

                array_push($currentData, $existingData);

                $lastValue = $value->persediaan_barang;
            }

            $tahunLama = $value->tahun;
            $bulanLama = $value->bulan;

            // Hitung waktu untuk prediksi
            $jarak = (($tahun - $tahunLama) * 12) + ($bulan - $bulanLama);
            $lastX = $jarak + $lastX; // rentan waktu

            $rentanWaktu = $jarak;

            $a = $jumlahy / count($dataPrediksi);

            $b = ($xValue * $jumlahxy - $jumlahx * $jumlahy) / ($xValue * $jumlahx2 - pow($jumlahx, 2));
            $results = [];
            for ($i = 0; $i < $rentanWaktu; $i++) {
                $xValue = $lastX - $i;

                $jumlahxy += $lastValue * $xValue;
                $jumlahy += $lastValue;
                $jumlahx += $xValue;
                $jumlahx2 += pow($xValue, 2);

                $Y = $a + ($b * $xValue);

                $results[] = [
                    'tahun' => $tahun,
                    'x' => $bulan - $i,
                    'forecasting' => $Y,
                    'a' => $a,
                    'b' => $b,
                    'gap' => $xValue
                ];
            }

            foreach ($currentData as &$data) {
                $data['a'] = $a;
                $data['b'] = $b;
            }


            $defaultData['defaultData'] = $currentData;
            $resultsData['forecastData'] = $results;

            $xValues = array_column($resultsData['forecastData'], 'x');

            array_multisort($xValues, SORT_ASC, $resultsData['forecastData']);

            $finalResults = array_merge($defaultData, $resultsData);

            return $finalResults;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }
}
