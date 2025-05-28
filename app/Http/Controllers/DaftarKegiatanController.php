<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DaftarKegiatanController extends Controller
{
    /**
     * Display a listing of registrations for the logged-in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Authorization: Only admin can access this method
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $pendaftaran = DaftarKegiatan::with(['user', 'kegiatan'])
            ->latest()
            ->paginate(15);

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Show the form for creating a new registration.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function create(Kegiatan $kegiatan)
    {
        // Check if user already registered for this event
        $alreadyRegistered = DaftarKegiatan::where('user_id', Auth::id())
            ->where('kegiatan_id', $kegiatan->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('kegiatan.public.show', $kegiatan)
                ->with('error', 'Anda sudah terdaftar dalam kegiatan ini');
        }

        // Check if registration is full
        $currentRegistrations = DaftarKegiatan::where('kegiatan_id', $kegiatan->id)->count();
        if ($currentRegistrations >= $kegiatan->batas_pendaftar) {
            return redirect()->route('kegiatan.public.show', $kegiatan)
                ->with('error', 'Pendaftaran sudah penuh');
        }

        // Check if event still active
        if ($kegiatan->status !== 'aktif' || now()->gt($kegiatan->tanggal_selesai)) {
            return redirect()->route('kegiatan.public.show', $kegiatan)
                ->with('error', 'Kegiatan tidak aktif atau sudah berakhir');
        }

        return view('daftar-kegiatan.create', compact('kegiatan'));
    }

    /**
     * Store a newly created registration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $request->validate([
            'latar_belakang' => 'required|string',
            'pernah_relawan' => 'required|in:pernah,belum',
            'nama_kegiatan_sebelumnya' => 'nullable|required_if:pernah_relawan,pernah|string|max:255',
            'jenis_kendaraan' => 'required|string|max:100',
            'merk_kendaraan' => 'required|string|max:100',
            'siap_kontribusi' => 'required|boolean',
            'bukti_follow' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_repost' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload bukti follow
        $buktiFollowPath = $request->file('bukti_follow')->store('bukti_follow', 'public');

        // Upload bukti repost
        $buktiRepostPath = $request->file('bukti_repost')->store('bukti_repost', 'public');

        DaftarKegiatan::create([
            'user_id' => Auth::id(),
            'kegiatan_id' => $kegiatan->id,
            'status' => 'pending', // Default status
            'tanggal_daftar' => now(),
            'latar_belakang' => $request->latar_belakang,
            'pernah_relawan' => $request->pernah_relawan,
            'nama_kegiatan_sebelumnya' => $request->nama_kegiatan_sebelumnya,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'merk_kendaraan' => $request->merk_kendaraan,
            'siap_kontribusi' => $request->siap_kontribusi,
            'bukti_follow' => $buktiFollowPath,
            'bukti_repost' => $buktiRepostPath,
        ]);

        return redirect()->route('daftar-kegiatan.index')
            ->with('success', 'Pendaftaran kegiatan berhasil, menunggu persetujuan admin');
    }

    /**
     * Display the specified registration.
     *
     * @param  \App\Models\Daftar_Kegiatan  $daftarKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $daftarKegiatan = DaftarKegiatan::findOrFail($id);

        // Authorization: Only admin or the owner can view
        if (Auth::id() !== $daftarKegiatan->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $daftarKegiatan->load(['user', 'kegiatan']);

        return view('admin.pendaftaran.show', compact('daftarKegiatan'));
    }

    /**
     * Approve a registration.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        // Authorization: Only admin can approve
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $daftarKegiatan = DaftarKegiatan::findOrFail($id);

        $daftarKegiatan->update([
            'status' => 'diterima'
        ]);

        return back()->with('success', 'Pendaftaran berhasil disetujui');
    }

    /**
     * Reject a registration.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        // Authorization: Only admin can reject
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $daftarKegiatan = DaftarKegiatan::findOrFail($id);

        $daftarKegiatan->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Pendaftaran berhasil ditolak');
    }
}
