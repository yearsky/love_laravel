<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg  lg:py-8">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center text-xl font-medium">
                    {{ __("Selamat Datang, Berikut merupakan dashboard anda 🎉") }}
                </div>
                @if($getListStok > 0)
                {{-- <div class="flex justify-center gap-3 py-5">
                    <x-card-dashboard :type="__('masuk')" :count="$getListStok[0]->stok_masuk" />
                    <x-card-dashboard :type=" __('keluar')" :count="$getListStok[0]->stok_keluar" />

                </div> --}}
                <div class="flex max-w-full mt-10 justify-center">
                    <canvas id="display-chart-dashboard" class="max-w-3xl max-h-96"></canvas>
                </div><br />
                @endif
            </div>
        </div>
    </div>

    <script>
        let dataStok = {!! json_encode($getListStok) !!};

        const labels = dataStok.map(entry => entry.tahun);
        const stokMasuk = dataStok.map(entry => parseInt(entry.stok_masuk));
        const stokKeluar = dataStok.map(entry => parseInt(entry.stok_keluar));

        const totalStokMasuk = stokMasuk.reduce((total, current) => total + current, 0);
        const totalStokKeluar = stokKeluar.reduce((total, current) => total + current, 0);
        const data = {
            labels: labels,
            datasets: [
            {
                label: 'Total Barang Masuk: '+totalStokMasuk,
                data: stokMasuk,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            },
            {
                label: 'Total Barang Keluar: '+totalStokKeluar,
                data: stokKeluar,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1
            }
        ]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            },
        };

        new Chart(document.getElementById('display-chart-dashboard'), config);
    </script>
</x-app-layout>