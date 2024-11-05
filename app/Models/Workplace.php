<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    use HasFactory;

    // Khai báo các thuộc tính có thể điền giá trị (mass assignable)
    protected $fillable = [
        'workplace',
        'zipcode',
        'address',
    ];

    // Định nghĩa mối quan hệ với model Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
