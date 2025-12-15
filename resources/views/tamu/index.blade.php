@extends('layouts.app')
@php $title = "Daftar Tamu"; @endphp

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
html { 
    overflow-y: scroll; 
}

body {
    font-family: Inter, sans-serif;
    background: linear-gradient(180deg,#eef4fb,#f7fbf9);
    color:#111827;
}

/* WRAPPER */
.content {
    padding: 40px 20px;
    display:flex;
    justify-content:center;
}
.page-wrapper {
    width:100%;
    max-width:1100px;
}

/* EVENT CARD */
.event-card{
    background:rgba(255,255,255,.75);
    backdrop-filter: blur(10px);
    border-radius:20px;
    padding:24px;
    box-shadow:0 18px 40px rgba(0,0,0,.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:28px;
}
.avatar{
    width:60px;height:60px;
    border-radius:16px;
    background:#eef2ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    font-size:1.4rem;
    color:#4b6cff;
}
.event-title{ font-size:1.35rem;font-weight:700; }
.event-meta{ font-size:.95rem;color:#6b7280; }

/* TABLE */

/* Kolom # */
#tamuTable th:nth-child(1),

#tamuTable thead th {
    text-align: center !important;
    vertical-align: middle;
}

#tamuTable td:nth-child(1) {
    width: 40px !important;
    min-width: 40px;
    max-width: 40px;
    text-align: center;
    padding-left: 6px;
    padding-right: 6px;
    font-weight: 600;
}

#tamuTable td:nth-child(3) {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

#tamuTable td:nth-child(4) {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


#tamuTable {
    table-layout: fixed;
    width: 100%;
}


table {
    table-layout: fixed;
    width: 100%;
}

.table-container{
    background:white;
    border-radius:18px;
    padding:12px;
    box-shadow:0 12px 32px rgba(0,0,0,.06);
}

table.dataTable{
    border-collapse:separate!important;
    border-spacing:0 10px!important;
    width:100%!important;
}

table.dataTable thead th{
    background:#111827;
    color:#fff;
    border:none!important;
    padding:14px;
    font-size:.9rem;
}

table.dataTable tbody tr{
    background:#fff;
    border-radius:14px;
    box-shadow:0 6px 20px rgba(0,0,0,.05);
}

table.dataTable tbody td{
    padding:14px;
    vertical-align:middle;
}

/* DATATABLE UI */
.dataTables_wrapper .top,
.dataTables_wrapper .bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 6px;
}
.dataTables_filter input,
.dataTables_length select{
    border-radius:10px;
    padding:6px 10px;
    border:1px solid #d1d5db;
}

/* BOX */
.pesan-box {
    background:#f1f5f9;
    padding:8px 12px;
    border-radius:10px;

    display:-webkit-box;
    -webkit-line-clamp:2;      /* maksimal 2 baris */
    -webkit-box-orient:vertical;

    overflow:hidden;
    text-overflow:ellipsis;
    line-height:1.4;
    max-width:100%;
    font-size:.95rem;
}

.alamat-box{
    max-width:200px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* BUTTON */
.action-btn{
    padding:8px 12px;
    border-radius:10px;
    font-weight:700;
    border:none;
    cursor:pointer;
}
.btn-detail{ background:#2563eb;color:white; }
.btn-edit{ background:#f59e0b;color:white; }
.btn-delete{ background:#ef4444;color:white; }

.presence-toggle{
    width:18px;
    height:18px;
    cursor:pointer;
}
.waktu-cell{
    font-family:monospace;
    font-size:.9rem;
    text-align:center;
}

.dataTables_paginate {
    display:flex;
    align-items:center;
    gap:8px;
}

.dataTables_paginate .paginate_button {
    padding:6px 12px!important;
    border-radius:8px!important;
    border:1px solid #d1d5db!important;
    background:white!important;
    color:#1f2937!important;
    cursor:pointer;
}

.dataTables_paginate .paginate_button.current {
    background:#2563eb!important;
    color:white!important;
    border:none!important;
}

.dataTables_paginate .paginate_button:hover {
    background:#e5e7eb!important;
}

/* DARK MODE */
body.dark{
    background:#0f172a;
    color:#e5e7eb;
}

body.dark .event-card,
body.dark .table-container{
    background:#111827 !important;
    box-shadow:none;
}

body.dark .dataTables_wrapper table.dataTable thead th{
    background:#0b1220;
    color:#ffffff;
}

body.dark .dataTables_wrapper table.dataTable tbody tr{
    background:#1f2937 !important;
}

body.dark .dataTables_wrapper table.dataTable tbody td{
    background:#1f2937 !important;
    color:#e5e7eb;
}

body.dark .pesan-box{
    background:#334155;
    color:#e5e7eb;
}

body.dark .dataTables_filter input,
body.dark .dataTables_length select{
    background:#1f2937;
    color:#e5e7eb;
    border:1px solid #374151;
}

body.dark .dataTables_filter label,
body.dark .dataTables_length label{
    color:#e5e7eb;
}

body.dark .dataTables_paginate .paginate_button{
    background:#1f2937 !important;
    color:#e5e7eb !important;
    border:1px solid #374151 !important;
}

body.dark .dataTables_paginate .paginate_button.current{
    background:#2563eb !important;
    color:#ffffff !important;
}

body.dark .dataTables_paginate .paginate_button:hover{
    background:#374151 !important;
}
/* =========================
   DARK MODE - MODAL
========================= */
body.dark .modal-content {
    background: #111827;
    color: #e5e7eb;
    border: 1px solid #1f2937;
    box-shadow: 0 30px 80px rgba(0,0,0,.85);
}

body.dark .modal-header {
    border-bottom: 1px solid #1f2937;
}

body.dark .modal-body {
    color: #e5e7eb;
}

body.dark .modal-title {
    color: #f9fafb;
}

/* Close button (X) */
body.dark .modal-header .btn-close {
    filter: invert(1);
    opacity: .8;
}
body.dark .modal-header .btn-close:hover {
    opacity: 1;
}

/* Text inside modal */
body.dark .modal-body p,
body.dark .modal-body strong,
body.dark .modal-body span {
    color: #e5e7eb;
}

/* HR inside modal */
body.dark .modal-body hr {
    border-color: #1f2937;
}

/* Modal backdrop (lebih soft) */
body.dark .modal-backdrop.show {
    opacity: .65;
}

/* =========================
   AKSI BUTTON - CENTER & VERTIKAL
========================= */
.aksi-group {
    display: flex;
    flex-direction: column;   /* vertikal */
    align-items: center;      /* CENTER horizontal */
    justify-content: center;  /* CENTER vertical (di dalam cell) */
    gap: 6px;                 /* jarak rapat */
}

.aksi-group .action-btn {
    min-width: 90px;
    text-align: center;
    padding: 6px 12px;
}

.aksi-group form {
    margin: 0;
}

</style>

<div class="content">
<div class="page-wrapper">

    <!-- EVENT HEADER -->
    <div class="event-card">
        <div class="d-flex gap-3 align-items-center">
            <div class="avatar">{{ strtoupper(substr($event->nama_acara,0,1)) }}</div>
            <div>
                <div class="event-title">{{ $event->nama_acara }}</div>
                <div class="event-meta">
                    {{ $event->tanggal_acara->format('d M Y') }} •
                    {{ $event->tipe === 'resmi' ? 'Acara Resmi' : 'Acara Non Resmi' }}
                </div>
                @if(!empty($event->deskripsi))
                    <div class="event-desc" title="{{ $event->deskripsi }}" style="margin-top:6px; color:#6b7280;">{{ \Illuminate\Support\Str::limit($event->deskripsi, 180) }}</div>
                @endif
            </div>
        </div>
        <button class="action-btn btn-detail" data-bs-toggle="modal" data-bs-target="#addTamuModal">
            + Tambah Tamu
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-container">
       <table id="tamuTable" class="table display" style="width:100%; table-layout:fixed;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Pesan</th>
                    <th>Kehadiran</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tamus as $i => $t)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $t->nama }}</td>
                    <td>{{ $t->email }}</td>
                    <td><div class="alamat-box" title="{{ $t->alamat }}">{{ $t->alamat }}</div></td>
                    <td>
                        <div class="pesan-box" title="{{ $t->pesan }}">
                            {{ $t->pesan }}
                        </div>

                        <button class="action-btn btn-detail mt-2 btn-view"
                            data-nama="{{ $t->nama }}"
                            data-email="{{ $t->email }}"
                            data-alamat="{{ $t->alamat }}"
                                data-pesan="{{ $t->pesan }}"
                                data-nomor="{{ $t->nomor_telepon }}">
                            Detail
                        </button>
                    </td>

                    <td>
                        <input type="checkbox"
                            class="presence-toggle"
                            data-url="{{ route('tamu.presence',[$event->id,$t->id]) }}"
                            {{ $t->kehadiran ? 'checked':'' }}>
                    </td>
                    <td class="waktu-cell"
                        data-time="{{ $t->kehadiran_at?->toIso8601String() }}">
                        {{ $t->kehadiran_at? $t->kehadiran_at->format('H:i d/m/Y'):'-' }}
                    </td>
                    <td>
                        <div class="aksi-group">
                            <a href="{{ route('tamu.edit',[$event->id,$t->id]) }}" class="action-btn btn-edit">Edit</a>

                            <form action="{{ route('tamu.destroy',[$event->id,$t->id]) }}"
                                method="POST"
                                class="delete-form">
                                @csrf @method('DELETE')
                                <button class="action-btn btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
</div>

@include('tamu.create-modal')

<!-- MODAL PESAN -->
<div class="modal fade" id="pesanModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Pesan</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <p><strong>Nama:</strong> <span id="mNama"></span></p>
        <p><strong>Nomor Telepon:</strong> <span id="mNomorTelepon"></span></p>
        <p><strong>Email:</strong> <span id="mEmail"></span></p>
        <p><strong>Alamat:</strong> <span id="mAlamat"></span></p>
        <hr>
        <p id="mPesan"></p>
    </div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function(){

   $('#tamuTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"top"lf>rt<"bottom"ip>',
        columnDefs: [
            { targets: 0, width: "40px" },
            { targets: 1, width: "160px" },
            { targets: 2, width: "160px" },
            { targets: 3, width: "120px" },
            { targets: 4, width: "200px" },
            { targets: 5, width: "40px", className: "text-center" },
            { targets: 6, width: "150px", className: "text-center" },
            { targets: 7, width: "140px" }
        ]
    });

    $('.btn-view').on('click',function(){
        $('#mNama').text($(this).data('nama'));
        // be resilient to either data-nomor or data-nomor_telepon attributes
        $('#mNomorTelepon').text($(this).data('nomor') || $(this).data('nomor_telepon') || '-');
        $('#mEmail').text($(this).data('email'));
        $('#mAlamat').text($(this).data('alamat'));
        $('#mPesan').text($(this).data('pesan'));
        new bootstrap.Modal('#pesanModal').show();
    });

    function pad(n){return n<10?'0'+n:n;}
    function format(d){
        return pad(d.getHours())+':'+pad(d.getMinutes())+' '+pad(d.getDate())+'/'+pad(d.getMonth()+1)+'/'+d.getFullYear();
    }

    /* ============================
       FIX KEHADIRAN (STATIS)
    ============================ */
    $('.presence-toggle').on('change', function () {

    let cb = $(this);
    let url = cb.data('url');
    let cell = cb.closest('tr').find('.waktu-cell');

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            present: cb.prop('checked') ? 1 : 0,
            _token: $('meta[name=csrf-token]').attr('content')
        },
        success: function (res) {
            if (res.ok) {
                cell.text(res.waktu);
            }
        },
        error: function () {
            cb.prop('checked', !cb.prop('checked'));
            alert('Gagal memperbarui kehadiran');
        }
    });

});
    /* ============================
       KONFIRMASI HAPUS TAMU
    ============================ */

    $('.delete-form').on('submit',function(e){
        e.preventDefault();
        let f=this;
        Swal.fire({
            title:'Hapus?',
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'Hapus'
        }).then(r=>{ if(r.isConfirmed) f.submit(); });
    });

});
</script>

@endsection
