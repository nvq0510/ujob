<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'status',
        'notes',
        'updated_at',
    ];

    // Định nghĩa mối quan hệ với Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
