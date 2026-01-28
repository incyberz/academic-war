<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Stm;
use App\Models\TahunAjar;
use App\Models\User;
use App\Models\UnitPenugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StmController extends Controller
{
    /**
     * Tampilkan daftar STM.
     */
    public function index()
    {
        if (!isRole('super_admin')) return redirect()->route('dashboard')->with('error', "Hanya Super Admin yang boleh akses Index STM");
        $stms = Stm::with(['tahunAjar', 'dosen', 'unitPenugasan'])->paginate(10);

        return view('stm.index', compact('stms'));
    }

    /**
     * Tampilkan form untuk membuat STM baru.
     */
    public function create(Request $request)
    {
        $tahunAjarId = session('tahun_ajar_id');

        if (!$tahunAjarId) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Tahun Ajar belum dipilih. Silahkan pilih Tahun Ajar terlebih dahulu.');
        }

        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $dosenId = $dosen->id;

        // jika sudah ada STM pada TA aktif, jangan bikin baru (unique)
        $existing = Stm::query()
            ->where('tahun_ajar_id', $tahunAjarId)
            ->where('dosen_id', $dosenId)
            ->first();

        if ($existing) {
            return redirect()
                ->route('stm.edit', $existing->id)
                ->with('info', 'STM untuk Tahun Ajar ini sudah ada. Silahkan edit STM yang tersedia.');
        }

        // list unit penugasan untuk dropdown
        $unitPenugasan = UnitPenugasan::query()
            ->orderBy('nama')
            ->get();

        // default value untuk form
        $stm = new Stm([
            'tahun_ajar_id' => $tahunAjarId,
            'dosen_id' => $dosenId,
            'status' => 'draft',
        ]);

        return view('stm.create', compact('stm', 'unitPenugasan'));
    }

    /**
     * Simpan STM baru ke database.
     */
    public function store(Request $request)
    {
        $tahunAjarId = session('tahun_ajar_id');

        if (!$tahunAjarId) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Tahun Ajar belum dipilih. Silahkan pilih Tahun Ajar terlebih dahulu.');
        }

        // pastikan user login adalah dosen yang valid (ada row di tabel dosen)
        $dosen = Dosen::query()
            ->where('user_id', Auth::id())
            ->first();

        if (!$dosen) {
            return back()
                ->withInput()
                ->with('error', 'Akun Anda belum terdaftar sebagai dosen. Hubungi admin.');
        }

        $validated = $request->validate([
            'unit_penugasan_id'      => ['required', 'integer', 'exists:unit_penugasan,id'],
            'nomor_surat'            => ['required', 'string', 'max:255'],
            'tanggal_surat'          => ['required', 'date'],
            'penandatangan_nama'     => ['required', 'string', 'max:255'],
            'penandatangan_jabatan'  => ['required', 'string', 'max:255'],
        ]);

        // enforce 1 STM per TA per dosen
        $exists = Stm::query()
            ->where('tahun_ajar_id', $tahunAjarId)
            ->where('dosen_id', $dosen->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('stm.index')
                ->with('warning', 'STM Anda pada Tahun Ajar ini sudah ada.');
        }

        $stm = Stm::create([
            'tahun_ajar_id'          => $tahunAjarId,
            'dosen_id'              => $dosen->id,
            'unit_penugasan_id'      => $validated['unit_penugasan_id'],

            'nomor_surat'            => $validated['nomor_surat'],
            'tanggal_surat'          => $validated['tanggal_surat'],
            'penandatangan_nama'     => $validated['penandatangan_nama'],
            'penandatangan_jabatan'  => $validated['penandatangan_jabatan'],

            'uuid'                   => (string) Str::uuid(),
            'status'                 => 'draft',
        ]);

        return redirect()
            ->route('stm.show', $stm->id)
            ->with('success', 'STM berhasil dibuat. Silahkan tambahkan Item MK.');
    }

    /**
     * Tampilkan detail STM.
     */
    public function show(Stm $stm): \Illuminate\View\View
    {
        // Eager load semua relasi yang diperlukan, termasuk detail STM Items
        $stm->load([
            'tahunAjar',
            'dosen',
            'unitPenugasan',
            'items.kurMk',   // memuat nama mata kuliah
            'items.kelas',   // memuat detail kelas
        ]);

        return view('stm.show', compact('stm'));
    }


    /**
     * Tampilkan form untuk mengedit STM.
     */
    public function edit(Stm $stm)
    {
        $tahunAjar = TahunAjar::all();
        $dosen = User::all();
        $unitPenugasan = UnitPenugasan::all();

        return view('stm.edit', compact('stm', 'tahunAjar', 'dosen', 'unitPenugasan'));
    }

    /**
     * Update STM di database.
     */
    public function update(Request $request, Stm $stm)
    {
        $request->validate([
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
            'dosen_id' => 'required|exists:users,id',
            'unit_penugasan_id' => 'required|exists:unit_penugasan,id',
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'penandatangan_nama' => 'nullable|string|max:255',
            'penandatangan_jabatan' => 'nullable|string|max:255',
            'status' => 'required|in:draft,disahkan',
        ]);

        $stm->update($request->all());

        return redirect()->route('stm.index')->with('success', 'STM berhasil diperbarui!');
    }

    /**
     * Hapus STM.
     */
    public function destroy(Stm $stm)
    {
        $stm->delete();
        return redirect()->route('stm.index')->with('success', 'STM berhasil dihapus!');
    }
}
