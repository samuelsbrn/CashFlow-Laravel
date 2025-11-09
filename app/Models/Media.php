<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'disk',     // contoh: 'public'
        'path',     // contoh: 'covers/123abc.png'
        'size',
        'mime',
    ];

    // ================= RELASI =================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // ================= ACCESSOR KECIL =================

    public function getUrlAttribute(): string
    {
        // kalau pakai disk 'public'
        return asset('storage/' . ltrim($this->path, '/'));
    }
}
