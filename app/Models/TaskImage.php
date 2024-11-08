<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'path'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
