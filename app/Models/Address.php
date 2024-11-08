<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = [
        'postal_code', 'region_kana', 'city_kana', 'area_kana', 
        'region_kanji', 'city_kanji', 'area_kanji'
    ];
}
