<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'total_before',
        'total_after',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
