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

                <form method="get" action="{{ route('prediksi') }}" class="flex flex-col items-center max-w-full">
                    @csrf
                    <div class="flex gap-x-5 justify-center w-full">
                        <div class="mt-10">
                            <x-input-label for="Produk" value="{{ __('Produk') }}" />

                            <select name="produk" class="w-full border border-gray-400 rounded-md">
                                @foreach ($listBarang as $key => $value)

                                <option value="{{$value->id_barang}}" {{ !empty(session('data')['produk']) ? session('data')['produk'] == $value->id_barang ? 'selected' : '' : ''  }}>{{$value->nama_barang}}</option>

                                @endforeach
                            </select>

                        </div>
                        <div class="mt-10">
                            <x-input-label for="bulan" value="{{ __('Bulan') }}" />

                            <select name="bulan" class="w-full border border-gray-400 rounded-md">
                                @foreach ($months as $key => $value)

                                <option value="{{$key}}" {{ !empty(session('data')['bulan']) ? session('data')['bulan'] == $key ? 'selected' : '' : ''  }}>{{$value}}</option>

                                @endforeach
                            </select>

                        </div>
                        <div class="mt-10">
                            <x-input-label for="tahun" value="{{ __('Tahun') }}" />

                            <select name="tahun" class="w-full border border-gray-400 rounded-md">
                                @php
                                $selectedYear = !empty(session('data')['tahun']) ? session('data')['tahun'] : null;
                                $currentYear = date('Y');
                                $startYear = $currentYear - 2;
                                $endYear = $currentYear + 2;
                                @endphp
                                @for ($year = $startYear; $year <= $endYear; $year++) <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                            </select>



                        </div>
                    </div>
                    <x-button-primary class="mt-5">Prediksi</x-button-primary>
                </form>
            </div>
        </div>
    </div>

    @if(session('data'))
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
                    <div class="max-w-full my-10" x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'Existing' }" id="tab_wrapper">
                        <!-- The tabs navigation -->
                        <nav class="flex gap-x-3 my-5 justify-center">
                            <a class="p-2 rounded-md" :class="{ 'bg-blue-500 text-white': tab === 'Existing', 'active': tab === 'Existing' }" @click.prevent="tab = 'Existing'; window.location.hash = 'Existing'" href="#">Existing Data</a>
                            <a class="p-2 rounded-md" :class="{ 'bg-blue-500 text-white': tab === 'prediksi', 'active': tab === 'prediksi' }" @click.prevent="tab = 'prediksi'; window.location.hash = 'prediksi'" href="#">Prediksi Data</a>
                        </nav>

                        <!-- The tabs content -->
                        <div x-show="tab === 'Existing'" x-transition>
                            <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400">
                                <x-table-existing :data="session('data')['defaultData']" :lastData="session('data')['forecastLastData']"/>
                                <div class="flex max-w-full mt-10 justify-center">
                                    <canvas id="display-chart-default" class="max-w-3xl max-h-96"></canvas>
                                </div><br />
                            </div>
                        </div>
                        <div x-show="tab === 'prediksi'" x-transition.duration.500ms>
                            <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400">
                                <x-table-prediksi :data="session('data')['forecastData']" />
                                <div class="flex max-w-full mt-10 justify-center">
                                    <canvas id="display-chart-forecast" class="max-w-3xl max-h-96"></canvas>
                                </div><br />
                            </div>
                        </div>

                    </div>

                </div>
                
            </div>
        </div>
    </div>

    @section('script')
    <script>
        $(function() {
            const defaultData = {!! json_encode(session('data')['defaultData']) !!};
            const forecastData = {!! json_encode(session('data')['forecastData']) !!};

            // Mengubah format tanggal menjadi nama bulan
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            function processData(data) {
                return {
                    labels: data.map(item => {
                        const monthName = monthNames[item.currentMonth - 1];
                        return `${monthName} ${item.currentYear}`;
                    }),
                    aktualData: data.map(item => item.jumlahy),
                    prediksiData: data.map(item => item.a + (item.b * item.x))
                };
            }

            const { labels: labelsDefault, aktualData: aktualDataDefault, prediksiData: prediksiDataDefault } = processData(defaultData);
            const { labels: labelsForecast, aktualData: aktualDataForecast, prediksiData: prediksiDataForecast } = processData(forecastData);

            const configDefault = createChartConfig(labelsDefault, aktualDataDefault, prediksiDataDefault);
            const configForecast = createChartConfig(labelsForecast, aktualDataForecast, prediksiDataForecast);

            new Chart(document.getElementById('display-chart-default'), configDefault);
            new Chart(document.getElementById('display-chart-forecast'), configForecast);
        });

        function createChartConfig(labels, aktualData, prediksiData) {
            return {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Aktual',
                            data: aktualData,
                            fill: false,
                            borderColor: 'rgba(255, 99, 132)',
                        },
                        {
                            label: 'Prediksi',
                            data: prediksiData,
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)',
                        }
                    ]
                }
            };
        }


    </script>
    @endsection
    @endif
</x-app-layout>