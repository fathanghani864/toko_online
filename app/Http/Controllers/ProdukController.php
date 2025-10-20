<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Tampilkan semua produk milik user yang login.
     */
    public function index()
    {
        $produk = Produk::where('user_id', Auth::id())->latest()->get();
        return view('seller.produk.index', compact('produk'));
    }

    /**
     * Halaman tambah produk.
     */
    public function create()
    {
        return view('seller.produk.create');
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk-images', 'public');
            $validatedData['gambar'] = $path;
        }

        $validatedData['user_id'] = Auth::id();

        Produk::create($validatedData);

        return redirect()->route('seller.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Halaman edit produk.
     */
    public function edit($id)
{
    $produk = Produk::findOrFail($id); // ✅ AMAN
    return view('seller.edit', compact('produk'));
}


    /**
     * Update data produk.
     */
   public function update(Request $request, Produk $produk)
{
    // Validasi
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'status' => 'required|in:aktif,nonaktif',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|max:2048',
    ]);

    // Update data
    if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
    }

    $produk->update($validated);

    return redirect()->route('seller.index')->with('success', 'Produk berhasil diperbarui.');
}


    /**
     * Hapus produk.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->user_id != Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        // Hapus gambar dari storage
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('seller.index')->with('success', 'Produk berhasil dihapus!');
    }
}
