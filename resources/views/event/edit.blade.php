@extends('layouts.app')
@php $title = "Edit Event"; @endphp

@section('content')

<style>
/* Reuse create page styles to keep layout consistent */
.content-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 40px 20px;
}
.form-container { width: 100%; max-width: 900px; }
.hero-card { background: rgba(255,255,255,0.9); padding: 32px; border-radius: 22px; margin-bottom: 32px; box-shadow: 0 18px 40px rgba(16,24,40,0.08); border: 1px solid rgba(16,24,40,0.05); transition: 0.3s ease; }
.hero-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 6px; }
.hero-sub { font-size: 1rem; opacity: 0.65; }
.form-card { background: rgba(255,255,255,0.85); padding: 32px; border-radius: 20px; box-shadow: 0 14px 32px rgba(16,24,40,0.06); border: 1px solid rgba(16,24,40,0.04); transition: 0.3s ease; }
.form-label { font-weight: 600; margin-bottom: 6px; }
.form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid rgba(16,24,40,0.12); background: white; transition: 0.2s; }
.form-control:focus { border-color: #6b8cff; box-shadow: 0 0 0 4px rgba(107,140,255,0.25); }
textarea.form-control { min-height: 140px; }
.btn-save { background: linear-gradient(135deg,#49c16c,#2b9f52); border: none; padding: 12px 20px; border-radius: 12px; font-weight: 600; font-size: 1rem; color: #fff; transition: .25s ease; }
.btn-save:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(40,200,100,0.25); }
body.dark .hero-card { background: rgba(30,40,60,0.82); border-color: #2f3b50; color: #e5e7eb; }
body.dark .form-card { background: rgba(28,35,48,0.82); border-color: #2a3244; color: #e5e7eb; }
body.dark .form-control { background: #1e2533; border-color: #3a4255; color: #e5e7eb; }
body.dark .form-control:focus { border-color: #4b6cff; box-shadow: 0 0 0 4px rgba(75,108,255,0.35); }
</style>

<div class="content-wrapper">
    <div class="form-container">

        <div class="hero-card">
            <div class="hero-title">Edit Acara</div>
            <div class="hero-sub">Perbarui detail acara</div>
        </div>

        <div class="form-card">
            <form action="{{ route('event.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Acara *</label>
                    <input type="text" name="nama_acara" class="form-control" required placeholder="Contoh: Seminar Teknologi" value="{{ old('nama_acara', $event->nama_acara) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Acara</label>
                    <input type="date" name="tanggal_acara" class="form-control" value="{{ old('tanggal_acara', $event->tanggal_acara ? $event->tanggal_acara->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" placeholder="Ringkasan acara...">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Acara</label>
                    <select name="tipe" class="form-control">
                        <option value="non_resmi" {{ old('tipe', $event->tipe) === 'non_resmi' ? 'selected' : '' }}>Non Resmi</option>
                        <option value="resmi" {{ old('tipe', $event->tipe) === 'resmi' ? 'selected' : '' }}>Resmi</option>
                    </select>
                </div>

                <button class="btn btn-save action-btn mt-2" type="submit">✔ Simpan Perubahan</button>
            </form>
        </div>

    </div>
</div>

@endsection
