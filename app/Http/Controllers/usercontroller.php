<?php

namespace App\Http\Controllers;

use App\Models\Order; // Diubah dari 'order' menjadi 'Order'
use App\Models\Produk; // Diubah dari 'produk' menjadi 'Produk'
use Illuminate\Support\Facades\Auth; // Tambahkan import untuk Auth facade
use DB;
use Illuminate\Http\Request;

class usercontroller extends Controller
{
    /**
     * Menampilkan riwayat pesanan HANYA untuk pengguna yang sedang login.
     */
    public function statusPesanan()
    {
        // 1. Ambil ID pengguna yang sedang login.
        //    Pastikan rute ini dilindungi middleware('auth').
        $userId = Auth::id();

        // 2. Query database: Ambil semua pesanan ($orders) di mana
        //    kolom 'user_id' sama dengan $userId.
        //    Menggunakan with('produk') untuk menghindari N+1 problem pada View.
        $orders = Order::where('user_id', $userId)
                        ->with('produk') 
                        ->orderBy('created_at', 'desc')
                        ->get();

        // 3. Kirim data pesanan yang sudah difilter ke View yang kamu buat sebelumnya
        return view('user.status', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengubah 'produk' menjadi 'Produk' sesuai standar penamaan Model
        $produk = Produk::all();
        return view('user.index', compact('produk'));
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
        $data = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'nama_pemesan' => 'required|string',
            'alamat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'kurir' => 'required|in:JNE,JNT,POS',
            'metode_pembayaran' => 'required|in:COD,transfer',
        ]);

        $product = Produk::where('status', 'aktif')
            ->findOrFail($data['produk_id']);

        $jumlah = (int) $data['jumlah'];

        // 🚨 Pengecekan Stok
        if ($product->stok < $jumlah) {
            return back()->withInput()->withErrors(['jumlah' => "Stok produk tidak mencukupi. Stok yang tersedia: {$product->stok}"]);
        }

        $harga = (int) $product->harga;
        $total_harga = $harga * $jumlah;


        DB::transaction(function () use ($request, $product, $jumlah, $total_harga): void {
            Order::create([ // Menggunakan Order
                'user_id' => auth()->user()->id, // Pastikan kolom user_id ada di tabel orders
                'produk_id' => $product->id,
                'nama_pemesan' => $request->nama_pemesan,
                'alamat' => $request->alamat,
                'jumlah' => $jumlah,
                'kurir' => $request->kurir,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => $total_harga,
                'status' => 'pending', 
            ]);

            // Kurangi Stok
            $product->update([
                'stok' => $product->stok - $jumlah
            ]);
        });

        return redirect()->route('user.index')
            ->with('success', 'Order berhasil dibuat! Menunggu proses dan konfirmasi admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::findOrFail($id);
        return view('user.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
