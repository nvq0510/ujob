<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Khai báo các thuộc tính có thể điền giá trị (mass assignable)
    protected $fillable = [
        'user_id',
        'workplace_id',
        'work_date',
        'shift',
        'start_time',
        'end_time',
        'description',
        'notes',
        'status',
    ];

    // Định nghĩa các kiểu dữ liệu
    protected $casts = [
        'work_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Định nghĩa mối quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Định nghĩa mối quan hệ với model Workplace
    public function workplace()
    {
        return $this->belongsTo(Workplace::class);
    }

    public function images()
    {
        return $this->hasMany(TaskImage::class);
    }

        public function tasks()
        {
            return $this->hasMany(Task::class);
        }
}