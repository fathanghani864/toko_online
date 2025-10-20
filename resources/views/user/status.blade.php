<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-center mb-6 text-gray-800 tracking-tight">
                Status Barang / Pesanan Anda
            </h1>

            {{-- Menampilkan pesan sukses dari session (jika ada) --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-6 text-center shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Cek apakah ada data pesanan yang sudah difilter --}}
            @if($orders->isEmpty())
                <div class="bg-white p-8 rounded-xl shadow-lg text-center text-gray-600 border border-gray-200">
                    Belum ada riwayat pesanan yang tercatat untuk akun Anda.
                </div>
            @else
                <div class="bg-white shadow-xl rounded-xl overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">No. Order</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Pemesan</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                {{-- Kolom Aksi DIHAPUS untuk tampilan read-only pelanggan --}}
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($orders as $order)
                                @php
                                    // Menentukan kelas warna berdasarkan status pesanan
                                    $color = match ($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'dikirim' => 'bg-purple-100 text-purple-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp

                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                    {{-- Menggunakan operator null-safe (?->) untuk relasi produk --}}
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->produk?->nama ?? 'Barang Tidak Ditemukan' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->nama_pemesan }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
