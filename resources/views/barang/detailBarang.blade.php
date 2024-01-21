<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Detail Informasi Barang') }}
                            </h2>
                        </header>

                    </section>
                </div>
                <div class="mt-3 grid grid-cols-1 gap-x-2 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <div class="mt-4">
                            <x-input-label for="nama_barang" value="{{ __('Nama Barang') }}" />

                            <x-input-disabled :value="$barang->nama_barang" />

                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <div class="mt-4">
                            <x-input-label for="nama_barang" value="{{ __('Kategori Barang') }}" />

                            <x-input-disabled :value="$barang->nama_kategori" />

                        </div>
                    </div>


                    <div class="sm:col-span-3">
                        <div class="">
                            <x-input-label for="harga_jual" value="{{ __('Harga Jual') }}" />

                            <x-input-disabled :value="$barang->harga_jual" />

                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <div class="">
                            <x-input-label for="harga_beli" value="{{ __('Harga Beli') }}" />

                            <x-input-disabled :value="$barang->harga_beli" />

                        </div>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <div class="mt-4">
                        <x-input-label for="harga_beli" value="{{ __('Deskripsi Barang') }}" />
                        <x-input-disabled :value="$barang->deskripsi" />

                    </div>
                </div>
                <section class="mt-10">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Histori Informasi Barang') }}
                        </h2>
                    </header>

                </section>
                <div class="w-full my-5">
                    <table class="border-collapse border border-slate-400 w-full rounded-full">
                        <thead>
                            <tr>
                                <th class="border border-slate-300">Stok Masuk</th>
                                <th class="border border-slate-300">Stok Keluar</th>
                                <th class="border border-slate-300">Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyBarang as $value)
                            <tr class="text-center">
                                <td class="border border-slate-300 stok_masuk">{{ $value->stok_masuk }}</td>
                                <td class="border border-slate-300 stok_keluar">{{ $value->stok_keluar }}</td>
                                <td class="border border-slate-300">{{ date('Y-m-d',strtotime($value->updated_at)) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="border border-slate-300 text-center">Total Persediaan Barang</td>
                                <td colspan="2" class="border border-slate-300 text-center" id="totalCount"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <x-button-primary class="mt-4" onclick="window.location='{{ route('barang') }}'">Kembali</x-button-primary>
            </div>



        </div>
    </div>
    @section('script')

    <script>
        $(function() {
            let totalStokMasuk = 0;
            let totalStokKeluar = 0;

            $('.stok_masuk').each(function() {
                let stokMasuk = parseInt($(this).text()) || 0; // Use 0 if the text is not a valid number
                totalStokMasuk += stokMasuk;
            });

            $('.stok_keluar').each(function() {
                let stokKeluar = parseInt($(this).text()) || 0; // Use 0 if the text is not a valid number
                totalStokKeluar += stokKeluar;
            });
            let finalCount = totalStokMasuk - totalStokKeluar
            $('#totalCount').text(finalCount)
        })
    </script>
    @endsection
</x-app-layout>