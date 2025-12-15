<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'nama',
        'nomor_telepon',
        'email',
        'alamat',
        'pesan',
        'kehadiran',
        'kehadiran_at'
    ];

    protected $casts = [
        'kehadiran' => 'boolean',
        'kehadiran_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
