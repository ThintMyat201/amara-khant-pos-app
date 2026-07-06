<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreSession extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime'
    ];

    public function sales() {
        return $this->hasMany(Sale::class, 'store_session_id');
    }
}
