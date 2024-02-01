<x-modal name="add-barang" focusable>
    <form method="post" action="{{ route('barang.createOrUpdate') }}" class="p-6">
        @csrf
        @method('put')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Tambah Data Barang') }}
        </h2>
        <div class="mt-3 grid grid-cols-1 gap-x-2 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <div class="mt-4">
                    <x-input-label for="nama_barang" value="{{ __('Nama Barang') }}" />

                    <x-text-input id="nama_barang" name="nama_barang" type="text" required class="mt-1 block w-full" placeholder="{{ __('Nama Barang') }}" />

                </div>
            </div>

            @if ($category)
            <div class="sm:col-span-3">
                <div class="mt-4">
                    <x-input-label for="kategori" value="{{ __('Kategori') }}" />
                    <select name="kategori" class="block w-full text-gray-700 py-2 mt-1 px-4 pr-8 rounded" id="grid-state">
                        <option value="">Kategori Baru</option>
                        @foreach ($category as $value)
                        <option value="{{ $value->nama_kategori }}">
                            {{ $value->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @endif

            <div class="sm:col-span-3">
                <div class="mt-4">
                    <x-input-label for="harga_jual" value="{{ __('Harga Jual') }}" />

                    <x-text-input id="harga_jual" required name="harga_jual" type="number" class="mt-1 block w-full" placeholder="{{ __('Harga Jual') }}" />

                </div>
            </div>
            <div class="sm:col-span-3">
                <div class="mt-4">
                    <x-input-label for="harga_beli" value="{{ __('Harga Beli') }}" />

                    <x-text-input id="harga_beli" required name="harga_beli" type="number" class="mt-1 block w-full" placeholder="{{ __('Harga Beli') }}" />

                </div>
            </div>
            <div class="sm:col-span-3">
                <div class="mt-6">
                    <x-input-label for="stok_masuk" value="{{ __('Stok Masuk') }}" />

                    <x-text-input id="stok_masuk" required name="stok_masuk" type="number" class="block w-full" placeholder="{{ __('Stok Masuk') }}" />

                </div>
            </div>
            <div class="sm:col-span-3">
                <div class="mt-6">
                    <x-input-label for="tanggal_masuk" value="{{ __('Tanggal Masuk') }}" />

                    <x-text-input id="tanggal_masuk" required name="tanggal_masuk" type="date" class="block w-full" placeholder="{{ __('Tanggal Masuk') }}" />

                </div>
            </div>
        </div>
        <div class="mt-6">
            <x-input-label for="deskripsi" value="{{ __('Deskripsi Barang') }}" />

            <x-text-input id="deskripsi" name="deskripsi" type="text" class="block w-full" placeholder="{{ __('Deskripsi') }}" />

        </div>
        <x-text-input name="action" value="create" hidden />
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3">
                {{ __('Simpan') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>