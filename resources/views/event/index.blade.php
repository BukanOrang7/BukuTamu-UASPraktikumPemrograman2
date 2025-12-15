@extends('layouts.app')
@php $title = "Buku Catatan Tamu"; @endphp

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Styles: hybrid Bootstrap + custom -->
<style>
    /* --- basic --- */
    html { overflow-y: scroll; }
    :root {
        --primary: #0b5ed7;
        --muted: #6d7580;
        --card-bg: rgba(255,255,255,0.85);
    }

    /* Blob background (keep your custom look) */
    .blob-bg {
        position: absolute;
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        width: 900px;
        height: 500px;
        background: radial-gradient(circle at 30% 20%, #4e8cff 0%, #73c8ff 40%, transparent 70%);
        filter: blur(80px);
        opacity: .65;
        z-index: -1;
        pointer-events:none;
    }

    /* HERO (use Bootstrap card but keep glass style) */
    .center-hero {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        padding: 36px;
        border-radius: 18px;
        box-shadow: 0 18px 46px rgba(0,0,0,0.06);
        margin-bottom: 30px;
    }
    .center-hero h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: .25rem; }
    .center-hero .meta { color: var(--muted); font-size: .95rem; }

    .clock { color: var(--primary); font-weight: 600; }

    /* Buttons (blend bootstrap + custom) */
    .btn-add {
        background: white;
        color: var(--primary);
        border: 1px solid #d0d7ff;
        font-weight: 600;
        border-radius: 10px;
    }
    .btn-add:hover { background: var(--primary); color: white; }

    /* LIST ITEMS - use Bootstrap row / card */
    .event-item {
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 18px;
        border-radius: 12px;
        background: white;
        box-shadow: 0 10px 30px rgba(2,6,23,0.04);
        margin-bottom: 16px;
    }

    .avatar {
        width:58px; height:58px; border-radius:12px;
        background:#eef2ff; display:flex; align-items:center; justify-content:center;
        font-weight:700; color:#355bd6;
    }

    .event-title { font-size:1.05rem; font-weight:700; }
    .event-desc { color:var(--muted); font-size:.95rem; }

    /* Action column */
    .event-actions {
        margin-left:auto;
        display:flex;
        gap:8px;
        align-items:center;
    }
    .event-actions .btn, .action-btn { min-width:110px; background:#f1f5f9; border-radius:10px; font-weight:700; padding:8px 12px; }

    /* Action button colors */
    .action-btn { border: none; cursor: pointer; }
    .btn-detail { background:#2563eb; color:white; }
    .btn-edit { background:#f59e0b; color:white; }
    .btn-delete { background:#ef4444; color:white; }

    /* Button polish */
    .action-btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; height:40px; min-width:110px; }
    a.action-btn, a.action-btn:hover, a.action-btn:active { text-decoration: none !important; }
    .action-btn:focus { outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }

    @media (max-width:768px) {
        .center-hero { padding: 20px; }
        .center-hero h1 { font-size:1.4rem; }
        .event-item { padding:12px; }
        .event-title { font-size:1rem; }
        .event-actions { flex-direction:column; gap:8px; align-items:stretch; }
        .action-btn { width:100%; }
    }

    /* Status button keep your custom variants */
    .status-btn {
        border: none;
        cursor: pointer;
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 12px;
        background: #e6f6ff;
        color: #062a4a;
    }
    .status-btn.status-belum { background:#fef3c7; color:#92400e; }
    .status-btn.status-berlangsung { background:#10b981; color:#052e18; }
    .status-btn.status-selesai { background:#6b7280; color:#0f172a; }
    .status-btn.small { padding:6px 10px; font-size:.85rem; }
    .status-btn.small.toggle-status-btn { background:#eef2ff; color:#355bd6; }

    /* smaller screens */
    @media (max-width: 576px) {
        .event-item { flex-direction: column; align-items:flex-start; }
        .event-actions { width:100%; justify-content:space-between; margin-top:8px; flex-direction:column; gap:8px; }
        .event-actions .action-btn { width:100%; }
    }

    /* DARK MODE adjustments */
    body.dark {
    --card-bg: rgba(17,24,39,0.85);
        }

        body.dark .center-hero,
        body.dark .event-item,
        body.dark .card,
        body.dark .list-group-item {
            background:#111827 !important;
            color:#e5e7eb;
        }

        body.dark .center-hero {
            box-shadow:0 20px 50px rgba(0,0,0,0.6);
        }
    body.dark .center-hero { background: rgba(31,41,55,0.75); color:#e5e7eb; box-shadow:0 20px 50px rgba(0,0,0,0.6); }
    body.dark .event-item { background:#1f2937; box-shadow:none; border:1px solid rgba(222, 38, 38, 0.03); }
    body.dark .avatar { background:#1f2937; color:#93c5fd; }
    body.dark .event-desc { color:#cbd5e1; }
    body.dark .event-title { color: #f3f4f6; }
    body.dark .clock { color: white }
    body.dark .btn-add { background:#0b5ed7; color:white; border:none; }
    body.dark .status-btn.status-selesai { background:#6b7280!important; color:white; }

    /* Modal small tweaks */
    .modal-confirm .modal-content { border-radius:12px; }
</style>

<div class="blob-bg"></div>

<div class="container py-4">

    <!-- HERO (Bootstrap row inside container) -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="center-hero d-flex align-items-center justify-content-between">
                <div>
                    <h1>BUKU TAMU</h1>
                    <div class="meta">
                        <span class="clock" id="liveClock">{{ now()->format('d-m-Y H:i:s') }}</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('event.create') }}" class="action-btn btn-add btn-lg">
                        + Tambah Acara
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- EVENTS LIST -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-dark text-white" style="border-radius:12px 12px 0 0;">
                    Daftar Acara
                </div>

                <div class="card-body">

                    @forelse($events as $ev)
                        <div class="event-item align-items-center">
                            <div class="avatar">
                                {{ strtoupper(substr($ev->nama_acara, 0, 1)) }}
                            </div>

                            <div class="ms-2">
                                <div class="event-title">{{ $ev->nama_acara }}</div>
                                <div class="event-desc">
                                    <div>{{ \Carbon\Carbon::parse($ev->tanggal_acara)->format('d M Y') }}</div>
                                    @if(!empty($ev->deskripsi))
                                        <div title="{{ $ev->deskripsi }}">{{ \Illuminate\Support\Str::limit($ev->deskripsi, 120) }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="event-actions">

                                @php
                                    $eventDate = \Carbon\Carbon::parse($ev->tanggal_acara);
                                    if ($eventDate->isFuture()) {
                                        $autoStatus = 'belum';
                                    } elseif ($eventDate->isToday()) {
                                        $autoStatus = 'berlangsung';
                                    } else {
                                        $autoStatus = 'selesai';
                                    }
                                @endphp

                                <!-- Auto status badge (updates in real-time via JS) -->
                                <button type="button"
                                    class="status-btn auto-status status-{{ $autoStatus }}"
                                    data-date="{{ $ev->tanggal_acara ? $ev->tanggal_acara->format('Y-m-d') : '' }}">
                                    {{ $autoStatus == 'belum' ? 'Belum Mulai' : ($autoStatus == 'berlangsung' ? 'Berlangsung' : 'Selesai') }}
                                </button>

                                <!-- Keep the existing toggle button for manual toggles -->

                                <a href="{{ route('tamu.index', $ev->id) }}" class="action-btn btn-detail">
                                    Detail
                                </a>

                                <a href="{{ route('event.edit', $ev->id) }}" class="action-btn btn-edit">Edit</a>

                                <form method="POST" action="{{ route('event.destroy', $ev->id) }}" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete">Hapus</button>
                                </form>

                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            Belum ada acara. Tambah acara terlebih dahulu.
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal: Confirm Delete (Bootstrap) -->
<div class="modal fade modal-confirm" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm">
      <div class="modal-header border-0">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-0">Yakin ingin menghapus acara ini? Tindakan ini tidak bisa dibatalkan.</p>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS (assume app layout includes bootstrap but keep here for safety) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toggle status AJAX + Delete confirm scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // LIVE CLOCK
    function updateClock() {
        const el = document.getElementById('liveClock');
        if (!el) return;
        const now = new Date();
        const pad = n => String(n).padStart(2,'0');
        el.textContent = `${pad(now.getDate())}-${pad(now.getMonth()+1)}-${now.getFullYear()} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Toggle status buttons (AJAX POST)
    document.querySelectorAll('.toggle-status-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const button = this;
            const url = button.dataset.url;

            // optimistic UI: give small fade
            button.disabled = true;
            button.style.opacity = '.6';

            fetch(url, {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                },
            })
            .then(res => res.json())
            .then(data => {
                // update label and classes for the small manual toggle
                if (data.status === 'Berlangsung' || data.status === true) {
                    button.classList.remove('status-selesai');
                    button.classList.add('status-berlangsung');
                    button.textContent = 'Resmi';
                } else {
                    button.classList.remove('status-berlangsung');
                    button.classList.add('status-selesai');
                    button.textContent = 'Non Resmi';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Gagal mengubah status acara');
            })
            .finally(() => {
                button.disabled = false;
                button.style.opacity = '1';
            });
        });
    });

    // AUTO STATUS: compute from tanggal_acara and update in realtime
    function updateAutoStatuses() {
        document.querySelectorAll('.auto-status').forEach(btn => {
            const dateStr = btn.dataset.date;
            if (!dateStr) return;
            const eventDate = new Date(dateStr + 'T00:00:00');
            const today = new Date();
            const e = new Date(eventDate.getFullYear(), eventDate.getMonth(), eventDate.getDate());
            const t = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            let state;
            if (e.getTime() > t.getTime()) state = 'belum';
            else if (e.getTime() === t.getTime()) state = 'berlangsung';
            else state = 'selesai';

            btn.classList.remove('status-belum','status-berlangsung','status-selesai');
            btn.classList.add('status-' + state);
            btn.textContent = state === 'belum' ? 'Belum Mulai' : (state === 'berlangsung' ? 'Berlangsung' : 'Selesai');
        });
    }

    // run immediately and then every minute
    updateAutoStatuses();
    setInterval(updateAutoStatuses, 60 * 1000);

    // Delete confirmation: intercept all .delete-form
    let deleteForm = null;
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            deleteForm = this;
            const modalEl = document.getElementById('confirmDeleteModal');
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteForm) return;
        // optionally show spinner or disable button
        deleteForm.submit();
    });
});
</script>

@endsection
