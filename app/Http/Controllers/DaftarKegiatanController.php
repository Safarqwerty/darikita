<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DaftarKegiatanController extends Controller
{
    /**
     * Display a listing of registrations for the admin.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatanOptions = Kegiatan::select('id', 'nama_kegiatan')->orderBy('nama_kegiatan')->get();

        $query = DaftarKegiatan::with(['user', 'kegiatan'])->latest();

        if ($request->filled('nama_kegiatan')) {
            $query->where('kegiatan_id', $request->nama_kegiatan);
        }

        $pendaftaran = $query->get();

        // Return early if no registrations to process
        if ($pendaftaran->isEmpty()) {
            return view('admin.pendaftaran.index', [
                'pendaftaran' => new LengthAwarePaginator([], 0, 15),
                'kegiatanOptions' => $kegiatanOptions,
            ]);
        }

        // TOPSIS Calculation
        $hasil = $this->calculateTopsis($pendaftaran);

        // Sort results by score descending
        usort($hasil, fn($a, $b) => $b['score'] <=> $a['score']);

        // Manual pagination
        $page = $request->input('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;
        $pagedData = array_slice($hasil, $offset, $perPage);

        $paginatedResult = new LengthAwarePaginator(
            $pagedData,
            count($hasil),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pendaftaran.index', [
            'pendaftaran' => $paginatedResult,
            'kegiatanOptions' => $kegiatanOptions,
        ]);
    }

    /**
     * Auto approve and reject registrations based on TOPSIS ranking and volunteer limit.
     *
     * @param int $kegiatanId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function autoApprove($kegiatanId)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        if ($kegiatan->batas_pendaftar <= 0) {
            return back()->with('error', 'Kegiatan ini tidak memiliki batas pendaftar yang valid untuk auto-approval.');
        }

        // Get all pending registrations for this activity
        $pendingRegistrations = DaftarKegiatan::where('kegiatan_id', $kegiatanId)
            ->where('status', 'pending')
            ->get();

        if ($pendingRegistrations->isEmpty()) {
            return back()->with('error', 'Tidak ada pendaftaran dengan status "pending" yang bisa diproses.');
        }

        // Get current approved count
        $currentApprovedCount = DaftarKegiatan::where('kegiatan_id', $kegiatanId)
            ->where('status', 'diterima')
            ->count();

        // Calculate available slots
        $slotsAvailable = $kegiatan->batas_pendaftar - $currentApprovedCount;

        // Calculate TOPSIS scores for pending registrations
        $hasilSeleksi = $this->calculateTopsis($pendingRegistrations);

        // Sort by highest score
        usort($hasilSeleksi, fn($a, $b) => $b['score'] <=> $a['score']);

        $approvedCount = 0;
        $rejectedCount = 0;

        foreach ($hasilSeleksi as $index => $seleksi) {
            $pendaftar = $seleksi['pendaftar'];
            // Approve if there are available slots
            if ($approvedCount < $slotsAvailable) {
                $pendaftar->update(['status' => 'diterima']);
                $approvedCount++;
            } else {
                // Reject the rest
                $pendaftar->update(['status' => 'ditolak']);
                $rejectedCount++;
            }
        }

        return back()->with('success', "Proses seleksi selesai! {$approvedCount} pendaftar diterima dan {$rejectedCount} pendaftar ditolak berdasarkan ranking TOPSIS.");
    }

    /**
     * Show the form for creating a new registration.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Kegiatan $kegiatan)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mendaftar kegiatan.');
        }

        $user = Auth::user();

        $requiredFields = [
            'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama',
            'jenis_kelamin', 'foto', 'nomor_wa', 'link_instagram'
        ];

        foreach ($requiredFields as $field) {
            if (empty($user->{$field})) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Harap lengkapi data profil Anda terlebih dahulu sebelum mendaftar kegiatan.');
            }
        }

        // Check if user already registered for this event
        $alreadyRegistered = DaftarKegiatan::where('user_id', $user->id)
            ->where('kegiatan_id', $kegiatan->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('welcome')
                ->with('error', 'Anda sudah terdaftar dalam kegiatan ini.');
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
        $user = Auth::user();

        // **FIXED**: Add profile completeness validation here as well
        $requiredFields = [
            'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama',
            'jenis_kelamin', 'foto', 'nomor_wa', 'link_instagram'
        ];

        foreach ($requiredFields as $field) {
            if (empty($user->{$field})) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Gagal mendaftar. Harap lengkapi data profil Anda terlebih dahulu.');
            }
        }

        // Check if user already registered for this event
        $alreadyRegistered = DaftarKegiatan::where('user_id', $user->id)
            ->where('kegiatan_id', $kegiatan->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda sudah pernah mendaftar untuk kegiatan ini.');
        }

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

        if (isset($dataToCreate['kategori_kendaraan'])) {
            $dataToCreate['tipe_kendaraan'] = $dataToCreate['kategori_kendaraan'];
            unset($dataToCreate['kategori_kendaraan']);
        }

        if (in_array($request->latar_belakang_pendidikan, ['SMP', 'SMA'])) {
            $dataToCreate['jurusan'] = null;
        }

        $dataToCreate['user_id'] = $user->id;
        $dataToCreate['kegiatan_id'] = $kegiatan->id;
        $dataToCreate['status'] = 'pending';
        $dataToCreate['tanggal_daftar'] = now();

        if ($request->hasFile('bukti_follow')) {
            $dataToCreate['bukti_follow'] = $request->file('bukti_follow')->store('bukti_follow', 'public');
        }

        if ($request->hasFile('bukti_repost')) {
            $dataToCreate['bukti_repost'] = $request->file('bukti_repost')->store('bukti_repost', 'public');
        }

        $dataToCreate['pernah_relawan'] = (bool)$validatedData['pernah_relawan'];
        $dataToCreate['siap_kontribusi'] = (bool)$validatedData['siap_kontribusi'];

        DaftarKegiatan::create($dataToCreate);

        return redirect()->route('public.kegiatan.sukses')
            ->with('success', 'Pendaftaran kegiatan berhasil! Status pendaftaran Anda sedang ditinjau oleh admin.');
    }

    /**
     * Display a success page after registration.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function sukses()
    {
        // Memeriksa session 'success' untuk mencegah akses langsung ke halaman ini
        if (!session('success')) {
            return redirect()->route('welcome'); // Arahkan ke halaman utama jika diakses langsung
        }
        // Menggunakan path view yang benar sesuai dengan struktur folder Anda
        return view('public.kegiatan.sukses');
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

        if (Auth::id() !== $daftarKegiatan->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.pendaftaran.show', compact('daftarKegiatan'));
    }

    /**
     * Calculate TOPSIS scores for a given collection of registrations.
     *
     * @param \Illuminate\Support\Collection $pendaftaran
     * @return array
     */
    private function calculateTopsis(Collection $pendaftaran): array
    {
        $matrix = [];
        $alternatif = [];

        $bobot = [
            'pendidikan' => 0.3,
            'relawan_baru' => 0.2,
            'kontribusi' => 0.2,
            'kendaraan' => 0.3,
        ];

        $pendidikanValue = ['SMP' => 1, 'SMA' => 2, 'S1' => 3, 'S2' => 4];
        $kendaraanValue = [
            'tidak_ada' => 1, 'bebek_skuter' => 2, 'sport' => 3, 'adventure_small' => 4,
            'dual_sport' => 5, 'trail_enduro' => 6, 'city_car' => 2, 'mpv_suv_4x2' => 3,
            'suv_4x4' => 4, 'dcab_4x4' => 5, 'pickup_van' => 6,
        ];

        foreach ($pendaftaran as $item) {
            $matrix[] = [
                'pendidikan' => $pendidikanValue[$item->latar_belakang_pendidikan] ?? 1,
                'relawan_baru' => !$item->pernah_relawan ? 1 : 0,
                'kontribusi' => $item->siap_kontribusi ? 1 : 0,
                'kendaraan' => $kendaraanValue[$item->tipe_kendaraan ?? 'tidak_ada'] ?? 1,
            ];
            $alternatif[] = $item;
        }

        if (empty($matrix)) {
            return [];
        }

        // Normalization
        $normal = [];
        $div = [];
        foreach (array_keys($bobot) as $key) {
            $sumSquares = array_sum(array_map(fn($val) => pow($val, 2), array_column($matrix, $key)));
            $div[$key] = $sumSquares > 0 ? sqrt($sumSquares) : 1;
        }

        foreach ($matrix as $row) {
            $normalRow = [];
            foreach ($row as $k => $v) {
                $normalRow[$k] = $v / $div[$k];
            }
            $normal[] = $normalRow;
        }

        // Weighted Normalization
        $weighted = [];
        foreach ($normal as $row) {
            $wRow = [];
            foreach ($row as $k => $v) {
                $wRow[$k] = $v * $bobot[$k];
            }
            $weighted[] = $wRow;
        }

        // Ideal Solutions
        $idealPos = [];
        $idealNeg = [];
        foreach (array_keys($bobot) as $k) {
            $column = array_column($weighted, $k);
            $idealPos[$k] = max($column);
            $idealNeg[$k] = min($column);
        }

        // Calculate final scores
        $hasil = [];
        foreach ($weighted as $i => $row) {
            $dPos = 0;
            $dNeg = 0;
            foreach ($row as $k => $v) {
                $dPos += pow($v - $idealPos[$k], 2);
                $dNeg += pow($v - $idealNeg[$k], 2);
            }
            $dPos = sqrt($dPos);
            $dNeg = sqrt($dNeg);
            $score = ($dPos + $dNeg) > 0 ? $dNeg / ($dPos + $dNeg) : 0;

            $hasil[] = [
                'pendaftar' => $alternatif[$i],
                'score' => round($score, 4),
            ];
        }

        return $hasil;
    }

    /**
     * Upload contribution proof.
     */
    public function uploadBuktiKontribusi(Request $request, $id)
    {
        $request->validate([
            'bukti_kontribusi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $daftarKegiatan = DaftarKegiatan::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'diterima')
            ->firstOrFail();

        try {
            if ($daftarKegiatan->bukti_kontribusi && Storage::disk('public')->exists($daftarKegiatan->bukti_kontribusi)) {
                Storage::disk('public')->delete($daftarKegiatan->bukti_kontribusi);
            }

            $file = $request->file('bukti_kontribusi');
            $filename = 'bukti_kontribusi_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_kontribusi', $filename, 'public');

            $daftarKegiatan->update([
                'bukti_kontribusi' => $path,
                'tanggal_upload_bukti' => now(),
            ]);

            return redirect()->back()->with('success', 'Bukti kontribusi berhasil diupload!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload bukti kontribusi. Silakan coba lagi.');
        }
    }
}

