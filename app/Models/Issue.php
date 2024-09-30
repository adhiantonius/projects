<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel yang digunakan
    protected $table = 'issues';

    // Pastikan kolom yang bisa diisi (fillable) sesuai
    protected $fillable = ['date', 'description', 'priority', 'attachment','priority','status'];
}
