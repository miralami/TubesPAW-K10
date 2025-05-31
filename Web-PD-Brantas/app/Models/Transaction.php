<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionItem;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    // Relasi ke user (opsional, jika kamu butuh)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke semua item dalam transaksi ini
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
