<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Halaman utama: daftar acara + form tambah acara
    public function create()
    {
        $events = Event::latest()->get();
        return view('event.create', compact('events'));
    }

    // Simpan acara baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'deskripsi' => 'nullable|string',
            'tipe' => 'nullable|in:resmi,non_resmi',
        ]);

        $event = Event::create([
            'nama_acara' => $request->nama_acara,
            'tanggal_acara' => $request->tanggal_acara,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe ?? 'non_resmi',
        ]);

        return redirect()->route('tamu.index', $event->id)
            ->with('success', 'Acara "' . $event->nama_acara . '" berhasil dibuat.');
    }

    // Hapus acara dan tamu terkait
    public function destroy(Event $event)
    {
        $event->tamus()->delete();
        $event->delete();

        return redirect()->route('event.create')
            ->with('success', 'Acara "' . $event->nama_acara . '" berhasil dihapus beserta semua tamu.');
    }

    // Toggle or set event status via AJAX
    public function toggleStatus(Request $request, Event $event)
    {
        $new = $request->input('status');
        if (!$new) {
            // toggle between 'finished' and 'ongoing'
            if ($event->status === 'Selesai') {
                $event->status = 'Berlangsung';
            } else {
                $event->status = 'Selesai';
            }
        } else {
            $event->status = $new;
        }
        $event->save();

        return response()->json(['ok' => true, 'status' => $event->status]);
    }
    public function index()
{
    $events = Event::latest()->get();
    return view('event.index', compact('events'));
}

    // Edit event form
    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'deskripsi' => 'nullable|string',
            'tipe' => 'nullable|in:resmi,non_resmi',
        ]);

        $event->update([
            'nama_acara' => $request->nama_acara,
            'tanggal_acara' => $request->tanggal_acara,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe ?? 'non_resmi',
        ]);

        return redirect()->route('event.index')->with('success', 'Acara berhasil diperbarui.');
    }

}
