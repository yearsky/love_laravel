@props(['data' => []])

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
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
        @php
        $yValues = $value['a'] + ($value['b'] * $value['x']);
        @endphp
        <tr>
            <td>{{$value['currentYear']}}</td>
            <td>{{$value['x']}}</td>
            <td>{{$value['jumlahy']}}</td>
            <td>{{$value['jumlahxy']}}</td>
            <td>{{$value['jumlahx2']}}</td>
            <td>{{$yValues}}</td>
        </tr>
        @endforeach

    </tbody>
</table>