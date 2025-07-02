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
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:100',
            'deskripsi_kegiatan' => 'required|string',
            'syarat_ketentuan' => 'nullable|string',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan_desa' => 'required|string|max:255',
            'batas_pendaftar' => 'nullable|integer|min:1',
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_lokasi' => 'nullable|array|max:10',
            'gambar_lokasi.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_mulai_daftar' => 'required|date',
            'tanggal_selesai_daftar' => 'required|date|after_or_equal:tanggal_mulai_daftar',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'status' => 'required|string|in:draft,publish,selesai',
        ]);

        $data = $request->all();

        // Handle gambar sampul upload
        if ($request->hasFile('gambar_sampul')) {
            // $data['gambar_sampul'] = $request->file('gambar_sampul')->store('kegiatan/sampul', 'public');
        }

        if ($request->file('gambar_sampul')) {
            $file = $request->file('gambar_sampul');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/kegiatan/sampul'), $filename);
            $data['gambar_sampul'] = 'kegiatan/sampul/' . $filename;
        }

        if ($request->file('gambar_lokasi')) {
            foreach ($request->file('gambar_lokasi') as $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/kegiatan/lokasi'), $filename);
                $filenames[] = 'kegiatan/lokasi/' . $filename;
            }
            $data['gambar_lokasi'] = json_encode($filenames);
        }

        // Handle multiple gambar lokasi upload
        // if ($request->hasFile('gambar_lokasi')) {
        //     $gambarLokasiPaths = [];
        //     foreach ($request->file('gambar_lokasi') as $file) {
        //         $gambarLokasiPaths[] = $file->store('kegiatan/lokasi', 'public');
        //     }
        //     $data['gambar_lokasi'] = $gambarLokasiPaths;
        // }

        $data['created_by'] = Auth::id();

        Kegiatan::create($data);

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
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:100',
            'deskripsi_kegiatan' => 'required|string',
            'syarat_ketentuan' => 'nullable|string',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan_desa' => 'required|string|max:255',
            'batas_pendaftar' => 'nullable|integer|min:1',
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_lokasi' => 'nullable|array|max:10',
            'gambar_lokasi.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_mulai_daftar' => 'required|date',
            'tanggal_selesai_daftar' => 'required|date|after_or_equal:tanggal_mulai_daftar',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'status' => 'required|string|in:draft,publish,selesai',
        ]);

        // Handle gambar sampul upload
        if ($request->hasFile('gambar_sampul')) {
            // Delete old gambar sampul if exists
            if ($kegiatan->gambar_sampul) {
                Storage::disk('public')->delete($kegiatan->gambar_sampul);
            }
            $data['gambar_sampul'] = $request->file('gambar_sampul')->store('kegiatan/sampul', 'public');
        }

        // Handle multiple gambar lokasi upload
        if ($request->hasFile('gambar_lokasi')) {
            // Delete old gambar lokasi if exists (with safety check)
            if ($kegiatan->gambar_lokasi && is_array($kegiatan->gambar_lokasi)) {
                foreach ($kegiatan->gambar_lokasi as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $gambarLokasiPaths = [];
            foreach ($request->file('gambar_lokasi') as $file) {
                $gambarLokasiPaths[] = $file->store('kegiatan/lokasi', 'public');
            }
            $data['gambar_lokasi'] = $gambarLokasiPaths;
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
        // Delete gambar sampul
        if ($kegiatan->gambar_sampul) {
            Storage::disk('public')->delete($kegiatan->gambar_sampul);
        }

        // Delete gambar lokasi (with safety check)
        if ($kegiatan->gambar_lokasi && is_array($kegiatan->gambar_lokasi)) {
            foreach ($kegiatan->gambar_lokasi as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
