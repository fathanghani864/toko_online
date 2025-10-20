<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Card Utama Pemesanan --}}
            <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
                <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                    Lengkapi Detail Pemesanan
                </h1>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- Kiri: Detail Produk --}}
                    <div class="lg:col-span-1 border-r lg:pr-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">Detail Barang</h2>

                        <div class="flex items-start gap-4 mb-6">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                     alt="Gambar {{ $produk->nama }}" 
                                     class="w-24 h-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs">
                                    No Image
                                </div>
                            @endif

                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 leading-snug">{{ $produk->nama }}</h3>
                                <p class="text-sm text-gray-500">{{ Str::limit($produk->deskripsi, 50) }}</p>
                                <p class="text-xl font-bold text-indigo-600 mt-2" id="harga-satuan"
                                   data-harga="{{ $produk->harga }}">
                                   Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Stok Tersedia: {{ $produk->stok }} unit
                                </p>
                            </div>
                        </div>

                        {{-- Total Pembayaran --}}
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex justify-between font-bold text-lg mt-2 text-gray-900">
                                <span>Total Pembayaran</span>
                                <span id="total-harga">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan: Formulir Pemesanan --}}
                    <div class="lg:col-span-1 lg:pl-4">
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            {{-- Hidden total harga biar ikut dikirim --}}
                            <input type="hidden" name="total_harga" id="input-total-harga" value="{{ $produk->harga }}">

                            {{-- Nama Pemesan --}}
                            <div class="mb-4">
                                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan Lengkap</label>
                                <input type="text" id="nama_pemesan" name="nama_pemesan"
                                       readonly
                                       value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            {{-- Jumlah Barang --}}
                            <div class="mb-6">
                                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Barang</label>
                                <div class="relative">
                                    <input type="number" id="jumlah" name="jumlah" value="1" min="1" 
                                           max="{{ $produk->stok }}"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10">
                                    <span class="absolute right-0 top-0 h-full flex items-center pr-3 text-sm text-gray-500">unit</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Maksimal permintaan adalah {{ $produk->stok }} unit.</p>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-6">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                                <textarea id="alamat" name="alamat" rows="3"
                                    placeholder="Masukkan alamat lengkap (jalan, kecamatan, kota, kode pos)"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ auth()->check() && auth()->user()->alamat ? auth()->user()->alamat : '' }}</textarea>
                            </div>

                            {{-- Kurir --}}
                            <div class="mb-6">
                                <label for="kurir" class="block text-sm font-medium text-gray-700 mb-1">
                                    Pilih Jasa Pengiriman
                                </label>
                                <select id="kurir" name="kurir"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Ekspedisi --</option>
                                    <option value="JNE">JNE</option>
                                    <option value="JNT">J&T Express</option>
                                    <option value="POS">POS Indonesia</option>
                                </select>
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                                <div class="flex gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="metode_pembayaran" value="COD" checked
                                            class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-2 text-gray-700">COD (Bayar di Tempat)</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="metode_pembayaran" value="transfer"
                                            class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-2 text-gray-700">Bayar Online</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <button type="submit"
                                class="w-full bg-indigo-600 text-white py-3 mt-4 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition shadow-md">
                                Proses Pemesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT: Hitung total otomatis --}}
    <script>
        const hargaSatuan = parseInt(document.getElementById('harga-satuan').dataset.harga);
        const jumlahInput = document.getElementById('jumlah');
        const totalHargaElement = document.getElementById('total-harga');
        const inputTotalHidden = document.getElementById('input-total-harga');

        jumlahInput.addEventListener('input', () => {
            let jumlah = parseInt(jumlahInput.value) || 1;
            let total = hargaSatuan * jumlah;
            totalHargaElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
            inputTotalHidden.value = total; // simpan ke hidden input
        });
    </script>
</x-app-layout>
