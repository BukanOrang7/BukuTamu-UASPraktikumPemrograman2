<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['nama_acara', 'tanggal_acara', 'deskripsi', 'status', 'tipe'];

    protected $casts = [
        'tanggal_acara' => 'date',
    ];

    public function tamus()
    {
        return $this->hasMany(Tamu::class);
    }
}
