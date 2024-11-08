<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Khai báo các thuộc tính có thể điền giá trị (mass assignable)
    protected $fillable = [
        'workplace_id', // Khóa ngoại liên kết với bảng workplaces
        'room_number',
        'status',
        'checkin',
        'checkout',
        'notes',
    ];

    // Định nghĩa mối quan hệ với model Workplace
    public function workplace()
    {
        return $this->belongsTo(Workplace::class);
    }

    public function statuses()
    {
        return $this->hasMany(RoomStatus::class);
    }
    
}
