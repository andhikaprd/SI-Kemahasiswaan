<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Menampilkan halaman daftar berita.
     */
    public function index()
    {
        // Ambil semua berita, urutkan dari yang paling baru, dan gunakan paginasi
        $beritas = Berita::latest()->paginate(10); 
        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string|max:500',
            'isi' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|in:published,draft',
            'penulis' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|string',
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder 'public/berita'
            $pathGambar = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul), // Buat slug otomatis
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'penulis' => $request->penulis,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'gambar' => $pathGambar,
            'tags' => $request->tags,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Mengupdate berita di database.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string|max:500',
            'isi' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|in:published,draft',
            'penulis' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|string',
        ]);

        $pathGambar = $berita->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            // Upload gambar baru
            $pathGambar = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'penulis' => $request->penulis,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'gambar' => $pathGambar,
            'tags' => $request->tags,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Berita $berita)
    {
        // Hapus gambar dari storage jika ada
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}

