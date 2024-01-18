@props(['type'])
<div class="max-w-sm rounded-md overflow-hidden shadow-lg bg-gray-200">
    <div class="px-10 py-4 text-center">
        <div class="font-bold text-xl mb-2 text-center">Total Barang {{ $type == 'masuk' ? 'Masuk 📥 ': 'Keluar 📤'  }}</div>
        <div class="text-2xl py-2 bg-white rounded-md mx-auto justify-center max-w-16 my-5">99</div>
        <a href="#" class="py-2 text-white bg-blue-600 px-4 text-center rounded-full font-semibold">Detail 👉</a>
    </div>
    <!-- <div class="px-6 pt-4 pb-2">
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
    </div> -->
</div>