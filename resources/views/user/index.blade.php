<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold mb-6 text-gray-900 text-center">
                Daftar Produk
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($produk as $produks)
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                        <div class="w-full h-48 overflow-hidden">
                            @if($produks->gambar)
                                <img src="{{ asset('storage/' . $produks->gambar) }}" alt="{{ $produks->nama }}"
                                    class="w-full h-full object-cover object-center transform hover:scale-105 transition duration-300 ease-in-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-900 truncate">
                                {{ $produks->nama }}
                            </h2>
                            <p class="text-gray-600 text-sm mt-2 line-clamp-3">
                                {{ $produks->deskripsi }}
                            </p>

                            <div class="mt-4">
                                <span class="text-gray-900 font-bold text-base">
                                    Rp {{ number_format($produks->harga, 0, ',', '.') }}
                                </span>
                                <p class="text-gray-500 text-sm mt-1">
                                    Stok: <span class="font-medium">{{ $produks->stok }}</span>
                                </p>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('user.show', $produks->id) }}"
                                    class="mt-4 block text-center py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 w-24">
                                    Beli
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
