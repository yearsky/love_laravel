<div>
    <table id="dataTable" class="dataTable stripe hover row-border cell-border">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Persediaan Barang</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listBarang as $value)
            <tr>
                <td>{{$value->nama_barang}}</td>
                <td>{{ $value->harga_beli }}</td>
                <td>{{ $value->harga_jual }}</td>
                <td>{{ $value->persediaan_barang }}</td>
                <td>{{ date('Y-m-d',strtotime($value->created_at)) }}</td>
                <td class="flex gap-x-3">
                    <x-button-primary class="text-2xl" onclick="window.location='{{ route('barang.show', ['id' => $value->id_barang]) }}'">🔎</x-button-primary>
                    <x-button-warning class="text-2xl bg-yellow-400">📝</x-button-warning>
                    <x-danger-button class="text-2xl bg-slate-300 text-white" onclick="showDeleteModal({{ $value->id_barang }})">❌</x-danger-button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<div id="modalDelete" hidden class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form method="post" id="formDelete" class="mr-4">
                    @csrf
                    @method('delete')
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="flex sm:flex sm:items-start gap-x-5">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete this data?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Data tidak akan bisa kembali') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                        <button type="button" onclick="$('#modalDelete').attr('hidden',true)" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

<script>
    function showDeleteModal(id) {
        let modal = $('#modalDelete');
        let formDelete = $('#formDelete');
        let actionUrl = "{{ url('barang') }}" + '/' + id;

        // Update the form action attribute
        formDelete.attr('action', actionUrl);

        modal.removeAttr('hidden');
    }
</script>