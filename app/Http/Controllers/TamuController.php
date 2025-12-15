<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    /* =========================
       INDEX – DAFTAR TAMU
    ========================== */
    public function index(Request $request, $event_id)
    {
        $event = Event::findOrFail($event_id);
        $allEvents = Event::latest()->get();

        $search = $request->input('search');

        $tamus = Tamu::where('event_id', $event_id)
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tamu.index', compact(
            'event',
            'allEvents',
            'tamus',
            'search'
        ));
    }

    /* =========================
       STORE – TAMBAH TAMU
    ========================== */
    public function store(Request $request, $event_id)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'nomor_telepon'  => 'required|string|max:50',
            'email'          => 'required|email|max:255',
            'alamat'         => 'required|string|max:1000',
            'pesan'          => 'nullable|string',
        ]);

        Tamu::create([
            'event_id'       => $event_id,
            'nama'           => $request->nama,
            'nomor_telepon'  => $request->nomor_telepon,
            'email'          => $request->email,
            'alamat'         => $request->alamat,
            'pesan'          => $request->pesan,
            'kehadiran'      => false,
            'kehadiran_at'   => null,
        ]);

        return redirect()
            ->route('tamu.index', $event_id)
            ->with('success', 'Data tamu berhasil disimpan.');
    }

    /* =========================
       EDIT FORM
    ========================== */
    public function edit($event_id, Tamu $tamu)
    {
        $event = Event::findOrFail($event_id);
        return view('tamu.edit', compact('event', 'tamu'));
    }

    /* =========================
       UPDATE DATA TAMU
    ========================== */
    public function update(Request $request, $event_id, Tamu $tamu)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'nomor_telepon'  => 'required|string|max:50',
            'email'          => 'required|email|max:255',
            'alamat'         => 'required|string|max:1000',
            'pesan'          => 'nullable|string',
        ]);

        // ⚠️ PENTING:
        // Kita TIDAK menyentuh kehadiran & kehadiran_at
        $tamu->update(
            $request->only([
                'nama',
                'nomor_telepon',
                'email',
                'alamat',
                'pesan'
            ])
        );

        return redirect()
            ->route('tamu.index', $event_id)
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    /* =========================
       DELETE TAMU
    ========================== */
    public function destroy($event_id, Tamu $tamu)
    {
        $tamu->delete();

        return redirect()
            ->route('tamu.index', $event_id)
            ->with('success', 'Data tamu berhasil dihapus.');
    }

    /* =========================
       REKAP KEHADIRAN
    ========================== */
    public function rekap($event_id)
    {
        $event = Event::findOrFail($event_id);
        $tamus = Tamu::where('event_id', $event_id)->get();

        return view('tamu.rekap', compact('event', 'tamus'));
    }

    /* =========================
       EXPORT CSV
    ========================== */
    public function exportCSV($event_id)
    {
        $event = Event::findOrFail($event_id);
        $filename = 'laporan_tamu_' . $event->id . '.csv';

        $tamus = Tamu::where('event_id', $event_id)->get();

        $handle = fopen($filename, 'w+');

        fputcsv($handle, [
            'ID',
            'Nama',
            'Nomor Telepon',
            'Email',
            'Alamat',
            'Pesan',
            'Kehadiran',
            'Waktu Kehadiran'
        ]);

        foreach ($tamus as $tamu) {
            fputcsv($handle, [
                $tamu->id,
                $tamu->nama,
                $tamu->nomor_telepon,
                $tamu->email,
                $tamu->alamat,
                $tamu->pesan,
                $tamu->kehadiran ? 'Hadir' : 'Tidak Hadir',
                $tamu->kehadiran_at
                    ? $tamu->kehadiran_at->format('d-m-Y H:i')
                    : '-'
            ]);
        }

        fclose($handle);

        return response()->download($filename);
    }

    /* =========================
       TOGGLE KEHADIRAN (AJAX)
    ========================== */
    public function togglePresence(Request $request, $event_id, Tamu $tamu)
{
    $present = $request->boolean('present');

    $tamu->kehadiran = $present;

    if ($present) {
        // SET SEKALI SAJA
        $tamu->kehadiran_at = now();
    } else {
        $tamu->kehadiran_at = null;
    }

    $tamu->save();

    return response()->json([
        'ok' => true,
        'kehadiran' => $tamu->kehadiran,
        // kirim format siap tampil
        'waktu' => $tamu->kehadiran_at
            ? $tamu->kehadiran_at->format('H:i d/m/Y')
            : '-'
    ]);
}
}