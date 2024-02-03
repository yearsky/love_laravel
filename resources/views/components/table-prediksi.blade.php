@props(['data' => []])

<table id="dataTable" class="dataTable stripe hover row-border cell-border">
    <thead>
        <tr>
            <th>Tahun</th>
            <th>X</th>
            <th>FX</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{$value['currentYear']}}</td>
            <td>{{$value['x']}}</td>
            <td>{{$value['forecasting']}}</td>
        </tr>
        @endforeach

    </tbody>
</table>