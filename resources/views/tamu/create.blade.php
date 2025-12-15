@extends('layouts.app')
@section('content')

@php $title = "Tambah Tamu"; @endphp

<div class="container">
    <h2 class="mb-4">Tambah Tamu</h2>

    <form method="POST" action="{{ route('tamu.store', $event->id) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama *</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon *</label>
            <input type="text" name="nomor_telepon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat *</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Pesan</label>
            <textarea name="pesan" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>

@endsection
