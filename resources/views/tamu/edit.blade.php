@extends('layouts.app')
@section('content')

@php $title = "Edit Tamu"; @endphp

<style>
/* Reuse create/edit form styles */
.content-wrapper { width:100%; display:flex; justify-content:center; padding:40px 20px; }
.form-container { width:100%; max-width:900px; }
.hero-card { background: rgba(255,255,255,0.9); padding:32px; border-radius:22px; margin-bottom:24px; box-shadow:0 18px 40px rgba(16,24,40,0.08); border:1px solid rgba(16,24,40,0.05); }
.hero-title { font-size:1.6rem; font-weight:700; }
.hero-sub { opacity:.65; margin-top:6px; }
.form-card { background: rgba(255,255,255,0.85); padding:28px; border-radius:18px; box-shadow:0 14px 32px rgba(16,24,40,0.06); border:1px solid rgba(16,24,40,0.04); }
.form-label { font-weight:600; margin-bottom:6px; }
.form-control { border-radius:12px; padding:12px 15px; border:1px solid rgba(16,24,40,0.12); background:white; }
textarea.form-control { min-height:120px; }
.btn-save { background: linear-gradient(135deg,#49c16c,#2b9f52); border:none; padding:10px 18px; border-radius:12px; color:white; font-weight:600; }
.btn-cancel { background:#e6e9ee; border:none; padding:10px 16px; border-radius:10px; }
body.dark .hero-card { background: rgba(30,40,60,0.82); color:#e5e7eb; }
body.dark .form-card { background: rgba(28,35,48,0.82); color:#e5e7eb; }
body.dark .form-control { background:#1e2533; border-color:#3a4255; color:#e5e7eb; }
</style>

<div class="content-wrapper">
    <div class="form-container">

        <div class="hero-card">
            <div class="hero-title">Edit Tamu</div>
            <div class="hero-sub">Perbarui informasi tamu acara</div>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('tamu.update', [$event->id, $tamu->id]) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama *</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $tamu->nama) }}" required placeholder="Nama lengkap">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon *</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', $tamu->nomor_telepon) }}" required placeholder="0812xxxx">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $tamu->email) }}" required placeholder="nama@contoh.com">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Alamat *</label>
                        <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $tamu->alamat) }}" required placeholder="Kota, Kecamatan, dsb.">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pesan</label>
                        <textarea name="pesan" class="form-control" placeholder="Pesan dari tamu">{{ old('pesan', $tamu->pesan) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-save" type="submit">✔ Update</button>
                    <a href="{{ route('tamu.index', $event->id) }}" class="btn btn-cancel">Batal</a>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
