<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kegiatans = Kegiatan::with('creator')->latest()->paginate(10);
        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'lokasi_kegiatan' => 'required|string',
            'batas_pendaftar' => 'required|integer|min:1',
            'gambar_lokasi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string|in:draft,publish,selesai',
        ]);

        // Handle file upload
        $gambarPath = $request->file('gambar_lokasi')->store('kegiatan', 'public');

        Kegiatan::create([
            'judul' => $request->judul,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'lokasi' => $request->lokasi,
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'batas_pendaftar' => $request->batas_pendaftar,
            'gambar_lokasi' => $gambarPath,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load(['creator', 'pendaftar.user']);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'lokasi_kegiatan' => 'required|string',
            'batas_pendaftar' => 'required|integer|min:1',
            'gambar_lokasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string|in:draft,publish,selesai',
        ]);

        // dd($data['gambar_lokasi']);

        if (isset($data['gambar_lokasi'])) {
            $file = $data['gambar_lokasi'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/kegiatan'), $filename);
            $data['gambar_lokasi'] = 'kegiatan/' . $filename;
        } else {
            // If no new image is uploaded, keep the existing one
            $data['gambar_lokasi'] = $kegiatan->gambar_lokasi;
        }


        $kegiatan->update($data);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kegiatan $kegiatan)
    {
        // Delete image
        if ($kegiatan->gambar_lokasi) {
            Storage::disk('public')->delete($kegiatan->gambar_lokasi);
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
