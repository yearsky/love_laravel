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
                <div class="flex justify-center gap-3 py-5">
                    <x-card-dashboard :type="__('masuk')" :count="$getListStok[0]->stok_masuk" />
                    <x-card-dashboard :type=" __('keluar')" :count="$getListStok[0]->stok_keluar" />
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>