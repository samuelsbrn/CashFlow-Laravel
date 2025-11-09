<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',         // income | expense
        'title',
        'note',
        'amount',
        'occurred_at',
        'cover_path',
    ];

    protected $casts = [
        'occurred_at' => 'date',
        'amount'      => 'decimal:2',
    ];

    // ================= RELASI =================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Tanpa Kategori',
        ]);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    // ================= SCOPE FILTER (buat index) =================

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('note', 'like', "%{$keyword}%");
        });
    }

    public function scopeType($query, ?string $type)
    {
        if (!$type) return $query;

        return $query->where('type', $type);
    }

    public function scopeCategory($query, ?int $categoryId)
    {
        if (!$categoryId) return $query;

        return $query->where('category_id', $categoryId);
    }

    public function scopeDateRange($query, ?string $from, ?string $to)
    {
        if ($from) {
            $query->whereDate('occurred_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('occurred_at', '<=', $to);
        }

        return $query;
    }
}
