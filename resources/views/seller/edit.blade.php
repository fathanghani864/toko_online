<x-app-layout>
<div class="bg-gray-100 min-h-screen">
    <div class="p-8">
        <div class="max-w-xl mx-auto rounded-xl shadow-2xl overflow-hidden bg-white">
            <div class="p-4 sm:p-6 text-white bg-gradient-to-r from-indigo-600 to-purple-600">
                <h1 class="font-bold text-xl">Edit Produk</h1>
            </div>

            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
                @csrf
                @method('PUT')

                <div class="flex flex-col mt-3">
                    <label for="nama">Nama Produk</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" class="border p-2 rounded-lg">
                </div>

                <div class="flex flex-col mt-5">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" class="border p-2 rounded-lg">
                </div>

                <div class="flex flex-col mt-5">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" class="border p-2 rounded-lg">
                </div>

                <div class="flex flex-col mt-5">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="border p-2 rounded-lg">
                        <option value="aktif" {{ $produk->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $produk->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="flex flex-col mt-5">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="border p-2 rounded-lg">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                <div class="flex flex-col mt-5">
                    <label for="gambar">Gambar</label>
                    @if ($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-20 h-20 rounded mb-2">
                    @endif
                    <input type="file" name="gambar" id="gambar" class="border p-2 rounded-lg">
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full py-2 text-white font-medium rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
