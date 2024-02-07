@props(['data' => []])

<table id="dataTable" class="dataTable stripe hover row-border cell-border">
    <thead>
        <tr>
            <th>Tahun</th>
            <th>X</th>
            <th>Y</th>
            <th>FX</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
        @php
        $date = \Carbon\Carbon::create($value['currentYear'], $value['currentMonth']);
        @endphp
        <tr>
            <td>{{ $date->translatedFormat('F Y') }}</td>
            <td>{{$value['x']}}</td>
            <td>{{$value['y']}}</td>
            <td>{{$value['forecasting']}}</td>
        </tr>
        @endforeach

    </tbody>
</table>