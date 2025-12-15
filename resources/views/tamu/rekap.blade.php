@extends('layouts.app')
@section('content')

@php $title = "Rekap Kehadiran"; @endphp

<div class="container">
    <h2 class="mb-4">Rekap Kehadiran: {{ $event->nama_acara }}</h2>

    <table class="table bg-white table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>

        <tbody>
            @foreach($tamus as $t)
            <tr>
                <td>{{ $t->nama }}</td>
                <td>{{ $t->email }}</td>
                <td>{{ $t->kehadiran ? 'Hadir' : 'Tidak Hadir' }}</td>
                <td>{{ $t->kehadiran_at }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
