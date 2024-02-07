@props(['data' => [],'lastData' => []])

@php
$totalMAD = 0;
$totalMAPE = 0;
$totalMSE = 0;
$dateForecast = \Carbon\Carbon::create($lastData['currentYear'], $lastData['currentMonth']);
@endphp

<table id="dataTable" class="dataTable stripe hover row-border cell-border">
    <thead>
        <tr>
            <th>Tahun</th>
            <th>X</th>
            <th>Y</th>
            <th>X*Y</th>
            <th>X
                <sup>2</sup>
            </th>
            <th>FX</th>
            <th>MAD</th>
            <th>MSE</th>
            <th>MAPE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
        @php
        $yValues = $value['a'] + ($value['b'] * $value['x']);
        $mad = abs($value['y'] - $yValues);
        $mape = abs($mad) / 8;
        $mse = $value['x'] - pow($value['y'],2) / 8;
        $totalMAD += $mad;
        $totalMAPE += $mape;
        $totalMSE += $mse;
        $date = \Carbon\Carbon::create($value['currentYear'], $value['currentMonth']);
        @endphp
        <tr>
            <td>{{ $date->translatedFormat('F Y') }}</td>
            <td>{{$value['x']}}</td>
            <td>{{$value['jumlahy']}}</td>
            <td>{{$value['jumlahxy']}}</td>
            <td>{{$value['jumlahx2']}}</td>
            <td>{{$yValues}}</td>
            <td>{{$mad}}</td>
            <td>{{$mse}}</td>
            <td>{{$mape}}</td>
        </tr>
        @endforeach

    </tbody>
</table>

<div class="grid grid-cols-2 gap-5 w-full mt-8 gap-y-10">
    <div class="p-5 border-2 border-e-2  rounded-md  border-green-400 shadow-xl">
        <div class="flex justify-between items-center">
            <div class="text-4xl">📌</div>
            <div class="flex-col text-center justify-center gap-y-5">
                <div class="text-xl font-semibold">MAPE</div>
                <div class="text-lg">{{$totalMAPE}}</div>
            </div>
            <div class="flex-col text-center justify-center gap-y-5">
                <div class="text-xl font-semibold">MAD</div>
                <div class="text-lg">{{$totalMAD}}</div>
            </div>
            <div class="flex-col text-center justify-center gap-y-5">
                <div class="text-xl font-semibold">MSE</div>
                <div class="text-lg">{{$totalMSE}}</div>
            </div>

        </div>
    </div>
    <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400 shadow-xl">
        <div class="text-4xl">📊</div>
        <div class="flex justify-center -mt-12">
            <div class="flex flex-col justify-center">
                <div class="text-xl font-semibold">Forecasting</div>
                <div>{{ $dateForecast->translatedFormat('F Y') }} : {{$lastData['forecasting']}}</div>
            </div>
        </div>
    </div>
</div>