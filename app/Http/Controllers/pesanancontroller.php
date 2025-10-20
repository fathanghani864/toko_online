<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class pesanancontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admin lihat semua pesanan
        $orders = Order::with(['produk', 'user'])
                        ->latest()
                        ->get();

        return view('status-barang.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pesanan = Order::findOrFail($id); 
        return view('status-barang.show', ['order' => $pesanan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mengarahkan ke form edit. Kita akan gunakan show untuk sekarang,
        // tapi ini adalah tempat yang tepat untuk view edit.
        $order = Order::findOrFail($id);
        // Anggap Anda memiliki view 'status-barang.edit'
        return view('status-barang.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage (Untuk update detail seperti nama/alamat).
     */
    public function update(Request $request, Order $order)
    {
        // 1. Validasi input dari form edit
        $validatedData = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            // Tambahkan field lain yang diizinkan untuk di-update
        ]);

        // 2. Perbarui data pesanan
        $order->update($validatedData);

        // 3. Redirect kembali ke halaman daftar pelanggan (pelanggan.index)
        // Note: Route pelanggan.index seharusnya tidak menerima parameter ID.
        return redirect()->route('pelanggan.index') 
                         ->with('success', 'Detail pesanan #' . $order->id . ' berhasil diperbarui dan dialihkan ke Daftar Pelanggan.');
    }
    
    /**
     * Update STATUS pesanan dari dropdown (Digunakan di halaman show).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->status = $validatedData['status'];
        $order->save();

        return redirect()->route('pesanan.index', $order->id)
                         ->with('success', 'Status pesanan berhasil diubah menjadi ' . ucfirst($order->status) . '.');
    }

    /**
     * Fungsi untuk admin meng-approve pesanan (SET STATUS KE DIPROSES).
     */
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'diproses'; // ubah status dari pending ke diproses
        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil disetujui!');
    }

    /**
     * Fungsi untuk pembeli mengkonfirmasi pesanan diterima (SET STATUS KE SELESAI).
     */
    public function complete(Order $order)
    {
        $order->status = 'selesai'; 
        $order->save();

        // Redirect ke daftar pesanan setelah selesai
        return redirect()->route('pesanan.index')
                         ->with('success', 'Pesanan #' . $order->id . ' berhasil dikonfirmasi selesai.');
    }

    /**
     * Fungsi untuk membatalkan pesanan (SET STATUS KE DIBATALKAN).
     */
    public function cancel(Order $order)
    {
        // 1. Cek apakah pesanan masih bisa dibatalkan
        if ($order->status !== 'pending' && $order->status !== 'diproses') {
             return redirect()->route('pesanan.show', $order->id)
                             ->with('error', 'Pesanan tidak dapat dibatalkan karena statusnya sudah ' . $order->status . '.');
        }

        // 2. Ubah status pesanan
        $order->status = 'dibatalkan';
        $order->save();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('pesanan.index') // Redirect ke halaman daftar
                         ->with('success', 'Pesanan #' . $order->id . ' berhasil dibatalkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
