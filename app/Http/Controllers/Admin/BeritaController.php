<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Berita::class, 'berita');
    }

    public function index(Request $request)
    {
        $beritas = Berita::query()
            ->when($request->q, function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->q}%")
                  ->orWhere('isi', 'like', "%{$request->q}%")
                  ->orWhere('ringkasan', 'like', "%{$request->q}%");
            })
            ->when($request->kategori, fn($q) => $q->where('kategori', $request->kategori))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('Admin.berita.index', compact('beritas'));
    }

    /**
     * 🆕 Tampilkan form untuk tambah berita.
     */
    public function create()
    {
        return view('Admin.berita.create');
    }

    /**
     * 💾 Simpan berita baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string|max:500',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'penulis' => 'nullable|string|max:150',
            'tanggal_publikasi' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'tags' => 'nullable|string|max:255',
        ]);

        // Tanggal otomatis jika kosong
        $validated['tanggal_publikasi'] = $request->tanggal_publikasi ?? now();

        // Penulis default jika kosong
        $validated['penulis'] = $request->penulis ?? (Auth::user()->name ?? 'Admin');

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // Buat slug unik
        $validated['slug'] = Str::slug($request->judul . '-' . now()->format('YmdHis'));

        Berita::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', '✅ Berita berhasil ditambahkan!');
    }

    /**
     * ✏ Tampilkan form edit berita.
     */
    public function edit(Berita $berita)
    {
        return view('Admin.berita.edit', compact('berita'));
    }

    /**
     * Tampilkan detail berita (admin).
     */
    public function show(Berita $berita)
    {
        return view('Admin.berita.show', compact('berita'));
    }

    /**
     * 🔁 Update berita.
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string|max:500',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'penulis' => 'nullable|string|max:150',
            'tanggal_publikasi' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'tags' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($request->judul . '-' . $berita->id);

        // Jika ada gambar baru, hapus lama & simpan baru
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        } else {
            // Jika tidak upload gambar baru, pertahankan gambar lama
            $validated['gambar'] = $berita->gambar;
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', '✅ Berita berhasil diperbarui!');
    }

    /**
     * 🗑 Hapus berita dari database & hapus gambar di storage.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', '🗑 Berita berhasil dihapus!');
    }
}
