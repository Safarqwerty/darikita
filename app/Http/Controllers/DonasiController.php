<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donasis = Donasi::with('creator')->latest()->paginate(10);
        return view('admin.donasi.index', compact('donasis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Authorization: Only admin can create
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.donasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Authorization: Only admin can create
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_bencana' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string|in:open,closed',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        $gambarPath = $request->file('gambar')->store('donasi', 'public');

        Donasi::create([
            'nama_bencana' => $request->nama_bencana,
            'deskripsi' => $request->deskripsi,
            'target_dana' => $request->target_dana,
            'dana_terkumpul' => 0, // Default 0
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
            'gambar' => $gambarPath,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donasi  $donasi
     * @return \Illuminate\Http\Response
     */
    public function show(Donasi $donasi)
    {
        $donasi->load(['creator', 'pemberiDonasi.user']);
        return view('donasi.show', compact('donasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donasi  $donasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Donasi $donasi)
    {
        // Authorization: Only admin can edit
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.donasi.edit', compact('donasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donasi  $donasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donasi $donasi)
    {
        // Authorization: Only admin can update
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_bencana' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|numeric|min:' . $donasi->dana_terkumpul, // Cannot be less than collected
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string|in:open,closed',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_bencana' => $request->nama_bencana,
            'deskripsi' => $request->deskripsi,
            'target_dana' => $request->target_dana,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
        ];

        // Handle file upload if new image is provided
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($donasi->gambar) {
                Storage::disk('public')->delete($donasi->gambar);
            }

            $gambarPath = $request->file('gambar')->store('donasi', 'public');
            $data['gambar'] = $gambarPath;
        }

        $donasi->update($data);

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donasi  $donasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donasi $donasi)
    {
        // Authorization: Only admin can delete
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Check if there are donations
        if ($donasi->pemberiDonasi()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus donasi yang sudah memiliki donatur.');
        }

        // Delete image
        if ($donasi->gambar) {
            Storage::disk('public')->delete($donasi->gambar);
        }

        $donasi->delete();

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil dihapus!');
    }

    /**
     * Display a listing of active donations for public view.
     *
     * @return \Illuminate\Http\Response
     */
    public function listActive()
    {
        $donasis = Donasi::where('status', 'aktif')
            ->whereDate('tanggal_selesai', '>=', now())
            ->latest()
            ->paginate(12);

        return view('donasi.public', compact('donasis'));
    }

    /**
     * Show details of a specific donation for public.
     *
     * @param  \App\Models\Donasi  $donasi
     * @return \Illuminate\Http\Response
     */
    public function publicShow(Donasi $donasi)
    {
        // Calculate percentage progress
        $progressPercentage = 0;
        if ($donasi->target_dana > 0) {
            $progressPercentage = min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100);
        }

        return view('donasi.public-detail', compact('donasi', 'progressPercentage'));
    }

    public function showdonasi($id)
    {
        $donasi = Donasi::findOrFail($id);

        // Hitung progress donasi
        $progress = $donasi->target_donasi > 0 ?
            ($donasi->terkumpul / $donasi->target_donasi) * 100 : 0;

        return view('donasi.detail', compact('donasi', 'progress'));
    }
}
