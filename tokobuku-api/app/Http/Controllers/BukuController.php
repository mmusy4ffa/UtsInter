<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Buku::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255', //harus disi
            'penulis' => 'required',
            'harga' => 'required|numeric|min:1000', //menambahkan min untuk memasang harga minimal 1000 rup
            'stok' => 'required',
            'kategori_id' => 'required',
        ]);

        $kategori = Buku::create($request->all());
        return response()->json($kategori, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $request->validate([
            'judul' => 'required|string|max:255', // harus di isi
            'penulis' => 'required',
            'harga' => 'required|numeric|min:1000', //harga min 1000
            'stok' => 'required',
            'kategori_id' => 'required',
        ]);

        $buku->update($request->only(['judul', 'penulis', 'harga', 'stok', 'kategori_id']));

        return response()->json($buku, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);

    }

    public function search(Request $request)
    {
        $query = Buku::query();

        //mencari menggunakan judul
        if ($request->has('judul')) {
            $query->where('judul', 'like', '%' . $request->input('judul') . '%');
        }

        //menggunakan kategori
        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        $bukus = $query->get();

        return response()->json($bukus, 200);

    }
}
