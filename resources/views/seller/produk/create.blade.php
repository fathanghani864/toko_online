<x-app-layout>
{{-- Main Container (Hanya untuk styling halaman) --}}
<div class="bg-gray-100 min-h-screen">
{{-- Padding luar --}}
<div class="p-8">

        {{-- KOTAK UTAMA FORM DENGAN TEMA GRADIENT --}}
        <div class="max-w-xl mx-auto rounded-xl shadow-2xl overflow-hidden bg-white">
            
            {{-- HEADER FORM dengan GRADIENT --}}
            <div class="p-4 sm:p-6 text-white 
                         bg-gradient-to-r from-indigo-600 to-purple-600">
                <h1 class="font-bold text-xl">Tambah Produk</h1>
            </div>

            {{-- ISI FORM - Pastikan menggunakan 'name' untuk request dan enctype untuk file --}}
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
                @csrf
                
                <div class="flex flex-col mt-3">
                    <label for="nama" class="text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="nama" name="nama" required
                           class="rounded-lg border border-gray-300 p-2 mt-1 
                                  focus:border-purple-500 focus:ring-purple-500" 
                           placeholder="ketik nama barang" value="{{ old('nama') }}">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex flex-col mt-5">
                    <label for="harga" class="text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="harga" name="harga" required
                           class="rounded-lg border border-gray-300 p-2 mt-1 
                                  focus:border-purple-500 focus:ring-purple-500" 
                           placeholder="ketik Harga" value="{{ old('harga') }}">
                    @error('harga')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex flex-col mt-5">
                    <label for="stok" class="text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" id="stok" name="stok" required
                           class="rounded-lg border border-gray-300 p-2 mt-1 
                                  focus:border-purple-500 focus:ring-purple-500" 
                           placeholder="ketik Stok" value="{{ old('stok') }}">
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex flex-col mt-5">
                    <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" required
                            class="rounded-lg border border-gray-300 p-2 mt-1 
                                   focus:border-purple-500 focus:ring-purple-500">
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col mt-5">
                    <label for="deskripsi" class="text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"
                              class="rounded-lg border border-gray-300 p-2 mt-1 
                                     focus:border-purple-500 focus:ring-purple-500" 
                              placeholder="ketik deksripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex flex-col mt-5">
                    <label for="gambar" class="text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" 
                           class="rounded-lg border border-gray-300 p-2 mt-1 
                                  file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 
                                  file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 
                                  hover:file:bg-purple-100"
                           >
                    @error('gambar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
                <div class="mt-8">
                    <button type="submit" class="w-full py-2 text-white font-medium rounded-lg 
                             bg-gradient-to-r from-indigo-500 to-purple-600 
                             hover:from-indigo-600 hover:to-purple-700 
                             transition duration-150 ease-in-out shadow-md">
                        Simpan Data Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</x-app-layout>