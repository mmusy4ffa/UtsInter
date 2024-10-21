<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Log;

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
            'judul' => 'required|string|max:255', // nama tidak boleh kosong
            'penulis' => 'required',
            'harga' => 'required|numeric|min:1000', //untuk harga minimal 1000
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
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($buku);


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
            'judul' => 'required|string|max:255',
            'penulis' => 'required',
            'harga' => 'required|numeric|min:1000',
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
        try {
            $kategori = $request->input('kategori');
            $buku = Buku::whereHas('kategori', function ($query) use ($kategori) {
                $query->where('nama_kategori', 'like', '%' . $kategori . '%');
            })->get();

            return response()->json($buku, 202);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mencari buku',
                'message' => $e->getMessage()
            ], 500);
        }
    }



}
