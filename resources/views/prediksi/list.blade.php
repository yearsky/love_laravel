<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Prediksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Informasi Prediksi Barang') }}
                            </h2>

                        </header>

                    </section>
                </div>
                <form method="post" action="{{ route('prediksi.olah') }}" class="flex flex-col items-center max-w-full">
                    @csrf
                    <div class="flex gap-x-5 justify-center w-full">
                        <div class="mt-10">
                            <x-input-label for="bulan" value="{{ __('Bulan') }}" />

                            <select name="bulan" class="w-full border border-gray-400 rounded-md">
                                @foreach ($months as $key => $value)

                                <option value="{{$key}}">{{$value}}</option>

                                @endforeach
                            </select>

                        </div>
                        <div class="mt-10">
                            <x-input-label for="tahun" value="{{ __('Tahun') }}" />

                            <select name="tahun" class="w-full border border-gray-400 rounded-md">
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>

                        </div>
                    </div>
                    <x-button-primary class="mt-5">Prediksi</x-button-primary>
                </form>
            </div>
        </div>
    </div>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Data Prediksi Barang') }}
                            </h2>

                        </header>

                    </section>
                </div>
                <div class="mt-10 max-w-full">
                    <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400 shadow-md">

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
                                <tr>
                                    <td>2023</td>
                                    <td>-4</td>
                                    <td>4</td>
                                    <td>16</td>
                                    <td>16</td>
                                    <td>
                                        3.641231
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex max-w-full mt-10">
                    <canvas id="display-chart" class="max-w-3xl max-h-96"></canvas>
                    <div class="flex flex-col w-full mt-8 gap-y-10">
                        <div class="p-5 border-2 border-e-2  rounded-md  border-green-400 shadow-xl">
                            <div class="flex justify-between items-center">
                                <div class="text-4xl">📌</div>
                                <div class="flex-col text-center justify-center gap-y-5">
                                    <div class="text-xl font-semibold">MAPE</div>
                                    <div class="text-lg">23.0</div>
                                </div>
                                <div class="flex-col text-center justify-center gap-y-5">
                                    <div class="text-xl font-semibold">MAD</div>
                                    <div class="text-lg">114.6</div>
                                </div>
                                <div class="flex-col text-center justify-center gap-y-5">
                                    <div class="text-xl font-semibold">MSE</div>
                                    <div class="text-lg">22,319</div>
                                </div>

                            </div>
                        </div>
                        <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400 shadow-xl">
                            <div class="text-4xl">📊</div>
                            <div class="flex justify-center -mt-12">
                                <div class="flex flex-col justify-center">
                                    <div class="text-xl font-semibold">Forecasting</div>
                                    <div>Juni: 359.123</div>
                                    <div>Juli: 213.12</div>
                                    <div>Agustus: 312.13</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br />
            </div>
        </div>
    </div>

    @section('script')
    <script>
        $(function() {
            const data = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                        label: 'Aktual',
                        data: [65, 59, 80, 81, 26, 55, 40],
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                    },
                    {
                        label: 'Prediksi',
                        data: [45, 30, 50, 61, 46, 85, 40],
                        fill: false,
                        borderColor: 'rgb(54, 162, 235)',
                    }
                ]
            };
            const config = {
                type: 'line',
                data: data,
            };
            const chart = new Chart(document.getElementById('display-chart'), config);
        })
    </script>
    @endsection
</x-app-layout>