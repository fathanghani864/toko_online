<x-app-layout>

<div class="p-8 text-gray-700 dark:text-gray-400">
    {{-- Section: Halo User --}}
    <div class="p-4 rounded-xl mb-6 bg-white shadow-md border border-dashed border-gray-200">
        {{-- Menggunakan Auth::user() untuk menampilkan nama user yang sedang login --}}
        <h1 class="text-xl font-bold text-gray-800">Halo {{ Auth::user()->name }}</h1>
    </div>

    {{-- Section: Header dan Tombol Tambah Produk --}}
    <div class="p-4 rounded-lg">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div class="mb-4 sm:mb-0">
                <h1 class="font-bold text-2xl text-gray-800">Kelola Produk</h1>
                <p class="text-sm text-gray-500">Daftar produk yang tersimpan di database.</p>
            </div>
            {{-- Link ke halaman tambah produk --}}
            <a href="seller/produk/create" class="p-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium shadow-md hover:from-indigo-700 hover:to-purple-700 transition duration-150 ease-in-out">
                Tambah Produk
            </a>
        </div>
    </div>

    {{-- Section: Tabel Daftar Produk --}}
    <div class="relative overflow-x-auto shadow-2xl rounded-xl mt-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">NO</th>
                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                    <th scope="col" class="px-6 py-3">Harga</th>
                    <th scope="col" class="px-6 py-3">Stok</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                    <th scope="col" class="px-6 py-3">Gambar</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data produk yang dikirim dari controller --}}
                @forelse ($produk as $index => $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $index + 1 }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $product->nama}}
                        </td>
                        <td class="px-6 py-4">
                            {{ 'Rp ' . number_format($product->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->stok }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $product->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ Str::upper($product->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs overflow-hidden truncate" title="{{ $product->deskripsi }}">
                            {{ $product->deskripsi }}
                        </td>
                       <td class="px-6 py-4">
   <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-12 h-12 object-cover rounded-md shadow-sm border border-gray-200 dark:border-gray-600">

</td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            {{-- Tombol Edit --}}
                       <a href="{{ url('seller/produk/' . $product->id . '/edit') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">
    Edit
</a>

                            {{-- Tombol Hapus (Contoh menggunakan form DELETE) --}}
                            <form action="seller/produk/{{ $product->id }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800">
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Belum ada produk yang tersedia. Silakan tambahkan produk baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</x-app-layout>