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
        setlocale(LC_TIME, 'id_ID');
        
        $currentYear = $value['currentYear'];
        $currentMonth = $value['currentMonth'];
        
        $year = substr($currentYear, 0, 4);
        $month = substr($currentMonth, -2);
        
        if ($month > 12) {
            $month = $month % 12;
            if ($month == 0) {
                $currentYear -= 1;
            }
        }
        
        $formattedMonth = strftime('%B', strtotime("$currentYear-$month-01"));
        @endphp
        <tr>
            <td>{{ $formattedMonth }}  {{ $currentYear }}</td>
            <td>{{ $value['x'] }}</td>
            <td>{{ $value['y'] }}</td>
            <td>{{ $value['forecasting'] }}</td>
        </tr>
        @endforeach


    </tbody>
</table>