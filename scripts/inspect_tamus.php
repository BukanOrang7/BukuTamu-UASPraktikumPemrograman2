<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tamu;

$rows = Tamu::limit(20)->get();
foreach ($rows as $t) {
    $id = $t->id;
    $nama = $t->nama;
    $kehadiran = $t->kehadiran ? '1' : '0';
    $kehadiran_at = $t->kehadiran_at ? $t->kehadiran_at->toDateTimeString() : 'NULL';
    $created = $t->created_at ? $t->created_at->toDateTimeString() : 'NULL';
    echo "$id|$nama|$kehadiran|$kehadiran_at|$created\n";
}
