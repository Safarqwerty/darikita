<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DaftarKegiatanController extends Controller
{
    /**
     * Display a listing of registrations for the admin.
     *
     * @return \Illuminate\View\View
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
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Kegiatan $kegiatan)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mendaftar kegiatan.');
        }

        // Check if user already registered for this event
        $alreadyRegistered = DaftarKegiatan::where('user_id', Auth::id())
            ->where('kegiatan_id', $kegiatan->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('welcome')
                ->with('error', 'Anda sudah terdaftar dalam kegiatan ini.');
        }

        // Check if registration is full
        $currentRegistrations = DaftarKegiatan::where('kegiatan_id', $kegiatan->id)->where('status', 'diterima')->count();
        if ($kegiatan->batas_pendaftar > 0 && $currentRegistrations >= $kegiatan->batas_pendaftar) {
            return redirect()->route('welcome')
                ->with('error', 'Pendaftaran untuk kegiatan ini sudah penuh.');
        }

        // Check if event still active
        if ($kegiatan->status !== 'aktif' || now()->gt($kegiatan->tanggal_selesai)) {
            return redirect()->route('welcome')
                ->with('error', 'Kegiatan tidak aktif atau sudah berakhir.');
        }

        return view('daftar-kegiatan.create', compact('kegiatan'));
    }

    /**
     * Store a newly created registration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Aturan validasi disesuaikan dengan form HTML
        $validatedData = $request->validate([
            'latar_belakang_pendidikan' => ['required', Rule::in(['SMP', 'SMA', 'S1', 'S2'])],
            'jurusan' => 'nullable|required_if:latar_belakang_pendidikan,S1,S2|string|max:255',
            'pernah_relawan' => 'required|boolean',
            'nama_kegiatan_sebelumnya' => 'nullable|required_if:pernah_relawan,1|string|max:500',
            'jenis_kendaraan' => ['required', 'string', Rule::in(['motor', 'mobil', 'tidak_ada'])],
            'kategori_kendaraan' => 'nullable|required_if:jenis_kendaraan,motor,mobil|string|max:100',
            'siap_kontribusi' => 'required|boolean',
            'bukti_follow' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_repost' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'alasan_diloloskan' => 'required|string|max:1000',
        ]);

        $dataToCreate = $validatedData;

        // Mengganti key 'kategori_kendaraan' menjadi 'tipe_kendaraan' agar sesuai dengan migrasi DB
        if(isset($dataToCreate['kategori_kendaraan'])) {
            $dataToCreate['tipe_kendaraan'] = $dataToCreate['kategori_kendaraan'];
            unset($dataToCreate['kategori_kendaraan']);
        }

        // Mengosongkan jurusan jika tidak relevan untuk menjaga data tetap bersih
        if($request->latar_belakang_pendidikan === 'SMP' || $request->latar_belakang_pendidikan === 'SMA') {
            $dataToCreate['jurusan'] = null;
        }

        $dataToCreate['user_id'] = Auth::id();
        $dataToCreate['kegiatan_id'] = $kegiatan->id;
        $dataToCreate['status'] = 'pending';
        $dataToCreate['tanggal_daftar'] = now();

        // Handle file uploads menggunakan Storage facade
        if ($request->hasFile('bukti_follow')) {
            $dataToCreate['bukti_follow'] = $request->file('bukti_follow')->store('bukti_follow', 'public');
        }

        if ($request->hasFile('bukti_repost')) {
            $dataToCreate['bukti_repost'] = $request->file('bukti_repost')->store('bukti_repost', 'public');
        }

        // Memastikan nilai boolean tersimpan dengan benar
        $dataToCreate['pernah_relawan'] = (bool)$validatedData['pernah_relawan'];
        $dataToCreate['siap_kontribusi'] = (bool)$validatedData['siap_kontribusi'];

        DaftarKegiatan::create($dataToCreate);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran kegiatan berhasil! Status pendaftaran Anda sedang ditinjau oleh admin.');
    }


    /**
     * Display the specified registration.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $daftarKegiatan = DaftarKegiatan::with(['user', 'kegiatan'])->findOrFail($id);

        // Authorization: Only admin or the owner can view
        if (Auth::id() !== $daftarKegiatan->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.pendaftaran.show', compact('daftarKegiatan'));
    }

    /**
     * Approve a registration.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        // Authorization: Only admin can approve
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $daftarKegiatan = DaftarKegiatan::findOrFail($id);
        $daftarKegiatan->update(['status' => 'diterima']);

        return back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    /**
     * Reject a registration.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        // Authorization: Only admin can reject
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $daftarKegiatan = DaftarKegiatan::findOrFail($id);
        $daftarKegiatan->update(['status' => 'ditolak']);

        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
