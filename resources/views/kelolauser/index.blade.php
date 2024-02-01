<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Informasi User') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Berikut ini merupakan list user yang tersedia di sistem.") }}
                            </p>
                        </header>

                        <div class="mt-5">
                            <a href="{{ route('kelolauser.add') }}" class="bg-blue-500 p-2 rounded-md text-white">Tambah Data</a>
                        </div>

                    </section>
                </div>

                <div class="mt-10 p-5 border-2 border-e-2  rounded-md  border-gray-400">
                    <table class="dataTable stripe hover row-border cell-border">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listUsers as $key => $value)
                            <tr>
                                <td>{{ $key += 1 }}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->role == 1 ? 'Penjual' : 'Gudang'}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    <x-button-primary onclick="window.location='{{ route('kelolauser.edit', ['id' => $value->id]) }}'">Edit</x-button-primary>
                                    <form method="post" action="{{ route('kelolauser.delete', ['id' => $value->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>Delete</x-danger-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
