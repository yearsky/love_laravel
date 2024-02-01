<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Informasi Stok Barang') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Berikut ini merupakan list stok barang yang anda punya.") }}
                            </p>
                        </header>

                    </section>
                </div>
                <div class="p-5 max-w-full ">
                    <div class="my-4">
                        <x-primary-button>
                            {{ __('Filters') }}
                        </x-primary-button>
                        <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-barang')">
                            {{ __('Tambah Data') }}
                        </x-secondary-button>
                    </div>
                    <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400">
                        <!-- <x-table-barang :propsData="$listBarang" /> -->
                        @include('barang.partials.tableBarang')
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Informasi Keluar Masuk Barang') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Berikut ini merupakan list stok barang yang anda punya.") }}
                            </p>
                        </header>

                    </section>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white h-10 font-bold py-2 px-4 rounded">
                        Filter Data
                    </button>
                </div>
                <div class="max-w-full my-10" x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'masuk' }" id="tab_wrapper">
                    <!-- The tabs navigation -->
                    <nav class="flex gap-x-3 my-5 justify-center">
                        <a class="p-2 rounded-md" :class="{ 'bg-blue-500 text-white': tab === 'masuk', 'active': tab === 'masuk' }" @click.prevent="tab = 'masuk'; window.location.hash = 'masuk'" href="#">Masuk</a>
                        <a class="p-2 rounded-md" :class="{ 'bg-blue-500 text-white': tab === 'keluar', 'active': tab === 'keluar' }" @click.prevent="tab = 'keluar'; window.location.hash = 'keluar'" href="#">Keluar</a>
                    </nav>

                    <!-- The tabs content -->
                    <div x-show="tab === 'masuk'" x-transition>
                        <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400">
                            <x-table-barang />
                        </div>
                    </div>
                    <div x-show="tab === 'keluar'" x-transition.duration.500ms>
                        <div class="p-5 border-2 border-e-2  rounded-md  border-gray-400">
                            <x-table-barang />
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @include('barang.partials.addModal')
</x-app-layout>