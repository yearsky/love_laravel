@props(['propsData' => []])
<div>
    @if($propsData)
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
            @foreach ($propsData as $value)
            <tr>
                <td>{{$value->nama_barang}}</td>
                <td>{{ $value->harga_beli }}</td>
                <td>{{ $value->harga_jual }}</td>
                <td>{{ $value->persediaan_barang }}</td>
                <td>{{ date('Y-m-d',strtotime($value->created_at)) }}</td>
                <td class="flex gap-x-3">
                    <x-button-primary class="text-2xl" onclick="window.location='{{ route('barang.show', ['id' => $value->id_barang]) }}'">🔎</x-button-primary>
                    <x-button-warning class="text-2xl bg-yellow-400">📝</x-button-warning>
                    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'barangDeletion')" class="text-2xl bg-red-300 text-white deleteBtn" data-id="{{ $value->id_barang }}">❌</x-danger-button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @endif
</div>

<x-modal-delete name="barangDeletion" focusable>
    <form method="post">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete your account?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
        </p>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal-delete>

@section('script')
<script>
    $(function() {

    })
</script>
@endsection