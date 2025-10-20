<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Tombol Kembali --}}
            <div class="mb-4">
                {{-- Menggunakan route 'pesanan.index' sesuai kode Anda sebelumnya --}}
                <a href="{{ route('pesanan.index') }}" 
                    class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>

            {{-- Pesan Sukses/Error --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">
                Detail Pesanan #{{ $order->id }}
            </h1>

            @php
                // Logika pewarnaan status
                $color = match ($order->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'diproses' => 'bg-blue-100 text-blue-800',
                    'dikirim' => 'bg-purple-100 text-purple-800',
                    'selesai' => 'bg-green-100 text-green-800',
                    'dibatalkan' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                };

                // Format harga
                $formatted_total_harga = 'Rp ' . number_format($order->total_harga, 0, ',', '.');
            @endphp

            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-6 sm:p-8 space-y-6">

                    {{-- Status Pesanan (Area Update Status Utama) --}}
                    <div class="flex justify-between items-center pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Ubah Status Pesanan:</h2>

                        <form action="{{ route('pesanan.updateStatus', $order->id) }}" method="POST"
                            class="flex items-center space-x-2">
                            
                            @csrf
                            @method('PATCH')

                            @php
                                $statuses = ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];
                            @endphp

                            <select name="status" id="status-update"
                                class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                @foreach ($statuses as $statusOption)
                                    <option value="{{ $statusOption }}" {{ $order->status === $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>


                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                Simpan
                            </button>
                        </form>
                    </div>
                    <div class="mb-4">
                        Status Saat Ini:
                        <span
                            class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $color }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- Detail Pesanan (Informasi Produk, Pemesan, dll.) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                        {{-- Informasi Produk --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-1">Informasi Produk</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium text-gray-600">Nama Barang:</span> <span
                                        class="text-gray-900 font-bold">{{ $order->produk?->nama ?? 'Barang Tidak Ditemukan' }}</span>
                                </p>
                                <p><span class="font-medium text-gray-600">Jumlah:</span> <span
                                        class="text-gray-900">{{ number_format($order->jumlah) }}</span></p>
                                <p><span class="font-medium text-gray-600">Harga Satuan:</span> <span
                                        class="text-gray-900">{{ 'Rp ' . number_format($order->produk?->harga ?? 0, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Informasi Pemesan --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-1">Detail Pemesan</h3>
                            <div class="space-y-2 text-sm">
                                
                                <p><span class="font-medium text-gray-600">Nama Pemesan:</span> <span
                                        class="text-gray-900">{{ $order->nama_pemesan }}</span></p>
                                <p><span class="font-medium text-gray-600">ID User:</span> <span
                                        class="text-gray-900">{{ $order->user_id }}</span></p>
                                <p><span class="font-medium text-gray-600">Tanggal Pesan:</span> <span
                                        class="text-gray-900">{{ $order->created_at->format('d F Y (H:i)') }}</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pengiriman & Pembayaran --}}
                    <div class="pt-4 border-t">
                        <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-1">Pengiriman & Pembayaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="font-medium text-gray-600">Kurir:</p>
                                <p class="text-gray-900 font-bold">{{ $order->kurir }}</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-600">Metode Pembayaran:</p>
                                <p class="text-gray-900 font-bold">{{ $order->metode_pembayaran }}</p>
                            </div>
                            <div class="md:col-span-1">
                                <p class="font-medium text-gray-600">Alamat Pengiriman:</p>
                                <p class="text-gray-900 break-words">{{ $order->alamat }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Pembayaran --}}
                    <div class="pt-6 border-t mt-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-800">TOTAL HARGA:</h3>
                            <span class="text-2xl font-extrabold text-indigo-600">{{ $formatted_total_harga }}</span>
                        </div>
                    </div>

                    {{-- Aksi Tambahan: TOMBOL CUSTOM --}}
                    <div class="flex justify-end pt-4 border-t mt-4 space-x-3">
                        
                        {{-- BLOK YANG DIMINTA: Mengubah Link Edit Detail menjadi Form Update --}}
                        <form action="{{ route('pesanan.update', $order->id) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menyimpan perubahan detail dan kembali ke daftar pelanggan?');">
                            @csrf
                            {{-- Menggunakan PATCH untuk pembaruan data --}}
                            @method('PATCH') 
                            
                            {{-- Anda mungkin perlu menambahkan input tersembunyi jika aksi update ini membawa data --}}
                            {{-- <input type="hidden" name="action_type" value="detail_update"> --}}
                            
                           
                        </form>
                        {{-- AKHIR BLOK YANG DIMINTA --}}


                        {{-- Tombol Batalkan Pesanan (Hanya jika pending) --}}
                        @if ($order->status === 'pending')
                            <form action="{{ route('pesanan.cancel', $order->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan #{{ $order->id }}?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded text-sm font-semibold transition shadow-md">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                        
                        {{-- Tombol Konfirmasi Diterima (Hanya jika dikirim) --}}
                        @if ($order->status === 'dikirim')
                            <form action="{{ route('pesanan.complete', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded text-sm font-semibold transition shadow-md">
                                    Konfirmasi Diterima
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
