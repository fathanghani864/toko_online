<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
                Status Barang / Pesanan
            </h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow text-center text-gray-600">
                    Belum ada pesanan.
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No. Order</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Pemesan</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                @php
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
                                    <td class="px-4 py-3 text-sm text-gray-800">#{{ $order->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->produk?->nama ?? 'Barang Tidak Ditemukan' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->nama_pemesan }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{-- Tombol ke halaman detail --}}
                                        <a href="{{ route('pesanan.show', $order->id) }}"
                                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                           Detail
                                        </a>
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
